<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Donorline;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\Response;


class DonorlineController extends Controller
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

    public function actionCreate(){

       $service = Yii::$app->params['ServiceName']['NewEmployeeDonors'];
       $model = new Donorline();

        //Yii::$app->recruitment->printrr(Yii::$app->request->get());
        if(Yii::$app->request->isGet && !isset(Yii::$app->request->post()['Donorline'])){

               
                $model->Contract_Code = Yii::$app->request->get('Contract_Code');//$Contract_Code;
                $model->Contract_Line_No = Yii::$app->request->get('Contract_Line_No'); // $Contract_Line_No;
                $model->Employee_No = Yii::$app->request->get('Employee_No'); //  $Employee_No;
                $model->Change_No =  Yii::$app->request->get('Change_No');//$Change_No;
                $model->Grant_Start_Date = Yii::$app->request->get('Grant_Start_Date');
                $model->Grant_End_Date = Yii::$app->request->get('Grant_End_Date');
                

                $result = Yii::$app->navhelper->postData($service, $model);
                if(is_string($result)){
                    Yii::$app->recruitment->printrr($result);
                }
                $model = Yii::$app->navhelper->loadmodel($result,$model);
        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Donorline'],$model) ){



            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Line Added Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Adding Line: '.$result.'</div>'];
            }

        }

               // $model->Grant_Start_Date = date('Y-m-d');
               // $model->Grant_End_Date = date('Y-m-d');
                $model->isNewRecord = true;

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'donors' => $this->getDonors()
            ]);
        }


    }


    public function actionUpdate($Line_No){
       
       $service = Yii::$app->params['ServiceName']['NewEmployeeDonors'];
       $model = new Donorline();
        $model->isNewRecord = false;
       
        $filter = [
            
            'Line_No' => $Line_No,
            
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Donorline'],$model) ){

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
                'donors' => $this->getDonors()
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'donors' => $this->getDonors()
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['NewEmployeeDonors'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionSetfield($field){
        $model = new Donorline();
        $service = Yii::$app->params['ServiceName']['NewEmployeeDonors'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);
        //Yii::$app->recruitment->printrr($line);
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

    /*Get Donor List */

    public function getDonors(){
        $service = Yii::$app->params['ServiceName']['DonorList'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);

        return Yii::$app->navhelper->refactorArray($result,'Donor_Code','Donor_Name');

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