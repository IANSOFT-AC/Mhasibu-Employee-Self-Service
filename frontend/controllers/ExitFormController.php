<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentstrength;
use frontend\models\Changerequest;
use frontend\models\Dependant;
use frontend\models\Employeeappraisalkra;
use frontend\models\ExitForm;
use frontend\models\Experience;
use frontend\models\Imprestcard;
use frontend\models\Imprestline;
use frontend\models\Imprestsurrendercard;
use frontend\models\Leaveplan;
use frontend\models\Leaveplancard;
use frontend\models\Salaryadvance;

use frontend\models\Vehiclerequisition;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use yii\web\Response;
use kartik\mpdf\Pdf;

class ExitFormController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','list','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','list','create','update','delete','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['list','setfield'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        return $this->render('index');

    }

    public function actionVehicleAvailability(){

        return $this->render('vehicle-availability');

    }

    public function actionApprovedRequisitions(){

        return $this->render('approved');

    }


    public function actionCreate(){

        $model = new Changerequest();
        $service = Yii::$app->params['ServiceName']['ChangeRequestCard'];

        /*Do initial request */
        if(!isset(Yii::$app->request->post()['Changerequest'])){
            $model->Employee_No = Yii::$app->user->identity->{'Employee_No'};
            $request = Yii::$app->navhelper->postData($service, $model);
            if(!is_string($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{
                Yii::$app->session->setFlash('error',$request);
                return $this->render('create',[
                    'model' => $model,
                ]);
            }
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Vehiclerequisition'],$model) ){

            $filter = [
                'Booking_Requisition_No' => $model->Booking_Requisition_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model = Yii::$app->navhelper->loadmodel($refresh[0],$model);
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Request Created Successfully.' );
                return $this->redirect(['view','No' => $result->Booking_Requisition_No]);

            }else{
                Yii::$app->session->setFlash('error','Error Creating Request '.$result );
                return $this->redirect(['index']);

            }

        }


        //Yii::$app->recruitment->printrr($model);

        return $this->render('create',[
            'model' => $model,
        ]);
    }




    public function actionUpdate($No){
        $model = new Changerequest();
        $service = Yii::$app->params['ServiceName']['ChangeRequestCard'];
        $model->isNewRecord = false;

        $filter = [
            'Booking_Requisition_No' => $No,
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Plan_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Salaryadvance'],$model) ){
            $filter = [
                'Plan_No' => $model->Plan_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            Yii::$app->navhelper->loadmodel($refresh[0],$model);

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Leave Plan Header Updated Successfully.' );

                return $this->redirect(['view','Plan_No' => $result->Plan_No]);

            }else{
                Yii::$app->session->setFlash('success','Error Updating Leave Plan Header '.$result );
                return $this->render('update',[
                    'model' => $model,
                ]);

            }

        }


        // Yii::$app->recruitment->printrr($model);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,


            ]);
        }

        return $this->render('update',[
            'model' => $model,

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['CareerDevStrengths'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionGender()
    {

        $changes = [
            ['Code' => '_blank_','Desc' => '_blank_'],
            ['Code' => 'Male' ,'Desc' =>'Male'],
            ['Code' => 'Female' ,'Desc' => 'Female'],
            ['Code' =>'Unknown' ,'Desc' => 'Unknown'],
        ];

        $data =  ArrayHelper::map($changes,'Code','Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }


    public function actionAction()
    {

        $changes = [
            ['Code' => 'Retain','Desc' => 'Retain'],
            ['Code' => 'Remove' ,'Desc' =>'Remove'],
            ['Code' => 'New_Addition' ,'Desc' =>'New_Addition'],
            ['Code' => 'Existing' ,'Desc' =>'Existing'],
            ['Code' => 'Modify_Allocation' ,'Desc' =>'Modify_Allocation'],

        ];

        $data =  ArrayHelper::map($changes,'Code','Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionRelatives()
    {
        $service = Yii::$app->params['ServiceName']['Relatives'];
        $relatives = Yii::$app->navhelper->getData($service, []);

        $data = Yii::$app->navhelper->refactorArray($relatives,'Code','Description');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionMiscCode()
    {
        $service = Yii::$app->params['ServiceName']['MiscArticles'];
        $relatives = Yii::$app->navhelper->getData($service, []);

        $data = Yii::$app->navhelper->refactorArray($relatives,'Code','Description');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionProfessional()
    {
        $service = Yii::$app->params['ServiceName']['Professional'];
        $relatives = Yii::$app->navhelper->getData($service, []);

        $data = Yii::$app->navhelper->refactorArray($relatives,'Code','Name');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionQualifications()
    {
        $service = Yii::$app->params['ServiceName']['Qualifications'];
        $relatives = Yii::$app->navhelper->getData($service, []);

        $data = Yii::$app->navhelper->refactorArray($relatives,'Code', 'Description');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionType()
    {

        $changes = [
            ['Code' => 'Adult','Desc' => 'Adult'],
            ['Code' => 'Minor' ,'Desc' =>'Minor'],

        ];

        $data =  ArrayHelper::map($changes,'Code','Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }


    public function actionReturned()
    {

        $changes = [
            ['Code' => '_blank_','Desc' => '_blank_'],
            ['Code' => 'Yes' ,'Desc' =>'Yes'],
            ['Code' => 'No' ,'Desc' =>'No'],
            ['Code' => 'N_A' ,'Desc' =>'N_A'],

        ];

        $data =  ArrayHelper::map($changes,'Code','Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionCondition()
    {

        $changes = [
            ['Code' => 'Good','Desc' => 'Good'],
            ['Code' => 'Bad' ,'Desc' =>'Bad'],

        ];

        $data =  ArrayHelper::map($changes,'Code','Desc');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }




    public function actionView($No){
        $model = new ExitForm();
        $service = Yii::$app->params['ServiceName']['ClearanceFormCard'];

        $filter = [
            'Form_No' => $No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $model = $this->loadtomodel($result[0], $model);

        //Yii::$app->recruitment->printrr($model);

        $model->Ict_Unpaid = number_format($model->Ict_Unpaid);
        $model->Library_Unpaid = number_format($model->Library_Unpaid);
        $model->Lab_Unpaid = number_format($model->Lab_Unpaid);
        $model->Security_Uncleared_Item = number_format($model->Security_Uncleared_Item);
        $model->Payroll_Uncleared_Items = number_format($model->Payroll_Uncleared_Items);
        $model->Personal_Account_Uncleared = number_format($model->Personal_Account_Uncleared);
        $model->Archives_Uncleared_Items = number_format($model->Archives_Uncleared_Items);

        return $this->render('view',[
            'model' => $model,
        ]);
    }




    public function actionSetfield($field){
        $model = new ExitForm();
        $service = Yii::$app->params['ServiceName']['ClearanceFormCard'];

        $filter = [
            'Form_No' => Yii::$app->request->post('No'),
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
      
        if(is_array($result)){
            Yii::$app->navhelper->loadmodel($result[0],$model);
            $model->Key = $result[0]->Key;
            $model->$field = Yii::$app->request->post($field);

        }


        $result = Yii::$app->navhelper->updateData($service,$model);
        return $result;

    }




    public function actionClear($exitNo, $formNo, $stage)
    {
         $service = Yii::$app->params['ServiceName']['EmployeeExitManagement'];
         $data = [
            'exitNo' => $exitNo,
            'formNo' => $formNo,
            'sendEmail' => 1,
            'approvalURL' => Html::encode(Yii::$app->urlManager->createAbsoluteUrl(['exit-form/view', 'No' => $formNo]))
        ];

        if($stage == 'Library')
        {
            $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToLibraryForClearance');
        }
        elseif($stage == 'Store')
        {
            $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToStoreForClearance');
        }
        elseif($stage == 'Archives')
        {
            $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToArchiveForClearance');
        }
        elseif($stage == 'Lab')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToLabForClearance');
        }
        elseif($stage == 'Assets')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToAssetForClearance');
        }
         elseif($stage == 'ICT')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToICTForClearance');
        }
        elseif($stage == 'Security')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToSecurityForClearance');
        }
        elseif($stage == 'Payroll')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToPayrollForClearance');
        }
        elseif($stage == 'Training')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToTrainingForClearance');
        }
        elseif($stage == 'Personal_Account')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToPersonalAccountForClearance');
        }
        elseif($stage == 'HOD')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToHODForClearance');
        }
        elseif($stage == 'Human_Resources')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToHRForClearance');
        }
        elseif($stage == 'Executive_Director')
        {
             $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendToEDForClearance');
        }


        if(is_string($result))
        {
            Yii::$app->session->setFlash('error', 'Error: '. $result);
            
        }else{
            
            Yii::$app->session->setFlash('success', 'Clearance Successfully Sent For Approval.');
        }

        return $this->redirect(['view','No' => $formNo]);


    }

    public function actionClearSection($exitNo,$FormNo)
    {
         $service = Yii::$app->params['ServiceName']['EmployeeExitManagement'];
        $data = [
            'exitNo' =>  $exitNo,
            'formNo' => $FormNo ,
            'sendEmail' => true ,
            'approvalURL' => Html::encode(Yii::$app->urlManager->createAbsoluteUrl(['exit-form/view', 'No' => $exitNo]))
        ];

        $result = Yii::$app->navhelper->CodeUnit($service,$data,'IanClearSection');

        if(!is_string($result))
        {
            Yii::$app->session->setFlash('success', 'Section Cleared Successfully.');
        }else
        {
            Yii::$app->session->setFlash('error', 'Error: '.$result);
        }

        return $this->redirect(['index']);
    }

    // Get clearance status

    public function actionClearanceStatus($form_no){
        $model = new ExitForm();
        $service = Yii::$app->params['ServiceName']['ClearanceStatus'];

        $filter = [
            'Form_No' => $form_no
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

        usort($result, function ($a, $b) {return $a->Sequence > $b->Sequence;});
        /*print '<pre>';
        print_r( $result ); exit;*/

        return $this->render('clearance_status',[
            'model' => $result,
        ]);
    }


   // Get Vehicle Requisition list

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['ClearanceFormList'];
        $filter = [
           
        ];
         // 'Employee_No' => Yii::$app->user->identity->Employee[0]->No,

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){

            if(!empty($item->Form_No) && ($item->Employee_No == Yii::$app->user->identity->{'Employee No_'} || ( !empty($item->Responsible_Employee) && $item->Responsible_Employee == Yii::$app->user->identity->{'Employee No_'}))  )
            {
                $link = $updateLink = $deleteLink =  '';
                $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Form_No ],['class'=>'btn btn-outline-primary btn-xs','title' => 'View Request.' ]);
                $Statuslink = Html::a('<i class="fas fa-envelope-open"></i>',['clearance-status','form_no'=> $item->Form_No ],['class'=>'btn btn-outline-success btn-xs','title' => 'View Clearance Status.' ]);


                $result['data'][] = [
                    'Key' => $item->Key,
                    'No' => $item->Form_No,
                    'Exit_No' => !empty($item->Exit_No)?$item->Exit_No:'',
                    'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                    'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                
                    'Action' => $link.' '. $updateLink.' '.$Viewlink.' '.$Statuslink ,

                ];
            }

        }

        return $result;
    }









    public function actionSetloantype(){
        $model = new Salaryadvance();
        $service = Yii::$app->params['ServiceName']['SalaryAdvanceCard'];

        $filter = [
            'Plan_No' => Yii::$app->request->post('Plan_No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Loan_Type = Yii::$app->request->post('loan');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionCommit(){
        $commitModel = trim(Yii::$app->request->post('model'));
        $commitService = Yii::$app->request->post('service');
        $key = Yii::$app->request->post('key');
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');
        $filterKey = Yii::$app->request->post('filterKey');



        $service = Yii::$app->params['ServiceName'][$commitService];

        if(!empty($filterKey))
        {
            $filter = [
                $filterKey => Yii::$app->request->post('no')
            ];
        }
        else{
            $filter = [
                'Line_No' => Yii::$app->request->post('no')
            ];
        }

        $request = Yii::$app->navhelper->getData($service, $filter);


        $data = [];
        if(is_array($request)){
            $data = [
                'Key' => $request[0]->Key,
                $name => $value
            ];
        }else{
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return ['error' => $request];
        }



        $result = Yii::$app->navhelper->updateData($service,$data);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /* Set Imprest Type */

    public function actionSetimpresttype(){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'Plan_No' => Yii::$app->request->post('Plan_No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_Type = Yii::$app->request->post('Imprest_Type');
        }


        $result = Yii::$app->navhelper->updateData($service,$model,['Amount_LCY']);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

        /*Set Imprest to Surrend*/

    public function actionSetimpresttosurrender(){
        $model = new Imprestsurrendercard();
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderCardPortal'];

        $filter = [
            'Plan_No' => Yii::$app->request->post('Plan_No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_Plan_No = Yii::$app->request->post('Imprest_Plan_No');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    /* Call Approval Workflow Methods */

    public function actionSendForApproval()
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];
        $DocNo = Yii::$app->request->get('No');
        $data = [
            'applicationNo' => $DocNo,
            'sendMail' => true,
            'approvalUrl' => '',
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSendVehicleBookingRequisitionForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['view','No' => $DocNo]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending  Request for Approval  : '. $result);
            return $this->redirect(['view','No' => $DocNo]);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelVehicleBookingRequisitionApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $Plan_No]);

        }
    }



}