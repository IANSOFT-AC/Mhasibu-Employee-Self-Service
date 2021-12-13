<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 2:53 PM
 */

namespace backend\controllers;

use common\models\Hruser;
use frontend\models\Applicantprofile;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\UploadedFile;
use yii\web\Response;
use kartik\mpdf\Pdf;
use kartik\tabs\TabsX;
use yii\helpers\Url;

class ApplicantprofileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index', 'view-profile'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index', 'view-profile'],
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
                'only' => ['getleaves'],
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

    public function actionViewProfile(){
        $model = new Applicantprofile();
        $Countries = $this->getCountries();
        $PostalCodes = $this->getPostalCodes();
        
       $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];


       if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Applicantprofile'],$model)){
        //    echo '<pre>';
        //    print_r(Yii::$app->request->post());
        //    exit;

           if(!empty($_FILES['Applicantprofile']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
                 $result = Yii::$app->navhelper->postData($service,$model);

            if(!is_string($result)){

                //Update profileID on Employee or HRUser
                //update a HRUser
                $hruser = Hruser::findOne(Yii::$app->user->identity->id);
                $hruser->profileID = $result->No;
                $hruser->save();//do not validate model since we are just updating a single property

                if(Yii::$app->session->has('HRUSER')){
              
                
                    //update for a particular employee
                    $srvc = Yii::$app->params['ServiceName']['EmployeeCard'];
                    $filter = [
                        'No' => Yii::$app->user->identity->employee[0]->No
                    ];
                    $Employee = Yii::$app->navhelper->getData($srvc,$filter);

                    $data = [
                        'Key' => $Employee[0]->Key,
                        'ProfileID' => $result->No
                    ];

                    $update = Yii::$app->navhelper->updateData($srvc,$data);


                }

                Yii::$app->session->set('ProfileID', $result->No); // ProfileID session
                Yii::$app->session->setFlash('success','Applicant Profile Created Successfully',true);
                return $this->redirect(['update','No' => $result->No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Applicant Profile: '.$result,true);
                return $this->redirect(Yii::$app->request->referrer);
            }

       }

        return $this->render('create',[

            'model' => $model,
            'countries' => ArrayHelper::map($Countries,'Code','Name'),
            'PostalCodes' => ArrayHelper::map($PostalCodes,'Code','Name')

        ]);
       
    }

    public function actionCreate(){
        //Yii::$app->recruitment->printrr(Yii::$app->session->get('HRUSER'));
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external' && Yii::$app->session->has('HRUSER')){
            $this->layout = 'external';
        }

        if(Yii::$app->session->has('ProfileID') || Yii::$app->recruitment->hasProfile(Yii::$app->session->get('ProfileID')))
        {
            return $this->redirect(['update','No' =>Yii::$app->session->get('ProfileID') ]);
        }
        $model = new Applicantprofile();

        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];

        if(Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Applicantprofile'],$model)){

           if(!empty($_FILES['Applicantprofile']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
            $result = Yii::$app->navhelper->postData($service,$model);

            if(!is_string($result)){

                //Update profileID on Employee or HRUser

                if(Yii::$app->session->has('HRUSER')){
                    //update a HRUser
            
                    $hruser = Hruser::findOne(Yii::$app->session->get('HRUSER')->id);
           
                    $hruser->profileID = $result->No;
                    $hruser->save();//do not validate model since we are just updating a single property
                }else{
                    //update for a particular employee
                    $srvc = Yii::$app->params['ServiceName']['EmployeeCard'];
                    $filter = [
                        'No' => Yii::$app->user->identity->employee[0]->No
                    ];
                    $Employee = Yii::$app->navhelper->getData($srvc,$filter);

                    $data = [
                        'Key' => $Employee[0]->Key,
                        'ProfileID' => $result->No
                    ];

                    $update = Yii::$app->navhelper->updateData($srvc,$data);


                }

                Yii::$app->session->set('ProfileID', $result->No); // ProfileID session
                Yii::$app->session->setFlash('success','Profile Created Successfully',true);
                return $this->redirect(['update','No' => $result->No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Profile: '.$result,true);
                return $this->redirect(['create']);

            }

        }


        $Countries = $this->getCountries();
       // $Religion = $this->getReligion();

        return $this->render('create',[

            'model' => $model,
            'countries' => ArrayHelper::map($Countries,'Code','Name'),
            //'religion' => ArrayHelper::map($Religion,'Code','Description')

        ]);
    }


    public function actionUpdate(){
        $profileID = Yii::$app->user->identity->profileID;
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];

        $filter = [
            'No' => $profileID,
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $ProfileModel = new Applicantprofile();



        $model = $this->loadtomodel($result[0],$ProfileModel);  

        //Yii::$app->recruitment->printrr(Yii::$app->request->post()['Applicantprofile']['imageFile']);  

        if( Yii::$app->request->post() && $this->loadpost(Yii::$app->request->post()['Applicantprofile'],$model)){
           

           // Yii::$app->recruitment->printrr($_FILES['Applicantprofile']['name']['imageFile']);
            if(!empty($_FILES['Applicantprofile']['name']['imageFile'])){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->upload();
            }
            
            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result) ){
                Yii::$app->session->setFlash('success','Applicant Profile Updated Successfully',true);
                return $this->redirect(['update','No' => $model->No]);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Applicant Profile  : '.$result,true);
                //return $this->redirect(['index']);
                return $this->redirect(['update','No' => $model->No]);
            }

        }

        $Countries = $this->getCountries();
        $PostalCodes = $this->getPostalCodes();
        return $this->render('update',[
            'model' => $model,
            'countries' => ArrayHelper::map($Countries,'Code','Name'),
            'PostalCodes' => ArrayHelper::map($PostalCodes,'Code','Name'),

            // 'religion' => [],

        ]);
    }

    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['JobApplicantProfile'];

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $leaveModel = new Leave();
        $model = $this->loadtomodel($leave[0],$leaveModel);


        return $this->render('view',[
            'model' => $model,

        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave request sent for approval Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending leave request for approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionCancelRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->CancelLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Cancelling Leave Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    /*Data access functions */

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetleaves(){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
        $leaves = \Yii::$app->navhelper->getData($service);

        $result = [];
        foreach($leaves as $leave){


            $link = $updateLink =  '';
            $Viewlink = Html::a('Details',['view','ApplicationNo'=> $leave->Application_No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($leave->Approval_Status == 'New' ){
                $link = Html::a('Send Approval Request',['approval-request','app'=> $leave->Application_No ],['class'=>'btn btn-primary btn-xs']);
                $updateLink = Html::a('Update Leave',['update','ApplicationNo'=> $leave->Application_No ],['class'=>'btn btn-info btn-xs']);
            }else if($leave->Approval_Status == 'Approval_Pending'){
                $link = Html::a('Cancel Approval Request',['cancel-request','app'=> $leave->Application_No ],['class'=>'btn btn-warning btn-xs']);
            }



            $result['data'][] = [
                'Key' => $leave->Key,
                'Employee_No' => !empty($leave->Employee_No)?$leave->Employee_No:'',
                'Employee_Name' => !empty($leave->Employee_Name)?$leave->Employee_Name:'',
                'Application_No' => $leave->Application_No,
                'Days_Applied' => $leave->Days_Applied,
                'Application_Date' => $leave->Application_Date,
                'Approval_Status' => $leave->Approval_Status,
                'Leave_Status' => $leave->Leave_Status,
                'Action' => $link,
                'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
    }

    public function actionReport(){
        $service = Yii::$app->params['ServiceName']['leaveApplicationList'];
        $leaves = \Yii::$app->navhelper->getData($service);
        krsort( $leaves);//sort by keys in descending order
        $content = $this->renderPartial('_historyreport',[
            'leaves' => $leaves
        ]);

        //return $content;
        $pdf = \Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->orientation = Pdf::ORIENT_PORTRAIT;

        //The trick to returning binary content
        $content = $pdf->render('', 'S');
        $content = chunk_split(base64_encode($content));

        return $content;
    }

    public function actionReportview(){
        return $this->render('_viewreport',[
            'content'=>$this->actionReport()
        ]);
    }

    public function Getleavebalance(){
        $service = Yii::$app->params['ServiceName']['leaveBalance'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $balances = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        //print '<pre>';
        // print_r($balances);exit;

        foreach($balances as $b){
            $result = [
                'Key' => $b->Key,
                'Annual_Leave_Bal' => $b->Annual_Leave_Bal,
                'Maternity_Leave_Bal' => $b->Maternity_Leave_Bal,
                'Paternity' => $b->Paternity,
                'Study_Leave_Bal' => $b->Study_Leave_Bal,
                'Compasionate_Leave_Bal' => $b->Compasionate_Leave_Bal,
                'Sick_Leave_Bal' => $b->Sick_Leave_Bal
            ];
        }

        return $result;

    }



    public function getLeaveTypes($gender = 'Female'){
        $service = Yii::$app->params['ServiceName']['leaveTypes'];
        $filter = [
            'Gender' => $gender,
            'Gender' => 'Both'
        ];

        $leavetypes = \Yii::$app->navhelper->getData($service,$filter);
        return $leavetypes;
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];

        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Name))
            $res[] = [
                'Code' => $c->Code,
                'Name' => $c->Name
            ];
        }

        return $res;
    }


    
    public function getPostalCodes(){
        $service = Yii::$app->params['ServiceName']['PostalCodes'];

        $res = [];
        $PostalCodes = \Yii::$app->navhelper->getData($service);
        foreach($PostalCodes as $PostalCode){
            if(!empty($PostalCode->Code))
            $res[] = [
                'Code' => $PostalCode->Code,
                'Name' => $PostalCode->City
            ];
        }

        return $res;
    }

    public function getReligion(){
        $service = Yii::$app->params['ServiceName']['Religion'];
        $filter = [
            'Type' => 'Religion'
        ];
        $religion = \Yii::$app->navhelper->getData($service, $filter);
        return $religion;
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

    public function loadpost($post,$model){ // load model with form data


        $modeldata = (get_object_vars($model)) ;

        foreach($post as $key => $val){

            $model->$key = $val;
        }

        return $model;
    }

}