<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/25/2020
 * Time: 3:55 PM
 */


namespace frontend\controllers;

use common\models\User;
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

class ApprovalsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
                'only' => ['getapprovals','open','rejected','approved','super-approved','super-rejected'],
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


  /* start Rendering of dashboard approval action pages*/

    public function actionOpenApprovals(){

        return $this->render('open');

    }

    public function actionRejectedApprovals(){

        return $this->render('rejected');

    }


    public function actionApprovedApprovals(){

        return $this->render('approved');

    }

    public function actionSapproved() 
    {
        return $this->render('sapproved');
    }

    public function actionSrejected()
    {
        return $this->render('srejected');
    }

    /* End Rendering of dashboard approval action pages*/


    public function actionCreate(){


        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];

        if(\Yii::$app->request->get('create') ){
            //make an initial empty request to nav
            $req = Yii::$app->navhelper->postData($service,[]);
            $modeldata = (get_object_vars($req)) ;
            foreach($modeldata as $key => $val){
                if(is_object($val)) continue;
                $model->$key = $val;
            }

            $model->Start_Date = date('Y-m-d');
            $model->End_Date = date('Y-m-d');

        }

        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();
        $message = "";
        $success = false;

        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){

            $result = Yii::$app->navhelper->updateData($service,Yii::$app->request->post()['Leave']);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Leave request Created Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);

            }else{

                Yii::$app->session->setFlash('error','Error Creating Leave request: '.$result,true);
                return $this->redirect(['index']);

            }

        }



        return $this->render('create',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name'),

        ]);
    }


    public function actionUpdate($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();


        $filter = [
            'Application_No' => $ApplicationNo
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);



        //load nav result to model
        $leaveModel = new Leave();

        $model = $this->loadtomodel($result[0],$leaveModel);



        if($model->load(Yii::$app->request->post()) && Yii::$app->request->post()){
            $result = Yii::$app->navhelper->updateData($model);


            if(!empty($result)){
                Yii::$app->session->setFlash('success','Leave request Updated Successfully',true);
                return $this->redirect(['view','ApplicationNo' => $result->Application_No]);
            }else{
                Yii::$app->session->setFlash('error','Error Updating Leave Request : '.$result,true);
                return $this->redirect(['index']);
            }

        }

        return $this->render('update',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name')
        ]);
    }

    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);


        return $this->render('view',[
            'leave' => $leave[0],
        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        print '<pre>';
        print_r($request);
        return;
    }

    /*Data access functions */

    public function actionLeavebalances(){

        $balances = $this->Getleavebalance();

        return $this->render('leavebalances',['balances' => $balances]);

    }

    public function actionGetapprovals(){
        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];

        $filter = [
           
            'Approver_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Open'
        ];
        $approvals = \Yii::$app->navhelper->getData($service,$filter);


        $result = [];

        $leaveWorkflows = ['Leave_Application','Leave_Reinstatement','Leave_Reimbursement'];
        $Rejectlink = "";

        if(!is_object($approvals)){
            foreach($approvals as $app){

                    if(in_array($app->Document_Type, $leaveWorkflows)){
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Leave',['approve-leave','app'=> $app->Document_No ],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';

                        $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => $app->Document_Type ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";
                    }
                    elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Leave Recall',['approve-recall','app'=> $app->Document_No ],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';

                         $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => 'Leave_Recall' ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";
                    }
                    elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Leave Plan',['approve-leave-plan','app'=> $app->Document_No ],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';


                        $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => 'Leave_Plan' ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";

                    }elseif($app->Document_Type == 'Requisition_Header') // Purchase Requisition
                    {
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Request',['approve-request','app'=> $app->Document_No, 'empNo' => $app->Approver_No, 'docType' => 'Requisition_Header'  ],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';

                        $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => 'Requisition_Header' ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";


                    }
                    elseif($app->Document_Type == 'Contract_Renewal') // Contract Renewal
                    {
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Request',['approve-request','app'=> $app->Document_No, 'empNo' => $app->Approver_No, 'docType' => $app->Document_Type  ],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';

                        $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => $app->Document_Type ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";


                    }
                    elseif($app->Document_Type == 'Change_Request') // Contract Renewal
                    {
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Request',['approve-request','app'=> $app->Document_No, 'empNo' => $app->Approver_No, 'docType' => $app->Document_Type  ],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';

                        $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => $app->Document_Type ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";


                    }
                    else{
                        $Approvelink = ($app->Status == 'Open')? Html::a('Approve Request',['approve-request','app'=> $app->Document_No, 'empNo' => $app->Approver_No, 'docType' => $app->Document_Type],['class'=>'btn btn-success btn-xs','data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ]]):'';

                        $Rejectlink = ($app->Status == 'Open')? Html::a('Reject Request',['reject-request', 'docType' => $app->Document_Type ],['class'=>'btn btn-warning reject btn-xs',
                            'rel' => $app->Document_No,
                            'rev' => $app->Record_ID_to_Approve,
                            'name' => $app->Table_ID
                        ]): "";
                    }

                    


                    /*Card Details */


                    if($app->Document_Type == 'Staff_Board_Allowance'){
                        $detailsLink = Html::a('View Details',['fund-requisition/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Imprest')
                    {
                        $detailsLink = Html::a('Request Details',['imprest/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Leave_Reimbursement')
                    {
                        $detailsLink = Html::a('View Details',['leave-reimburse/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Application')
                    {
                        $detailsLink = Html::a('View Details',['leave/view-approval','No'=> $app->Document_No,'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Contract_Renewal')
                    {
                        $detailsLink = Html::a('View Details',['contractrenewal/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Employee_Exit')
                    {
                        $detailsLink = Html::a('View Details',['exit/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $detailsLink = Html::a('View Details',['leaveplan/view','Plan_No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $detailsLink = Html::a('View Details',['leaverecall/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Change_Request')
                    {
                        $detailsLink = Html::a('View Details',['change-request/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Asset_Assignment')
                    {
                        $detailsLink = Html::a('View Details',['asset-assignment/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Salary_Advance')
                    {
                        $detailsLink = Html::a('View Details',['salaryadvance/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Overtime_Application')
                    {
                        $detailsLink = Html::a('View Details',['overtime/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    else{ //Employee_Exit
                        $detailsLink = '';

                    }





                $result['data'][] = [
                    'Key' => $app->Key,
                    'Entry_No' => $app->Entry_No,
                    'Details' => !empty($app->Details)?$app->Details:'NOT SET',
                    'Comment' => $app->Comment,
                    'Sender_ID' => @$app->Sender_Name,
                    'Document_Type' => $app->Document_Type,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'Approvelink' => $Approvelink,
                    'Rejectlink' => $Rejectlink,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;
    }

 



    public function actionApproveRequest($app, $empNo, $docType = "")
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $app,
            'emplN' => $empNo
        ];

        if($docType == 'Requisition_Header')
        {
        //    Yii::$app->recruitment->printrr($data);

            $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanApproveRequisitionHeader');
        }elseif($docType == 'Leave_Reimbursement')
        {
             $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanApproveLeave');
        }
        elseif($docType == 'Contract_Renewal')
        {
             $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanApproveChangeRequest');
        }
         elseif($docType == 'Overtime_Application')
        {
             $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanApproveOverTime');
        }
          elseif($docType == 'Employee_Exit')
        {
             $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanApproveEmployeeExit');
        }
          elseif($docType == 'Change_Request')
        {
             $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanApproveChangeRequest');
        }
        else{
            $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanApproveImprest');
        }


        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Approved Successfully.', true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error', 'Error Approving Approval Approval Request.  : '. $result);
            return $this->redirect(['index']);
        }
    }

    public function actionRejectRequest($docType = ""){
        $service = Yii::$app->params['ServiceName']['PortalFactory'];
        $Commentservice = Yii::$app->params['ServiceName']['ApprovalCommentsWeb'];

        if(Yii::$app->request->post()){
            
        // print '<pre>';
        // print_r(Yii::$app->request->post());
        // return;

            $comment = Yii::$app->request->post('comment');
            $documentno = Yii::$app->request->post('documentNo');
            $Record_ID_to_Approve = Yii::$app->request->post('Record_ID_to_Approve');
            $Table_ID = Yii::$app->request->post('Table_ID');


           $commentData = [
               'Comment' => $comment,
               'Document_No' => $documentno,
               'Record_ID_to_Approve' => $Record_ID_to_Approve,
               'Table_ID' => $Table_ID
           ];


            $data = [
                'applicationNo' => $documentno,
            ];
            //save comment
            $Commentrequest = Yii::$app->navhelper->postData($Commentservice, $commentData);
           // Call rejection cu function

            if(is_string($Commentrequest)){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['note' => '<div class="alert alert-danger">Error Rejecting Request: '. $Commentrequest.'</div>'];
            }

            if($docType == 'Requisition_Header')
            {
                $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanRejectRequisitionHeader');
            }
            elseif($docType == 'Leave_Reimbursement')
             {
                $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanRejectLeave');
             }
             elseif($docType == 'Contract_Renewal')
             {
                $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanRejectChangeRequest');
             }
              elseif($docType == 'Overtime_Application')
            {
                 $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanRejectOverTime');
            }
            elseif($docType == 'Employee_Exit')
            {
                 $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanRejectEmployeeExit');
            }
            elseif($docType == 'Change_Request')
            {
                 $result = Yii::$app->navhelper->PortalWorkFlows($service,['applicationNo' => $app],'IanRejectChangeRequest');
            }
            else{
                $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanRejectLeave');
            }


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(!is_string($result)){
                return ['note' => '<div class="alert alert-success">Request Rejected Successfully. </div>' ];
            }else{
                return ['note' => '<div class="alert alert-danger">Error Rejecting Request: '.$result.'</div>'];
            }


        }


    }





    public function actionApproveLeave($app)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $app,
            'emplN'=>Yii::$app->user->identity->Employee[0]->No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanApproveLeave');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Approved Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Approving Request.  : '. $result);
            return $this->redirect(['index']);

        }
    }

    public function actionApproveRecall($app)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $app,
            'emplN'=>Yii::$app->user->identity->Employee[0]->No,

        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanApproveLeaveRecall');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Approved Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Approving Request.  : '. $result);
            return $this->redirect(['index']);

        }
    }

    /* Approve Leave Plan */

    public function actionApproveLeavePlan($app)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $app,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanApproveLeavePlan');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Approved Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error Approving Request.  : '. $result);
            return $this->redirect(['index']);

        }
    }

    public function getName($userID){

        //get Employee No
        $user = \common\models\User::find()->where(['User ID' => $userID])->one();
        $No = $user->{'Employee_No'};
        //Get Employees full name
        $service = Yii::$app->params['ServiceName']['Employees'];
        $filter = [
            'No' => $No
        ];

        $results = Yii::$app->navhelper->getData($service,$filter);
        return $results[0]->FullName;
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

        /*Open Approvals*/

    public function actionOpen(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];

        $filter = [
            'Sender_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Open'
        ];
        $approvals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){


                    /*Card Details */


                    if($app->Document_Type == 'Staff_Board_Allowance'){
                        $detailsLink = Html::a('View Details',['fund-requisition/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Imprest')
                    {
                        $detailsLink = Html::a('Request Details',['imprest/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Leave_Reimbursement')
                    {
                        $detailsLink = Html::a('View Details',['leave-reimburse/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Application')
                    {
                        $detailsLink = Html::a('View Details',['leave/view','No'=> $app->Document_No,'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Contract_Renewal')
                    {
                        $detailsLink = Html::a('View Details',['contractrenewal/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Employee_Exit')
                    {
                        $detailsLink = Html::a('View Details',['exit/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $detailsLink = Html::a('View Details',['leaveplan/view','Plan_No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $detailsLink = Html::a('View Details',['leaverecall/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Change_Request')
                    {
                        $detailsLink = Html::a('View Details',['change-request/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Asset_Assignment')
                    {
                        $detailsLink = Html::a('View Details',['asset-assignment/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Salary_Advance')
                    {
                        $detailsLink = Html::a('View Details',['salaryadvance/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Overtime_Application')
                    {
                        $detailsLink = Html::a('View Details',['overtime/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    else{ //Employee_Exit
                        $detailsLink = '';

                    }





                $result['data'][] = [
                    'Key' => $app->Key,
                    'Entry_No' => $app->Entry_No,
                    'Details' => !empty($app->Details)?$app->Details:'NOT SET',
                    'Comment' => $app->Comment,
                    'Sender_ID' => $app->Sender_Name,
                    'Document_Type' => $app->Document_Type,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;
    }

    public function actionRejected()
    {

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];

        $filter = [
            'Sender_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Rejected'
        ];
        $approvals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){

                    /*Card Details */


                    if($app->Document_Type == 'Staff_Board_Allowance'){
                        $detailsLink = Html::a('View Details',['fund-requisition/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Imprest')
                    {
                        $detailsLink = Html::a('Request Details',['imprest/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Leave_Reimbursement')
                    {
                        $detailsLink = Html::a('View Details',['leave-reimburse/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Application')
                    {
                        $detailsLink = Html::a('View Details',['leave/view','No'=> $app->Document_No,'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Contract_Renewal')
                    {
                        $detailsLink = Html::a('View Details',['contractrenewal/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Employee_Exit')
                    {
                        $detailsLink = Html::a('View Details',['exit/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $detailsLink = Html::a('View Details',['leaveplan/view','Plan_No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $detailsLink = Html::a('View Details',['leaverecall/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Change_Request')
                    {
                        $detailsLink = Html::a('View Details',['change-request/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Asset_Assignment')
                    {
                        $detailsLink = Html::a('View Details',['asset-assignment/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Salary_Advance')
                    {
                        $detailsLink = Html::a('View Details',['salaryadvance/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Overtime_Application')
                    {
                        $detailsLink = Html::a('View Details',['overtime/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    else{ //Employee_Exit
                        $detailsLink = '';

                    }





                $result['data'][] = [
                    'Key' => $app->Key,
                    'Entry_No' => $app->Entry_No,
                    'Details' => !empty($app->Details)?$app->Details:'NOT SET',
                    'Comment' => $app->Comment,
                    'Sender_ID' => $app->Sender_Name,
                    'Document_Type' => $app->Document_Type,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;

    }

    public function actionApproved()
    {


        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];

        $filter = [
            'Sender_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Approved'
        ];
        $approvals = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){

                     /*Card Details */


                    if($app->Document_Type == 'Staff_Board_Allowance'){
                        $detailsLink = Html::a('View Details',['fund-requisition/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Imprest')
                    {
                        $detailsLink = Html::a('Request Details',['imprest/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Leave_Reimbursement')
                    {
                        $detailsLink = Html::a('View Details',['leave-reimburse/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Application')
                    {
                        $detailsLink = Html::a('View Details',['leave/view','No'=> $app->Document_No,'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Contract_Renewal')
                    {
                        $detailsLink = Html::a('View Details',['contractrenewal/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Employee_Exit')
                    {
                        $detailsLink = Html::a('View Details',['exit/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $detailsLink = Html::a('View Details',['leaveplan/view','Plan_No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $detailsLink = Html::a('View Details',['leaverecall/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Change_Request')
                    {
                        $detailsLink = Html::a('View Details',['change-request/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Asset_Assignment')
                    {
                        $detailsLink = Html::a('View Details',['asset-assignment/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Salary_Advance')
                    {
                        $detailsLink = Html::a('View Details',['salaryadvance/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Overtime_Application')
                    {
                        $detailsLink = Html::a('View Details',['overtime/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    else{ //Employee_Exit
                        $detailsLink = '';

                    }





                $result['data'][] = [
                    'Key' => $app->Key,
                    'Entry_No' => $app->Entry_No,
                    'Details' => !empty($app->Details)?$app->Details:'NOT SET',
                    'Comment' => $app->Comment,
                    'Sender_ID' => $app->Sender_Name,
                    'Document_Type' => $app->Document_Type,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;

    }

    /*Get Approvals based on supervisor actions -Approved or Rejected -*/

     /*Request I have approved*/

    public function actionSuperApproved(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Approver_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Approved'
        ];
        $approvals = Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){

                     /*Card Details */


                    if($app->Document_Type == 'Staff_Board_Allowance'){
                        $detailsLink = Html::a('View Details',['fund-requisition/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Imprest')
                    {
                        $detailsLink = Html::a('Request Details',['imprest/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Leave_Reimbursement')
                    {
                        $detailsLink = Html::a('View Details',['leave-reimburse/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Application')
                    {
                        $detailsLink = Html::a('View Details',['leave/view','No'=> $app->Document_No,'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Contract_Renewal')
                    {
                        $detailsLink = Html::a('View Details',['contractrenewal/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Employee_Exit')
                    {
                        $detailsLink = Html::a('View Details',['exit/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $detailsLink = Html::a('View Details',['leaveplan/view','Plan_No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $detailsLink = Html::a('View Details',['leaverecall/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Change_Request')
                    {
                        $detailsLink = Html::a('View Details',['change-request/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Asset_Assignment')
                    {
                        $detailsLink = Html::a('View Details',['asset-assignment/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Salary_Advance')
                    {
                        $detailsLink = Html::a('View Details',['salaryadvance/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Overtime_Application')
                    {
                        $detailsLink = Html::a('View Details',['overtime/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    else{ //Employee_Exit
                        $detailsLink = '';

                    }





                $result['data'][] = [
                    'Key' => $app->Key,
                    'Entry_No' => $app->Entry_No,
                    'Details' => !empty($app->Details)?$app->Details:'NOT SET',
                    'Comment' => $app->Comment,
                    'Sender_ID' => $app->Sender_Name,
                    'Document_Type' => $app->Document_Type,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;

       
    }


    /* Requests I have Rejected */

    public function actionSuperRejected(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Approver_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Rejected'
        ];
        $approvals = Yii::$app->navhelper->getData($service,$filter);

        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){

                     /*Card Details */


                    if($app->Document_Type == 'Staff_Board_Allowance'){
                        $detailsLink = Html::a('View Details',['fund-requisition/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Imprest')
                    {
                        $detailsLink = Html::a('Request Details',['imprest/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Leave_Reimbursement')
                    {
                        $detailsLink = Html::a('View Details',['leave-reimburse/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Application')
                    {
                        $detailsLink = Html::a('View Details',['leave/view','No'=> $app->Document_No,'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif($app->Document_Type == 'Contract_Renewal')
                    {
                        $detailsLink = Html::a('View Details',['contractrenewal/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Employee_Exit')
                    {
                        $detailsLink = Html::a('View Details',['exit/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Leave_Plan')
                    {
                        $detailsLink = Html::a('View Details',['leaveplan/view','Plan_No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Leave_Recall')
                    {
                        $detailsLink = Html::a('View Details',['leaverecall/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                      elseif($app->Document_Type == 'Change_Request')
                    {
                        $detailsLink = Html::a('View Details',['change-request/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Asset_Assignment')
                    {
                        $detailsLink = Html::a('View Details',['asset-assignment/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Salary_Advance')
                    {
                        $detailsLink = Html::a('View Details',['salaryadvance/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                     elseif($app->Document_Type == 'Overtime_Application')
                    {
                        $detailsLink = Html::a('View Details',['overtime/view','No'=> $app->Document_No, 'Approval' => true ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    else{ //Employee_Exit
                        $detailsLink = '';

                    }





                $result['data'][] = [
                    'Key' => $app->Key,
                    'Entry_No' => $app->Entry_No,
                    'Details' => !empty($app->Details)?$app->Details:'NOT SET',
                    'Comment' => $app->Comment,
                    'Sender_ID' => $app->Sender_Name,
                    'Document_Type' => $app->Document_Type,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;

        
    }

}