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
use frontend\models\Misc;
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

class FmsController extends Controller
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

         $fmsGrants = $this->getGrants();

         // Yii::$app->recruitment->printrr($fmsGrants);  

         //Yii::$app->recruitment->printrr($this->actionEssGrantCodes());

         
        
         $i = 0;
         foreach($fmsGrants as $grant)
         {
            ++$i;

            if(!in_array($grant->No,$this->actionEssGrantCodes()))
            {
                /*print_r($grant);
                exit();*/
               
                
                 $result = $this->postToEss($grant);


                 sleep(5);
            }

           /* else{
                $this->updateGrant($fmsGrants[$i]);
                sleep(5);
                print 'Updating: '.$grant->No;
            }*/
           
         }

    }

    public function actionTest()
    {
        return 'Hallo Francis, what are you doing? ';
    }

    public function actionCreate($Change_No){

        $model = new Misc();
        $service = Yii::$app->params['ServiceName']['Miscinformation'];
        $model->Action = 'New_Addition';
        $model->Change_No = $Change_No;
        $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
       
        $model->isNewRecord = true;

        if(Yii::$app->request->post() && $model->load(Yii::$app->request->post()['Misc'],'')  && $model->validate() ){

           
            $result = Yii::$app->navhelper->postData($service,$model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(is_object($result)){

                return ['note' => '<div class="alert alert-success">Record Added Successfully. </div>'];

            }else{

                return ['note' => '<div class="alert alert-danger">Error Adding Record : '.$result.'</div>' ];

            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'articles' => $this->getMiscArticles(),
                
            ]);
        }

        return $this->render('create',[
            'model' => $model,
            'articles' => $this->getMiscArticles(),
           
        ]);
    }


    public function actionUpdate(){
        $model = new Employeeappraisalkpi() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPI'];
        $filter = [
            'KRA_Line_No' => Yii::$app->request->get('KRA_Line_No'),
            'Employee_No' => Yii::$app->request->get('Employee_No'),
            'Appraisal_No' => Yii::$app->request->get('Appraisal_No'),
            'Line_No' => Yii::$app->request->get('Line_No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Employeeappraisalkpi'],$model) && $model->validate() ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success">Employee Objective/ KPI Updated Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Updating Employee Objective/ KPI: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'ratings' => $this->getRatings(),
                'assessments' => $this->getPerformancelevels(),
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'ratings' => $this->getRatings(),
            'assessments' => $this->getPerformancelevels() ,
        ]);
    }



    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPI'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
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




    public function getGrants()
    {
          $service = Yii::$app->params['FMS-ServiceName']['FMSGrants'];
          $data = Yii::$app->fms->getData($service, []);
          return $data;
    }


     public function actionEssGrants()
    {
          $service = Yii::$app->params['ServiceName']['GrantList'];
          $data = Yii::$app->navhelper->getData($service, []);
          // return $data;

          Yii::$app->recruitment->printrr($data);
    }

    public function postToEss($grant)
    {
        // Yii::$app->recruitment->printrr($grant->Name);
        $service = Yii::$app->params['ServiceName']['GrantList'];

        $args = [
            'Donor_Code' => !empty($grant->No)?$grant->No:'',
            'Donor_Name' => !empty($grant->Name)?$grant->Name:'',
            'Status' => ($grant->Blocked == '_blank_')?'Inactive':'Active',
            'Grant_Activity' => '',
            'Grant_Type' => !empty($grant->Class)?$grant->Class:'' ,
            'Grant_Start_Date' => !empty($grant->Start_Date)?$grant->Start_Date: date('Y-m-d'),
            'Grant_End_Date' => !empty($grant->End_Date)?$grant->End_Date: date('Y-m-d'),
            'Grant_Accountant' => !empty($grant->Grant_Accountant)?$grant->Grant_Accountant: date('Y-m-d'),
        ];

        // Post to ESS


        $result = Yii::$app->navhelper->postData($service, $args);

        if(!is_string($result)){
            print '<br>';
            print_r($result);
        }else{
            print '<br>';
            print_r('Error Posting to Nav: '.$result);
        }

        exit(true);

       
        
    }

    public function updateGrant($grant)
    {
        // Yii::$app->recruitment->printrr($grant->Name);
        $service = Yii::$app->params['ServiceName']['GrantList'];

        $args = [
            'Donor_Code' => $grant->No ,
        ];

        $result = Yii::$app->navhelper->getData($service, $args);

       


        if(is_array($result))
        {
             $data = [
                    
                    
                    'Key' => $result[0]->Key
                ];


                // Post to ESS

                $res = Yii::$app->navhelper->updateData($service, $data);


                print '<br>';
                print_r($res);
                exit(true);
        }
        

       
    }


    public function actionEssGrantCodes()
    {
          $service = Yii::$app->params['ServiceName']['GrantList'];
          $data = Yii::$app->navhelper->getData($service, []);

           

          $codes = [];

          foreach($data as $d)
          {
            if(isset($d->Donor_Code)){
                 array_push($codes, $d->Donor_Code);
            }
           
          }

          return $codes;

         // Yii::$app->recruitment->printrr($codes);
    }





}