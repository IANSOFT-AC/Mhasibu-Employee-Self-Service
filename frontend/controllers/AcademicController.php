<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\Academic;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Qualification;
use yii\web\UploadedFile;
use yii\web\Response;
use kartik\mpdf\Pdf;



class AcademicController extends Controller
{
    public  $metadata = [];
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','professional','setfield','read'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','professional','setfield','read'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule,$action){
                            return (Yii::$app->session->has('HRUSER') || !Yii::$app->user->isGuest);
                        },
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

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    public function actionIndex(){
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }
        return $this->render('index');

    }

    public function actionProfessional(){
       
        return $this->render('professional');

    }


   

    public function actionCreate(){

        $model = new Academic();
        $service = Yii::$app->params['ServiceName']['qualifications'];

        $model->Employee_No = Yii::$app->recruitment->getProfileID();
        $model->From_Date = date('Y-m-d');
        $model->To_Date = date('Y-m-d');
        $model->Line_No = time();

        //Create Initial Data
        $record = Yii::$app->navhelper->postData($service, $model);

        if(is_object($record))
        {
            Yii::$app->navhelper->loadmodel($record, $model);
        }else{
            return Yii::$app->recruitment->printrr($record);
        }
       

       
        
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'levels' => Yii::$app->navhelper->dropDown('EducationLevel','Level','Level'),
                'academicQualifications' => Yii::$app->navhelper->dropDown('AcademicQualification','Level','Qualification')

            ]);
        }

        return $this->render('create',[

            'model' => $model,

        ]);
    }

   


    public function actionUpdate(){
        $service = Yii::$app->params['ServiceName']['qualifications'];
       
        $result = Yii::$app->navhelper->readByKey($service,Yii::$app->request->get('Key'));
        $model = new Academic();
        //load nav result to model
        Yii::$app->navhelper->loadmodel($result,$model);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'levels' => Yii::$app->navhelper->dropDown('EducationLevel','Level','Level'),
                'academicQualifications' => Yii::$app->navhelper->dropDown('AcademicQualification','Level','Qualification')

            ]);
        }

    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['qualifications'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        if(!is_string($result)){
            Yii::$app->session->setFlash('success','Qualification Purged Successfully .',true);
            if(!empty(Yii::$app->request->get('path'))){
                //$file = Yii::$app->recruitment->absoluteUrl().Yii::$app->request->get('path');
                unlink(Yii::$app->request->get('path'));
            }
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Purging Qualification: '.$result,true);
            return $this->redirect(['index']);
        }
    }

    public function actionView($ApplicationNo){
       
    }


    public function actionList(){
        $service = Yii::$app->params['ServiceName']['qualifications'];

        $filter = [
            'Employee_No' => \Yii::$app->recruitment->getProfileID()
        ];
        $qualifications = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $count = 0;
        
            foreach($qualifications as $quali){

                ++$count;
                $link = $updateLink =  '';
                $updateLink = Html::a('<i class="fa fa-edit"></i>',['update','Key'=> $quali->Key ],['class'=>'update btn btn-outline-info btn-xs']);

                $link = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $quali->Key ],['class'=>'btn btn-outline-warning btn-xs','data' => [
                    'confirm' => 'Are you sure you want to delete this qualification?',
                    'method' => 'post',
                ]]);

                $documentLink = !empty($quali->Attachement_path)?
                Html::a('<i class="fa fa-file"></i> View',['read','path'=> $quali->Attachement_path ],['class'=>'btn btn-outline-primary btn-md', 'target' => '_blank']):'';

               // $qualificationLink = !empty($quali->Attachement_path)? Html::a('View Document',['read','path'=> $quali->Attachement_path ],['class'=>'btn btn-outline-warning btn-xs']):$quali->Qualification_Code;
                $result['data'][] = [
                    'index' => $count,
                    'Employee_No' => !empty($quali->Employee_No)?$quali->Employee_No:'',
                    'Level' => !empty($quali->Level)?$quali->Level:'',
                    'Academic_Qualification' => !empty($quali->Academic_Qualification)?$quali->Academic_Qualification:'',
                    'From_Date' => !empty($quali->From_Date)?$quali->From_Date:'',
                    'To_Date' => !empty($quali->To_Date)?$quali->To_Date:'',
                    'Description' => !empty($quali->Description)?$quali->Description:'',
                    'Institution_Company' => !empty($quali->Institution_Company)?$quali->Institution_Company:'',
                    'Attachement_path' => !empty($quali->Attachement_path)?$documentLink:'',  
                    'Action' => $updateLink.' | '.$link,
                    
                ];
            
        }
        return $result;

    }    

    /*Read file from local server */
    public function actionRead($path){
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }
        //$absolute = Yii::$app->recruitment->absoluteUrl().$path;
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $fh = file_get_contents($path); //read file into a string or get a file handle resource from sharepoint
        $mimetype = $finfo->buffer($fh); //get mime type

        return $this->render('read',[
            'mimeType' => $mimetype,
            'documentPath' => $path
        ]);
    }

    /*Get file from sharepoint*/
    public function actionDownload($path){
        if(Yii::$app->session->has('mode') && Yii::$app->session->get('mode') == 'external'){
            $this->layout = 'external';
        }
        $base = basename($path);
        $ctx = Yii::$app->recruitment->connectWithUserCredentials(Yii::$app->params['sharepointUrl'],Yii::$app->params['sharepointUsername'],Yii::$app->params['sharepointPassword']);
        $fileUrl = '/'.Yii::$app->params['library'].'/'.$base;
        $targetFilePath = './qualifications/download.pdf';
        $resource = Yii::$app->recruitment->downloadFile($ctx,$fileUrl,$targetFilePath);

        return $this->render('readsharepoint',[
            'content' => $resource
        ]);


    }


     /** Updates a single field */
     public function actionSetfield($field){
        $service = 'qualifications';
        $value = Yii::$app->request->post('fieldValue');
       
        $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
          
    }

    // Global file upload handler


    public function actionUpload()
    {
        $targetPath = '';
        if($_FILES)
        {
            $targetPath = './uploads/'.$_FILES['attachment']['name']; // Upload file
        }
       
        // Upload
        if(Yii::$app->request->isPost)
        {
            $file = $_FILES['attachment']['tmp_name'];
            //Return JSON
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(move_uploaded_file($file,$targetPath))
            {
                return [
                    'status' => 'success',
                    'message' => 'File Uploaded Successfully',
                    'filePath' => $targetPath
                ];
            }else 
            {
                return 'error';
            }
        }
        

        // Update Nav
        if(Yii::$app->request->isGet) 
        {
            $fileName = basename(Yii::$app->request->get('filePath'));
            
            $service = Yii::$app->params['ServiceName'][Yii::$app->request->get('Service')];
            $data = [
                'Key' => Yii::$app->request->get('Key'),
                'Attachement_path' => \yii\helpers\Url::home(true).'uploads/'.$fileName,
            ];
            // Update Nav
            $result = Yii::$app->navhelper->updateData($service, $data);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(is_object($result))
            {
                return $result;
            }else {
                return $result;
            }
            
        }
    }
}