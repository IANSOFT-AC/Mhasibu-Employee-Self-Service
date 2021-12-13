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
Yii::$app->session->set('EY_Appraisal_Status',$model->Appraisal_Status);

if($model->Employee_No == Yii::$app->user->identity->{'Employee No_'})
{
    Yii::$app->session->set('isAppraisee', TRUE);
}else{
    Yii::$app->session->set('isAppraisee', FALSE);
}

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

                <div class="row justify-content-between">
                    
                    <!-- Appraisee actions -->

                    <?php 
                       
                        if($model->isAppraisee()) 
                        {
                            echo $this->render('_appraisee_actions', ['model' => $model]);
                        }

                        // Supervisor actions 

                        if($model->isSupervisor()) 
                        {
                            echo $this->render('_supervisor_actions', ['model' => $model]);
                        }

                         // Overview actions
                         
                         if($model->isOverview()) 
                        {
                            echo $this->render('_overview_actions', ['model' => $model]);
                        }

                        // HR actions

                        if($model->isHR()) 
                        {
                            echo $this->render('_hr_actions', ['model' => $model]);
                        }

                    ?>

                     
                    


                    <!-- This action is universal unless otgerwise advised, hence not in a partial view -->
                    <div class="col-md-4 mx-1">
                                <?=  Html::a('<i class="fas fa-book-open"></i> P.A Report',['report','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],[
                                    'class' => 'btn btn-app bg-success  pull-right mx-1',
                                    'title' => 'Generate Performance Appraisal Report',
                                    'target'=> '_blank',
                                    'data' => [
                                        // 'confirm' => 'Are you sure you want to send appraisal to peer 2?',
                                        'params'=>[
                                            'appraisalNo'=>$model->Appraisal_No,
                                            'employeeNo' => $model->Employee_No,
                                        ],
                                        'method' => 'post',]
                                ]);
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
                           <?= $form->field($model, 'Job_Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Probation_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Probation_End_date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <p class="parent"><span>+</span>
                               

                               <?= $form->field($model, 'Goal_Setting_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                           </p>


                       </div>
                       <div class="col-md-6">

                           <?= $form->field($model, 'Appraisal_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Supervisor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Overview_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Over_View_Manager_Comments')->textInput(['readonly'=> true]) ?>
                           <?= $form->field($model, 'Supervisor_Overall_Comments')->textInput(['readonly'=> true]) ?>
                           <?= $form->field($model, 'Overall_Score')->textInput(['readonly'=> true]) ?>

                           <p class="parent"><span>+</span>

                               <?= $form->field($model, 'Supervisor_User_Id')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                              
                              
                               
                              
                              


                                <input type="hidden" id="Key" value="<?= $model->Key ?>">
                                
                           </p>



                       </div>
                   </div>

            </div>

          
                

               <?php ActiveForm::end(); ?>



            </div>
        </div><!--end details card-->


        <!-- Recommended Action -->
        <?php if($model->Appraisal_Status == 'Supervisor_Level' || $model->Appraisal_Status == 'Overview_Manager' || $model->Appraisal_Status == 'Human_Resource' || $model->Appraisal_Status == 'Closed'): ?>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Recommended Action</div>
                </div>
                <div class="card-body">
                <?= ($model->Appraisal_Status == 'Supervisor_Level') ?$form->field($model, 'Probation_Recomended_Action')->dropDownList(
                                                        [
                                                            '_blank_' => '_blank_',
                                                            'Confirm' => 'Confirm',
                                                            'Extend_Probation' => 'Extend_Probation',
                                                            'Terminate_Employee' => 'Terminate_Employee'
                                                        ],['prompt' => 'Select ...']
                                                    ):  $form->field($model, 'Probation_Recomended_Action')->textInput(['readonly' => true]) ?>


                   
                </div>
            </div>

        <?php endif; ?>


        <!-- Employee Appraisal Questions -->


        <div class="card">
                <div class="card-header">
                    <div class="card-title">Employee Appraisal Questions</div>
                </div>
                <div class="card-body">
               
                    <?php if(property_exists($appraisal->Employee_Appraisal_Questions, 'Employee_Appraisal_Questions')): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td><b>Question</b></td>  
                                        <td><b>Action</b></td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($appraisal->Employee_Appraisal_Questions->Employee_Appraisal_Questions as $q):
                                         $answerLink = Html::a('<i class="fa fa-plus-square"></i>',['probation-answer/create','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No,'Question_No' => $q->Line_No  ],['class'=>'mx-1 add btn btn-success btn-xs','title' => 'Add an Answer.']);
                                        ?>

                                        <tr class="parent">
                                            <td><span>+</span></td>
                                            <td><?= !empty($q->Question)?$q->Question:'Not Set' ?></td>
                                            <td><?=($model->Goal_Setting_Status == 'New')?$answerLink:'' ?></td>
                                        </tr>
                                        <tr class="child">
                                                <td colspan="3">
                                                    <div class="table-responsive">
                                                                    <table class="table table-hover table-borderless table-info">
                                                                        <thead>
                                                                            <tr>
                                                                                <td class="text-bold">#</td>
                                                                                <td class="text-bold">Answer</td>
                                                                                <td class="text-bold">Actions</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php if(is_array($model->getAnswers($q->Line_No))): ?>


                                                                                    <?php foreach($model->getAnswers($q->Line_No) as $a):
                                                                                        $updateLink = Html::a('<i class="fa fa-edit"></i>',['probation-answer/update', 'Key'=> $a->Key],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Update Key Result Area']);
                                                                                        $deleteLink = ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fa fa-trash"></i>',['probation-answer/delete','Key'=> $a->Key ],['class'=>'mx-1 delete btn btn-danger btn-xs', 'title' => 'Delete Record']):'';
                                                                                        ?>
                                                                                        <tr>
                                                                                
                                                                                            <td><?= !empty($a->Answer)?$a->Answer:'Not Set' ?></td>
                                                                                            <td><?= $updateLink.$deleteLink ?></td>
                                                                                        
                                                                                        </tr>
                                                                                
                                                                                    <?php endforeach; ?>

                                                                            <?php else: ?>

                                                                                <tr><td colspan="3" class="text-center">No answers to show.</td></tr>

                                                                            <?php endif; ?>
                                                                        </tbody>
                                                                    </table>
                                                    </div>
                                                </td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        <!--Objectives card -->

        <div class="card">
            <div class="card-header">
                <div class="card-title">Employee Appraisal KRAs (Key Result Areas)   </div>
                <div class="card-tools">
                    <?= ($model->Goal_Setting_Status == 'New')?Html::a('<i class="fa fa-plus-square"></i> Add K.R.A',['objective/create','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_No],['class' => 'add-objective btn btn-sm btn-outline-info']):'' ?>
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
                            <td><b>Action</b></td>

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
                                    <td><?=($model->Goal_Setting_Status == 'New')?$updateLink.$deleteLink.$addKpi:'' ?></td>
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
                                                    
                                                   

                                                    <th><b>Action</b></th>

                                                   
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
                                                
                                                


                                                <td><?= $updateLink.$deleteLink ?></td>

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
                    <?= Html::a('<i class="fa fa-plus"></i> Add Competence',['competence/create','Appraisal_Code'=> $model->Appraisal_No],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Create Record ?']); ?>
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
                            <td></td>
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
                                <td><?= $updateLink ?></td>
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
                                                <td width="4%"><b>Peer 2</b></td>-->
                                                <td><b>Weight</b></td>
                                                <!-- <td><b>Agreed Rating</b></td> -->
                                                <td><b>Appraiser Remarks</b></td>
                                                <td><b>Action</b></td>
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
                                                        <td><?= !empty($be->Peer_2)?$be->Peer_2:'' ?></td>-->
                                                        <td><?= !empty($be->Weight)?$be->Weight:'' ?></td>
                                                       <!--  <td><?= !empty($be->Agreed_Rating)?$be->Agreed_Rating:'' ?></td> -->
                                                        <td><?= !empty($be->Overall_Remarks)?$be->Overall_Remarks:'' ?></td>
                                                        <td><?= (
                                                            $model->Goal_Setting_Status == 'New' ||
                                                            $model->Appraisal_Status == 'Appraisee_Level' ||
                                                            $model->Appraisal_Status == 'Supervisor_Level'
                                                             )?Html::a('<i title="Evaluate Behaviour" class="fa fa-edit"></i>',['employeeappraisalbehaviour/update','Employee_No'=>$be->Employee_No,'Line_No'=> $be->Line_No,'Appraisal_No' => $be->Appraisal_Code ],['class' => ' evalbehaviour btn btn-info btn-xs']):'' ?></td>
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


        <!-- Employee Qualifications -->

       <div class="card">
           <div class="card-header">
               <div class="card-title">Employee Qualifications</div>
           </div>
           <div class="card-body">
               <div class="table-reponsive-lg">
                   <table class="table table-bordered">
                       <thead>
                           <tr>
                               <td class="text-bold">Qualification Code</td>
                               <td class="text-bold">From Date</td>
                               <td class="text-bold">To Date</td>
                               <td class="text-bold">Type</td>
                               <td class="text-bold">Description</td>
                               <td class="text-bold">Expiration Date</td>
                               <td class="text-bold">Institution / Company</td>
                               <td class="text-bold">Course / Grade</td>
                               <td class="text-bold">Certificate No.</td>
                               <td class="text-bold">Comment</td>
                           </tr>
                       </thead>
                       <tbody>
                           <?php if(property_exists($appraisal->Employee_Qualifications, 'Employee_Qualifications')): ?>
                                    

                                    <?php foreach($appraisal->Employee_Qualifications->Employee_Qualifications as $qualification) : ?>

                                        <tr>
                                            <td><?= !empty($qualification->Qualification_Code)?$qualification->Qualification_Code:'' ?></td>
                                            <td><?= !empty($qualification->From_Date)?$qualification->From_Date:'' ?></td>
                                            <td><?= !empty($qualification->To_Date)?$qualification->To_Date:'' ?></td>
                                            <td><?= !empty($qualification->Type)?$qualification->Type:'' ?></td>
                                            <td><?= !empty($qualification->Description)?$qualification->Description:'' ?></td>
                                            <td><?= !empty($qualification->Expiration_Date)?$qualification->Expiration_Date:'' ?></td>
                                            <td><?= !empty($qualification->Institution_Company)?$qualification->Institution_Company:'' ?></td>
                                            <td><?= !empty($qualification->Course_Grade)?$qualification->Course_Grade:'' ?></td>
                                            <td><?= !empty($qualification->Certificate_no)?$qualification->Certificate_no:'' ?></td>
                                            <td><?= !empty($qualification->Comment)?$qualification->Comment:'' ?></td>
                                        </tr>

                                    <?php endforeach; ?>


                            <?php else: ?>
                                <tr>
                                    <td class="text-center">No qualifications to show.</td>
                                </tr>
                            <?php endif; ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>                                     



    </div>
</div>

<!-- Modals -->

<!--My Bs Modal template  --->

<div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Probation Appraisal</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
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
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
      
    
    /*Evaluate KRA*/
        $('.evalkra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
      //Add a training plan
    
     $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
    
     $('.add').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Update Learning Assessment and Add/update employee objectives/kpis */
      
      $('.update-learning, .add-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
      
    
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
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
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
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
        $('.modal').modal('show')
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
                    $('.modal').modal('show')
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
        $('.modal').modal('show')
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
                    $('.modal').modal('show')
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
            $('.modal').modal('show')
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
                        $('.modal').modal('show')
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
                $('.modal').modal('show')
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
                            $('.modal').modal('show')
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
