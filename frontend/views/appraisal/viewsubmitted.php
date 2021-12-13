<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Supervisor Appraisal View - '.$model->Appraisal_No;
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal View', 'url' => ['view','Employee_No'=> $model->Employee_No,'Appraisal_No' => $model->Appraisal_No]];

Yii::$app->session->set('Goal_Setting_Status',$model->Goal_Setting_Status);
Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor','true');
Yii::$app->session->set('isOverview', $model->isOverView());
Yii::$app->session->set('isAppraisee', $model->isAppraisee());
//Yii::$app->recruitment->printrr($peers);
$absoluteUrl = \yii\helpers\Url::home(true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-info">
            <div class="card-header">
                <h3>Performance Appraisal Card</h3>
            </div>

         
           
           
            <div class="card-body info-box">

                <div class="row">

               

                     <!-- Line Mgr Actions on complete goals -->

                    <?php if($model->Goal_Setting_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>


                         <?= Html::a('<i class="fas fa-backward"></i> To Appraisee.',['backtoemp','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'btn btn-app bg-danger rejectappraiseesubmition',
                                    'rel' => $_GET['Appraisal_No'],
                                    'rev' => $_GET['Employee_No'],
                                    'title' => 'Submit Probation  Back to Appraisee'

                            ]) ?>


                            <!-- Send Probation to Overview -->

                            <?= Html::a('<i class="fas fa-forward"></i> Overview ',['sendgoalsettingtooverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-1 btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to Submit Goals to Overview Manager ?',
                                'method' => 'post',
                            ],
                                'title' => 'Submit Goals to Overview Manager.'
                            ]) ?>


                           



                    <?php endif; ?>

                    <!-- Overview Manager Actions -->

                <?php if($model->EY_Appraisal_Status == 'Overview_Manager' && $model->isOverview()): ?>

                    <?= Html::a('<i class="fas fa-check"></i> Approve EY',['approveey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'mx-1 btn btn-app bg-success submitforapproval',
                                'title' => 'Approve End Year Appraisal',
                                'data' => [
                                'confirm' => 'Are you sure you want to Approve this End Year Appraisal ?',
                                'method' => 'post',
                            ]
                        ])
                    ?>

                    <?= Html::a('<i class="fas fa-times"></i> To Ln Manager',['rejectey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-danger ovrejectey',
                                'title' => 'Reject Goals Set by Appraisee',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
                                'method' => 'post',]*/
                            ]) 
                        ?>

                <?php endif; ?>


                <?php if($model->EY_Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>

                <?= Html::a('<i class="fas fa-check"></i> Agreement..',['sendtoagreementlevel','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-app bg-success submitforapproval',
                            'title' => 'Move Appraisal to  Agreement Level',
                            'data' => [
                            'confirm' => 'Are you sure you want to send this End-Year Appraisal to Agreement Level ?',
                            'method' => 'post',
                            ]
                    ])
                ?>

                <!-- Back to Appraisee -->

                <?= Html::a('<i class="fas fa-times"></i> To Appraisee',['rejectey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-danger rejectey',
                                'title' => 'Reject Goals Set by Appraisee',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
                                'method' => 'post',]*/
                            ]) 
                        ?>


                 <?= Html::a('<i class="fas fa-forward"></i> Overview',['sendeytooverview','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'mx-1 btn btn-app bg-success submitforapproval',
                            'title' => 'Move Appraisal to  Agreement Level',
                            'data' => [
                            'confirm' => 'Are you sure you want to send this End-Year Appraisal to Agreement Level ?',
                            'method' => 'post',
                            ]
                    ])
                ?>

            <?php endif; ?>

             
              


                <?php if($model->Goal_Setting_Status == 'Pending_Approval'): ?>
                    <div class="col-md-4">

                        <?= Html::a('<i class="fas fa-times"></i> Reject',['reject','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-warning reject',
                                'title' => 'Reject Goals Set by Appraisee',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
                                'method' => 'post',]*/
                            ]) 
                        ?>

                    </div>

                <!-- Mid YEar Supervisor Action -->

                <?php elseif($model->MY_Appraisal_Status == 'Supervisor_Level'): ?>

                    <?= Html::a('<i class="fas fa-times"></i> Reject MY',['rejectmy'],[
                                'class' => 'btn btn-app bg-warning rejectmy mx-1',
                                'title' => 'Reject Mid-Year Appraisal',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this Mid-Year appraisal?',
                                'method' => 'post',]*/
                            ]) 
                        ?>

                     <?= Html::a('<i class="fas fa-play"></i>MY To Agreement ',['send-my-to-agreement','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],[
                                'class' => 'btn btn-app bg-warning  mx-1',
                                'title' => 'Mid-Year to Agreement Stage',
                                'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal to Agreement Level ?',
                                'method' => 'post',]
                            ]) ;
                        ?>




                        <?= Html::a('<i class="fas fa-play"></i> To Overview ',['my-to-overview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],[
                                'class' => 'btn btn-app bg-warning mx-1',
                                'title' => 'Send Appraisal To Overview Manager.',
                                'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal to Overview Manager ?',
                                'method' => 'post',]
                            ]) ;
                        ?>

     <!--/ Mid YEar Supervisor Action -->
                 <?php elseif($model->MY_Appraisal_Status == 'Agreement_Level'): ?>

                 <?= Html::a('<i class="fas fa-play"></i>MY To Appraisee ',['my-to-appraisee','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],[
                                'class' => 'btn btn-app bg-warning  mx-1',
                                'title' => 'Mid-Year Agreement Back to Appraisee.',
                                'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal Back to Appraisee ?',
                                'method' => 'post',]
                            ]) ;
                        ?>

                <?php elseif($model->EY_Appraisal_Status == 'Agreement_Level'): ?>

                    
                    <?= Html::a('<i class="fas fa-times"></i> Reject EY',['rejectey','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                'class' => 'btn btn-app bg-warning rejectey',
                                'title' => 'Reject End-Year Appraisal',
                                'rel' =>  $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                /*'data' => [
                                'confirm' => 'Are you sure you want to Reject this End-Year Appraisal?',
                                'method' => 'post',]*/
                            ]) 
                    ?>

                <?php endif; ?>

                 <?php if($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Agreement_Level'): ?>

                            <div class="col-md-4">
                                <?= Html::a('<i class="fas fa-check"></i> To Ln Mgr.',['agreementtolinemgr','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                    'class' => 'btn btn-app bg-success',
                                    'title' => 'Submit End Year Appraisal for Approval',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to submit End Year Appraisal?',
                                        'method' => 'post',
                                    ]
                                ]) ?>
                            </div>

                        <?php endif; ?>
</div><!--end row-->

<div class="row"><!-- start peer actions-->
                    <div class="col-md-3">
                    </div>

                    <div class="col-md-3">

                       



                    </div>

                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3">

                      


                        <?=  ($model->EY_Appraisal_Status == 'Closed')?Html::a('<i class="fas fa-book-open"></i> P.A Report',['report','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
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

                   
                </div><!--end peer actions--->
                <div class="row">
                    <div class=" col-md-6 col-md-offset-3">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?=($model->EY_Appraisal_Status == 'Peer_1_Level' || $model->EY_Appraisal_Status == 'Peer_2_Level')?Html::a('<i class="fas fa-play"></i> Send Back to Supervisor',['sendbacktosupervisor','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                            'class' => 'btn btn-success ',
                            'title' => 'Send Peer Appraisal to Supervisor',
                            'data' => [
                                'confirm' => 'Are you sure you want to send Appraisal to Supervisor?',
                                'method' => 'post',]
                        ]) :'';
                        ?>
                    </div>
                </div>

            </div><!--end card body-->
         
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Appraisal : <?= $model->Appraisal_No?></h3>



                <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                                    echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('error');
                        print '</div>';
                    }
                ?>
            </div>
            <div class="card-body">


               <?php $form = ActiveForm::begin(); ?>


               <div class="row">
                   <div class=" row col-md-12">
                       <div class="col-md-6">

                                <?= $form->field($model, 'Appraisal_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Mid_Year_Overrall_rating')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                <p class="parent"><span>+</span>
                                    <?= $form->field($model, 'Overview_Rejection_Comments')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Level_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Job_Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Appraisal_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Appraisal_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Goal_Setting_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'MY_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'MY_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                </p>


                       </div>
                       <div class="col-md-6">

                                <?= $form->field($model, 'EY_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'EY_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Goal_Setting_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Overall_Score')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                <p class="parent"><span>+</span>

                                    <?= $form->field($model, 'Supervisor_Rejection_Comments')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'MY_Appraisal_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'EY_Appraisal_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                   
                                    <?= $form->field($model, 'Supervisor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    
                                    <?= $form->field($model, 'Overview_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?php $form->field($model, 'Overview_Manager_UserID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                    <?= $form->field($model, 'Recomended_Action')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                                </p>



                       </div>
                   </div>
               </div>




               <!-- Mid Year Overview comment shit -->

                    <div class="row">
                        <div class="col-md-6">
                        </div>

                         <div class="col-md-6">



                                                <div class="card">

                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    Mid Year Overview Manager Comments
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                 <?= ($model->MY_Appraisal_Status == 'Overview_Manager') ?$form->field($model, 'Overview_Mid_Year_Comments')->textArea(['rows' => 2, 'maxlength'=> '140']): '' ?>
                                                                    <span class="text-success" id="confirmation-my">Comment Saved Successfully.</span>

                                                                    <?= ($model->MY_Appraisal_Status !== 'Overview_Manager') ?$form->field($model, 'Overview_Mid_Year_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                                            </div>
                                                </div>

                        </div>
                    </div>

               <div class="row">

                                 <div class="col-md-6">



                                    <div class="card">

                                                        <div class="card-header">
                                                                <div class="card-title">
                                                                    Line Manager Comments
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                 <?= ($model->EY_Appraisal_Status == 'Supervisor_Level') ?$form->field($model, 'Supervisor_Overall_Comments')->textArea(['rows' => 2, 'maxlength'=> '140']): '' ?>
                                                                    <span class="text-success" id="confirmation-super">Comment Saved Successfully.</span>

                                                                    <?= ($model->EY_Appraisal_Status !== 'Supervisor_Level') ?$form->field($model, 'Supervisor_Overall_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                                            </div>
                                    </div>



                                 </div>
                                  <div class="col-md-6">



                                                <div class="card">

                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    Overview Manager Comments
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                 <?= ($model->EY_Appraisal_Status == 'Overview_Manager') ?$form->field($model, 'Over_View_Manager_Comments')->textArea(['rows' => 2, 'maxlength'=> '140']): '' ?>
                                                                    <span class="text-success" id="confirmation">Comment Saved Successfully.</span>

                                                                    <?= ($model->EY_Appraisal_Status !== 'Overview_Manager') ?$form->field($model, 'Over_View_Manager_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                                            </div>
                                                </div>

                                 </div>

                      </div>



               <?php ActiveForm::end(); ?>



            </div>
        </div><!--end details card-->

        
        <!--KRA CARD -->
        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Employee Appraisal KRA <?php $model->EY_Appraisal_Status ?></h4>
            </div>
             <div class="card-body">

                        <?php if(property_exists($card->Employee_Appraisal_KRAs,'Employee_Appraisal_KRAs')){ ?>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                   <th></th>
                                    <th>KRA</th>
                                   
                                    <th>Maximum Weight</th>
                                    <th>Total Weight</th>
                                    <th>Mid Year Overall Rating</th>
                                     <th>Overall Rating</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($card->Employee_Appraisal_KRAs->Employee_Appraisal_KRAs as $k){
                                    $mvtopip = Html::Checkbox('Move_To_PIP',$k->Move_To_PIP,['readonly' => true,'disabled' => true]);
                                   
                                    ?>

                                    <tr class="parent">

                                        <td><span>+</span></td>
                                      
                                        <td><?= $k->KRA ?></td>
                                        <td><?= !empty($k->Maximum_Weight)?$k->Maximum_Weight: 'Not Set' ?></td>
                                        <td><?= !empty($k->Total_Weigth)?$k->Total_Weigth: 'Not Set' ?></td>
                                        <td><?= $k->Mid_Year_Overall_Rating ?></td>
                                        <td><?= $k->Overall_Rating ?></td>
                                        <td><?=(($model->Goal_Setting_Status == 'New'))?Html::a('<i class="fa fa-edit"></i>',['appraisalkra/update','Line_No'=> $k->Line_No,'Appraisal_No' => $k->Appraisal_No,'Employee_No' => $k->Employee_No ],['class' => ' evalkra btn btn-info btn-xs']):''?></td>
                                    </tr>
                                    <tr class="child">
                                        <td colspan="11" >
                                            <table class="table table-hover table-borderless table-info">
                                                <thead>
                                                <tr >
                                                     <td><b>Objective</b></td>
                                                    
                                                    <td><b>Weight</b></td>
                                                    <td><b>Mid Year Appraisee Assesment</b></td>
                                                    <td><b>Mid Year Agreement</b></td>
                                                    <td><b>Mid Year Supervisor Assesment</b></td>
                                                   <!--  <td>Mid_Year_Supervisor_Comments</td> -->
                                                    <td><b>Appraisee Self Rating</b></td>
                                                    <td><b>Employee Comments</b></td>
                                                    <td><b>Appraiser Rating</b></td>
                                                    <td><b>End Year Supervisor Comments</b></td>
                                                    <td><b>Agree</b></td>
                                                    <td><b>Disagreement Comments</b></td>


                                                    <th> <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fas fa-plus"></i>',['employeeappraisalkpi/create','Appraisal_No'=> $k->Appraisal_No,'Employee_No' => $k->Employee_No,'KRA_Line_No' => $k->Line_No],['class' => 'btn btn-xs btn-success add-objective','title' => 'Add Objective / KPI']):'' ?>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($model->getKPI($k->Line_No))){

                                                    foreach($model->getKPI($k->Line_No) as $kpi): 

                                                        $agreement = ($kpi->Agree)?'Agreed':'Disagreed';
                                                         $appmyassessment = !empty($kpi->Mid_Year_Appraisee_Assesment)?$kpi->Mid_Year_Appraisee_Assesment:'';
                                                          $supermyassessment = !empty($kpi->Mid_Year_Supervisor_Assesment)?$kpi->Mid_Year_Supervisor_Assesment:'';
                                                           $agree = ($kpi->Agree)?'Yes':'No';
                                                        $mvkpitopip = Html::Checkbox('Move_To_PIP',$kpi->Move_To_PIP,[]);
                                                     ?>
                                                        <tr>
                                                            
                                                
                                                            <td><?= $kpi->Objective ?></td>
                                                            
                                                            <td><?= !empty($kpi->Weight)?$kpi->Weight:'Not Set' ?></td>
                                                            <td><?= !empty($kpi->Mid_Year_Appraisee_Assesment)?$appmyassessment:'Not Set' ?></td>
                                                            <td><?= ($kpi->Mid_Year_Agreement)?'Yes': 'No' ?></td>
                                                            <td><?= !empty($kpi->Mid_Year_Supervisor_Assesment)?$supermyassessment:'Not Set' ?></td>
                                                            <!-- <td><?php !empty($kpi->Mid_Year_Supervisor_Comments)?$kpi->Mid_Year_Supervisor_Comments:'Not Set' ?></td> -->
                                                            <td><?= !empty($kpi->Appraisee_Self_Rating)?$kpi->Appraisee_Self_Rating:'Not Set' ?></td>
                                                            <td><?= !empty($kpi->Employee_Comments)?$kpi->Employee_Comments:'Not Set' ?></td>
                                                            <td><?= !empty($kpi->Appraiser_Rating)?$kpi->Appraiser_Rating:'Not Set' ?></td>
                                                            <td><?= !empty($kpi->End_Year_Supervisor_Comments)?$kpi->End_Year_Supervisor_Comments:'Not Set' ?></td>
                                                            <td><?= $agree ?></td>
                                                            <td><?= !empty($kpi->Disagreement_Comments)?$kpi->Disagreement_Comments:'Not Set' ?></td>

                                                            <td>
                                                                <?= (
                                                                    $model->Goal_Setting_Status == 'New' ||
                                                                    $model->MY_Appraisal_Status == 'Supervisor_Level' ||
                                                                     $model->EY_Appraisal_Status == 'Supervisor_Level' ||
                                                                    $model->EY_Appraisal_Status == 'Agreement_Level'

                                                            )?Html::a('<i class="fas fa-edit"></i> ',['employeeappraisalkpi/update','Appraisal_No'=> $kpi->Appraisal_No,'Employee_No' => $kpi->Employee_No,'KRA_Line_No' => $kpi->KRA_Line_No,'Line_No' => $kpi->Line_No],['class' => 'btn btn-xs btn-primary add-objective', 'title' => 'Update Objective /KPI']):'' ?>
                                                                <?= ($model->Goal_Setting_Status == 'New')? Html::a('<i class="fa fa-trash"></i>',['employeeappraisalkpi/delete','Key' => $kpi->Key],['class'=> 'btn btn-xs btn-danger delete-objective','title' => 'Delete Objective']):'' ?>

                                                            </td>

                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                <?php } ?>
                                </tbody>
                            </table>


                        <?php } ?>
                    </div>
        </div>

        
        <!--END KRA CARD -->

        
        <!--/Training Plan Card -->

        <!--Employee Appraisal  Competence --->

        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Employee Appraisal Competences</h4>
            </div>
           <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td></td>
                                <td>Category</td>
                                <td>Maximum Weight</td>
                                <td>Mid Year Overall Rating</td>
                                <td>Overall Rating</td>

                            </tr>
                            </thead>
                            <?php if(property_exists($card->Employee_Appraisal_Competence,'Employee_Appraisal_Competence')){ ?>

                            <tbody>
                            <?php foreach($card->Employee_Appraisal_Competence->Employee_Appraisal_Competence as $comp){ ?>

                                <tr class="parent">
                                    <td><span>+</span></td>
                                   
                                    <td><?= isset($comp->Category)?$comp->Category:'Not Set' ?></td>
                                    <td><?= isset($comp->Maximum_Weigth)?$comp->Maximum_Weigth:'Not Set' ?></td>
                                    <td><?= $comp->Mid_Year_Overall_Rating ?></td>
                                    <td><?= isset($comp->Overal_Rating)?$comp->Overal_Rating:'Not Set' ?></td>

                                </tr>
                                <tr class="child">
                                    <td colspan="11">
                                        <table class="table table-hover table-borderless table-info">
                                            <thead>
                                            <tr>
                                                <th colspan="15" style="text-align: center;">Employee Appraisal Behaviours</th>
                                            </tr>
                                            <tr>
                                                <td><b>Behaviour Name</b></td>
                                                <td><b>Weight</b></td>

                                               
                                                <td><b>M.Yr Employee Rating</b></td>
                                                <td><b>M.Yr Employee Comments</b></td>
                                                <td><b>M.Yr Supervisor Rating</b></td>
                                                <td><b>M.Yr Supervisor Comments</b></td>
                                                <td><b>M.Yr Agreement</b></td>

                                                <td><b>Self Rating</b></td>
                                                <td><b>Appraisee Remark</b></td>
                                                <td><b>Appraiser Rating</b></td>

                                                <td><b>Overall Remarks</b></td>
                                                <td><b>Agree</b></td>
                                                <td><b>Action</b></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(is_array($model->getAppraisalbehaviours($comp->Line_No))){

                                                foreach($model->getAppraisalbehaviours($comp->Line_No) as $be):  ?>
                                                    <tr>
                                                        
                                                        <td><?= isset($be->Behaviour_Name)?$be->Behaviour_Name:'Not Set' ?></td>
                                                        <td><?= !empty($be->Weight)?$be->Weight:'' ?></td>

                                                        
                                                       
                                                        <td><?= !empty($be->Mid_Year_Employee_Rating)?$be->Mid_Year_Employee_Rating:'' ?></td>
                                                        <td><?= !empty($be->Mid_Year_Employee_Comments)?$be->Mid_Year_Employee_Comments:'' ?></td>
                                                        <td><?= !empty($be->Mid_Year_Supervisor_Rating)?$be->Mid_Year_Supervisor_Rating:'' ?></td>
                                                        <td><?= !empty($be->Mid_Year_Supervisor_Comments)?$be->Mid_Year_Supervisor_Comments:'' ?></td>
                                                        <td><?= ($be->Mid_Year_Agreement)?'Yes':'No' ?></td>


                                                        <td><?= !empty($be->Self_Rating)?$be->Self_Rating:'' ?></td>
                                                        <td><?= !empty($be->Appraisee_Remark)?$be->Appraisee_Remark:'' ?></td>
                                                        <td><?= !empty($be->Appraiser_Rating)?$be->Appraiser_Rating:'' ?></td>


                                                        <td><?= !empty($be->Overall_Remarks)?$be->Overall_Remarks:'' ?></td>
                                                        <td><?= ($be->Agree)?'Yes': 'No' ?></td>
                                                        <td><?= (
                                                            $model->Goal_Setting_Status == 'New' ||
                                                            $model->MY_Appraisal_Status == 'Supervisor_Level' ||
                                                            $model->EY_Appraisal_Status == 'Supervisor_Level' )?Html::a('<i title="Evaluate Behaviour" class="fa fa-edit"></i>',['employeeappraisalbehaviour/update','Employee_No'=>$be->Employee_No,'Line_No'=> $be->Line_No,'Appraisal_No' => $be->Appraisal_Code ],['class' => ' evalbehaviour btn btn-info btn-xs']):'' ?></td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            <?php } ?>
                            </tbody>
                        </table>


                        <?php } ?>
                    </div>
        </div>


 <!----Training Needs-->
                <div class="card-info">


                        <div class="card-header">
                            <h4 class="card-title">Training Needs</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="card-tools">
                            <?= ($model->isAppraisee())?Html::a('<i class="fas fa-plus"></i> Add New',['weeknessdevelopmentplan/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-sm btn-outline-light add']):'' ?>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                     <thead>
                                                <tr >
                                                                                                      
                                                    <th>Training Need</th>
                                                    <th>Training Category</th>
                                                    <th>Proposed Training Institute</th>
                                                    <th>Training Need Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                    </thead>
                                     <tbody>
                                             <?php if(property_exists($card->Weakness_Development_Plan,'Weakness_Development_Plan')){ ?>

                                                    <?php foreach($card->Weakness_Development_Plan->Weakness_Development_Plan as $wdp):  ?>
                                                        <tr>
                                                           
                                                            <td><?= !empty($wdp->Development_Plan)?$wdp->Development_Plan: '' ?></td>
                                                            <td><?= !empty($wdp->Training_Category)?$wdp->Training_Category: '' ?></td>
                                                            <td><?= !empty($wdp->Proposed_Trainer)?$wdp->Proposed_Trainer: '' ?></td>
                                                            <td><?= !empty($wdp->Training_Need_Description)?$wdp->Training_Need_Description:'' ?></td>
                                                            <td>
                                                                <?= ($model->isAppraisee())? Html::a('<i class="fas fa-edit"></i> ',['weeknessdevelopmentplan/update','Line_No'=> $wdp->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning','title'=> 'Update Weakness Development Plan']):'' ?>
                                                                <?= ($model->isAppraisee())? Html::a('<i class="fas fa-trash"></i> ',['weeknessdevelopmentplan/delete','Key'=> $wdp->Key],['class' => 'btn btn-xs btn-outline-primary delete', 'title'=>'Delete Weakness Development Plan']):'' ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    endforeach; ?>


                                             <?php } ?>


                                     </tbody>
                                </table>
                            </div>
                    </div>



                </div>
                <!-- / Training Needs -->
        

<!-- Areas of Further Development  -->



        <div class="card-info">
            <div class="card-header">
                <h4 class="card-title">Areas of Further Development</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fas fa-plus"></i> Add New',['furtherdevelopmentarea/create','Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-primary add']):'' ?>

            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                                <td>#</td>
                       
                                <th>Employee No</th>
                                <th>Appraisal No</th>
                                <th>Weakness</th>
                                <th>Training Needed</th>
                                <th>Support Needed</th>
                                <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php if(property_exists($card->Areas_of_Further_Development,'Areas_of_Further_Development')){ ?>
                        <?php foreach($card->Areas_of_Further_Development->Areas_of_Further_Development as $fda){ ?>
                            <tr class="parent">
                                <td><span>+</span></td>
                               <!--  <td><?php $fda->Line_No ?></td> -->
                                <td><?= $fda->Employee_No ?></td>
                                <td><?= $fda->Appraisal_No ?></td>
                                <td><?= !empty($fda->Weakness)?$fda->Weakness:'' ?></td>
                                <td><?= !empty($fda->Training_Needed)?Html::Checkbox('Training_Needed',$fda->Training_Needed,['readonly' => true]):'' ?></td>
                                <td><?= !empty($fda->Support_Needed)?$fda->Support_Needed:'' ?></td>

                                <td>
                                    <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fas fa-edit"></i> ',['furtherdevelopmentarea/update','Line_No'=> $fda->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning']):'' ?>
                                    <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fas fa-plus-square"></i> ',['weeknessdevelopmentplan/create','Wekaness_Line_No'=> $fda->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary add','Add a Weakness Development Plan.']):'' ?>
                                </td>
                            </tr>
                            <!--Start displaying children-- comment cont
                            <tr class="child">
                                <td colspan="11" >
                                    <table class="table table-hover table-borderless table-info">
                                        <thead>
                                        <tr >
                                                    <th>Training Need</th>
                                                    <th>Training Category</th>
                                                    <th>Proposed Trainer</th>
                                                    <th>Training Need Description</th>
                                                    <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($model->getWeaknessdevelopmentplan($fda->Line_No))){

                                            foreach($model->getWeaknessdevelopmentplan($fda->Line_No) as $wdp):  ?>
                                                <tr>
                                                            <td><?= !empty($wdp->Development_Plan)?$wdp->Development_Plan: '' ?></td>
                                                            <td><?= !empty($wdp->Training_Category)?$wdp->Training_Category: '' ?></td>
                                                            <td><?= !empty($wdp->Proposed_Trainer)?$wdp->Proposed_Trainer: '' ?></td>
                                                            <td><?= !empty($wdp->Training_Need_Description)?$wdp->Training_Need_Description:'' ?></td>
                                                    <td>
                                                        <?php Html::a('<i class="fas fa-edit"></i> ',['weeknessdevelopmentplan/update','Line_No'=> $wdp->Line_No,'Appraisal_No'=> $model->Appraisal_No,'Employee_No' => $model->Employee_No],['class' => 'btn btn-xs btn-outline-primary update-learning','title'=> 'Update Weakness Development Plan']) ?>
                                                        <?php Html::a('<i class="fas fa-trash"></i> ',['weeknessdevelopmentplan/delete','Key'=> $wdp->Key],['class' => 'btn btn-xs btn-outline-primary delete', 'title'=>'Delete Weakness Development Plan']) ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!--end displaying children-->
                        <?php } ?>
                    <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--/-Areas_of_Further_Development-->



    </div>
</div>

<!--My Bs Modal template  --->

<!-----end modal----------->

<!-- GOALS REJECTION COMMENT FORM--->
    <div id="rejform" style="display: none">

        <?= Html::beginForm(['appraisal/reject'],'post',['id'=>'reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>

<!--End gOAL REJECTION comment form-->

<!-- Goal setting rejection by overview -->


<div id="rejgoalsbyoverview" style="display: none">

        <?= Html::beginForm(['appraisal/sendbacktolinemanager'],'post',['id'=>'reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>

<!-- Goal setting rejection by overview -->



<!---mID YEAR COMMENT REJECTION FORM -->

    <div id="myrejform" style="display: none">

        <?= Html::beginForm(['appraisal/rejectmy'],'post',['id'=>'my-reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Mid-Year Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>


<!---END  mID YEAR COMMENT REJECTION FORM -->


    <!---mID YEAR COMMENT REJECTION FORM -->

    <div id="eyrejform" style="display: none">

        <?= Html::beginForm(['appraisal/rejectey'],'post',['id'=>'ey-reject-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'End-Year Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>


        <?= Html::submitButton('Reject EY Appraisal',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>


    <!-- rejectappraiseesubmition -->

<div id="rejectappraiseesubmition" style="display: none">

        <?= Html::beginForm(['appraisal/backtoemp'],'post',['id'=>'rejectappraiseesubmition-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control']); ?>


        <?= Html::submitButton('submit',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
</div>


<!-- Overview reject ey -->


<div id="ovrejectey" style="display: none">

        <?= Html::beginForm(['appraisal/ovrejectey'],'post',['id'=>'ovrejectey-form']) ?>

        <?= Html::textarea('comment','',['placeholder'=>'End-Year Rejection Comment','row'=> 4,'class'=>'form-control','required'=>true])?>

        <?= Html::input('hidden','Appraisal_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>
        <?= Html::input('hidden','Employee_No','',['class'=> 'form-control','style'=>'margin-top: 10px']); ?>


        <?= Html::submitButton('Reject EY Appraisal',['class' => 'btn btn-warning','style'=>'margin-top: 10px']) ?>

        <?= Html::endForm() ?>
    </div>





    <!---END  mID YEAR COMMENT REJECTION FORM -->
    <input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<?php

$script = <<<JS

    $(function(){
      
        
      
    
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
    
     $('.add-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update a training plan
    
     $('.update-trainingplan').on('click',function(e){
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
      
      
      $('.add-learning-assessment, .add').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Update Learning Assessment*/
      
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
    
    //select2
    
    $('.peer').select2();
    
    //Pop up the goals Rejection comment form Modal
    
    $('.reject').on('click', function(e){
        e.preventDefault();
        const form = $('#rejform').html(); 
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
    
    
    
    
    //Click event on M.Y aAppraisal rejection button: modal form
    
    
    $('.rejectmy').on('click', function(e){
        e.preventDefault();
        const form = $('#myrejform').html(); 
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
        $('form#my-reject-form').on('submit', function(e){
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
    
    
    
    //End Click event on M.Y aAppraisal rejection button
    
    
    //Rejecting end year Appraisal comment
    
    $('.rejectey').on('click', function(e){
        e.preventDefault();
        const form = $('#eyrejform').html(); 
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
        $('form#ey-reject-form').on('submit', function(e){
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
    
    //End Rejecting end year Appraisal comment



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
   


    
    //select 2
    
    $('#appraisalcard-peer_1_employee_no').select2();
    $('#appraisalcard-peer_2_employee_no').select2();



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



        /*Reject Appraisal Submission by Appraisee - rejectappraiseesubmition*/

         $('.ovrejectey').on('click', function(e){
            e.preventDefault();
            const form = $('#ovrejectey').html(); 
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
            $('form#ovrejectey').on('submit', function(e){
                e.preventDefault()
                const data = $(this).serialize();
                const url = $(this).attr('action');
                $.post(url,data).done(function(msg){
                        $('#modal').modal('show')
                        .find('.modal-body')
                        .html(msg.note);
            
                    },'json');
            });
            
            
        });//End click event on  ovrejectey button



    /*Commit Overview Manager Comment*/
     
     $('#confirmation').hide();
     $('#appraisalcard-over_view_manager_comments').change(function(e){
        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();
        if(Appraisal_No.length){
            
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Over_View_Manager_Comments';
            $.post(url,{'Over_View_Manager_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-over_view_manager_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-over_view_manager_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });





       /*Commit Line Manager Comment*/
     
     $('#confirmation-super').hide();
     $('#appraisalcard-supervisor_overall_comments').change(function(e){

        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();

       
        if(Appraisal_No.length){

      
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Supervisor_Overall_Comments';
            $.post(url,{'Supervisor_Overall_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-supervisor_overall_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-supervisor_overall_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation-super').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });



      /*Commit Mid Year Overview Manager Comment*/
     
     $('#confirmation-my').hide();
     $('#appraisalcard-overview_mid_year_comments').change(function(e){

        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();

       
        if(Appraisal_No.length){

      
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Overview_Mid_Year_Comments';
            $.post(url,{'Overview_Mid_Year_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-overview_mid_year_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-overview_mid_year_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation-my').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });




    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

