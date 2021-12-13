<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Contractrenewalline;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Leaveplanline;
use frontend\models\Storerequisitionline;
use frontend\models\Vehiclerequisitionline;
use frontend\models\Weeknessdevelopmentplan;
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

class ContractrenewallineController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete','view'],
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
                'only' => ['setquantity','setitem','setlocation','setfield'],
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

    public function actionCreate($No){
       $service = Yii::$app->params['ServiceName']['ContractRenewalLines'];
       $model = new Contractrenewalline();

        if(Yii::$app->request->get('No') && !Yii::$app->request->post()){

                $model->Change_No = $No;
                $model->Employee_No = Yii::$app->request->get('Employee_No');
                $result = Yii::$app->navhelper->postData($service, $model);

                if(is_string($result))
                {
                    Yii::$app->recruitment->printrr('<div class="alert alert-danger">Error Adding Line: '.$result.'</div>');
                }
                

                $model = Yii::$app->navhelper->loadmodel($result,$model);
        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Contractrenewalline'],$model) ){



            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Line Added Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Adding Line: '.$result.'</div>'];
            }

        }
         $model->Contract_Start_Date = date('Y-m-d');
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('create', [
                'model' => $model,
                'contracts' => $this->getContracts(),
                'grades' => $this->getPayrollscales(),
                'jobs' => $this->getJobs(),
                'pointers' => $this->getPointers($model->Grade),
            ]);
        }


    }


    public function actionUpdate(){
        $model = new Contractrenewalline() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['ContractRenewalLines'];
        $filter = [
            'Line_No' => Yii::$app->request->get('No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Contractrenewalline'],$model) ){

            $filter = [
                'Line_No' => $model->Line_No,
            ];
            $refresh = Yii::$app->navhelper->getData($service, $filter);
            $model->Key = $refresh[0]->Key;

            //Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success"> Line Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'contracts' => $this->getContracts(),
                'grades' => $this->getPayrollscales(),
                'jobs' => $this->getJobs(),
                'pointers' => $this->getPointers($model->Grade)
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'contracts' => $this->getContracts(),
            'grades' => $this->getPayrollscales(),
            'jobs' => $this->getJobs(),
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['ContractRenewalLines'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionSetfield($field){
        $model = new Contractrenewalline();
        $service = Yii::$app->params['ServiceName']['ContractRenewalLines'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($line);
        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->$field = Yii::$app->request->post($field);

        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        return $result;

    }

    // Set Location

    public function actionSetlocation(){
        $model = new Contractrenewalline();
        $service = Yii::$app->params['ServiceName']['StoreRequisitionLine'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($line);
        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->Location = Yii::$app->request->post('Location');

        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        return $result;

    }

    public function actionSetitem(){
        $model = new Contractrenewalline();
        $service = Yii::$app->params['ServiceName']['StoreRequisitionLine'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($line);
        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->No = Yii::$app->request->post('No');

        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        return $result;

    }

    /*Get Emp Contracts */

    public function getContracts(){
        $service = Yii::$app->params['ServiceName']['EmployeeContracts'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);

        $arr = [];
        $i = 0;

        if(is_array($result)){
            foreach($result as $res)
            {
                ++$i;
                $arr[$i] = [
                    'Code' => $res->Code,
                    'Description' => $res->Description
                ];
            }
            return ArrayHelper::map($arr,'Code','Description');
        }

        return $arr;

    }

    /*Get Locations*/

    public function getLocations(){
        $service = Yii::$app->params['ServiceName']['Locations'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }

    /*Get Items*/

    public function getItems(){
        $service = Yii::$app->params['ServiceName']['Items'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'No','Description');
    }




    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $leaveModel = new Leave();
        $model = $this->loadtomodel($leave[0],$leaveModel);


        return $this->render('view',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name'),
        ]);
    }


  public function getPayrollscales()
    {
        $service = Yii::$app->params['ServiceName']['PayrollScales'];
        $result = Yii::$app->navhelper->getData($service, []);

         return Yii::$app->navhelper->refactorArray($result,'Scale','Sequence');
    }

    public function getPointers($scale)
    {
        $service = Yii::$app->params['ServiceName']['PayrollScales'];
        $filter = ['Scale' => $scale];
        $result = Yii::$app->navhelper->getData($service, $filter);

        return Yii::$app->navhelper->refactorArray($result,'Pointer','Pointer');
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


    //get Jobs


    public function getJobs()
    {
        $service = Yii::$app->params['ServiceName']['ApprovedHRJobs'];
        $result = Yii::$app->navhelper->getData($service, []);

         return Yii::$app->navhelper->refactorArray($result,'Job_ID','Job_Description');
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
}