<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentstrength;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Imprestcard;
use frontend\models\Imprestline;
use frontend\models\Imprestsurrendercard;
use frontend\models\Leaveattachment;
use frontend\models\Leaveplancard;
use frontend\models\Leave;
use frontend\models\Salaryadvance;
use frontend\models\Trainingplan;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;

class LeaveController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','advance-list','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','advance-list','create','update','delete','view', 'check-leave-balance', 'is-allowed-to-apply-for-leave'],
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
                'only' => ['list', 'check-leave-balance', 'is-allowed-to-apply-for-leave', 'attachement-list'],
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


    public function actionCreate(){

        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        // if(Yii::$app->request->isAjax){
        //     return $this->renderAjax('create', [
        //         'model' => $model,
        //         'leavetypes' => $this->getLeaveTypes(),
        //         'employees' => $this->getEmployees(),
        //     ]);
        // }

        /*Do initial request */
        if(!isset(Yii::$app->request->post()['Leave']) && empty($_FILES) ){

            $now = date('Y-m-d');
            // $model->Start_Date = date('Y-m-d', strtotime($now.' + 2 days'));
            $model->Employee_No = Yii::$app->user->identity->Employee[0]->No; //Yii::$app->user->identity->{'Employee No_'};
            // echo '<pre>';
            // print_r(Yii::$app->user->identity->Employee[0]->No);
            // exit;

            $request = Yii::$app->navhelper->postData($service,$model);
            //Yii::$app->recruitment->printrr($request);
            if(is_object($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{
                Yii::$app->session->setFlash('error', 'Error : ' . $request, true);
                return $this->redirect(['index']);
            }
        } 
        /*End Application Initialization*/

        if(Yii::$app->request->post() && !empty(Yii::$app->request->post()['Leave']) && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leave'],$model) ){
             $model->Employee_No = Yii::$app->user->identity->Employee[0]->No; //Yii::$app->user->identity->{'Employee No_'};

            $filter = [
                'Application_No' => $model->Application_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model->Key = $refresh[0]->Key;

            //Yii::$app->recruitment->printrr($refresh );
            //Yii::$app->navhelper->loadmodel($refresh[0],$model);
          

            $result = Yii::$app->navhelper->updateData($service,$model);
            
          
            if(!is_string($result)){
                 // Upload Attachment File

                if(!empty($_FILES)){
                    $Attachmentmodel = new Leaveattachment();
                    $Attachmentmodel->Document_No =  $result->No;
                    $Attachmentmodel->attachmentfile = UploadedFile::getInstanceByName('attachmentfile');

                    $UploadResultresult = $Attachmentmodel->Upload($Attachmentmodel->Document_No);

                    if(!is_string($UploadResultresult) || $UploadResultresult == true){
                        Yii::$app->session->setFlash('success','Leave Request Created Successfully.' );
                        return $this->redirect(['update','No' =>  $result->Application_No]);
                    }else{
                        Yii::$app->session->setFlash('error','ErrorUplpading Leave Attachement : '.$UploadResultresult );
                        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                    }
                    
                }
                Yii::$app->session->setFlash('success','Leave Request Created Successfully.' );
                return $this->redirect(['view','No' =>  $result->Application_No]);

            }else{
                Yii::$app->session->setFlash('error','Error Creating Leave Request : '.$result );
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }

        }


       

        return $this->render('create',[
            'model' => $model,
            'leavetypes' => $this->getLeaveTypes(),
            'employees' => $this->getEmployees(),
        ]);
    }

    public function actionAttach($No)
    {
        $Attachmentmodel = new Leaveattachment();
         // Upload Attachment File
        if(!empty($_FILES)){
            $Attachmentmodel->Document_No =  Yii::$app->request->post()['Leaveattachment']['Document_No'];
            $Attachmentmodel->Description =  Yii::$app->request->post()['Leaveattachment']['Description'];
            $Attachmentmodel->attachmentfile = UploadedFile::getInstanceByName('attachmentfile');
            $result = $Attachmentmodel->Upload($Attachmentmodel);
            \yii\helpers\VarDumper::dump( $result, $depth = 10, $highlight = true);

            //exit;
            if(isset($result->Key)){//Sucess
                Yii::$app->session->setFlash('success','Leave Attachement Uploaded Succesfully' );
                return $this->redirect(['update','No' =>  $No]);
            }else{
                Yii::$app->session->setFlash('error','Error Uploading Attachement : '.$result );
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
            
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('Attach', [
                'LeaveNo' => $No,
                'leavetypes' => $this->getLeaveTypes(),
                'employees' => $this->getEmployees(),
                'Attachmentmodel' => new \frontend\models\Leaveattachment(),
            ]);
        }
    }




    public function actionUpdate($No){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];
        $model->isNewRecord = false;

        $filter = [
            'Application_No' => Yii::$app->request->get('No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }

        // Upload Attachment File
        if(!empty($_FILES)){
          //  Yii::$app->recruitment->printrr($_FILES);
            $Attachmentmodel = new Leaveattachment();
            $Attachmentmodel->Document_No =  Yii::$app->request->post()['Leaveattachment']['Document_No'];
            $Attachmentmodel->attachmentfile = UploadedFile::getInstanceByName('attachmentfile');
            $result = $Attachmentmodel->Upload($Attachmentmodel->Document_No);
            if(!is_string($result) || $result == true){
                Yii::$app->session->setFlash('success','Leave Attachement Saved Successfully. ', true);
            }else{
                Yii::$app->session->setFlash('error','Could not save attachment.'.$result, true);
            }

            return $this->render('UpdateLeave',[
                'model' => $model,
                'leavetypes' => $this->getLeaveTypes(),
                'employees' => $this->getEmployees(),
                'Attachmentmodel' => new \frontend\models\Leaveattachment(),

            ]);
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leave'],$model) ){
            $filter = [
                'Application_No' => $model->Application_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->getData($service,$filter);
            $model->Key = $refresh[0]->Key;
            // Yii::$app->navhelper->loadmodel($refresh[0],$model);

            $result = Yii::$app->navhelper->updateData($service,$model);
            //Yii::$app->recruitment->printrr($result);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Leave Updated Successfully.' );

                return $this->redirect(['update','No' => $result->Application_No]);

            }else{
                Yii::$app->session->setFlash('error','Error Updating Leave Document '.$result );
                return $this->render('UpdateLeave',[
                    'model' => $model,
                    'leavetypes' => $this->getLeaveTypes(),
                    'employees' => $this->getEmployees(),
                    'Attachmentmodel' => new \frontend\models\Leaveattachment(),
                ]);

            }

        }



        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'leavetypes' => $this->getLeaveTypes(),
                'employees' => $this->getEmployees(),
                'Attachmentmodel' => new \frontend\models\Leaveattachment(),
            ]);
        }



        return $this->render('UpdateLeave',[
            'model' => $model,
            'leavetypes' => $this->getLeaveTypes(),
            'employees' => $this->getEmployees(),
            'Attachmentmodel' => new \frontend\models\Leaveattachment(),


        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['LeaveCard'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No){
       // exit($No);
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => $No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $model = $this->loadtomodel($result[0], $model);

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
            'leavetypes' => $this->getLeaveTypes(),
            'employees' => $this->getEmployees(),
            'Attachmentmodel' => new \frontend\models\Leaveattachment(),

        ]);
    }

    

    public function actionViewApproval($No){
        // exit($No);
         $model = new Leave();
         $service = Yii::$app->params['ServiceName']['LeaveCard'];
 
         $filter = [
             'Application_No' => $No
         ];
 
         $result = Yii::$app->navhelper->getData($service, $filter);
 
         //load nav result to model
         $model = $this->loadtomodel($result[0], $model);
 
         //Yii::$app->recruitment->printrr($model);
 
         return $this->render('LeaveApproval',[
             'model' => $model,
             'leavetypes' => $this->getLeaveTypes(),
             'employees' => $this->getEmployees(),
             'Attachmentmodel' => new \frontend\models\Leaveattachment(),
 
         ]);
     }


    public function actionDeleteAttachement($No, $Key){
        $model = new Leaveattachment();
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $result = Yii::$app->navhelper->deleteData($service,$Key);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Attachement Deleted Successfully.' );
            return $this->redirect(['update','No' => $No]);
        }else{
            Yii::$app->session->setFlash('error','Unable To delete Attachement. '.$result );
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

        }
    }

     public function actionViewAttachement($DocNo ,$LineNo){
        $model = new Leaveattachment();
        
          if(Yii::$app->request->isAjax){
              $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
              $filter = [
              'Document_No' => $DocNo,
              'Line_No'=>$LineNo
              ];
              $results = \Yii::$app->navhelper->getData($service,$filter);
              Yii::$app->navhelper->loadmodel($results[0],$model);
  
              return $this->renderAjax('ViewAttachement', [
                  'Attachmentmodel' => $model,
              ]);
          }
  
       }

    // Get imprest list

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['LeaveList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        //VarDumper::dump( $results, $depth = 10, $highlight = true); exit;
        $result = [];
        if(!is_object($results)){
            foreach($results as $item){
                $link = $updateLink = $deleteLink =  '';
                $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> @$item->Application_No ],['class'=>'btn btn-outline-primary btn-xs']);
                if(@$item->Status == 'New'){
                    $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->Application_No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);
                    $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> @$item->Application_No],['class'=>'btn btn-info btn-xs']);
                }else if(@$item->Status == 'Pending_Approval'){
                    $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> @$item->Application_No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
                }
    
                $result['data'][] = [
                    'Key' => @$item->Key,
                    'No' => @$item->Application_No,
                    'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                    'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                    'Application_Date' => !empty($item->Application_Date)?$item->Application_Date:'',
                    'Status' => @$item->Status,
                    'Action' => $link,
                    'Update_Action' => $updateLink,
                    'view' => $Viewlink
                ];
            }
        }
        else{
            $result = [];
        }

        return $result;
    }

    public function actionAttachementList($No){
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $No,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        //VarDumper::dump( $results, $depth = 10, $highlight = true); exit;
        $result = [];
        if(!is_object($results)){
            foreach($results as $item){
                
                $Viewlink =   \yii\helpers\Html::button('View Attachement',
                [  'value' => \yii\helpers\Url::to(['leave/view-attachement',
                    'DocNo'=>$item->Document_No,
                    'LineNo'=>$item->Line_No
                    ]),
                    'title' => 'View Attachement',
                    'class' => 'btn btn-outline-primary push-right showModalButton',
                     ]
                ); 

                $Deletelink = Html::a('Delete Attachement',['delete-attachement','No'=>$item->Document_No,'Key'=>$item->Key, ],
                        ['class'=>'btn btn-outline-danger push-left', 'data'=>[
                            'confirm'=>'Are You Sure You Want To Delete?'
                        ]]
                ); 
                
                
               
                $result['data'][] = [
                    'Key' => @$item->Key,
                    'No' => @$item->Document_No,
                    'Description' => !empty($item->Description)?$item->Description:'',
                    'view' => $Viewlink,
                    'delete'=>$Deletelink
                ];
            }
        }
        else{
            $result = [];
        }

        return $result;
    }
    // Get Imprest  surrender list

    public function actionGetimprestsurrenders(){
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        //Yii::$app->recruitment->printrr( );
        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){
            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view-surrender','No'=> $item->No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($item->Status == 'New'){
                $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);

                $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> $item->No ],['class'=>'btn btn-info btn-xs']);
            }else if($item->Status == 'Pending_Approval'){
                $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> $item->No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
            }

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->No,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Purpose' => !empty($item->Purpose)?$item->Purpose:'',
                'Imprest_Amount' => !empty($item->Imprest_Amount)?$item->Imprest_Amount:'',
                'Status' => $item->Status,
                'Action' => $link,
                'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
    }


    public function getCovertypes(){
        $service = Yii::$app->params['ServiceName']['MedicalCoverTypes'];

        $results = \Yii::$app->navhelper->getData($service);
        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                if(!empty($res->Code) && !empty($res->Description)){
                    $result[$i] =[
                        'Code' => $res->Code,
                        'Description' => $res->Description
                    ];
                    $i++;
                }

            }
        }
        return ArrayHelper::map($result,'Code','Description');
    }

    /* My Imprests*/

    public function getmyimprests(){
        $service = Yii::$app->params['ServiceName']['PostedImprestRequest'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Surrendered' => false,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_Amount
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }

    /*Get Staff Loans */

    public function getLoans(){
        $service = Yii::$app->params['ServiceName']['StaffLoans'];

        $results = \Yii::$app->navhelper->getData($service);
        return ArrayHelper::map($results,'Code','Loan_Name');
    }

    /* Get My Posted Imprest Receipts */

    public function getimprestreceipts($imprestNo){
        $service = Yii::$app->params['ServiceName']['PostedReceiptsList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Imprest_No' => $imprestNo,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_No
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }

    public function getLeaveTypes($gender = ''){
        $service = Yii::$app->params['ServiceName']['LeaveTypesSetup']; //['leaveTypes'];
        $filter = [];

        $arr = [];
        $i = 0;
        $result = \Yii::$app->navhelper->getData($service,$filter);
        foreach($result as $res)
        {
            if($res->Gender == 'Both' || $res->Gender == Yii::$app->user->identity->Employee[0]->Gender )
            {
                ++$i;
                $arr[$i] = [
                    'Code' => $res->Code,
                    'Description' => $res->Description
                ];
            }
        }
        return ArrayHelper::map($arr,'Code','Description');
    }

    public function actionRequiresattachment($Code)
    {
        $service = Yii::$app->params['ServiceName']['LeaveTypesSetup'];
        $filter = [
            'Code' => $Code
        ];

        $result = \Yii::$app->navhelper->getData($service,$filter);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['Requires_Attachment' => $result[0]->Requires_Attachment ];
    }

    public function getEmployees(){

        //Yii::$app->recruitment->printrr(Yii::$app->user->identity->Employee[0]->Global_Dimension_3_Code);
        $service = Yii::$app->params['ServiceName']['Employees'];
        // echo '<pre>';
        // print_r(Yii::$app->user->identity->Employee[0]);
        // exit;

        $filter = [
            //'Global_Dimension_3_Code' => Yii::$app->user->identity->Employee[0]->Global_Dimension_3_Code
        ];
        $employees = \Yii::$app->navhelper->getData($service, $filter);
        $data = [];
        $i = 0;
        if(is_array($employees)){

            foreach($employees as  $emp){
                $i++;
                if(!empty($emp->Full_Name) && !empty($emp->No)){
                    $data[$i] = [
                        'No' => $emp->No,
                        'Full_Name' => $emp->Full_Name
                    ];
                }

            }
        }
        return ArrayHelper::map($data,'No','Full_Name');
    }




    public function actionSetleavetype(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Leave_Code = Yii::$app->request->post('Leave_Code');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionSetreliever(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Reliever = Yii::$app->request->post('Reliever');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /*Set Receipt Amount */
    public function actionSetdays(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Days_To_Go_on_Leave = Yii::$app->request->post('Days_To_Go_on_Leave');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /*Set Start Date */
    public function actionSetstartdate(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Start_Date = Yii::$app->request->post('Start_Date');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /* Set Imprest Type */

    public function actionSetimpresttype(){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
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
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_No = Yii::$app->request->post('Imprest_No');
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

    //Check Leave Balance Without creating a New Entry
    public function actionCheckLeaveBalance($LeaveType, $DaysAppliedFor)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'leaveTpe' => $LeaveType,
            'employeeNo' => Yii::$app->user->identity->Employee[0]->No,
            'daysAppliedFor'=>$DaysAppliedFor,
            // 'leaveStartDate'=>$StartDate
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'GetLeaveBalanceForSelectedLeave');
        
        return $result;
    }

    
     //Check Leave Balance Without creating a New Entry
     public function actionIsAllowedToApplyForLeave($LeaveNo)
     {
         $service = Yii::$app->params['ServiceName']['PortalFactory'];
 
         $data = [
             'leaveType' => $LeaveNo,
             'employeeNo' => Yii::$app->user->identity->Employee[0]->No,
         ];
 
 
         $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IsAllowedToApplyForLeave');
         
         return $result;
     }

    /* Call Approval Workflow Methods */

    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
            'sendMail' => 1,
            'approvalUrl' => '',
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSendLeaveForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Sent to Supervisor for Approval Successfully.', true);
            //return $this->redirect(['view','No' => $No]);
             return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Request for Approval  : '. $result);
            // return $this->redirect(['view','No' => $No]);
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


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelLeaveApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }



}