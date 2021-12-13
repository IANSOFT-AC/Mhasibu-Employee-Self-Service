<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Probation Appraisal - '.$model->Appraisal_No;
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal View', 'url' => ['view','Employee_No'=> $model->Employee_No,'Appraisal_No' => $model->Appraisal_No]];



$absoluteUrl = \yii\helpers\Url::home(true);
/** Status Sessions */

Yii::$app->session->set('Appraisal_Status',$model->Appraisal_Status);
Yii::$app->session->set('Probation_Recomended_Action',$model->Probation_Recomended_Action);
Yii::$app->session->set('Goal_Setting_Status',$model->Goal_Setting_Status);

// print (Yii::$app->session->get('Probation_Recomended_Action')); exit;


 if(Yii::$app->session->hasFlash('success')){
            print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
            echo Yii::$app->session->getFlash('success');
            print '</div>';
        }else if(Yii::$app->session->hasFlash('error')){
            print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
            echo Yii::$app->session->getFlash('error');
            print '</div>';
        }

?>

<div class="row">
    <div class="col-md-12">
        <div class="card-info">
            <div class="card-header">
                <h3>Probation Appraisal Card </h3>
            </div>
            
            <div class="card-body info-box">

                <div class="row">
                    <?php if(($model->Goal_Setting_Status == 'New' && $model->isAppraisee()) || $model->Appraisal_Status == 'Agreement_Level'): ?>

                                <div class="col-md-4">

                                    <?php Html::a('<i class="fas fa-forward"></i> submit',['submit','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],['class' => 'btn btn-app submitforapproval','data' => [
                                            'confirm' => 'Are you sure you want to submit this probation appraisal to supervisor ?',
                                            'method' => 'post',
                                        ],
                                        'title' => 'Submit KRAs to Line Manager.'

                                    ]) ?>
                                </div>

                    <?php endif; ?>


                    
                    <?php if($model->Goal_Setting_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>
                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-forward"></i> To Overview',['submittooverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],['class' => 'btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to submit this appraisal to Overview Manager ?',
                                'method' => 'post',
                            ],
                                'title' => 'Submit Goals for Approval'

                            ]) ?>
                        </div>
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-backward"></i>Send Back',['backtoemp','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                ['
                                class' => 'mx-1 btn btn-app bg-danger rejectgoalsettingbyoverview',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                'title' => 'Reject KRAs and Send them Back to Appraisee.'

                            ]) ?>
                        </div>

                    <?php endif; ?>


                     <?php if($model->Goal_Setting_Status == 'Overview_Manager' && $model->isOverview()): ?>
                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-backward"></i> Line Mgr.',['backtolinemgr','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'mx-1 btn btn-app bg-danger rejectgoals',
                                    'rel' => $_GET['Appraisal_No'],
                                    'rev' => $_GET['Employee_No'],
                                    'title' => 'Submit Probation  Back to Line Manager'

                            ]) ?>
                        </div>
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-forward"></i> Approve',['approvegoals','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-2 btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to approve goals ?',
                                'method' => 'post',
                            ],
                                'title' => 'Approve Set Probation Goals .'
                            ]) ?>

                        </div>

                    <?php endif; ?>

                    <!-- Send Probation to Line Mgr -->

                    <?php if($model->Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()): ?>

                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-forward"></i> Submit ',['submitprobationtolinemgr','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-1 btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to Submit Probation Appraisal to Line Manager ?',
                                'method' => 'post',
                            ],
                                'title' => 'Submit Probation to Line Manager.'
                            ]) ?>

                        </div>

                    <?php endif; ?>

                        

                    <!-- Line Mgr Actions on complete goals -->

                    <?php if($model->Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>


                         <?= Html::a('<i class="fas fa-backward"></i> To Appraisee.',['probationbacktoappraisee','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'btn btn-app bg-danger rejectappraiseesubmition',
                                    'rel' => $_GET['Appraisal_No'],
                                    'rev' => $_GET['Employee_No'],
                                    'title' => 'Submit Probation  Back to Appraisee'

                            ]) ?>


                            <!-- Send Probation to Overview -->

                            <?= Html::a('<i class="fas fa-forward"></i> Submit ',['submitprobationtooverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-1 btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to Submit Probation Appraisal to Overview Manager ?',
                                'method' => 'post',
                            ],
                                'title' => 'Submit Probation to Overview Manager.'
                            ]) ?>


                           



                    <?php endif; ?>

                    <!-- Overview Manager Actions -->

                    <?php if($model->Appraisal_Status == 'Overview_Manager' && $model->isOverview()): ?>
                        
                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-backward"></i> To Line Mgr.',['overviewbacktolinemgr','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'mx-1 btn btn-app bg-danger Overviewbacktolinemgr',
                                    'rel' => $_GET['Appraisal_No'],
                                    'rev' => $_GET['Employee_No'],
                                    'title' => 'Send Probation Appraisal Back to Line Manager'

                            ]) ?>

                        </div>

                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-check"></i> Approve',['approveprobationoverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-1 btn btn-app bg-success submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to approve goals ?',
                                'method' => 'post',
                            ],
                                'title' => 'Approve Probation Appraisal.'
                            ]) ?>

                        </div>

                    <?php endif; ?>



                   


                    <?php if($model->Appraisal_Status == 'HR_Level' && $model->Hr_UserId == Yii::$app->user->identity->getId() ): ?>

                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-forward"></i> Approve',['close','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],['class' => 'btn bg-success btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to approve this probation appraisal?',
                                'method' => 'post',
                            ],
                                'title' => 'Approve and Close Probation Appraisal.'

                            ]) ?>
                        </div>

                        <div class="col-md-4">&nbsp;</div>

                        <div class="col-md-4">

                            <?= Html::a('<i class="fas fa-backward"></i> Send Back',['backtosuper','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],['class' => 'btn btn-app bg-danger submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to send back this probation appraisal to supervisor ?',
                                'method' => 'post',
                            ],
                                'title' => 'Send Probation Appraisal Back to Supervisor.'

                            ]) ?>
                        </div>



                    <?php endif; ?>

                    <div class="col-md-4">
                             <?=  ($model->Appraisal_Status == 'Closed')?Html::a('<i class="fas fa-book-open"></i> P.A Report',['report','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-success  pull-right',
                                'title' => 'Generate Performance Appraisal Report',
                                'target'=> '_blank',
                                'data' => [
                                    // 'confirm' => 'Are you sure you want to send appraisal to peer 2?',
                                    'params'=>[
                                        'appraisalNo'=> $_GET['Appraisal_No'],
                                        'employeeNo' => $_GET['Employee_No'],
                                    ],
                                    'method' => 'post',]
                            ]):'';
                            ?>
                    </div>
                    



                </div>

            </div>
           
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Appraisal : <?= $model->Appraisal_No?></h3>

            </div>
            <div class="card-body">


               <?php $form = ActiveForm::begin(); ?>


               <div class="row">
                   <div class=" row col-md-12">
                       <div class="col-md-6">

                           <?= $form->field($model, 'Appraisal_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <?= $form->field($model, 'Probation_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Probation_End_date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <p class="parent"><span>+</span>
                               <?= $form->field($model, 'Job_Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                               <?= $form->field($model, 'Goal_Setting_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                           </p>


                       </div>
                       <div class="col-md-6">

                           <?= $form->field($model, 'Appraisal_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Supervisor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Overall_Score')->textInput(['readonly'=> true]) ?>

                           <?= $form->field($model, 'Supervisor_Rejection_Comments')->textArea(['rows' => 2,'readonly'=> true]) ?>
                           <?= $form->field($model, 'Overview_Rejection_Comments')->textArea(['rows' => 2,'readonly'=> true]) ?>

                           <p class="parent"><span>+</span>

                               <?= $form->field($model, 'Supervisor_User_Id')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                              
                               <?= $form->field($model, 'Overview_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               
                              
                              


                                <input type="hidden" id="Key" value="<?= $model->Key ?>">
                                
                           </p>



                       </div>
                   </div>

            </div>

          
                  <div class="row">
                        <div class="col-md-6">
                             <?php if($model->Appraisal_Status == 'Supervisor_Level' || $model->Appraisal_Status == 'Overview_Manager' || $model->Appraisal_Status == 'Closed'): ?>
                                        <div class="card">

                                            <div class="card-header">
                                                <div class="card-title">
                                                    Recommended Action
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                 <?= ($model->Appraisal_Status == 'Supervisor_Level') ?$form->field($model, 'Probation_Recomended_Action')->dropDownList(
                                                    [
                                                        '_blank_' => '_blank_',
                                                        'Confirm' => 'Confirm',
                                                        'Extend_Probation' => 'Extend_Probation',
                                                        'Terminate_Employee' => 'Terminate_Employee'
                                                    ],['prompt' => 'Select ...']
                                                   ): '' ?>


                                                    <?= ($model->Appraisal_Status == 'Overview_Manager' || $model->Appraisal_Status == 'Appraisee_Level' || $model->Appraisal_Status == 'Closed') ?$form->field($model, 'Probation_Recomended_Action')->textInput(['readonly' => true]): '' ?>
                                            </div>
                                        </div>


                                        <div class="card">

                                        <div class="card-header">
                                                <div class="card-title">
                                                    Line Manager Comments
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                 <?= ($model->Appraisal_Status == 'Supervisor_Level') ?$form->field($model, 'Supervisor_Overall_Comments')->textArea(['rows' => 2, 'maxlength'=> '140']): '' ?>
                                                    <span class="text-success" id="confirmation-super">Comment Saved Successfully.</span>

                                                    <?= ($model->Appraisal_Status !== 'Supervisor_Level') ?$form->field($model, 'Supervisor_Overall_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                            </div>
                            </div>

                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">



                           
                                        <div class="card">

                                            <div class="card-header">
                                                <div class="card-title">
                                                    Overview Manager Comments
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                 <?= ($model->Appraisal_Status == 'Overview_Manager') ?$form->field($model, 'Over_View_Manager_Comments')->textArea(['rows' => 2, 'maxlength'=> '140']): '' ?>
                                                    <span class="text-success" id="confirmation">Comment Saved Successfully.</span>

                                                    <?= ($model->Appraisal_Status !== 'Overview_Manager') ?$form->field($model, 'Over_View_Manager_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                            </div>
                                        </div>
                           

                        </div>
                  </div>

               <?php ActiveForm::end(); ?>



            </div>
        </div><!--end details card-->


        <!--Objectives card -->

        <div class="card">
            <div class="card-header">
                <div class="card-title">Employee Appraisal KRAs (Key Result Areas)   </div>
                <div class="card-tools">
                    <?php ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fa fa-plus-square"></i> Add K.R.A',['objective/create','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No],['class' => 'add-objective btn btn-sm btn-outline-info']):'' ?>
                </div>
            </div>

            <div class="card-body">

                <?php if(is_array($model->getObjectives())){ //show Objectives ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                             <td>#</td>
                            <td><b>KRA</b></td>
                            <td><b>Overall Rating</b></td>
                            <td><b>Total Weight</b></td>
                            <td><b>Maximum Weight</b></td>
                            <!-- <td><b>Action</b></td> -->

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           // print '<pre>'; print_r($model->getObjectives()); exit;

                         foreach($model->objectives as $obj):
                            $updateLink = Html::a('<i class="fa fa-edit"></i>',['objective/update','Line_No'=> $obj->Line_No,'Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Update Key Result Area']);
                             $deleteLink = Html::a('<i class="fa fa-trash"></i>',['objective/delete','Key'=> $obj->Key ],['class'=>'mx-1 delete btn btn-danger btn-xs', 'title' => 'Delete Key Result Area']);
                             $addKpi = Html::a('<i class="fa fa-plus-square"></i>',['probation-kpi/create','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No,'KRA_Line_No' => $obj->Line_No  ],['class'=>'mx-1 add btn btn-success btn-xs','title' => 'Add a Key Performance Indicator']);
                         ?>
                                <tr class="parent">
                                     <td><span>+</span></td>
                                    <td><?= !empty($obj->KRA)?$obj->KRA:'Not Set' ?></td>
                                    <td><?= !empty($obj->Overall_Rating)?$obj->Overall_Rating:'Not Set' ?></td>
                                    <td><?= !empty($obj->Total_Weigth)?$obj->Total_Weigth:'Not Set' ?></td>
                                    <td><?= !empty($obj->Maximum_Weight)?$obj->Maximum_Weight:'Not Set' ?></td>
                                    <!-- <td><?php($model->Goal_Setting_Status == 'New')?$updateLink.$deleteLink.$addKpi:'' ?></td> -->
                                </tr>
                                <tr class="child">
                                    <td colspan="6" >
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless table-info">
                                                <thead>
                                                <tr >
                                                    
                                                    <td><b>KPI</b></td>
                                                    <td><b>Weight</b></td>
                                                    <td><b>Appraisee Self Rating</b></td>
                                                    <td><b>Employee Comment</b></td>
                                                    <td><b>Appraiser Rating</b></td>
                                                    <td><b>Supervisor Comments</b></td>
                                                    
                                                   

                                                   

                                                   
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($model->getKpi($obj->Line_No))){

                                                    foreach($model->getKpi($obj->Line_No) as $kpi):

                             $updateLink = Html::a('<i class="fa fa-edit"></i>',['probation-kpi/update','Line_No'=> $kpi->Line_No,'Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No,'KRA_Line_No' => $obj->Line_No],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Update Key Result Area']);
                             $deleteLink = ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fa fa-trash"></i>',['probation-kpi/delete','Key'=> $kpi->Key ],['class'=>'mx-1 delete btn btn-danger btn-xs', 'title' => 'Delete Key Performance Indicator/ Objective']):'';


                                                      ?>
                                            <tr>
                                                            
                                                <td><?= !empty($kpi->Objective)?$kpi->Objective:'' ?></td>
                                                <td><?= $kpi->Weight ?></td>
                                                <td><?= !empty($kpi->Appraisee_Self_Rating)?$kpi->Appraisee_Self_Rating:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Employee_Comments)?$kpi->Employee_Comments:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Appraiser_Rating)?$kpi->Appraiser_Rating:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Supervisor_Comments)?$kpi->Supervisor_Comments:'Not Set' ?></td>
                                                
                                                


                                               

                                            </tr>
                                                <?php
                                                    endforeach;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
            </div>
        </div>

        <!--objectives card -->

         <!--Competencies Card--->


        <div class="card">
            <div class="card-header">
                <div class="card-title">Employee Appraisal Competence</div>

                <div class="card-tools">
                    <?php Html::a('<i class="fa fa-plus"></i> Add Competence',['competence/create','Appraisal_Code'=> $model->Appraisal_No],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Create Record ?']); ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if(is_array($model->Competencies)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <td colspan="2" ><b>Category</b></td>
                            <td ><b>Maximum Weight</b></td>
                            <td ><b>Overall Rating</b></td>
                            <td ><b>Total Weight</b></td>
                           <!--  <td></td> -->
                        </thead>
                        <tbody>
                            <?php foreach($model->Competencies as $competency):


                                 $updateLink = Html::a('<i class="fa fa-edit"></i>',['competence/update','Line_No'=> $competency->Line_No],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Update Record ?']);
                             $deleteLink = Html::a('<i class="fa fa-trash"></i>',['competence/delete','Key'=> $competency->Key ],['class'=>'mx-1 delete btn btn-danger btn-xs', 'title' => 'Delete Record']);

                             $addBehaviour =  Html::a('<i class="fa fa-plus"></i>',['employeeappraisalbehaviour/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' => Yii::$app->user->identity->{'Employee No_'},'Category_Line_No' => $competency->Line_No],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Add Competence Behaviour ?']); 

                             ?>
                            <tr class="parent">
                                 <td><span>+</span></td>
                                <td><?= !empty($competency->Category)?$competency->Category:'' ?></td>
                                <td><?= !empty($competency->Maximum_Weigth)?$competency->Maximum_Weigth:'' ?></td>
                                <td><?= !empty($competency->Overal_Rating)?$competency->Overal_Rating:'' ?></td>
                                <td><?= !empty($competency->Total_Weigth)?$competency->Total_Weigth:'' ?></td>
                                <!-- <td><?php $updateLink ?></td> -->
                            </tr>
                             <tr class="child">
                            <!-- Start Child -->

                                <td colspan="6">
                                    <table class="table table-hover table-borderless table-info">
                                            <thead>
                                            <tr>
                                                <th colspan="7" style="text-align: center;">Employee Appraisal Behaviours</th>
                                            </tr>
                                            <tr>
                                                
                                                <td><b>Behaviour Name</b></td>
                                               <!--  <td><b>Applicable</b></td> -->
                                                <!-- <td width="7%"><b>Current Proficiency level</b></td>
                                                <td width="7%"><b>Expected Proficiency Level</b></td> -->
                                                <!--<td width="7%">Behaviour Description</td>-->
                                                <td><b>Self Rating</b></td>
                                                <td><b>Appraisee Remark</b></td>
                                                <td width="4%"><b>Appraiser Rating</b></td>
                                               <!--  <td width="4%"><b>Peer 1</b></td>
                                                <td width="10%"><b>Peer 1 Remark</b></td>
                                                <td width="4%"><b>Peer 2</b></td>
                                                <td width="10%"><b>Peer 2 Remark</b></td> -->
                                                <td><b>Agreed Rating</b></td>
                                                <td><b>Overall Remarks</b></td>
                                                <!-- <td><b>Action</b></td> -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(is_array($model->getBehaviours($competency->Line_No, $model->Appraisal_No))){

                                                foreach($model->getBehaviours($competency->Line_No, $model->Appraisal_No) as $be):  ?>
                                                    <tr>
                                                        
                                                        <td><?= isset($be->Behaviour_Name)?$be->Behaviour_Name:'Not Set' ?></td>
                                                       <!--  <td><?= Html::checkbox('Applicable',$be->Applicable,['disabled' => true]) ?></td> -->
                                                       <!--  <td><?= !empty($be->Current_Proficiency_Level)?$be->Current_Proficiency_Level:'' ?></td>
                                                        <td><?= !empty($be->Expected_Proficiency_Level)?$be->Expected_Proficiency_Level:'' ?></td> -->
                                                        <td><?= !empty($be->Self_Rating)?$be->Self_Rating:'' ?></td>
                                                        <td><?= !empty($be->Appraisee_Remark)?$be->Appraisee_Remark:'' ?></td>
                                                        <td><?= !empty($be->Appraiser_Rating)?$be->Appraiser_Rating:'' ?></td>
                                                       <!--  <td><?= !empty($be->Peer_1)?$be->Peer_1:'' ?></td>
                                                        <td><?= !empty($be->Peer_1_Remark)?$be->Peer_1_Remark:'' ?></td>
                                                        <td><?= !empty($be->Peer_2)?$be->Peer_2:'' ?></td>
                                                        <td><?= !empty($be->Peer_2_Remark)?$be->Peer_2_Remark:'' ?></td> -->
                                                        <td><?= !empty($be->Agreed_Rating)?$be->Agreed_Rating:'' ?></td>
                                                        <td><?= !empty($be->Overall_Remarks)?$be->Overall_Remarks:'' ?></td>
                                                        <!-- <td><?php (
                                                            $model->Goal_Setting_Status == 'New' ||
                                                            $model->Appraisal_Status == 'Appraisee_Level' ||
                                                            $model->Appraisal_Status == 'Supervisor_Level'
                                                             )?Html::a('<i title="Evaluate Behaviour" class="fa fa-edit"></i>',['employeeappraisalbehaviour/update','Employee_No'=>$be->Employee_No,'Line_No'=> $be->Line_No,'Appraisal_No' => $be->Appraisal_Code ],['class' => ' evalbehaviour btn btn-info btn-xs']):'' ?></td> -->
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                </td>

                            <!-- End Child -->
                             </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                </div>
            </div>
        </div>








    </>
</div>




<!-- Goal setting rejection by Line -->


<div id="rejgoalsbyoverview" style="display: none">

        <?= Html::beginForm(['probation/backtoemp'],'post',['id'=>'reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>

<!-- Goal setting rejection by Line -->

<!-- Goal setting rejection by overview -->


<div id="backtolinemgr" style="display: none">

        <?= Html::beginForm(['probation/backtolinemgr'],'post',['id'=>'backtolinemgr-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>

<!-- Goal setting rejection by overview -->


<!-- rejectappraiseesubmition -->

<div id="rejectappraiseesubmition" style="display: none">

        <?= Html::beginForm(['probation/probationbacktoappraisee'],'post',['id'=>'rejectappraiseesubmition-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
</div>


<!-- Overview rejection of goals -->
<div id="Overviewbacktolinemgr" style="display: none">

        <?= Html::beginForm(['probation/overviewbacktolinemgr'],'post',['id' => 'Overviewbacktolinemgr-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
</div>

<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<?php

$script = <<<JS

    $(function(){
      
        
     /*Deleting Records*/
     
     $('.delete, .delete-objective').on('click',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $.get(url).done(function(msg){
             $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
      
    
    /*Evaluate KRA*/
        $('.evalkra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
      //Add a training plan
    
     $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
    
     $('.add').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Update Learning Assessment and Add/update employee objectives/kpis */
      
      $('.update-learning, .add-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
      
    
    /*Handle modal dismissal event  */
    $('#modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    /*Parent-Children accordion*/ 
    
    $('tr.parent').find('span').text('+');
    $('tr.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('tr.parent').nextUntil('tr.parent').slideUp(1, function(){});    
    $('tr.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('tr.parent').slideToggle(100, function(){});
     });
    
    /*Divs parenting*/
    
     $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });
    
        //Add Career Development Plan
        
        $('.add-cdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
           
            
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         /*End Add Weakness Development Plan*/

         





        


    /*Commit Recommended action by supervisor*/


     $('#probation-probation_recomended_action').change(function(e){
        const Probation_Recomended_Action = e.target.value;
        const Appraisal_No = $('#probation-appraisal_no').val();
        if(Appraisal_No.length){
            
            const url = $('input[name=url]').val()+'probation/setaction';
            $.post(url,{'Probation_Recomended_Action': Probation_Recomended_Action,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#probation-key').val(msg.Key);
                  

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-probation-probation_recomended_action');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-probation-probation_recomended_action');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
                        
                    }
                    
                },'json');
            
        }     
     });


     /*Commit Overview Manager Comment*/
      $('#confirmation').hide();
     $('#probation-over_view_manager_comments').change(function(e){
        const Over_View_Manager_Comments = e.target.value;
        const Appraisal_No = $('#probation-appraisal_no').val();
        if(Appraisal_No.length){
            
            const url = $('input[name=url]').val()+'probation/set-overview-comment';
            $.post(url,{'Over_View_Manager_Comments': Over_View_Manager_Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#probation-key').val(msg.Key);
                  

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-probation-over_view_manager_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-probation-over_view_manager_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });










         // End Action Committing

         


     $('.rejectgoalsettingbyoverview').on('click', function(e){
        e.preventDefault();
        const form = $('#rejgoalsbyoverview').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('#modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#reject-form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });//End click event on  GOals rejection-button click



    /*Reject Goals by Overview - send Back to Line Mgr*/



    $('.rejectgoals').on('click', function(e){
        e.preventDefault();
        const form = $('#backtolinemgr').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('#modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#backtolinemgr').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });//End click event on  GOals rejection-button click


    /*Reject Appraisal Submission by Appraisee - rejectappraiseesubmition*/

         $('.rejectappraiseesubmition').on('click', function(e){
            e.preventDefault();
            const form = $('#rejectappraiseesubmition').html(); 
            const Appraisal_No = $(this).attr('rel');
            const Employee_No = $(this).attr('rev');
            
            console.log('Appraisal No: '+Appraisal_No);
            console.log('Employee No: '+Employee_No);
            
            //Display the rejection comment form
            $('#modal').modal('show')
                            .find('.modal-body')
                            .append(form);
            
            //populate relevant input field with code unit required params
                    
            $('input[name=Appraisal_No]').val(Appraisal_No);
            $('input[name=Employee_No]').val(Employee_No);
            
            //Submit Rejection form and get results in json    
            $('form#rejectappraiseesubmition').on('submit', function(e){
                e.preventDefault()
                const data = $(this).serialize();
                const url = $(this).attr('action');
                $.post(url,data).done(function(msg){
                        $('#modal').modal('show')
                        .find('.modal-body')
                        .html(msg.note);
            
                    },'json');
            });
            
            
        });//End click event on  GOals rejection-button click




        // Overview Probation Stage Back to Line Manager


             $('.Overviewbacktolinemgr').on('click', function(e){
                e.preventDefault();
                const form = $('#Overviewbacktolinemgr').html(); 
                const Appraisal_No = $(this).attr('rel');
                const Employee_No = $(this).attr('rev');
                
                console.log('Appraisal No: '+Appraisal_No);
                console.log('Employee No: '+Employee_No);
                
                //Display the rejection comment form
                $('#modal').modal('show')
                                .find('.modal-body')
                                .append(form);
                
                //populate relevant input field with code unit required params
                        
                $('input[name=Appraisal_No]').val(Appraisal_No);
                $('input[name=Employee_No]').val(Employee_No);
                
                //Submit Rejection form and get results in json    
                $('form#Overviewbacktolinemgr-form').on('submit', function(e){
                    e.preventDefault()
                    const data = $(this).serialize();
                    const url = $(this).attr('action');
                    $.post(url,data).done(function(msg){
                            $('#modal').modal('show')
                            .find('.modal-body')
                            .html(msg.note);
                
                        },'json');
                });
                
                
            });


            /*Commit Line Manager Comment*/
     
     $('#confirmation-super').hide();
     $('#probation-supervisor_overall_comments').change(function(e){

        const Comments = e.target.value;
        const Appraisal_No = $('#probation-appraisal_no').val();

       
        if(Appraisal_No.length){

      
            const url = $('input[name=url]').val()+'shortterm/setfield?field=Supervisor_Overall_Comments';
            $.post(url,{'Supervisor_Overall_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#probation-key').val(msg.Key);
                  
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-probation-supervisor_overall_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-probation-supervisor_overall_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation-super').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });



        
    });//end jquery

    

        
JS;

$this->registerJs($script);

