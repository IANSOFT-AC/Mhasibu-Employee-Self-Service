<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Request - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Change Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Change Request Card', 'url' => ['view','No'=> $model->No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/
?>

<div class="row">
    <div class="col-md-4">

      
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Change Request Document </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="push-right">
                        
                        <?= ($model->Approval_Status == 'New')?Html::a('Send For Approval',['send-for-approval'],['class' => 'btn btn-success submitforapproval ',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to send this document for approval?',
                                        'params'=>[
                                            'No'=> $model->No,
                                            'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                                        ],
                                        'method' => 'get',
                                ],
                                    'title' => 'Submit Request Approval'

                                ]):'' 
                        ?>


                        <?= ($model->Approval_Status == 'Pending_Approval' && !Yii::$app->request->get('Approval'))?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
                            'data' => [
                            'confirm' => 'Are you sure you want to cancel imprest approval request?',
                            'params'=>[
                                'No'=> $model->No,
                            ],
                            'method' => 'get',
                        ],
                            'title' => 'Cancel Approval Request'

                        ]):'' 
                        ?>

                        <?=
                            Html::a('Go Back',['index'],['class' => 'btn btn-warning',
                                
                                'title' => 'Close The Current Page'

                                ]);
                        ?>

                    </div>




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
                                <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Nature_of_Change')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <!-- <?= $form->field($model, 'Approval_Entries')->textInput(['readonly'=> true,'disabled'=> true]) ?> -->

                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->


             <?php if( (Yii::$app->request->get('Change') == 'Medical_Dependants' || $model->Nature_of_Change == 'Medical_Dependants')){ ?>
            <!--Medical Dependants -->

            <div class="card" id="Medical_Dependants">
                <div class="card-header">
                    <div class="card-title">
                       Employee Medical Depandants    <?= ($model->Approval_Status == 'New')?Html::a('Add',['dependant/create','No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php
                   // Yii::$app->recruitment->printrr($model);
                    if(is_array($model->dependants)){ //show Lines ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Full Name</b></td>
                                <td><b>ID Birth / Certificate_No</b></td>
                                <td><b>Is Student</b></td>
                                <td><b>Date of Birth</b></td>
                                <td><b>Age</b></td>
                                <td><b>Relationship</b></td>
                                <td><b>Gender</b></td>
                                <td><b>Change Action</b></td>
                               <!-- <td><b> Action</b></td>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;
                            foreach($model->dependants as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['dependant/update','No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['dependant/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td data-key="<?= $obj->Key ?>" data-name="Full_Name" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addInput(this)"><?= !empty($obj->Full_Name)?$obj->Full_Name:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="ID_Birth_Certificate_No" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addInput(this)"><?= !empty($obj->ID_Birth_Certificate_No)?$obj->ID_Birth_Certificate_No:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Is_Student" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addDropDown(this,'bool')" data-validate="Is_Student" id="Is_Student" ><?= !empty($obj->Is_Student && $obj->Is_Student)?'Yes':'No' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Date_of_Birth" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addInput(this,'date')" data-validate="_<?= $obj->Line_No ?>" id="_<?= $obj->Line_No ?>"><?= !empty($obj->Date_of_Birth)?$obj->Date_of_Birth:'Not Set' ?></td>
                                    <td><?= !empty($obj->Age)?$obj->Age:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Relationship" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addDropDown(this,'relatives')"><?= !empty($obj->Relationship)?$obj->Relationship:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Gender" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addDropDown(this,'gender')"><?= !empty($obj->Gender)?$obj->Gender:'Not Set' ?></td>
                                    <td data-key="<?= $obj->Key ?>" data-name="Action" data-no="<?= $obj->Line_No ?>" data-model="Dependants" data-service="EmployeeDepandants" ondblclick="addDropDown(this,'action')"><?= !empty($obj->Action)?$obj->Action:'Not Set' ?></td>
                                    <!--<td><?/*= $deleteLink */?></td>-->

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php } ?>
                </div>
            </div>


            <!--End Dependants Lines --Initially used for next of kin-->

            <?php }elseif( (Yii::$app->request->get('Change') == 'Emergency_Contacts' || $model->Nature_of_Change == 'Emergency_Contacts')){ ?>
            <!--Next of Keen-->

            <div class="card" id="Next_Of_Kin">
                <div class="card-header">
                    <div class="card-title">
                        Employee Next of Kin    <?= ($model->Approval_Status == 'New')?Html::a('Add',['relative/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php
                    //Yii::$app->recruitment->printrr($model->relatives);
                    if(is_array($model->relatives)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Relationship</b></td>
                                    <td><b>First Name</b></td>
                                    <td><b>Last Name</b></td>
                                    <td><b>Phone No.</b></td>
                                    <td><b>Birth Date</b></td>
                                    <td><b>Age</b></td>
                                    <td><b>ID / Birth Cert</b></td>
                                    <td><b>Gender</b></td>
                                    <td><b>Change Action</b></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->relatives as $robj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['dependant/update','No'=> $robj->Line_No],['class' => 'update-robjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['dependant/delete','Key'=> $robj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $robj->Key ?>" data-name="Relative_Code" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addDropDown(this,'relatives')"><?= !empty($robj->Relative_Code)?$robj->Relative_Code:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="First_Name" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addInput(this)"><?= !empty($robj->First_Name)?$robj->First_Name:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Last_Name" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addInput(this)"><?= !empty($robj->Last_Name)?$robj->Last_Name:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Phone_No" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addInput(this)"><?= !empty($robj->Phone_No)?$robj->Phone_No:'Not Set' ?></td>

                                        <td data-key="<?= $robj->Key ?>" data-name="Birth_Date" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addInput(this,'date')"><?= !empty($robj->Birth_Date)?$robj->Birth_Date:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Age" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange"><?= !empty($robj->Age)?$robj->Age:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="ID_Birth_Certificate_No" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addInput(this)"><?= !empty($robj->ID_Birth_Certificate_No)?$robj->ID_Birth_Certificate_No:'Not Set' ?></td>



                                        <td data-key="<?= $robj->Key ?>" data-name="Gender" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addDropDown(this,'gender')"><?= !empty($robj->Gender)?$robj->Gender:'Not Set' ?></td>
                                        <td data-key="<?= $robj->Key ?>" data-name="Action" data-no="<?= $robj->Line_No ?>" data-model="Relative" data-service="EmployeeRelativesChange" ondblclick="addDropDown(this,'action')"><?= !empty($robj->Action)?$robj->Action:'Not Set' ?></td>
                                        <!--<td><?/*= $deleteLink */?></td>-->

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                </div>
            </div>

            <!--Beneficiaries-->

            <?php }elseif( (Yii::$app->request->get('Change') == 'Beneficiaries' || $model->Nature_of_Change == 'Beneficiaries')){ ?>

            <div class="card" id="Employee_Beneficiaries_Change">
                <div class="card-header">
                    <div class="card-title">
                         <?= ($model->Approval_Status == 'New')?
                        // Html::a('Add',['beneficiaries/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' 
                        Html::button('Add Beneficiary Request',
                            [  'value' => yii\helpers\Url::to(['beneficiaries/create',
                            'Change_No' => $model->No
                            ]),
                            'title' => 'Add Beneficiary Request',
                            'class' => 'btn btn-success push-right showModalButton',
                         ]):''
                        ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->beneficiaries)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Full Names</b></td>
                                    <td><b>Type</b></td>
                                    <td><b>Relationship</b></td>
                                    <td><b>ID / Birth Cert</b></td>
                                    <td><b>Phone No.</b></td>
                                    <td><b>Email Address</b></td>
                                    <td><b>D.O.B</b></td>

                                    <td><b>Comments</b></td>
                                    <td><b>Percentage</b></td>
                                    <td><b>New Allocation</b></td>
                                    <td><b>Gender</b></td>
                                    <td><b>Action</b></td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->beneficiaries as $benobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['beneficiary/update','No'=> $benobj->No],['class' => 'update-benobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['beneficiary/delete','Key'=> $benobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $benobj->Key ?>" data-name="Full_Names" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this)"><?= !empty($benobj->Full_Names)?$benobj->Full_Names:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Type" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addDropDown(this,'type')"><?= !empty($benobj->Type)?$benobj->Type:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Relationship" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addDropDown(this,'relatives')"><?= !empty($benobj->Relationship)?$benobj->Relationship:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="ID_Birth_Certificate_No" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this)"><?= !empty($benobj->ID_Birth_Certificate_No)?$benobj->ID_Birth_Certificate_No:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Phone_No" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this)"><?= !empty($benobj->Phone_No)?$benobj->Phone_No:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Email_Address" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this,'email')"><?= !empty($benobj->Email_Address)?$benobj->Email_Address:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Date_of_Birth" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this,'date')"><?= !empty($benobj->Date_of_Birth)?$benobj->Date_of_Birth:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Comments" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this)"><?= !empty($benobj->Comments)?$benobj->Comments:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Percentage" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this,'number')"><?= !empty($benobj->Percentage)?$benobj->Percentage:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="New_Allocation" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addInput(this)"><?= !empty($benobj->New_Allocation)?$benobj->New_Allocation:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Gender" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addDropDown(this,'gender')"><?= !empty($benobj->Gender)?$benobj->Gender:'Not Set' ?></td>
                                        <td data-key="<?= $benobj->Key ?>" data-name="Action" data-no="<?= $benobj->No ?>" data-filter-field="No" data-service="EmployeeBeneficiariesChange" ondblclick="addDropDown(this,'action')"><?= !empty($benobj->Action)?$benobj->Action:'Not Set' ?></td>
                                        <!--<td><?/*= $deleteLink */?></td>-->

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <?php }elseif( (Yii::$app->request->get('Change') == 'Work_History' || $model->Nature_of_Change == 'Work_History') ){ ?>

            <!--Work History Change-->


            <div class="card" id="Employee_Work_History_Change">
                <div class="card-header">
                    <div class="card-title">
                        Work History    <?= ($model->Approval_Status == 'New')?Html::a('Add',['work-history/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->workhistory)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Work_Done</b></td>
                                    <td><b>Institution_Company</b></td>
                                    <td><b>From_Date</b></td>
                                    <td><b>To_Date</b></td>
                                    <td><b>Key_Experience</b></td>
                                    <td><b>Salary_on_Leaving</b></td>
                                    <td><b>Reason_For_Leaving</b></td>
                                    <!-- <td><b>Comments</b></td> -->

                                    <td><b>Action</b></td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->workhistory as $whobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['beneficiary/update','No'=> $whobj->Line_No],['class' => 'update-whobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['beneficiary/delete','Key'=> $whobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $whobj->Key ?>" data-name="Work_Done" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this)"><?= !empty($whobj->Work_Done)?$whobj->Work_Done:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Institution_Company" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this)"><?= !empty($whobj->Institution_Company)?$whobj->Institution_Company:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="From_Date" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this, 'date')"><?= !empty($whobj->From_Date)?$whobj->From_Date:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="To_Date" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this, 'date')"><?= !empty($whobj->To_Date)?$whobj->To_Date:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Key_Experience" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this)"><?= !empty($whobj->Key_Experience)?$whobj->Key_Experience:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Salary_on_Leaving" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this)"><?= !empty($whobj->Salary_on_Leaving)?$whobj->Salary_on_Leaving:'Not Set' ?></td>
                                        <td data-key="<?= $whobj->Key ?>" data-name="Reason_For_Leaving" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this)"><?= !empty($whobj->Reason_For_Leaving)?$whobj->Reason_For_Leaving:'Not Set' ?></td>
                                        <!-- <td data-key="<?= $whobj->Key ?>" data-name="Comments" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addInput(this)" ><?= !empty($whobj->Comments)?$whobj->Comments:'Not Set' ?></td> -->
                                        <td data-key="<?= $whobj->Key ?>" data-name="Action" data-no="<?= $whobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeWorkHistoryChange" ondblclick="addDropDown(this,'action')" ><?= !empty($whobj->Action)?$whobj->Action:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <?php }elseif( (Yii::$app->request->get('Change') == 'Proffesional_Bodies' || $model->Nature_of_Change == 'Proffesional_Bodies' ) ){ ?>
            <!--Professional Bodies-->

            <div class="card" id="Employee_Proffesional_Bodies_C">
                <div class="card-header">
                    <div class="card-title">
                        Professional Bodies Affiliation    <?= ($model->Approval_Status == 'New')?Html::a('Add',['professionalchange/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->professional)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Body_Code</b></td>
                                    <td><b>Name</b></td>
                                    <td><b>From_Date</b></td>
                                    <td><b>To_Date</b></td>
                                    <td><b>Membership_No</b></td>
                                    <td><b>Action</b></td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->professional as $proobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['professional/update','No'=> $proobj->Line_No],['class' => 'update-proobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['professional/delete','Key'=> $proobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $proobj->Key ?>" data-name="Body_Code" data-no="<?= $proobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeProffesionalBodies" ondblclick="addDropDown(this, 'professional')"><?= !empty($proobj->Body_Code)?$proobj->Body_Code:'Not Set' ?></td>
                                        <td data-key="<?= $proobj->Key ?>" data-name="Name" data-no="<?= $proobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeProffesionalBodies" ondblclick="addInput(this)"><?= !empty($proobj->Name)?$proobj->Name:'Not Set' ?></td>
                                        <td data-key="<?= $proobj->Key ?>" data-name="From_Date" data-no="<?= $proobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeProffesionalBodies" ondblclick="addInput(this, 'date')"><?= !empty($proobj->From_Date)?$proobj->From_Date:'Not Set' ?></td>
                                        <td data-key="<?= $proobj->Key ?>" data-name="To_Date" data-no="<?= $proobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeProffesionalBodies" ondblclick="addInput(this, 'date')"><?= !empty($proobj->To_Date)?$proobj->To_Date:'Not Set' ?></td>
                                        <td data-key="<?= $proobj->Key ?>" data-name="Membership_No" data-no="<?= $proobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeProffesionalBodies" ondblclick="addInput(this)"><?= !empty($proobj->Membership_No)?$proobj->Membership_No:'Not Set' ?></td>
                                        <td data-key="<?= $proobj->Key ?>" data-name="Action" data-no="<?= $proobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeProffesionalBodies" ondblclick="addDropDown(this,'action')"><?= !empty($proobj->Action)?$proobj->Action:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>


            <?php }elseif( (Yii::$app->request->get('Change') == 'Qualifications' || $model->Nature_of_Change == 'Qualifications' ) ){ ?>
            <!--Qualification Change-->

            <div class="card" id="Employee_Qualifications_Change">
                <div class="card-header">
                    <div class="card-title">
                        Qualifications Change Request    <?= ($model->Approval_Status == 'New')?Html::a('Add',['qualificationchange/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->qualifications)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Qualification_Code</b></td>
                                    <td><b>Description</b></td>
                                    <td><b>From_Date</b></td>
                                    <td><b>To_Date</b></td>
                                    <td><b>Institution_Company</b></td>
                                    <!-- <td><b>Comment</b></td> -->
                                    <td><b>Action</b></td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->qualifications as $qobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['professional/update','No'=> $qobj->Line_No],['class' => 'update-qobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['professional/delete','Key'=> $qobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $qobj->Key ?>" data-name="Qualification_Code" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addDropDown(this, 'qualifications')"><?= !empty($qobj->Qualification_Code)?$qobj->Qualification_Code:'Not Set' ?></td>
                                        <td data-key="<?= $qobj->Key ?>" data-name="Description" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addInput(this)"><?= !empty($qobj->Description)?$qobj->Description:'Not Set' ?></td>
                                        <td data-key="<?= $qobj->Key ?>" data-name="From_Date" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addInput(this, 'date')"><?= !empty($qobj->From_Date)?$qobj->From_Date:'Not Set' ?></td>
                                        <td data-key="<?= $qobj->Key ?>" data-name="To_Date" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addInput(this, 'date')"><?= !empty($qobj->To_Date)?$qobj->To_Date:'Not Set' ?></td>
                                        <td data-key="<?= $qobj->Key ?>" data-name="Institution_Company" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addInput(this)"><?= !empty($qobj->Institution_Company)?$qobj->Institution_Company:'Not Set' ?></td>
                                        <!-- <td data-key="<?= $qobj->Key ?>" data-name="Comment" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addInput(this)"><?= !empty($qobj->Comment)?$qobj->Comment:'Not Set' ?></td> -->
                                        <td data-key="<?= $qobj->Key ?>" data-name="Action" data-no="<?= $qobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeQualificationsChange" ondblclick="addDropDown(this,'action')"><?= !empty($qobj->Action)?$qobj->Action:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>



            <?php }elseif( (Yii::$app->request->get('Change') == 'Emergency_Contacts-1' || $model->Nature_of_Change == 'Emergency_Contacts-1') ){ ?>
           
            <!--Emergency Contact Change-->

            <div class="card" id="Employee_Emergency_Contacts_C">
                <div class="card-header">
                    <div class="card-title">
                       Emergency Contact Change    <?= ($model->Approval_Status == 'New')?Html::a('Add',['emergency/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->emergency)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Full_Name</b></td>
                                    <td><b>Relationship</b></td>
                                    <td><b>Phone_No</b></td>
                                    <td><b>Email_Address</b></td>
                                    <td><b>Action</b></td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->emergency as $emobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['emergency/update','No'=> $emobj->Line_No],['class' => 'update-emobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['emergency/delete','Key'=> $emobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $emobj->Key ?>" data-name="Full_Name" data-no="<?= $emobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeEmergencyContacts" ondblclick="addInput(this)"><?= !empty($emobj->Full_Name)?$emobj->Full_Name:'Not Set' ?></td>
                                        <td data-key="<?= $emobj->Key ?>" data-name="Relationship" data-no="<?= $emobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeEmergencyContacts" ondblclick="addDropDown(this,'relatives')"><?= !empty($emobj->Relationship)?$emobj->Relationship:'Not Set' ?></td>
                                        <td data-key="<?= $emobj->Key ?>" data-name="Phone_No" data-no="<?= $emobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeEmergencyContacts" ondblclick="addInput(this)"><?= !empty($emobj->Phone_No)?$emobj->Phone_No:'Not Set' ?></td>
                                        <td data-key="<?= $emobj->Key ?>" data-name="Email_Address" data-no="<?= $emobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeEmergencyContacts" ondblclick="addInput(this)"><?= !empty($emobj->Email_Address)?$emobj->Email_Address:'Not Set' ?></td>
                                        <td data-key="<?= $emobj->Key ?>" data-name="Action" data-no="<?= $emobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeEmergencyContacts" ondblclick="addDropDown(this,'action')"><?= !empty($emobj->Action)?$emobj->Action:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <!-- Bio Data Change -->

            <?php }elseif( (Yii::$app->request->get('Change') == 'Bio_Data' || $model->Nature_of_Change == 'Bio_Data') ){ ?>
           
           

            <div class="card" id="Bio_Data">
                <div class="card-header">
                    <div class="card-title">
                       Bio-Data Change Request   
                    </div>

                    <div class="card-tools">
                         <?= ($model->Approval_Status == 'New')?Html::a('Add',['biodata/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->biodata)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Phone_No</b></td>
                                    <td><b>Personal E-mail Address</b></td>
                                    <td><b>Passport No.</b></td>
                                    <td><b>Status</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;
                                foreach($model->biodata as $biobj):
                                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['biodata/update','No'=> $biobj->Line_No],['class' => 'update-emobjective btn btn-outline-info btn-xs']);
                                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['biodata/delete','Key'=> $biobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                    ?>
                                    <tr>

                                        <td data-key="<?= $biobj->Key ?>" data-name="Phone_Number" data-no="<?= $biobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeBioDataChange" ondblclick="addInput(this)"><?= !empty($biobj->Phone_Number)?$biobj->Phone_Number:'Not Set' ?></td>
                                        <td data-key="<?= $biobj->Key ?>" data-name="Personal_E_mail" data-no="<?= $biobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeBioDataChange" ondblclick="addInput(this)"><?= !empty($biobj->Personal_E_mail)?$biobj->Personal_E_mail:'Not Set' ?></td>
                                        <td data-key="<?= $biobj->Key ?>" data-name="Passport_No" data-no="<?= $biobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeBioDataChange" ondblclick="addInput(this)"><?= !empty($biobj->Passport_No)?$biobj->Passport_No:'Not Set' ?></td>
                                       
                                        <td data-key="<?= $biobj->Key ?>" data-name="Status" data-no="<?= $biobj->Line_No ?>" data-filter-field="Line_No" data-service="EmployeeBioDataChange" ondblclick="addDropDown(this,'biostatus')"><?= !empty($biobj->Status)?$biobj->Status:'Not Set' ?></td>


                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div>
            </div>


            <!---Miscelleneous change Req-->
             <?php }elseif( (Yii::$app->request->get('Change') == 'Asset_Assignment' || $model->Nature_of_Change == 'Asset_Assignment' ) ){ ?>

            <div class="card" id="Misc_artical_information_ch">
                <div class="card-header">
                    <div class="card-title">
                       Miscelleneous Change    <?=  ($model->Approval_Status == 'New')?Html::a('Add',['misc/create','Change_No' => $model->No],['class' => 'add-line btn btn-sm btn-info']):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php

            if(is_array($model->misc)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Misc_Article_Code</b></td>
                                    <td><b>Description</b></td>
                                    <td><b>From_Date</b></td>
                                    <td><b>To_Date</b></td>
                                    <td><b>Serial</b></td>
                                    <td><b>Action</b></td>
                                    <td><b>Asset_Number</b></td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                // print '<pre>'; print_r($model->getObjectives()); exit;
                foreach($model->misc as $miscobj):
                    $updateLink = Html::a('<i class="fa fa-edit"></i>',['misc/update','No'=> $miscobj->Line_No],['class' => 'update-miscobjective btn btn-outline-info btn-xs']);
                    $deleteLink = Html::a('<i class="fa fa-trash"></i>',['misc/delete','Key'=> $miscobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                    ?>
                                    <tr>

                                        <td data-key="<?= $miscobj->Key ?>" data-name="Misc_Article_Code" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addDropDown(this, 'misc-code')"><?= !empty($miscobj->Misc_Article_Code)?$miscobj->Misc_Article_Code:'Not Set' ?></td>
                                        <td data-key="<?= $miscobj->Key ?>" data-name="Description" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addDropDown(this,'relatives')"><?= !empty($miscobj->Description)?$miscobj->Description:'Not Set' ?></td>
                                        <td data-key="<?= $miscobj->Key ?>" data-name="From_Date" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this, 'date')"><?= !empty($miscobj->From_Date)?$miscobj->From_Date:'Not Set' ?></td>
                                        <td data-key="<?= $miscobj->Key ?>" data-name="To_Date" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this, 'date')"><?= !empty($miscobj->To_Date)?$miscobj->To_Date:'Not Set' ?></td>
                                        
                                        <td data-key="<?= $miscobj->Key ?>" data-name="Serial_No" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this)"><?= !empty($miscobj->Serial_No)?$miscobj->Serial_No:'Not Set' ?></td>

                                         <td data-key="<?= $miscobj->Key ?>" data-name="Action" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addDropDown(this,'action')"><?= !empty($miscobj->Action)?$miscobj->Action:'Not Set' ?></td>

                                        <td data-key="<?= $miscobj->Key ?>" data-name="Asset_Number" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this)"><?= !empty($miscobj->Asset_Number)?$miscobj->Asset_Number:'Not Set' ?></td>


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
