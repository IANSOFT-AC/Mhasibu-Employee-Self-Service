<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:33 AM
 */

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

use frontend\models\Employee;
use yii\web\Controller;
use yii\web\Response;

class EmployeeController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
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
        $model = new Employee();
        $service = Yii::$app->params['ServiceName']['EmployeeCard'];
        //Yii::$app->recruitment->printrr(Yii::$app->user->identity);
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $employee = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($employee);
        $model = $this->loadtomodel($employee[0],$model);


        return $this->render('index',[
            'model' => $model,
            'dependants' => (property_exists($employee[0]->Employee_Dependants, 'Employee_Dependants'))?$employee[0]->Employee_Dependants->Employee_Dependants:[],
            'beneficiaries' => (property_exists($employee[0]->Employee_Beneficiaries, 'Employee_Beneficiaries'))?$employee[0]->Employee_Beneficiaries->Employee_Beneficiaries:[],
            'emergency' => (property_exists($employee[0]->Employee_Beneficiaries, 'Employee_Relatives'))?$employee[0]->Employee_Relatives->Employee_Beneficiaries:[],
            'qualifications' => (property_exists($employee[0]->Employee_Qualifications, 'Employee_Qualifications'))?$employee[0]->Employee_Qualifications->Employee_Qualifications:[]

        ]);
    }

    public function actionExpetriate(){
        $model = new Employee();
        $service = Yii::$app->params['ServiceName']['ExpetriateCard'];
        //Yii::$app->recruitment->printrr(Yii::$app->user->identity);
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $employee = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($employee);
        $model = $this->loadtomodel($employee[0],$model);


        return $this->render('expetriate',[
            'model' => $model,
            'dependants' => (property_exists($employee[0]->Employee_Dependants, 'Employee_Dependants'))?$employee[0]->Employee_Dependants->Employee_Dependants:[],
            'beneficiaries' => (property_exists($employee[0]->Employee_Beneficiaries, 'Employee_Beneficiaries'))?$employee[0]->Employee_Beneficiaries->Employee_Beneficiaries:[],
            'emergency' => (property_exists($employee[0]->Employee_Relatives, 'Employee_Relatives'))?$employee[0]->Employee_Relatives->Employee_Relatives:[],
            'qualifications' => (property_exists($employee[0]->Employee_Qualifications, 'Employee_Qualifications'))?$employee[0]->Employee_Qualifications->Employee_Qualifications:[],
            'permits' => (property_exists($employee[0]->Employee_Work_Permits, 'Employee_Work_Permits'))?$employee[0]->Employee_Work_Permits->Employee_Work_Permits:[]

        ]);
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