<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Exit Form:  - '.$model->Form_No;
$this->params['breadcrumbs'][] = ['label' => 'Change Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Change Request Card', 'url' => ['view','No'=> $model->Form_No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/


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
                    
//print Yii::$app->user->identity->{'Employee No_'};
// Yii::$app->recruitment->printrr($model->sequence);

$absoluteUrl = \yii\helpers\Url::home(true);

?> 

<div class="row">
    <div class="col-md-12">

<?php if( $model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} ){ ?>


        <?=  ($model->sequence && $model->sequence == 'Library')?Html::a('<i class="fas fa-paper-plane"></i> Send to Library',['clear'],['class' =>  $model->CheckStatus('Library').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Library'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]): '' ?>

        <?= ($model->sequence && $model->sequence == 'Lab')?Html::a('<i class="fas fa-paper-plane"></i> Send to Lab',['clear'],['class' => $model->CheckStatus('Lab').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Lab'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):''; 

?>

        

        <?= ($model->sequence && $model->sequence == 'ICT')?Html::a('<i class="fas fa-paper-plane"></i> Send to ICT',['clear'],['class' => $model->CheckStatus('ICT').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'ICT'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>

        <?= ($model->sequence && $model->sequence == 'Store')?Html::a('<i class="fas fa-paper-plane"></i> Send to Store',['clear'],['class' => $model->CheckStatus('Store').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Store'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>

        <?= ($model->sequence && $model->sequence == 'Archives')?Html::a('<i class="fas fa-paper-plane"></i> Send to Archives',['clear'],['class' => $model->CheckStatus('Archives').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Archives'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>

        <?= ($model->sequence && $model->sequence == 'Assets')? Html::a('<i class="fas fa-paper-plane"></i> Send to Safety',['clear'],['class' => $model->CheckStatus('Assets').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Assets'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance to Health and Safety.'

        ]):'' ?>

        <!-- Add Other Stage Actions -->

        <?= ($model->sequence && $model->sequence == 'Security')?Html::a('<i class="fas fa-paper-plane"></i> Send to Security',['clear'],['class' => $model->CheckStatus('Security').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Security'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>


        <?= ($model->sequence && $model->sequence == 'Payroll')?Html::a('<i class="fas fa-paper-plane"></i> Send to Payroll',['clear'],['class' => $model->CheckStatus('Payroll').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Payroll'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>


        <?= ($model->sequence && $model->sequence == 'Personal Account')?Html::a('<i class="fas fa-paper-plane"></i>  Personal A/C ',['clear'],['class' => $model->CheckStatus('Personal_Account').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Personal_Account'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>


         <?= ($model->sequence && $model->sequence == 'Training')?Html::a('<i class="fas fa-paper-plane"></i>  Training ',['clear'],['class' => $model->CheckStatus('Training').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Training'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>


         <?= ($model->sequence && $model->sequence == 'Human Resources')?Html::a('<i class="fas fa-paper-plane"></i>  Human_Resources ',['clear'],['class' => $model->CheckStatus('Human_Resources').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Human_Resources'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>


         <?= ($model->sequence && $model->sequence == 'Executive Director')?Html::a('<i class="fas fa-paper-plane"></i>  Executive Director ',['clear'],['class' => $model->CheckStatus('Executive_Director').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'Executive_Director'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>

         <?= ($model->sequence && $model->sequence == 'HOD')?Html::a('<i class="fas fa-paper-plane"></i>  HOD ',['clear'],['class' => $model->CheckStatus('HOD').' btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'formNo' => $model->Form_No,
                    'stage' => 'HOD'
                ],
                'method' => 'get',
            ],
            'title' => 'Send For Clearance'

        ]):'' ?>












<?php } ?>


     <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'})? Html::a('<i class="fas fa-check"></i> Clear',['clear-section'],['class' => 'btn btn-app clear-section',
            'data' => [
                'confirm' => 'Are you sure you want to clear this section ?',
                'params'=>[
                    'exitNo' => $model->Exit_No,
                    'FormNo' => $model->Form_No,
                ],
                'method' => 'get',
            ],
            'title' => 'Clear '.$model->Action_ID.' section'

        ]): '' ?>


<?php if($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}){ ?>


    <div class=" px-1 mx-1" /><!-- clearance Readiness -->

        <span class="text">Ready to Clear ?</span>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="inlineRadioOptions"
            id="YesOption"
            value="Yes"
          />
          <label class="form-check-label" for="inlineRadio1">Yes</label>
        </div>

        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="inlineRadioOptions"
            id="NoOption"
            value="No"
          />
          <label class="form-check-label" for="inlineRadio2">No</label>
        </div>

    </div><!-- End clearance Readiness -->

<?php } ?>




    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Exit Form Document </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Request No : <?= $model->Form_No?></h3>

                    <div class="card-tools">
                        <?= Html::a('View Clearance Status',['clearance-status','form_no' => $model->Form_No],['class' => 'btn btn-sm btn-success']);?>
                    </div>


                   
                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'Form_No')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Exit_No')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true]) ?>

                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Global_Dimension_3_Code')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Global_Dimension_4_Code')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Global_Dimension_5_Code')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                            </div>
                        </div>

                        <hr />
                        <div class="text lead text-center">Dues</div>



                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'Ict_Unpaid')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Lab_Unpaid')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Payroll_Uncleared_Items')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Archives_Uncleared_Items')->hiddenInput(['readonly'=> true])->label(false) ?>
                               

                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Library_Unpaid')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Security_Uncleared_Item')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Personal_Account_Uncleared')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                               

                            </div>
                        </div>



                    </div>


                    <?php ActiveForm::end(); ?>



                    <!-- Comments Row -->


                    <div class="row">

                                 <div class="col-md-6">



                                    <div class="card">

                                                        <div class="card-header">
                                                                <div class="card-title">
                                                                    HOD Comments
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                 <?= ($model->Action_ID == 'HOD') ?$form->field($model, 'HOD_Comments')->textArea(['rows' => 2, 'maxlength'=> '250']): '' ?>
                                                                    <span class="text-success" id="confirmation-hod">Comment Saved Successfully.</span>

                                                                    <?= ($model->Action_ID !== 'HOD') ?$form->field($model, 'HOD_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                                            </div>
                                    </div>



                                 </div>
                                  <div class="col-md-6">



                                                <div class="card">

                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    HR Comments
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                 <?= ($model->Action_ID == 'Human_Resources') ?$form->field($model, 'HR_Comments')->textArea(['rows' => 2, 'maxlength'=> '250']): '' ?>
                                                                    <span class="text-success" id="confirmation-hr">Comment Saved Successfully.</span>

                                                                    <?= ($model->Action_ID !== 'Human_Resources') ?$form->field($model, 'HR_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                                            </div>
                                                </div>

                                 </div>

                     </div>

                     <div class="row">
                        <div class="col-md-6">
                        </div>

                         <div class="col-md-6">



                                                <div class="card">

                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    Executive Director Comments
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                 <?= ($model->Action_ID == 'Executive_Director') ?$form->field($model, 'ED_Comments')->textArea(['rows' => 2, 'maxlength'=> '250']): '' ?>
                                                                    <span class="text-success" id="confirmation-ed">Comment Saved Successfully.</span>

                                                                    <?= ($model->Action_ID !== 'Executive_Director') ?$form->field($model, 'ED_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]): '' ?>
                                                            </div>
                                                </div>

                        </div>
                    </div>




                </div><!-- End Card Body -->
            </div><!--end details card-->

            <!--Library Clearance Lines -->

<?php if(

            ($model->Action_ID == 'Library' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Library')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>

            <div class="card" id="Library">
                <div class="card-header">
                    <div class="card-title">
                       Library Clearance Lines
                    </div>
                    <div class="card-tools">
                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Library')?Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['library/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info ml-auto']):'' ?>
                    </div>

                </div>

                <div class="card-body">

                    <?php
                   // Yii::$app->recruitment->printrr($model);
                    if(is_array($model->library)){ //show Lines ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Employee_no</b></td>
                                <td><b>Exit_no</b></td>
                                <td><b>Book_Description</b></td>
                                <td><b>Book_Worth</b></td>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;
                            foreach($model->library as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['library-clearance/update','No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['library-clearance/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td data-key="<?= $obj->Key ?>" data-name="Employee_no" data-no="<?= $obj->Line_No ?>"  data-service="LibraryClearanceLines" ondblclick="addInput(this)"><?= !empty($obj->Employee_no)?$obj->Employee_no:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Exit_no" data-no="<?= $obj->Line_No ?>"  data-service="LibraryClearanceLines" ondblclick="addInput(this)"><?= !empty($obj->Exit_no)?$obj->Exit_no:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Book_Description" data-no="<?= $obj->Line_No ?>"  data-service="LibraryClearanceLines" ondblclick="addInput(this)"><?= !empty($obj->Book_Description)?$obj->Book_Description:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Book_Worth" data-no="<?= $obj->Line_No ?>"  data-service="LibraryClearanceLines" ondblclick="addInput(this, 'number')"><?= !empty($obj->Book_Worth)?$obj->Book_Worth:'Not Set' ?></td>


                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php } ?>
                </div>
            </div>

<?php } ?>


            <!--End Library Lines -->


            <!--Next Lab_Clearance_Lines-->

<?php 

if(

            ($model->Action_ID == 'Lab' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Lab')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>
            <div class="card" id="Lab">
                <div class="card-header">
                    <div class="card-title">
                        Lab Clearance Lines
                    </div>
                    <div class="card-tools">
                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Lab')?Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['lab/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No

                    ],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php
                    //Yii::$app->recruitment->printrr($model->relatives);
                    if(is_array($model->lab)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Exit_no</b></td>
                                    <td><b>Lab_Item</b></td>
                                    <td><b>Returned</b></td>
                                    <td><b>Item Worth</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->lab as $robj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['dependant/update','No'=> $robj->Line_No],['class' => 'update-robjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['dependant/delete','Key'=> $robj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $robj->Key ?>" data-name="Employee_no" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="LabClearanceLines"><?= !empty($robj->Employee_no)?$robj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Exit_no" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="LabClearanceLines"><?= !empty($robj->Exit_no)?$robj->Exit_no:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Lab_Item" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="LabClearanceLines"><?= !empty($robj->Lab_Item)?$robj->Lab_Item:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Returned" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="LabClearanceLines" ondblclick="addDropDown(this,'returned')"><?= !empty($robj->Returned)?$robj->Returned:'Not Set' ?></td>

                                        <td data-key="<?= $robj->Key ?>" data-name="Number" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="LabClearanceLines" ondblclick="addInput(this)"><?= !empty($robj->Number)?$robj->Number:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                </div>
            </div>

<?php } ?>

            <!--ICT cLEARANCE Form-->
<?php if(

            ($model->Action_ID == 'ICT' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('ICT')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))


){ ?>
           <div class="card" id="ICT_Clearance_Lines">
                <div class="card-header">
                    <div class="card-title">
                        ICT Clearance
                    </div>
                    <div class="card-tools">

                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'ICT')? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['ict/create',
                            'Form_No' => $model->Form_No,
                            'Exit_no' => $model->Exit_No,
                            'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):''

                     ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->ict)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>


                                    <td><b>Employee_no</b></td>
                                    <td><b>Exit_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>



                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->ict as $benobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['ict-clearance/update','No'=> $benobj->Line_No],['class' => 'update-benobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['ict/clearance','Key'=> $benobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $benobj->Key ?>" data-name="Employee_no" data-no="<?= $benobj->Line_No ?>" data-filter-field="Line_No" data-service="ICTClearanceLines" ondblclick="addInput(this)"><?= !empty($benobj->Employee_no)?$benobj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Exit_no" data-no="<?= $benobj->Line_No ?>" data-filter-field="Line_No" data-service="ICTClearanceLines" ondblclick="addDropDown(this,'type')"><?= !empty($benobj->Exit_no)?$benobj->Exit_no:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Item_Description" data-no="<?= $benobj->Line_No ?>" data-filter-field="Line_No" data-service="ICTClearanceLines" ondblclick="addInput(this)"><?= !empty($benobj->Item_Description)?$benobj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Item_Worth" data-no="<?= $benobj->Line_No ?>" data-filter-field="Line_No" data-service="ICTClearanceLines" ondblclick="addInput(this)"><?= !empty($benobj->Item_Worth)?$benobj->Item_Worth:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>


            <!--Assigned_store_Clearance-->
<?php if(

            ($model->Action_ID == 'Store' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Store')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>
            <div class="card" id="Store_CLearance_Form">
                <div class="card-header">
                    <div class="card-title">
                        Store Clearance Form
                    </div>
                    <div class="card-tools">



                    <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Store')? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['store/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):'' ?>



                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->store)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Exit_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->store as $whobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['store-clearance/update','No'=> $whobj->Line_No],['class' => 'update-whobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['store-clearance/delete','Key'=> $whobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $whobj->Key ?>" data-name="Employee_no" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="StoreCLearanceForm" ondblclick="addInput(this)"><?= !empty($whobj->Employee_no)?$whobj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Exit_no" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="StoreCLearanceForm" ondblclick="addInput(this)"><?= !empty($whobj->Exit_no)?$whobj->Exit_no:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Item_Description" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="StoreCLearanceForm" ondblclick="addInput(this)"><?= !empty($whobj->Item_Description)?$whobj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Item_Worth" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="StoreCLearanceForm" ondblclick="addInput(this, 'number')"><?= !empty($whobj->Item_Worth)?$whobj->Item_Worth:'Not Set' ?></td>

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>

            <!--Assigned Assets Clearance-->

<?php if(

            ($model->Action_ID == 'Assets' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Assets')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>
            <div class="card" id="Assigned_Assets_Clearance">
                <div class="card-header">
                    <div class="card-title">
                        Health and Safety Clearance Form
                    </div>
                    <div class="card-tools">

                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Assets')? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['asset/create',
                        
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->assets)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <!-- <td><b>Misc_Article_Code</b></td> -->
                                    <td><b>Description</b></td>
                                   <!--  <td><b>Asset_Number</b></td> -->
                                    <!-- <td><b>Condition</b></td> -->
                                    <!-- <td><b>Returned</b></td> -->
                                    <td><b>Value</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->assets as $whobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['assigned-assets-clearance/update','No'=> $whobj->Line_No],['class' => 'update-whobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['assigned-assets-clearance/delete','Key'=> $whobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $whobj->Key ?>" data-name="Employee_No" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ><?= !empty($whobj->Employee_No)?$whobj->Employee_No:'Not Set' ?></td>
                                       <!--  <td data-key="<?= $whobj->Key ?>" data-name="Misc_Article_Code" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ondblclick="addInput(this)"><?= !empty($whobj->Misc_Article_Code)?$whobj->Misc_Article_Code:'Not Set' ?></td> -->
                                        <td data-key="<?= $whobj->Key ?>" data-name="Description" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ondblclick="addInput(this)"><?= !empty($whobj->Description)?$whobj->Description:'Not Set' ?></td>
                                        <!-- <td data-key="<?= $whobj->Key ?>" data-name="Asset_Number" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ondblclick="addInput(this)"><?= !empty($whobj->Asset_Number)?$whobj->Asset_Number:'Not Set' ?></td> -->
                                        <!-- <td data-key="<?= $whobj->Key ?>" data-name="Condition" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ondblclick="addDropDown(this,'condition')"><?= !empty($whobj->Condition)?$whobj->Condition:'Not Set' ?></td> -->
                                       <!--  <td data-key="<?= $whobj->Key ?>" data-name="Returned" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ondblclick="addDropDown(this, 'returned')"><?= !empty($whobj->Returned)?$whobj->Returned:'Not Set' ?></td> -->
                                        <td data-key="<?= $whobj->Key ?>" data-name="Value_on_Return" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="AssignedAssetsClearance" ondblclick="addInput(this, 'number')"><?= !empty($whobj->Value_on_Return)?$whobj->Value_on_Return:'Not Set' ?></td>

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>


            <!-- Security Clearance -->

<?php if(

            ($model->Action_ID == 'Security' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Security')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>
            <div class="card" id="Security">
                <div class="card-header">
                    <div class="card-title">
                        Security Clearance Form
                    </div>
                    <div class="card-tools">

                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Security' )? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['security/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):''


                     ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->security)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>
                                    

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->security as $secobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['assigned-assets-clearance/update','No'=> $secobj->Line_No],['class' => 'update-secobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['assigned-assets-clearance/delete','Key'=> $secobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $secobj->Key ?>" data-name="Employee_no" data-no="<?= $secobj->Line_No ?>" data-filter-field="Line_No" data-service="SecurityClearanceForm" ><?= !empty($secobj->Employee_no)?$secobj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $secobj->Key ?>" data-name="Item_Description" data-no="<?= $secobj->Line_No ?>" data-filter-field="Line_No" data-service="SecurityClearanceForm" ondblclick="addInput(this)"><?= !empty($secobj->Item_Description)?$secobj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $secobj->Key ?>" data-name="Item_Worth" data-no="<?= $secobj->Line_No ?>" data-filter-field="Line_No" data-service="SecurityClearanceForm" ondblclick="addInput(this)"><?= !empty($secobj->Item_Worth)?$secobj->Item_Worth:'Not Set' ?></td>
                                       

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>



            <!-- Training Clearance -->

<?php if(
            ($model->Action_ID == 'Training' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Training')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))
){ ?>
            <div class="card" id="Training">
                <div class="card-header">
                    <div class="card-title">
                        Training Clearance Form 
                    </div>
                    <div class="card-tools">
                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Training' )? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['training/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->training)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>
                                   

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->training as $tobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['assigned-assets-clearance/update','No'=> $tobj->Line_No],['class' => 'update-tobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['assigned-assets-clearance/delete','Key'=> $tobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $tobj->Key ?>" data-name="Employee_no" data-no="<?= $tobj->Line_No ?>" data-filter-field="Line_No" data-service="TrainingClearanceForm" ><?= !empty($tobj->Employee_no)?$tobj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $tobj->Key ?>" data-name="Item_Description" data-no="<?= $tobj->Line_No ?>" data-filter-field="Line_No" data-service="TrainingClearanceForm" ondblclick="addInput(this)"><?= !empty($tobj->Item_Description)?$tobj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $tobj->Key ?>" data-name="Item_Worth" data-no="<?= $tobj->Line_No ?>" data-filter-field="Line_No" data-service="TrainingClearanceForm" ondblclick="addInput(this)"><?= !empty($tobj->Item_Worth)?$tobj->Item_Worth:'Not Set' ?></td>
                                        

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>



            <!-- Payroll Clearance -->

<?php if(

            ($model->Action_ID == 'Payroll' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Payroll')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>
            <div class="card" id="Payroll">
                <div class="card-header">
                    <div class="card-title">
                        Payroll Clearance Form
                    </div>
                    <div class="card-tools">
                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Payroll')? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['payroll/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->payroll)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>
                                    

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->payroll as $pobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['assigned-assets-clearance/update','No'=> $pobj->Line_No],['class' => 'update-pobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['assigned-assets-clearance/delete','Key'=> $pobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $pobj->Key ?>" data-name="Employee_no" data-no="<?= $pobj->Line_No ?>" data-filter-field="Line_No" data-service="PayrollClearanceForm" ><?= !empty($pobj->Employee_no)?$pobj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $pobj->Key ?>" data-name="Item_Description" data-no="<?= $pobj->Line_No ?>" data-filter-field="Line_No" data-service="PayrollClearanceForm" ondblclick="addInput(this)"><?= !empty($pobj->Item_Description)?$pobj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $pobj->Key ?>" data-name="Item_Worth" data-no="<?= $pobj->Line_No ?>" data-filter-field="Line_No" data-service="PayrollClearanceForm" ondblclick="addInput(this)"><?= !empty($pobj->Item_Worth)?$pobj->Item_Worth:'Not Set' ?></td>
                                        

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>

            <!-- Peronal Clearance -->



<?php if(

            ($model->Action_ID == 'Personal_Account' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Personal_Account')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))

){ ?>
            <div class="card" id="Personal">
                <div class="card-header">
                    <div class="card-title">
                        Personal Account Clearance Form
                    </div>
                    <div class="card-tools">
                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Personal_Account')? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['personal/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']): '' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->personal)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->personal as $PerObj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['assigned-assets-clearance/update','No'=> $PerObj->Line_No],['class' => 'update-PerObjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['assigned-assets-clearance/delete','Key'=> $PerObj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $PerObj->Key ?>" data-name="Employee_no" data-no="<?= $PerObj->Line_No ?>" data-filter-field="Line_No" data-service="PersonalAccountClearance" ><?= !empty($PerObj->Employee_no)?$PerObj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $PerObj->Key ?>" data-name="Item_Description" data-no="<?= $PerObj->Line_No ?>" data-filter-field="Line_No" data-service="PersonalAccountClearance" ondblclick="addInput(this)"><?= !empty($PerObj->Item_Description)?$PerObj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $PerObj->Key ?>" data-name="Item_Worth" data-no="<?= $PerObj->Line_No ?>" data-filter-field="Line_No" data-service="PersonalAccountClearance" ondblclick="addInput(this)"><?= !empty($PerObj->Item_Worth)?$PerObj->Item_Worth:'Not Set' ?></td>
                                       

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>


<?php if(


            ($model->Action_ID == 'Archives' && $model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'}) ||

            ($model->ClearingEmployee->Employee_No == Yii::$app->user->identity->{'Employee No_'} && $model->CheckStatus('Archives')) ||

            ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && in_array($model->Action_ID, $model->allowed))


){ ?>
            <div class="card" id="Personal">
                <div class="card-header">
                    <div class="card-title">
                        Archives Clearance Form
                    </div>
                    <div class="card-tools">
                        <?= ($model->ClearingEmployee->Clearing_Employee == Yii::$app->user->identity->{'Employee No_'} && $model->Action_ID == 'Archives')? Html::a('<i class="fas fa-plus-square mr-2"></i>Add',['archive/create',
                        'Form_No' => $model->Form_No,
                        'Exit_no' => $model->Exit_No,
                        'Employee_no' => $model->Employee_No
                    ],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->archives)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Employee_no</b></td>
                                    <td><b>Item_Description</b></td>
                                    <td><b>Item_Worth</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->archives as $ArchObj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['archive/update','No'=> $ArchObj->Line_No],['class' => 'update-ArchObjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['archive/delete','Key'=> $ArchObj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $ArchObj->Key ?>" data-name="Employee_no" data-no="<?= $ArchObj->Line_No ?>" data-filter-field="Line_No" data-service="ArchivesClearance" ><?= !empty($ArchObj->Employee_no)?$ArchObj->Employee_no:'Not Set' ?></td>
                                        <td data-key="<?= $ArchObj->Key ?>" data-name="Item_Description" data-no="<?= $ArchObj->Line_No ?>" data-filter-field="Line_No" data-service="ArchivesClearance" ondblclick="addInput(this)"><?= !empty($ArchObj->Item_Description)?$ArchObj->Item_Description:'Not Set' ?></td>
                                        <td data-key="<?= $ArchObj->Key ?>" data-name="Item_Worth" data-no="<?= $ArchObj->Line_No ?>" data-filter-field="Line_No" data-service="ArchivesClearance" ondblclick="addInput(this)"><?= !empty($ArchObj->Item_Worth)?$ArchObj->Item_Worth:'Not Set' ?></td>
                                       

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>
<?php } ?>












    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Exit Management</h4>
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
        
        
      //Add  plan Line
    
     $('.add-line, .update-objective').on('click',function(e){
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
      
      
      $('.add-learning-assessment').on('click',function(e){
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

         //Change Action taken

         $('select#probation-action_taken').on('change',(e) => {

            const key = $('input[id=Key]').val();
            const Employee_No = $('input[id=Employee_No]').val();
            const Appraisal_No = $('input[id=Appraisal_No]').val();
            const Action_Taken = $('#probation-action_taken option:selected').val();
           
              

            /* var data = {
                "Action_Taken": Action_Taken,
                "Appraisal_No": Appraisal_No,
                "Employee_No": Employee_No,
                "Key": key

             } 
            */
            $.get('./takeaction', {"Key":key,"Appraisal_No":Appraisal_No, "Action_Taken": Action_Taken,"Employee_No": Employee_No}).done(function(msg){
                 $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
                });


            });





    // Class to toggle : add-line , clear-section

            $('.add-line, .clear-section').hide();
            $('input[name="inlineRadioOptions"]').on('click', function(e){
                selectedOption = e.target.value;
                // alert(selectedOption);

                if(selectedOption == 'Yes'){
                    //Display Add and Clear Buttons
                        $('.clear-section').show();
                        $('.add-line').hide();
                }else{
                        $('.add-line').show();
                         $('.clear-section').hide();
                }
            });


     // Commit HOD Comments

             $('#confirmation-hod').hide();
             $('#exitform-hod_comments').change(function(e){
                const Comments = e.target.value;
                const No = $('#exitform-form_no').val();

                if(No.length){
                    
                    const url = $('input[name=url]').val()+'exit-form/setfield?field=HOD_Comments';
                    $.post(url,{'HOD_Comments': Comments,'No': No}).done(function(msg){
                           //populate empty form fields with new data
                           
                          
                           $('#exitform-key').val(msg.Key);
                          

                            console.log(typeof msg);
                            console.table(msg);
                            if((typeof msg) === 'string') { // A string is an error
                                const parent = document.querySelector('.form-group field-exitform-hod_comments');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                              
                                
                            }else{ // An object represents correct details
                                const parent = document.querySelector('.form-group field-exitform-hod_comments');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = ''; 
                                $('#confirmation-hod').show();
                                
                                
                            }
                            
                        },'json');
                    
                }     
             });


             // Commit HR Comments

             $('#confirmation-hr').hide();
             $('#exitform-hr_comments').change(function(e){
                const Comments = e.target.value;
                const No = $('#exitform-form_no').val();

                if(No.length){
                    
                    const url = $('input[name=url]').val()+'exit-form/setfield?field=HR_Comments';
                    $.post(url,{'HR_Comments': Comments,'No': No}).done(function(msg){
                           //populate empty form fields with new data
                           
                          
                           $('#exitform-key').val(msg.Key);
                          

                            console.log(typeof msg);
                            console.table(msg);
                            if((typeof msg) === 'string') { // A string is an error
                                const parent = document.querySelector('.form-group field-exitform-hr_comments');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                              
                                
                            }else{ // An object represents correct details
                                const parent = document.querySelector('.form-group field-exitform-hr_comments');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = ''; 
                                $('#confirmation-hr').show();
                                
                                
                            }
                            
                        },'json');
                    
                }     
             });

             // Commit ED Comments

             $('#confirmation-ed').hide();
             $('#exitform-ed_comments').change(function(e){
                const Comments = e.target.value;
                const No = $('#exitform-form_no').val();

                if(No.length){
                    
                    const url = $('input[name=url]').val()+'exit-form/setfield?field=ED_Comments';
                    $.post(url,{'ED_Comments': Comments,'No': No}).done(function(msg){
                           //populate empty form fields with new data
                           
                          
                           $('#exitform-key').val(msg.Key);
                          

                            console.log(typeof msg);
                            console.table(msg);
                            if((typeof msg) === 'string') { // A string is an error
                                const parent = document.querySelector('.form-group field-exitform-ed_comments');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                              
                                
                            }else{ // An object represents correct details
                                const parent = document.querySelector('.form-group field-exitform-ed_comments');
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = ''; 
                                $('#confirmation-ed').show();
                                
                                
                            }
                            
                        },'json');
                    
                }     
             });



    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

$style = <<<CSS
    p span {
        margin-right: 50%;
        font-weight: bold;
    }

    table td:nth-child(11), td:nth-child(12) {
                text-align: center;
    }
    
    /* Table Media Queries */
    
     @media (max-width: 500px) {
          table td:nth-child(2),td:nth-child(3),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
     @media (max-width: 550px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
    @media (max-width: 650px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }


    @media (max-width: 1500px) {
          table td:nth-child(2),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
CSS;

$this->registerCss($style);
