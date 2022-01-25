<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Overtime;
use frontend\models\Purchaserequisition;
use frontend\models\SalaryIncrement;
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

class OvertimeController extends Controller
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


    public function actionCreate(){
       // Yii::$app->recruitment->printrr($this->getPayrollscales());
        $model = new Overtime();
        $service = Yii::$app->params['ServiceName']['OvertimeCard'];

        /*Do initial request */
        if(!isset(Yii::$app->request->post()['Overtime'])){
            if(Yii::$app->user->identity->isSupervisor()){
                // exit('fuug');
                $model->Employee_No = '';
                $EmployeesUnderMe = $this->getEmployeesUnderMe();
                // ArrayHelper::merge($a, $b)
                // Yii::$app->recruitment->printrr($EmployeesUnderMe);

            }else{
                $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
                $EmployeesUnderMe = [];
            }
            $request = Yii::$app->navhelper->postData($service, $model);
            if(!is_string($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{

                Yii::$app->session->setFlash('error',$request);
                 return $this->render('create',[
                    'model' => $model,
                    'programs' => $this->getPrograms(),
                    'departments' => $this->getDepartments(),
                     'grades' => $this->getPayrollscales(),
                     'EmployeesUnderMe'=>$EmployeesUnderMe,
                ]);
            }
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Overtime'],$model) ){

            // Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Request Created Successfully.' );
                return $this->redirect(['view','No' => $result->No]);
            }else{
                Yii::$app->session->setFlash('error','Error Creating Request '.$result );
                return $this->redirect(['index']);

            }

        }


        //Yii::$app->recruitment->printrr($model);

        return $this->render('create',[
            'model' => $model,
            'programs' => $this->getPrograms(),
            'departments' => $this->getDepartments(),
            'grades' => $this->getPayrollscales(),
            'EmployeesUnderMe'=>$EmployeesUnderMe,

        ]);
    }




    public function actionUpdate($No){
        $model = new Overtime();
        $service = Yii::$app->params['ServiceName']['OvertimeCard'];
        $model->isNewRecord = false;

        if(Yii::$app->user->identity->isSupervisor()){
            // exit('fuug');
            $model->Employee_No = '';
            $EmployeesUnderMe = $this->getEmployeesUnderMe();
            // ArrayHelper::merge($a, $b)
            // Yii::$app->recruitment->printrr($EmployeesUnderMe);

        }else{
            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $EmployeesUnderMe = [];
        }

        $filter = [
            'No' => $No,
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Overtime'],$model) ){

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){
                Yii::$app->session->setFlash('success','Document Updated Successfully.' );
                return $this->redirect(['view','No' => $result->No]);

            }else{
                Yii::$app->session->setFlash('error','Error Updating Document'.$result );
                return $this->render('update',[
                    'model' => $model,
                    'EmployeesUnderMe'=>$EmployeesUnderMe,
                    'programs' => $this->getPrograms(),
                    'departments' => $this->getDepartments(),
                    'grades' => $this->getPayrollscales(),
                    'EmployeesUnderMe'=>$EmployeesUnderMe,
                ]);

            }

        }


        // Yii::$app->recruitment->printrr($model);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'programs' => $this->getPrograms(),
                'departments' => $this->getDepartments(),
                'grades' => $this->getPayrollscales(),
                'EmployeesUnderMe'=>$EmployeesUnderMe,



            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'programs' => $this->getPrograms(),
            'departments' => $this->getDepartments(),
            'grades' => $this->getPayrollscales(),
            'EmployeesUnderMe'=>$EmployeesUnderMe,


        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['SalaryIncrementCard'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No){
        $model = new Overtime();
        $service = Yii::$app->params['ServiceName']['OvertimeCard'];

        $filter = [
            'No' => $No
        ];

        if(Yii::$app->user->identity->isSupervisor()){
            $model->Employee_No = '';
            $EmployeesUnderMe = $this->getEmployeesUnderMe();
        }else{
            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $EmployeesUnderMe = [];
        }

        $result = Yii::$app->navhelper->getData($service, $filter);
       // Yii::$app->recruitment->printrr($result);

        //load nav result to model
        $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;

        //Yii::$app->recruitment->printrr($model);\
        
        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Overtime'],$model) ){

            // Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Request Created Successfully.' );
                return $this->redirect(['view','No' => $result->No]);

            }else{
                Yii::$app->session->setFlash('error',$result );
                return $this->redirect(['index']);

            }

        }

        return $this->render('view',[
            'model' => $model,
            'EmployeesUnderMe'=>$EmployeesUnderMe,
            'programs' => $this->getPrograms(),
            'departments' => $this->getDepartments(),
            'grades' => $this->getPayrollscales(),
            'EmployeesUnderMe'=>$EmployeesUnderMe,
        ]);
    }

   // Get list

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['OvertimeList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];


        $results = \Yii::$app->navhelper->getData($service,$filter);
        //Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(!empty($item->No ))
            {
                $link = $updateLink = $deleteLink =  '';

                $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->No ],['class'=>'btn btn-outline-primary btn-xs','title' => 'View Request.' ]);
                if($item->Status == 'Open'){
                    $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);
                    $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> $item->No ],['class'=>'btn btn-info btn-xs','title' => 'Update Request']);
                }else if($item->Status == 'Pending_Approval'){
                    $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> $item->No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
                }

                $result['data'][] = [
                    'Key' => $item->Key,
                    'No' => $item->No,
                    'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                    'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                    'Status' => !empty($item->Status)?$item->Status:'',
                    'Action' => $link.' '. $updateLink.' '.$Viewlink ,

                ];
            }
        }
        return $result;
    }


    /*Get Programs */

    public function getPrograms(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 1
        ];

        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    /* Get Department*/

    public function getDepartments(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 2
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    

 

    

    public function getEmployeesUnderMe(){
        $service = Yii::$app->params['ServiceName']['Employees']; //['leaveTypes'];
        $filter = [];

        $arr = [];
        $i = 0;
        $result = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($result);

        foreach($result as $res)
        {
            if(@$res->Manager_No == Yii::$app->user->identity->{'Employee No_'} || $res->No == Yii::$app->user->identity->{'Employee No_'} )
            {
                ++$i;
                $arr[$i] = [
                    'Code' => $res->No,
                    'Description' => $res->Full_Name
                ];
            }
        }
        return ArrayHelper::map($arr,'Code','Description');
    }


    public function getPayrollscales()
    {
        $service = Yii::$app->params['ServiceName']['PayrollScales'];
        $result = Yii::$app->navhelper->getData($service, []);

         return Yii::$app->navhelper->refactorArray($result,'Scale','Sequence');
    }

    public function actionPointerDd($scale)
    {
        $service = Yii::$app->params['ServiceName']['PayrollScalePointers'];
        $filter = ['Scale' => $scale];
        $result = Yii::$app->navhelper->getData($service, $filter);

        $data = Yii::$app->navhelper->refactorArray($result, 'Pointer','Pointer');

        if(count($data) )
        {
            foreach($data  as $k => $v )
            {
                echo "<option value='$k'>".$v."</option>";
            }
        }else{
            echo "<option value=''>No data Available</option>";
        }
    }



    /* Get Dimension 3*/

    public function getD3(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 3
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    





    public function getEmployees(){
        $service = Yii::$app->params['ServiceName']['Employees'];

        $employees = \Yii::$app->navhelper->getData($service);
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

        return $data;
    }









    /* Call Approval Workflow Methods */

    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
            'sendMail' => 1,
            'approvalUrl' => Html::encode(Yii::$app->urlManager->createAbsoluteUrl(['overtime/view', 'No' => $No])),
        ];


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendOverTimeForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Approval Request for Approval  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanCancelOverTimeApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }

    public function actionSetGrade(){
        $model = new SalaryIncrement();
        $service = Yii::$app->params['ServiceName']['SalaryIncrementCard'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->New_Grade = Yii::$app->request->post('New_Grade');
            $model->New_Pointer = Yii::$app->request->post('New_Pointer');

        }else{
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return $request;
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionCommit(){
        $commitService = Yii::$app->request->post('service');
        $key = Yii::$app->request->post('key');
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');

        $service = Yii::$app->params['ServiceName'][$commitService];
        $request = Yii::$app->navhelper->readByKey($service, $key);
        $data = [];
        if(is_object($request)){
            $data = [
                'Key' => $request->Key,
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

    public function actionAddLine($Service,$Document_No)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $data = [
            'Application_No' => $Document_No,
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
            'Line_No' => time()
        ];

        // Insert Record

        $result = Yii::$app->navhelper->postData($service, $data);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(is_object($result))
        {
            return ['note' => 'Record Created Successfully.'];
        }else{
            return ['note' => $result];
        }
    }

    public function actionDeleteLine($Service, $Key)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }



}