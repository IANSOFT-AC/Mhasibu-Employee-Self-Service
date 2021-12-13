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

class ChangeRequestController extends Controller
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
                'only' => ['list'],
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
            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
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

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Changerequest'],$model) ){

            $filter = [
                'No' => $model->No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model = Yii::$app->navhelper->loadmodel($refresh[0],$model);
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Request Created Successfully.' );
                return $this->redirect(['view','No' => $result->No,'Change' => $result->Nature_of_Change]);

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
            'No' => $No,
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Plan_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Changerequest'],$model) ){
            $filter = [
                'No' => $model->No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            Yii::$app->navhelper->loadmodel($refresh[0],$model);

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Document Updated Successfully.' );

                return $this->redirect(['view','No' => $result->No]);

            }else{
                Yii::$app->session->setFlash('success','Error Updating Document '.$result );
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


    public function actionBool() 
    {
         $changes = [
            ['Code' => 0,'Desc' => 'No'],
            ['Code' => 1 ,'Desc' =>'Yes'],
           
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

    /*Bio data status*/

     public function actionBiostatus()
    {

        $changes = [
            ['Code' => 'New','Desc' => 'New'],
            ['Code' => 'Current' ,'Desc' =>'Current'],

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



    public function actionView($No){
        $model = new Changerequest();
        $service = Yii::$app->params['ServiceName']['ChangeRequestCard'];

        $filter = [
            'No' => $No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $model = $this->loadtomodel($result[0], $model);

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }

   // Get Vehicle Requisition list

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['ChangeRequestList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){

            if(!empty($item->No ))
            {
                $link = $updateLink = $deleteLink =  '';
                $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->No ],['class'=>'btn btn-outline-primary btn-xs','title' => 'View Request.' ]);
                if($item->Approval_Status == 'New'){
                    $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);
                    $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> $item->No ],['class'=>'btn btn-info btn-xs','title' => 'Update Request']);
                }

                $result['data'][] = [
                    'Key' => $item->Key,
                    'No' => $item->No,
                    'Nature_of_Change' => !empty($item->Nature_of_Change)?$item->Nature_of_Change:'',
                    'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                    'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                    'Status' => !empty($item->Approval_Status)?$item->Approval_Status:'',
                    'Action' => $link.' '. $updateLink.' '.$Viewlink ,

                ];
            }

        }

        return $result;
    }









    public function actionSetchange(){
        $model = new Changerequest();
        $service = Yii::$app->params['ServiceName']['ChangeRequestCard'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Nature_of_Change = Yii::$app->request->post('Nature_of_Change');
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


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSendEmployeeChangeRequestForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending  Request for Approval  : '. $result);
            return $this->redirect(['index']);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelChangeRequestApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Cancelled Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Request.  : '. $result);
            return $this->redirect(['index']);

        }
    }



}