<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentplan;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Objective;
use frontend\models\Trainingplan;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use frontend\models\Resolution;
use yii\web\Response;
use kartik\mpdf\Pdf;

class ResolutionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index'],
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
                'only' => [''],
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

        $model = new Resolution();
        $service = Yii::$app->params['ServiceName']['HRAppraisalManagement'];
        $model->Employee_No = Yii::$app->request->get('Employee_No');
        $model->Appraisal_No =  Yii::$app->request->get('Appraisal_No');
        $model->Line_No = time();


        if(Yii::$app->request->isPost){
            $data = [
                'appraisalNo' => Yii::$app->request->get('Appraisal_No'),
                'employeeNo' => Yii::$app->request->get('Employee_No'),
                'resolution' => Yii::$app->request->post()['Resolution']['Resolution']
            ];
            $request = Yii::$app->navhelper->codeunit($service, $data,'IanaGenerateAppraisalResolutions');
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($request)) {
                return ['note' => '<div class="alert alert-success ">Record Added Successfully</div>'];
            }else{
                return ['note' => '<div class="alert alert-danger">Error : '.$request.'</div>' ];
            }
        }

        
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,

            ]);
        }
           

    }


    public function actionUpdate($Key){
        $model = new Resolution();
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['Resolution'];
        
        $result = Yii::$app->navhelper->readByKey($service,$Key);
        $model->Key = $result->Key;

        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Resolution'],$model) ){
            $result = Yii::$app->navhelper->updateData($service,$model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success ">Record Updated Successfully</div>'];
            }else{

                return ['note' => '<div class="alert alert-danger">Error : '.$result.'</div>' ];
            }

        }

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
        $service = Yii::$app->params['ServiceName']['Resolution'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($ApplicationNo){
       
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


         /** Updates a single field */
         public function actionSetfield($field){
            $service = 'Resolution';
            $value = Yii::$app->request->post('fieldValue');
           
            $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return $result;
              
        }
}