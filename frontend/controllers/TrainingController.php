<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Training;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

use yii\helpers\HTML;


class TrainingController extends Controller
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
                'only' => ['list','list-pending','list-approved','list-confirmation'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex() 
    {
        return $this->render('index');
    }

    public function actionPending()
    {
        return $this->render('pending');
    }

    public function actionApproved()
    {
        return $this->render('approved');
    }

    public function actionConfirm()
    {
        return $this->render('confirm');
    }

    public function actionCreate(){
        $model = new Training();
        $service = Yii::$app->params['ServiceName']['TrainingApplicationCard'];
        $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
        $result = Yii::$app->navhelper->postData($service,$model);

        if(is_object($result)) {
            // Redirect to Update
            return $this->redirect(['update', 'Key' => $result->Key]);
        }

        Yii::$app->session->setFlash('error', $result);
        return $this->redirect(['index']);
    }

    public function actionUpdate($Key){
        $model = new Training();
        $service = Yii::$app->params['ServiceName']['TrainingApplicationCard'];
        $result = Yii::$app->navhelper->readByKey($service,$Key);
        Yii::$app->navhelper->loadmodel($result, $model);

        // Yii::$app->recruitment->printrr($result);
        // TNeed Filters
        $filter = [];
        if(!empty($result->Training_Plan_Calender) && !empty($result->Global_Dimension_1_Code))
        {
            $filter = [
                'Global_Dimension_1_Code' => $result->Global_Dimension_1_Code,
                'Calender_Code' => $result->Training_Plan_Calender
            ];
        }
       

        return $this->render('update',[
            'model' => $model,
            'trainingNeeds' => Yii::$app->navhelper->dropdown('TrainingPlanLines','Training_Need','Training_Need_Description', $filter)
        ]);
    }

    public function actionView($Key='', $No='')
    {
        $model = new Training();
        $service = Yii::$app->params['ServiceName']['TrainingApplicationCard'];
        if(!empty($Key))
        {
            $result = Yii::$app->navhelper->readByKey($service,$Key);
        }elseif(!empty($No)){
            $result = Yii::$app->navhelper->findOne($service,'','Application_No',$No);
        }
        
        Yii::$app->navhelper->loadmodel($result, $model);

        return $this->render('view',[
            'model' => $model,
            'trainingNeeds' => Yii::$app->navhelper->dropdown('TrainingPlanLines','Training_Need','Training_Need_Description')
        ]);
    }
   

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['TrainingClearanceForm'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }


    public function actionList(){
        $service = Yii::$app->params['ServiceName']['TrainingApplicationList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('<i class="fas fa-eye"></i>', ['view','Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs', 'title' => 'View Record Details']);
                $Updatelink = ($req->Status == 'New')?Html::a('<i class="fas fa-pen"></i>', ['update','Key' => $req->Key], ['class' => 'mx-1 btn btn-outline-primary btn-xs','title' => 'Update Record']):'';
                $result['data'][] = [
                    'Application_No' => !empty($req->Application_No) ? $req->Application_No : 'Not Set',
                    'Date_of_Application' => !empty($req->Date_of_Application) ? $req->Date_of_Application : '',
                    'Training_Calender' => !empty($req->Training_Calender) ? $req->Training_Calender : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : 'Not Set',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : '',
                    'Period' =>  !empty($req->Period) ?$req->Period : '',
                    'Trainer' =>  !empty($req->Trainer) ?$req->Trainer : '',
                    'Action' => $Viewlink.$Updatelink,
                ];
            }
        }
        return $result;
    }

    // Pending

    public function actionListPending(){
        $service = Yii::$app->params['ServiceName']['TrainingApplicationList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);
                $result['data'][] = [
                    'Application_No' => !empty($req->Application_No) ? $req->Application_No : 'Not Set',
                    'Date_of_Application' => !empty($req->Date_of_Application) ? $req->Date_of_Application : '',
                    'Training_Calender' => !empty($req->Training_Calender) ? $req->Training_Calender : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : 'Not Set',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : '',
                    'Period' =>  !empty($req->Period) ?$req->Period : '',
                    'Trainer' =>  !empty($req->Trainer) ?$req->Trainer : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',
                ];
            }
        }
        return $result;
    }

    // Approved

    public function actionListApproved(){
        $service = Yii::$app->params['ServiceName']['TrainingApplicationApprovedList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);
                $result['data'][] = [
                    'Application_No' => !empty($req->Application_No) ? $req->Application_No : 'Not Set',
                    'Date_of_Application' => !empty($req->Date_of_Application) ? $req->Date_of_Application : '',
                    'Training_Calender' => !empty($req->Training_Calender) ? $req->Training_Calender : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : 'Not Set',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : '',
                    'Period' =>  !empty($req->Period) ?$req->Period : '',
                    'Trainer' =>  !empty($req->Trainer) ?$req->Trainer : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',
                ];
            }
        }
        return $result;
    }

    // Confirmation

    public function actionListConfirmation(){
        $service = Yii::$app->params['ServiceName']['TrainingApplicationConfirmList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        if(is_array($appraisals)){
            foreach($appraisals as $req){

                $Viewlink = Html::a('View', ['view','Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);
                $result['data'][] = [
                    'Application_No' => !empty($req->Application_No) ? $req->Application_No : 'Not Set',
                    'Date_of_Application' => !empty($req->Date_of_Application) ? $req->Date_of_Application : '',
                    'Training_Calender' => !empty($req->Training_Calender) ? $req->Training_Calender : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : 'Not Set',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : '',
                    'Period' =>  !empty($req->Period) ?$req->Period : '',
                    'Trainer' =>  !empty($req->Trainer) ?$req->Trainer : '',
                    'Action' => !empty($Viewlink) ? $Viewlink : '',
                ];
            }
        }
        return $result;
    }

    /** Updates a single field */
    public function actionSetfield($field){
        $service = 'TrainingApplicationCard';
        $value = Yii::$app->request->post('fieldValue');
       
        $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;    
    }


    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
            'sendMail' => 1,
            'approvalUrl' => '',
        ];


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanSendTrainingForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Sent for Approval Successfully.', true);
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


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanCancelTrainingApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }

    public function actionConfirmTraining($No)
    {
        $service = Yii::$app->params['ServiceName']['HRTrainingManagement'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->Codeunit($service,$data,'IanVouchForEmployeeAttendancePortal');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Confirmed Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }

    



}