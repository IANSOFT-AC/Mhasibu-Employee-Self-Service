<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\ProbationAnswer;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;


class ProbationAnswerController extends Controller
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
                        'actions' => ['logout','index','create','update','delete'],
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

    public function actionCreate($Employee_No, $Appraisal_No,$Question_Line_No){

        $model = new ProbationAnswer();
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalAnswers'];
        $model->Appraisal_No = $Appraisal_No;
        $model->Employee_No = $Employee_No;
        $model->Question_Line_No = $Question_Line_No;
        $model->Line_No = time();

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['ProbationAnswer'],$model)  && $model->validate() ){
               
            // exit('done...');
            $result = Yii::$app->navhelper->postData($service,$model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(is_object($result)){

                return ['note' => '<div class="alert alert-success">Record Added Successfully. </div>'];

            }else{

                return ['note' => '<div class="alert alert-danger">Error : '.$result.'</div>' ];

            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        }

        return $this->render('create',[
            'model' => $model
        ]);
    }


    public function actionUpdate($Key){
        $model = new ProbationAnswer() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalAnswers'];
       
        $result = Yii::$app->navhelper->readByKey($service,$Key);

        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['note' => '<div class="alert alert-danger">Error Updating Record: '.$result.'</div>'];
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['ProbationAnswer'],$model) && $model->validate() ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Record Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Record: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model
            ]);
        }

        return $this->render('update',[
            'model' => $model
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalAnswers'];
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


}