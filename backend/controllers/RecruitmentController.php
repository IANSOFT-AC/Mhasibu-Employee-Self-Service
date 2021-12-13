<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 12:27 AM
 */


namespace backend\controllers;

use common\models\HrloginForm;
use common\models\Hruser;
use common\models\SignupForm;
use frontend\models\Coverletter;
use frontend\models\Cv;
use frontend\models\HRPasswordResetRequestForm;
use frontend\models\HRResetPasswordForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use frontend\models\Applicantprofile;
use common\models\JobApplicationCard;



use frontend\models\Employeerequisition;
use frontend\models\Employeerequsition;
use frontend\models\Job;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\models\Employee;
use yii\web\Controller;
use yii\web\Response;

class RecruitmentController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','vacancies'],
                'rules' => [
                    [
                        'actions' => ['vacancies'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','vacancies'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['getvacancies','getexternalvacancies','requirementscheck','getapplications','getinternalapplications',  'can-apply',  'get-requiremententries'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function beforeAction($action){
        if(Yii::$app->user->isGuest){
            $this->layout = 'guest';
        }

        if (!parent::beforeAction($action)) {
            return false;
        }
        return true; // or false to not run the action
    }

    public function actionIndex(){

        //return $this->render('index');
        return $this->redirect(['recruitment/vacancies']);
    }



    public function actionDeclaration(){
        $model = new Applicantprofile();
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];
        $filter = [
            'No' => Yii::$app->user->identity->profileID,
        ];
        $modelData = Yii::$app->navhelper->getData($service, $filter);
        $model = $this->loadtomodel($modelData[0],$model);

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){
         
            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Applicantprofile']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Profile Sucesfully Updated');
                return $this->redirect(Yii::$app->request->referrer);

            }else{

                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);

            }

        }

        

        return $this->render('declaration', [
            'model' => $model,
        ]);
    }

    public function actionApplications(){

        if(Yii::$app->session->has('HRUSER')){
            $this->layout = 'external';
        }
        return $this->render('applications');
    }

    public function actionInternalapplications(){
        return $this->render('internalapplications');
    }

    public function actionCreate(){

        $model = new Employeerequsition();


        $service = Yii::$app->params['ServiceName']['RequisitionEmployeeCard'];

        if(\Yii::$app->request->get('create') ){
            //make an initial empty request to nav
            $req = Yii::$app->navhelper->postData($service,[]);
            $model = $this->loadtomodel($req,$model);
        }

        $jobs = $this->getJobs();
        $requestReasons = $this->getRequestReasons();
        $employmentTypes = $this->getEmploymentTypes();
        $priority = $this->getPriority();
        $requisitionType = $this->getRequisitionTypes();
        $message = "";
        $success = false;

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){

            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Leave']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Leave request Created Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Leave request: '.$result,true);
                return $this->redirect(['index']);

            }

        }



        return $this->render('create',[
            'model' => $model,
            'jobs' => $jobs,
            'requestReasons' => $requestReasons,
            'employmentTypes' => $employmentTypes,
            'priority' => $priority,
            'requisitionType' => $requisitionType

        ]);
    }

    public function actionUpdate($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['reqApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();


        $filter = [
            'Application_No' => $ApplicationNo
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);



        //load nav result to model
        $leaveModel = new Leave();

        $model = $this->loadtomodel($result[0],$leaveModel);



        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){
            $result = Yii::$app->navhelper->updateData($model);


            if(!empty($result)){
                Yii::$app->session->setFlash('success','Leave request Updated Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Leave Request : '.$result,true);
                return $this->redirect(['index']);
            }

        }

        return $this->render('update',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name')
        ]);
    }

    public function actionView($Job_ID){

       
        $service = Yii::$app->params['ServiceName']['JobsCard'];

        $filter = [
            'Job_Id' => $Job_ID
        ];

        $job = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($job);


    
        //Get the Job Requisition No

        if(empty($job[0]->Requisition_No)){
            Yii::$app->session->setFlash('error','You cannot apply for this job : Job ID ('.$job[0]->Requisition_No.') cannot be found in HR Requisitions List',true);
            return $this->redirect(['vacancies']);
        }

        
        return $this->render('view',[
            'model' => $job[0],
        ]);
    }

    public function getJobs(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $jobs = \Yii::$app->navhelper->getData($service);
        (object)$result = [];

        foreach($jobs as $j){
            $result []= [
                'Job_ID' =>$j->Job_ID,
                'Job_Description' => !empty($j->Job_Description)? $j->Job_Description: 'Not Set'
            ];
        }

        return ArrayHelper::map($result,'Job_ID','Job_Description');
    }

    public function getRequestReasons(){

        $result = [
            ['Code' => 'New_Vacancy', 'Description' => 'New Vacancy'],
            ['Code' => 'Replacement', 'Description' => 'Replacement'],
            ['Code' => 'Retirement', 'Description' => 'Retirement'],
            ['Code' => 'Retrenchment', 'Description' => 'Retrenchment'],
            ['Code' => 'Demise', 'Description' => 'Demise'],
            ['Code' => 'Other', 'Description' => 'Other'],
        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function getEmploymentTypes(){

        $result = [
            ['Code' => 'Permanent', 'Description' => 'Permanent'],
            ['Code' => 'Temporary', 'Description' => 'Temporary'],
            ['Code' => 'Voluntary', 'Description' => 'Voluntary'],
            ['Code' => 'Contract', 'Description' => 'Contract'],
            ['Code' => 'Interns', 'Description' => 'Interns'],
            ['Code' => 'Casuals', 'Description' => 'Casuals'],
        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function getPriority(){
        $result = [
            ['Code' => '_blank_', 'Description' => '_blank_'],
            ['Code' => 'High', 'Description' => 'High'],
            ['Code' => 'Medium', 'Description' => 'Medium'],
            ['Code' => 'Low', 'Description' => 'Low'],

        ];

        return ArrayHelper::map($result,'Code','Description');
    }

    public function getRequisitionTypes(){

        $result = [
            ['Code' => '_blank_', 'Description' => '_blank_'],
            ['Code' => 'Internal', 'Description' => 'Internal'],
            ['Code' => 'External', 'Description' => 'External'],
            ['Code' => 'Both', 'Description' => 'Both'],

        ];

        return ArrayHelper::map($result,'Code','Description');

    }

    public function actionVacancies(){
        return $this->render('vacancies');
    }

    public function actionExternalvacancies(){
        if(Yii::$app->user->isGuest){
            $this->layout = 'external';
        }
        return $this->render('externalvacancies');
    }


    public function actionCanApply1($ProfileId, $JobId){
        //Get Job Requirements
       


        $data = [
            'profileNo' => $ProfileId,
            'requisitionNo' => $JobId,
        ];
        $Requirements = $this->getRequiremententries($data);
        // echo '<pre>';
        // print_r($Requirements);
        // print_r($JobId);

        // exit;

        if(is_array($Requirements)){
            //Render Ajax Modal

            return $this->renderAjax('confrim-requirements', [
                'Requirements' => $Requirements,
                'ProfileId'=>$ProfileId
            ]);

        }

        //Error Manenos

    }

    public function actionCanApply($ProfileId, $JobId){
        //Get Job Requirements

      

        $data = [
            'profileNo' => $ProfileId,
            'requisitionNo' => $JobId,
        ];
        $Requirements = $this->getRequiremententries($data);

        $service = Yii::$app->params['ServiceName']['JobsCard'];
        $ProfileService = Yii::$app->params['ServiceName']['JobApplicantProfile'];
        $JobApplicationService = Yii::$app->params['ServiceName']['HRJobApplicationsCard'];
        $JobApplicationModel = new JobApplicationCard();
        $msg = [];

        $HasAppliedForTheJob =  Yii::$app->recruitment->HasApplicantAppliedForTheJob(Yii::$app->user->identity->profileID, $JobId);

        // if($HasAppliedForTheJob === true){
        //     return $msg[] = [
        //         'error'=>1,
        //         'eror_message'=>'You Have Already Applied For This Job',
        //     ];
        // }



        // $HasAcceptedTerms =  Yii::$app->recruitment->HasApplicantAcceptedTermsAndConditions($ProfileId);

        // if($HasAcceptedTerms === false){
        //     return $msg[] = [
        //         'error'=>1,
        //         'eror_message'=>'Kindly Accept Our Terms and Conditions First Before Applying for the Job',
        //     ];
        // }

        //Check Qualifications
        $ApplicantQualifications = [];  $JobQualifications = [];
        $NoOfRequiredQualoifications = 0;
   

        //Meets All Conditions. Make the Application For Them
        $JobApplicationModel->Profile_No = Yii::$app->user->identity->profileID;
        $JobApplicationModel->Job_Applying_For = $JobId;
        $JobApplicationResult = Yii::$app->navhelper->postData($JobApplicationService,$JobApplicationModel);
        // echo '<pre>';
        // print_r( $JobApplicationResult);
        // exit;

        if(is_object($JobApplicationResult)){

            return $msg[] = [
                'error'=>0,
                'success'=>1,
                'success_message'=>'Succesfully Applied for This Job. Your Application No is'. $JobApplicationResult->No
            ];

        }else{

            return $msg[] = [
                'error'=>1,
                'eror_message'=>$JobApplicationResult
            ];
        }     

    }
 

    public function actionGetexternalvacancies(){
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [];
        $requisitions = \Yii::$app->navhelper->getData($service,$filter);
        // echo '<pre>';
        // print_r($requisitions);
        // exit;
        $result = [];

        if(!is_object($requisitions)){
            foreach($requisitions as $req){
                if(($req->No_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_Id)) && ($req->Requisition_Type == 'External' || $req->Requisition_Type == 'Both')  ) {
                    
                    $ApplyLink = Html::a('Apply', ['view', 'Job_ID' => $req->Job_Id], [
                        'class' => 'btn btn-outline-success btn-md',
                        'data' => [
                            'params' => ['type' => 'External'],
                            'method' => 'post',
                        ],
                    ]);

                    $ViewJobLink = Html::a('View Details', ['view', 'Job_ID' => $req->Job_Id], [
                        'class' => 'btn btn-outline-success btn-md',
                        'data' => [
                            'params' => ['type' => 'External', ],
                            // 'method' => 'get',
                        ],
                    ]);
    
                    $result['data'][] = [
                        'Contract_Period' => !empty($req->Contract_Period) ? $req->Contract_Period : 'Not Set',
                        'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : '',
                        'No_of_Posts' => !empty($req->No_Posts) ? $req->No_Posts : 'Not Set',
                        'Start_Date' => !empty($req->Start_Date) ? $req->Start_Date : 'Not Set',
                        'End_Date' => !empty($req->End_Date) ? $req->End_Date : 'Not Set',
                        'ReqType' => !empty($req->Employment_Type) ? $req->Employment_Type : 'Not Set',
                        'action' => !empty($ViewJobLink) ? $ViewJobLink : '',
    
                    ];
    
                }
    
            }
        }
     
        return $result;
    }

    public function actionGetapplications(){

        $filter = [];
        $service = Yii::$app->params['ServiceName']['HRJobApplicationsList'];
        //Yii::$app->recruitment->printrr(Yii::$app->session->get('HRUSER'));
        if(Yii::$app->session->has('HRUSER')){

            $hruser = Hruser::findByUsername(Yii::$app->session->get('HRUSER')->username);
            $profileID = $hruser->profileID ;

            $filter = [
                'Profile_No' => $profileID
            ];


            if(empty($profileID)){
                return [];
            }
            $applications = \Yii::$app->navhelper->getData($service,$filter);
           // Yii::$app->recruitment->printrr($applications);
        }else{
            if(!Yii::$app->user->isGuest && Yii::$app->recruitment->hasProfile()){

                $filter = [
                    'Profile_No' => Yii::$app->recruitment->getProfileID()
                ];
            $applications = \Yii::$app->navhelper->getData($service,$filter);
            }

        }


//Yii::$app->recruitment->printrr($applications);



        $result = [];
        foreach($applications as $req){

            if(property_exists($req,'Job_Description') && property_exists($req,'Profile_No') ) {

                $result['data'][] = [
                    'No' => !empty($req->No) ? $req->No : 'Not Set',
                    'Applicant_Name' => !empty($req->Full_Name) ? $req->Full_Name : '',
                    'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : 'Not Set',
                    'Application_Status' => !empty($req->Job_Application_status) ? $req->Job_Application_status : '',

                ];

            }

        }
        return $result;
    }

    //Get Internal Applications

    public function actionGetinternalapplications(){
        if(!Yii::$app->user->isGuest){
            $srvc = Yii::$app->params['ServiceName']['employeeCard'];
            $filter = [
                'No' => Yii::$app->user->identity->employee[0]->No
            ];
            $Employee = Yii::$app->navhelper->getData($srvc,$filter);
            if(empty($Employee[0]->ProfileID)){
                return [];
            }
            $profileID = $Employee[0]->ProfileID;

        }else{ //if for some reason this check is called by a guest ,return false;
            return [];
        }

        $service = Yii::$app->params['ServiceName']['HRJobApplicationsList'];
        $filter = [
            'Applicant_No' => $profileID
        ];
        $applications = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($applications as $req){

            if(property_exists($req,'Job_Description') && property_exists($req,'Applicant_No') ) {

                $result['data'][] = [
                    'Job_Application_No' => !empty($req->Job_Application_No) ? $req->Job_Application_No : 'Not Set',
                    'Applicant_Name' => !empty($req->Applicant_Name) ? $req->Applicant_Name : '',
                    'Job_Description' => !empty($req->Job_Description) ? $req->Job_Description : 'Not Set',
                    'Application_Status' => !empty($req->Application_Status) ? $req->Application_Status : '',

                ];

            }

        }
        return $result;
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new HrloginForm();


        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           // Yii::$app->recruitment->printrr(Yii::$app->session->get('HRUSER'));
            //var_dump(Yii::$app->session->get('HRUSER')->username); exit;
            //return $this->goBack();//reroute to recruitment profile page
            return $this->redirect(['recruitment/externalvacancies']);

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        if(Yii::$app->session->has('HRUSER')){
            Yii::$app->session->remove('HRUSER');
            return $this->redirect(['recruitment/externalvacancies']);
        }
        return $this->redirect(['recruitment/externalvacancies']);

       // return $this->goHome();
    }

    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm(); //This signup form in common is for registering external hrusers
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $model->goHome();//redirect to recruitment login
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }





    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $model = new HRPasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->redirect(['recruitment/login']);
                //return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        try {
            $model = new HRResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect(['recruitment/login']);

            // return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }





    public function actionVerifyEmail($token)
    {

        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


        if ($user = $model->verifyEmail($HRUser = true)) {
           /* if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }*/
           Yii::$app->session->setFlash('success', 'Your email has been confirmed, Welcome !');
           return $this->redirect(['applicantprofile/create']);
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionSubmit(){
        // Yii::$app->recruitment->printrr($_SESSION);
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }

        //Check if the user has a requisition no

        if(!Yii::$app->session->has('REQUISITION_NO')){
            Yii::$app->session->setFlash('error','Kindly select a position to apply for.');
                if(Yii::$app->session->has('HRUSER')){
                    return $this->redirect(['externalvacancies']);
                }else{
                    return $this->redirect(['vacancies']);
                }

        }



        $model = new Applicantprofile();

        //get Applicant No
        $ApplicationNo = Yii::$app->recruitment->getProfileID();




        if(Yii::$app->request->isPost){

            if(!empty(Yii::$app->request->post()['Applicantprofile']['Motivation'])){ //Update motivation letter
                $service = Yii::$app->params['ServiceName']['applicantProfile'];
                $filter = [
                    'No' => $ApplicationNo,
                ];
                $modelData = Yii::$app->navhelper->getData($service, $filter);
                $model = $this->loadtomodel($modelData[0],$model);
                $model->Motivation = Yii::$app->request->post()['Applicantprofile']['Motivation'];
                $res = Yii::$app->navhelper->updateData($service,$model);
            }










            $data = [
                'profileNo' => $ApplicationNo,
                'requisitionNo' => Yii::$app->session->get('REQUISITION_NO'),
            ];
            $res = [];
            if(!strlen(Yii::$app->session->get('Job_Applicant_No'))){
                $res = $this->getRequiremententries($data);
                Yii::$app->session->set('REQ_ENTRIES',$res);
                $refreshed_entries = [];
                if(is_array($res)){ // refresh the entries to get this that are marked as met

                }
            }else{
                $requirementEntriesService = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];
                $Job_Applicant_No = Yii::$app->session->get('Job_Applicant_No');
                $refreshed_entries = Yii::$app->navhelper->getData($requirementEntriesService,['Job_Applicant_No' => $Job_Applicant_No]);
            }


            if(!is_string($res)){
                Yii::$app->session->setFlash('success', 'Congratulations, Job Application submitted successfully.', true);
            }else{
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to submit your application now : '. $result);
            }
        }
        

       // Yii::$app->recruitment->printrr(Yii::$app->session->get('REQ_ENTRIES'));
        return $this->render('submit',[
            'model' => $model,
            'requirements' => !empty($refreshed_entries)?$refreshed_entries:Yii::$app->session->get('REQ_ENTRIES'),
            'cvmodel' => new Cv(),
            'covermodel' => new Coverletter()
        ]);

    }

    public function getRequiremententries($data){
        $requirementEntriesService = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];

        $service = Yii::$app->params['ServiceName']['JobApplication'];

        $Applicant_No = Yii::$app->navhelper->Jobs($service,$data,'IanGenerateEmployeeRequirementEntries');

        $entries = [];
        if(is_array($Applicant_No)){

            Yii::$app->session->set('Job_Applicant_No',$Applicant_No['return_value']);
            // Get Entries
            $entries = Yii::$app->navhelper->getData($requirementEntriesService,['Job_Applicant_No' => $Applicant_No['return_value'] ]);
        }
        // Yii::$app->recruitment->printrr($entries);

        return $entries;

    }

    public function actionRequirementscheck(){
        $service = Yii::$app->params['ServiceName']['JobApplicantRequirementEntries'];
        $data = [
            'Key' => Yii::$app->request->post('Key'),
            'Line_No' => Yii::$app->request->post('Line_No'),
            'Met' => True,
        ];

        $result = Yii::$app->navhelper->updateData($service,$data);
        Yii::$app->session->setFlash('success','Job Requirement Specification Updated Successfully.');
        return $result;
    }

//Downloads cv or cover letter from share point and renders it in html view
    public function actionDownload($path){
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }
        $base = basename($path);
        /* $ctx = Yii::$app->recruitment->connectWithAppOnlyToken(
             Yii::$app->params['sharepointUrl'],
             Yii::$app->params['clientID'],
             Yii::$app->params['clientSecret']
         );*/
        $ctx = Yii::$app->recruitment->connectWithUserCredentials(Yii::$app->params['sharepointUrl'],Yii::$app->params['sharepointUsername'],Yii::$app->params['sharepointPassword']);
        $fileUrl = '/'.Yii::$app->params['library'].'/'.$base;
        $targetFilePath = './qualifications/download.pdf';
        $resource = Yii::$app->recruitment->downloadFile($ctx,$fileUrl,$targetFilePath);

        return $this->render('readsharepoint',[
            'content' => $resource
        ]);


    }

    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;//get properties of given object
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    

}