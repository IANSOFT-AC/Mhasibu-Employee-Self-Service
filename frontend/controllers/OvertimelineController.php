<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Leaveplanline;
use frontend\models\Overtimeline;
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

class OvertimelineController extends Controller
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
                'only' => ['setquantity','setitem','setstarttime','setendtime', 'set-nature-of-application'],
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
       $service = Yii::$app->params['ServiceName']['OvertimeLine'];
       $model = new Overtimeline();

        $HeaderService= Yii::$app->params['ServiceName']['OvertimeCard'];
        $filter = ['No'=>$No];
        $Headeresult = \Yii::$app->navhelper->getData($HeaderService,$filter);
       

        if(Yii::$app->request->get('No') && !Yii::$app->request->post()){
            if(isset($Headeresult[0]->Key)){
                $model->Nature_of_Application = $Headeresult[0]->Nature_of_Application;
                $model->Employee_No =  $Headeresult[0]->Employee_No;
            }
                $model->Application_No = $No;
                $model->Date = date('Y-m-d');
                $result = Yii::$app->navhelper->postData($service, $model);

                Yii::$app->navhelper->loadmodel($result,$model);
        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Overtimeline'],$model) ){

            $filter = [
                'Line_No' => $model->Line_No,
            ];
            // Yii::$app->recruitment->printrr(Yii::$app->request->post()['Overtimeline']);

            $request = Yii::$app->navhelper->getData($service, $filter);
            Yii::$app->navhelper->loadmodel($request[0],$model);
            // $model->Nature_of_Application = Yii::$app->request->post()['Overtimeline']['Nature_of_Application'];
            $result = Yii::$app->navhelper->updateData($service,$model);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Saved Sucesfully');
                return $this->redirect(Yii::$app->request->referrer);

            }else{

                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);

            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'departments' => $this->getDepartments(),
                'HeaderResult'=>$Headeresult
            ]);
        }


    }

    public function getDepartments(){
        $service = Yii::$app->params['ServiceName']['DimensionValueList'];

        $filter = [
            'Global_Dimension_No' => 2
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');
    }


    public function actionUpdate(){
        $model = new Overtimeline() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['OvertimeLine'];
        $filter = [
            'Line_No' => Yii::$app->request->get('No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        $HeaderService= Yii::$app->params['ServiceName']['OvertimeCard'];
        $Headerfilter = ['No'=> Yii::$app->request->get('DocNum')];
        $Headeresult = \Yii::$app->navhelper->getData($HeaderService,$Headerfilter);       
        

        if(is_array($result)){
            //load nav result to model
            Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Overtimeline'],$model) ){

            $refresh = Yii::$app->navhelper->getData($service, $filter);
            $model->Key = $refresh[0]->Key;
            $model->Start_Time = Yii::$app->request->post()['Overtimeline']['Start_Time'];
            $model->End_Time = Yii::$app->request->post()['Overtimeline']['End_Time'];

            if(Yii::$app->request->post()['Overtimeline'] ['Nature_of_Application'] == 'Off_duty_Recall' || Yii::$app->request->post()['Overtimeline'] ['Nature_of_Application'] == 'Leave_Recall' ){
                // exit('hf');
                $model->Normal_Work_Start_Time = null;
                $model->Normal_Work_End_Time = null;
            }


            // Yii::$app->recruitment->printrr(Yii::$app->request->post());

            $result = Yii::$app->navhelper->updateData($service,$model);

            // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Saved Sucesfully');
                return $this->redirect(Yii::$app->request->referrer);

            }else{

                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(Yii::$app->request->referrer);

            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'departments' => $this->getDepartments(),
                'HeaderResult'=>$Headeresult
            ]);
        }

        return $this->render('update',[
            'model' => $model,
        ]);
    }

    public function actionSetNatureOfApplication(){
        $model = new Overtimeline();
        $service = Yii::$app->params['ServiceName']['OvertimeLine'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr(Yii::$app->request->post());
        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->Nature_of_Application = Yii::$app->request->post('NatureOfApplication');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        return $result;

    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['OvertimeLine'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }


    public function actionSetstarttime(){
        $model = new Overtimeline();
        $service = Yii::$app->params['ServiceName']['OvertimeLine'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr(Yii::$app->request->post());
        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->Start_Time = Yii::$app->request->post('Start_Time');
            $model->Date = Yii::$app->request->post('Date');

            if( !null == Yii::$app->request->post('Normal_Start_Time')){
             $model->Normal_Work_Start_Time = Yii::$app->request->post('Normal_Start_Time');
            }
            if( !null == Yii::$app->request->post('Normal_End_Time')){
                $model->Normal_Work_End_Time = Yii::$app->request->post('Normal_End_Time');
               }

        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        return $result;

    }


    public function actionSetendtime(){
        $model = new Overtimeline();
        $service = Yii::$app->params['ServiceName']['OvertimeLine'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($line);
        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->End_Time = Yii::$app->request->post('End_Time');

        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        return $result;

    }

    // Set Location

    public function actionSetlocation(){
        $model = new Storerequisitionline();
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
        $model = new Storerequisitionline();
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


    /*Get Locations*/

    public function getLocations(){
        $service = Yii::$app->params['ServiceName']['Locations'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);
       // return ArrayHelper::map($result,'Code','Name');

        return Yii::$app->navhelper->refactorArray($result,'Code', 'Name');
    }



    /*Get Items*/

    public function getItems(){
        $service = Yii::$app->params['ServiceName']['Items'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);

        return Yii::$app->navhelper->refactorArray($result,'No','Description');
    }




    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];


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


    /*Get Vehicles */
    public function getVehicles(){
        $service = Yii::$app->params['ServiceName']['AvailableVehicleLookUp'];

        $result = \Yii::$app->navhelper->getData($service, []);
        $arr = [];
        $i = 0;
        foreach($result as $res){
            if(!empty($res->Vehicle_Registration_No) && !empty($res->Make_Model)){
                ++$i;
                $arr[$i] = [
                    'Code' => $res->Vehicle_Registration_No,
                    'Description' => $res->Make_Model
                ];
            }
        }

        return ArrayHelper::map($arr,'Code','Description');
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