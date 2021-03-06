<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentstrength;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Imprestcard;
use frontend\models\Imprestline;
use frontend\models\Imprestsurrendercard;
use frontend\models\Leaveplancard;
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
use yii\web\Response;
use kartik\mpdf\Pdf;

class ImprestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','surrenderlist'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','surrenderlist', 'get-employees', 'get-currencies', ],
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
                'only' => ['getimprests','getimprestsurrenders', 'get-employees', 'get-currencies', 'getmyimprests', 'getimprestreceipts'],
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

    public function actionSurrenderlist(){

        return $this->render('surrenderlist');

    }

    public function  actionCreateApplyingFor(){
        $model = new Imprestcard() ;
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('ImprestHeader', [
                'model' => $model,
                'employees' => $this->getEmployees(),
                'currencies' => $this->getCurrencies()

            ]);
        }

        if(isset(Yii::$app->request->post()['Imprestcard'])){
            
            // Yii::$app->recruitment->printrr(Yii::$app->request->post()['Imprestcard']);

            if(Yii::$app->request->post()['Imprestcard']['Request_For']== 'Self'){
                $model->Employee_No = Yii::$app->user->identity->employee[0]->No;
            }else{
                $model->Employee_No = Yii::$app->request->post()['Imprestcard']['Employee_No'];

            }
           
            $request = Yii::$app->navhelper->postData($service,$model);
            if(!is_string($request) )
            {
                $model = Yii::$app->navhelper->loadmodel($request,$model);

                if(Yii::$app->request->post()['Imprestcard']['Imprest_Type']== 'Local'){
                    $model->Imprest_Type = Yii::$app->request->post()['Imprestcard']['Imprest_Type'];
                    $model->Currency_Code = '';
                }else{
                    $model->Imprest_Type = Yii::$app->request->post()['Imprestcard']['Imprest_Type'];
                    $model->Currency_Code = Yii::$app->request->post()['Imprestcard']['Currency_Code'];
                    $model->Exchange_Rate = Yii::$app->request->post()['Imprestcard']['Exchange_Rate'];
                }

                // Update Request for
                $model->Request_For = Yii::$app->request->post()['Imprestcard']['Request_For'];
                $model->Purpose = Yii::$app->request->post()['Imprestcard']['Purpose'];

                $model->Key = $request->Key;
                $request = Yii::$app->navhelper->updateData($service, $model);

                $model = Yii::$app->navhelper->loadmodel($request,$model);
                if(is_string($request)){
                    Yii::$app->session->setFlash('error', $request);
                    return $this->redirect(Yii::$app->request->referrer);
                }

                Yii::$app->session->setFlash('success','Imprest Request Created Successfully.' );

                // Yii::$app->recruitment->printrr($result);
                return $this->redirect(['update','No' => $request->No]);

            }else {
                Yii::$app->session->setFlash('error', $request);
                return $this->redirect(Yii::$app->request->referrer);

            }
        }

    }

    public function  actionCreateApplyingForSurrender(){
        $model = new Imprestcard() ;
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('ImprestHeader', [
                'model' => $model,
                'employees' => $this->getEmployees(),
                'currencies' => $this->getCurrencies()

            ]);
        }

        if(isset(Yii::$app->request->post()['Imprestcard'])){
            
            // Yii::$app->recruitment->printrr(Yii::$app->request->post()['Imprestcard']);

            if(Yii::$app->request->post()['Imprestcard']['Request_For']== 'Self'){
                $model->Employee_No = Yii::$app->user->identity->employee[0]->No;
            }else{
                $model->Employee_No = Yii::$app->request->post()['Imprestcard']['Employee_No'];

            }
           
            $request = Yii::$app->navhelper->postData($service,$model);
            if(!is_string($request) )
            {
                $model = Yii::$app->navhelper->loadmodel($request,$model);

                if(Yii::$app->request->post()['Imprestcard']['Imprest_Type']== 'Local'){
                    $model->Imprest_Type = Yii::$app->request->post()['Imprestcard']['Imprest_Type'];
                    $model->Currency_Code = '';
                }else{
                    $model->Imprest_Type = Yii::$app->request->post()['Imprestcard']['Imprest_Type'];
                    $model->Currency_Code = Yii::$app->request->post()['Imprestcard']['Currency_Code'];
                    $model->Exchange_Rate = Yii::$app->request->post()['Imprestcard']['Exchange_Rate'];
                }

                // Update Request for
                $model->Request_For = Yii::$app->request->post()['Imprestcard']['Request_For'];
                $model->Purpose = Yii::$app->request->post()['Imprestcard']['Purpose'];

                $model->Key = $request->Key;
                $request = Yii::$app->navhelper->updateData($service, $model);

                $model = Yii::$app->navhelper->loadmodel($request,$model);
                if(is_string($request)){
                    Yii::$app->session->setFlash('error', $request);
                    return $this->redirect(Yii::$app->request->referrer);
                }

                Yii::$app->session->setFlash('success','Imprest Request Created Successfully.' );

                // Yii::$app->recruitment->printrr($result);
                return $this->redirect(['update','No' => $request->No]);

            }else {
                Yii::$app->session->setFlash('error', $request);
                return $this->redirect(Yii::$app->request->referrer);

            }
        }

    }


    public function actionCreate($RequestFor='Self'){

        $model = new Imprestcard() ;
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];
       
        // Once Initial Request is Made Redirect to Update Page

        if($RequestFor == 'Self')
        {
            $model->Request_For = $RequestFor;
            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $request = Yii::$app->navhelper->postData($service,$model);
            if(is_object($request)){
                return $this->redirect(['update','Key' => $request->Key]);
            }else{ // error situation
                Yii::$app->session->setFlash('error',$request, true);
                return $this->redirect(['index']);
            }
        }else { // Other
            $model->Request_For = $RequestFor;
            $request = Yii::$app->navhelper->postData($service,$model);
            if(is_object($request)){
                return $this->redirect(['update','Key' => $request->Key]);
            }else{ // error situation
                Yii::$app->session->setFlash('error',$request, true);
                return $this->redirect(['index']);
            }
        }
       
    }

    

    public function actionCreateSurrender(){
        // Yii::$app->recruitment->printrr(Yii::$app->request->get('requestfor'));
        $model = new Imprestsurrendercard();
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderCardPortal'];

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('createsurrender',[
                'model' => $model,
                'employees' => $this->getEmployees(),
                'programs' => $this->getPrograms(),
                'departments' => $this->getDepartments(),
                'currencies' => $this->getCurrencies(),
                'imprests' => $this->getmyimprests(),
                'receipts' => $this->getimprestreceipts($model->No)
            ]);
        }

        /*Do initial request */
        $request = Yii::$app->navhelper->postData($service,[]);
        // Yii::$app->recruitment->printrr($request);

        if(is_object($request) ){
            Yii::$app->navhelper->loadmodel($request,$model);
        }
        if(is_string($request)){
            Yii::$app->recruitment->printrr($request);
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Imprestsurrendercard'],$model) ){

            $filter = [
                'No' => $model->No,
            ];

            $refresh = Yii::$app->navhelper->getData($service,$filter);

            if(Yii::$app->request->post()['Imprestsurrendercard']['Request_For']== 'Self'){
                $model->Employee_No = Yii::$app->user->identity->employee[0]->No;
            }else{
                $model->Employee_No = Yii::$app->request->post()['Imprestsurrendercard']['Employee_No'];

            }

            $model->Key = $refresh[0]->Key;

            // Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model);


            if(!is_string($result)){
                //Yii::$app->recruitment->printrr($result);
                Yii::$app->session->setFlash('success','Imprest Request Created Successfully.' );

                return $this->redirect(['view-surrender','No' => $result->No]);

            }else{
                Yii::$app->session->setFlash('error',$result );
                return $this->redirect(Yii::$app->request->referrer);

            }

        }

    }


    public function actionUpdate($No = '', $Key = ''){
        $model = new Imprestcard() ;
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];
        $ERPservice = Yii::$app->params['ServiceName']['ImprestRequestCard'];
        $model->isNewRecord = false;

        // Get Document
        if(!empty($No))
        {
            $document = Yii::$app->navhelper->findOne($service, '','No',$No);
            $pageRecord = Yii::$app->navhelper->findOne($ERPservice, '','No',$No);
        }elseif(!empty($Key)){
            $document = Yii::$app->navhelper->readByKey($service,$Key);
            $pageRecord = Yii::$app->navhelper->readByKey($ERPservice,$Key);
        }else{
            Yii::$app->session->setFlash('error', 'We are unable to fetch a document to update', true);
            return Yii::$app->redirect(['index']);
        }

        if(is_object($document)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($document,$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->session->setFlash('error', $document, true);
            return Yii::$app->redirect(['index']);
        }


    
        return $this->render('update',[
            'model' => $model,
            'employees' => $this->getEmployees(),
            'programs' => $this->getPrograms(),
            'departments' => $this->getDepartments(),
            'currencies' => $this->getCurrencies(),
            'document' => $pageRecord
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No){
        $service = Yii::$app->params['ServiceName']['ImprestRequestCard'];

        $filter = [
            'No' => $No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $model = $this->loadtomodel($result[0], new Imprestcard());

        //Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }

    /*Print Imprest*/
    public function actionPrintImprest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalReports'];
        $data = [
            'imprest' => $No
        ];
        $path = Yii::$app->navhelper->Codeunit($service,$data,'IanGenerateImprest');
        if(!is_file($path['return_value'])){
          Yii::$app->session->setFlash('error','File is not available: '.$path['return_value']);
          return $this->render('printout',[
              'report' => false,
              'content' => null,
              'No' => $No
          ]);
        }

        $binary = file_get_contents($path['return_value']);
        $content = chunk_split(base64_encode($binary));
        //delete the file after getting it's contents --> This is some house keeping
        unlink($path['return_value']);
        return $this->render('printout',[
            'report' => true,
            'content' => $content,
            'No' => $No
        ]);

    }

    /*Print Surrender*/
    public function actionPrintSurrender($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalReports'];
        $data = [
            'surrender' => $No
        ];
        $path = Yii::$app->navhelper->Codeunit($service,$data,'IanGenerateImprestSurrender');
        if(!is_file($path['return_value'])){
            Yii::$app->session->setFlash('error','File is not available: '.$path['return_value']);
            return $this->render('printout',[
                'report' => false,
                'content' => null,
                'No' => $No
            ]);
        }

        $binary = file_get_contents($path['return_value']);
        $content = chunk_split(base64_encode($binary));
        //delete the file after getting it's contents --> This is some house keeping
        unlink($path['return_value']);
        return $this->render('printout',[
            'report' => true,
            'content' => $content,
            'No' => $No
        ]);

    }

    /*Imprest surrender card view*/

    public function actionViewSurrender($No){
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderCard'];
        $model = new Imprestsurrendercard();
        
        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Imprestsurrendercard'],$model) ){

                    //    Yii::$app->recruitment->printrr($model);

            $filter = [
                'No' => $model->No,
            ];

            $refresh = Yii::$app->navhelper->getData($service,$filter);

            if(Yii::$app->request->post()['Imprestsurrendercard']['Request_For']== 'Self'){
                $model->Employee_No = Yii::$app->user->identity->employee[0]->No;
            }else{
                $model->Employee_No = Yii::$app->request->post()['Imprestsurrendercard']['Employee_No'];

            }

            $model->Key = $refresh[0]->Key;

            // Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model);


            if(!is_string($result)){
                //Yii::$app->recruitment->printrr($result);
                Yii::$app->session->setFlash('success','Imprest Request Created Successfully.' );

                return $this->redirect(['view-surrender','No' => $result->No]);

            }else{
                Yii::$app->session->setFlash('error',$result );
                return $this->redirect(Yii::$app->request->referrer);

            }

        }

        $filter = [
            'No' => $No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        //load nav result to model
        $model = $this->loadtomodel($result[0], $model);

        return $this->render('viewsurrender',[
            'model' => $model,
            'employees' => $this->getEmployees(),
            'programs' => $this->getPrograms(),
            'departments' => $this->getDepartments(),
            'currencies' => $this->getCurrencies(),
            'imprests' => $this->getmyimprests(),
            'receipts' => $this->getimprestreceipts($model->No)
        ]);
    }

    // Get imprest list

    public function actionGetimprests(){
        $service = Yii::$app->params['ServiceName']['ImprestRequestListPortal'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        // Yii::$app->recruitment->printrr( $results);
        if(is_array($results))
        {
            foreach($results as $item){

                if(isset($item->No) && isset($item->Key)){
                    $link = $updateLink = $deleteLink =  '';
                    $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->No ],['class'=>'btn btn-outline-primary btn-xs']);
                    if($item->Status == 'New'){
                        $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);

                        $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> $item->No ],['class'=>'btn btn-info btn-xs']);
                    }else if($item->Status == 'Pending_Approval'){
                        $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> $item->No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
                    }

                    $result['data'][] = [
                        'Key' => $item->Key,
                        'No' => !empty($item->No)?$item->No:'',
                        'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                        'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                        'Purpose' => !empty($item->Purpose)?$item->Purpose:'',
                        'Imprest_Amount' => !empty($item->Imprest_Amount)?$item->Imprest_Amount:'',
                        'Status' => $item->Status,
                        'Action' => $link,
                        'Update_Action' => $updateLink,
                        'view' => $Viewlink
                    ];
                }

            }
        }


        return $result;
    }

    // Get Imprest  surrender list

    public function actionGetimprestsurrenders(){
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];
        //Yii::$app->recruitment->printrr( );
        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];

        if(is_array($results))
        {
            foreach($results as $item){
                $link = $updateLink = $deleteLink =  '';
                $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view-surrender','No'=> $item->No ],['class'=>'btn btn-outline-primary btn-xs']);
                if($item->Status == 'New'){
                    $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);

                    $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> $item->No ],['class'=>'btn btn-info btn-xs']);
                }else if($item->Status == 'Pending_Approval'){
                    $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> $item->No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
                }

                $result['data'][] = [
                    'Key' => $item->Key,
                    'No' => $item->No,
                    'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                    'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                    'Purpose' => !empty($item->Purpose)?$item->Purpose:'',
                    'Imprest_Amount' => !empty($item->Imprest_Amount)?$item->Imprest_Amount:'',
                    'Status' => $item->Status,
                    'Action' => $link,
                    'Update_Action' => $updateLink,
                    'view' => $Viewlink
                ];
            }
        }


        return $result;
    }


    public function getEmployees(){
        $service = Yii::$app->params['ServiceName']['Employees'];

        $employees = \Yii::$app->navhelper->getData($service);
        return ArrayHelper::map($employees,'No','Full_Name');
    }

    public function actionGetEmployees(){
        $service = Yii::$app->params['ServiceName']['Employees'];

        $employees = \Yii::$app->navhelper->getData($service);
        return $employees;
    }

    /* My Imprests*/

    public function getmyimprests($EmpNo = ''){
        $service = Yii::$app->params['ServiceName']['PostedImprestRequest'];
        $filter = [
            'Employee_No' => empty($EmpNo)?Yii::$app->user->identity->Employee[0]->No:$EmpNo,
            'Surrendered' => false,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_Amount
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }


    public function actionGetmyimprests($EmpNo = ''){
        $service = Yii::$app->params['ServiceName']['PostedImprestRequest'];
        $filter = [
            'Employee_No' => empty($EmpNo)?Yii::$app->user->identity->Employee[0]->No:$EmpNo,
            'Surrendered' => false,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_Amount
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return $result;
    }


    

    /* Get My Posted Imprest Receipts */

    public function getimprestreceipts($imprestNo){
        $service = Yii::$app->params['ServiceName']['PostedReceiptsList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Imprest_No' => $imprestNo,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_No
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }


    public function actionGetimprestreceipts($imprestNo=''){
        $service = Yii::$app->params['ServiceName']['PostedReceiptsList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Imprest_No' => $imprestNo,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_No
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
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


    // Get Currencies

    public function getCurrencies(){
        $service = Yii::$app->params['ServiceName']['Currencies'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return @ArrayHelper::map($result,'Code','Description');
    }

    public function actionGetCurrencies(){
        $service = Yii::$app->params['ServiceName']['Currencies'];

        $result = \Yii::$app->navhelper->getData($service, []);
        return $result;;
    }

    public function actionSetemployee(){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Employee_No = Yii::$app->request->post('Employee_No');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    public function actionSetdimension($dimension){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->{$dimension} = Yii::$app->request->post('dimension');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /* Set Imprest Type */

    public function actionSetimpresttype(){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_Type = Yii::$app->request->post('Imprest_Type');
        }


        $result = Yii::$app->navhelper->updateData($service,$model,['Amount_LCY']);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

        /*Set Imprest to Surrend*/

    public function actionSetimpresttosurrender(){
        $model = new Imprestsurrendercard();
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_No = Yii::$app->request->post('Imprest_No');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

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

    /* Call Approval Workflow Methods */

    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
            'sendMail' => 1,
            'approvalUrl' => '',
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanSendImprestForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Imprest Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Imprest Request for Approval  : '. $result);
            return $this->redirect(['view', 'No'=>$No]);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelImprestForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Imprest Request Cancelled Successfully.', true);
            return $this->redirect(['view']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Imprest Approval Request.  : '. $result);
            return $this->redirect(['view']);

        }
    }

    /** Updates a single field */
    public function actionSetfield($field){
        $service = 'ImprestRequestCardPortal';
        $value = Yii::$app->request->post('fieldValue');
        $result = Yii::$app->navhelper->Commit($service,[$field => $value],Yii::$app->request->post('Key'));
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
          
    }

    public function actionAddLine($Service,$Document_No)
    {
        $service = Yii::$app->params['ServiceName'][$Service];
        $data = [
            'Request_No' => $Document_No,
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


    public function actionTransactiontypes(){ 
        $result  = Yii::$app->navhelper->dropdown('PaymentTypes','Code','Description',['Source_Type' => 'Imprest']);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    
        return $result;
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