<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'KWTRP - Employee Profile'
?>
<h2 class="title">Employee : <?= $model->No.' - '. $model->First_Name. ' '. $model->Last_Name?></h2>

<?php


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
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}


// Yii::$app->recruitment->printrr($model->beneficiaries);
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['action'=> ['leave/create']]); ?>
        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">General Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'First_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Middle_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Last_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Full_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Gender')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'County_of_Origin')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Sub_County')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Location')->textInput(['readonly'=> true, 'disabled'=>true]) ?>




                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'Sub_Location')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Village')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'National_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Passport_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Marital_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ethnic_Origin')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Religion')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Driving_License')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Health_Conditions')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                    </div>
                </div>







            </div>
        </div>



        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Communication</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Phone_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Alternative_Phone_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'E_Mail')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Company_E_Mail')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'City')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Address')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Post_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Address_2')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'ShowMap')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Alt_Address_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>



        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title"> Important Dates</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Birth_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Age')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Employment_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Service_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Period_To_Retirement')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'End_of_Probation_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Probabtion_Extended_By')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'New_Probation_Period_End_Date')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Reasons_For_Extension')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Contract_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Contract_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_of_joining_Medical_Scheme')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Job Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Pointer')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?php $form->field($model, 'Job_Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Job_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_3_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Probation_Period_Extended')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Notice_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Probation_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Line_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Overview_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Grant_Approver_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Long_Term')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Termination Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Cause_of_Inactivity_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Termination_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Grounds_for_Term_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Administration-->

        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Administration Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Suspend_Leave_Application')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Nature_Of_Employment')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Disabled')->checkbox(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Line_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Grant_Approver_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Disability_Id')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Covered_Medically')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Overview_Manager_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Payments-->


        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Payment Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Payment_Methods')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Currency')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'KRA_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'NHIF_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'NSSF_Number')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Employee_Posting_Group')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Bank_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Bank_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Bank_Branch_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Branch_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Bank_Account_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Dependants -->


        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Medical Dependants</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Full Name</th>
                                    <th>Is Student</th>
                                    <th>DOB</th>
                                    <th>Age</th>
                                    <th>Relationship</th>
                                    <th>Gender</th>
                                </thead>
                                <tbody>
                                    <?php if(is_array($dependants)):

                                        foreach($dependants as $d){
                                     ?>

                                        <tr>
                                            <td><?= !empty($d->Full_Name)?$d->Full_Name:'' ?></td>
                                            <td><?= (isset($d->Is_Student) && $d->Is_Student)?'Yes':'No' ?></td>
                                            <td><?= !empty($d->Date_of_Birth)?$d->Date_of_Birth:'' ?></td>
                                            <td><?= !empty($d->Age)?$d->Age:'' ?></td>
                                            <td><?= !empty($d->Relationship)?$d->Relationship:'' ?></td>
                                            <td><?= !empty($d->Gender)?$d->Gender:'' ?></td>
                                        </tr>

                                    <?php }
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contacts -->

        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Next of Kin</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="table-responsive">
                           
                            <table class="table">
                                <thead>
                                    <th>Relative</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Phone No</th>
                                    <th>Birth Date</th>
                                    <th>Age</th>
                                    <th>ID  / Birth Certificate No.</th>
                                    <th>Gender</th>
                                    
                                </thead>
                                <tbody>
                                    <?php if(is_array($emergency)):

                                        foreach($emergency as $em){
                                     ?>

                                        <tr>
                                            <td><?= !empty($em->Relative_Code)?$em->Relative_Code:'' ?></td>
                                            <td><?= !empty($em->First_Name)?$em->First_Name:'' ?></td>
                                            <td><?= !empty($em->Middle_Name)?$em->Middle_Name:'' ?></td>
                                            <td><?= !empty($em->Last_Name)?$em->Last_Name:'' ?></td>
                                            <td><?= !empty($em->Phone_No)?$em->Phone_No:'' ?></td>
                                            <td><?= !empty($em->Birth_Date)?$em->Birth_Date:'' ?></td>
                                            <td><?= !empty($em->Age)?$em->Age:'' ?></td>
                                            <td><?= !empty($em->ID_Birth_Certificate_No)?$em->ID_Birth_Certificate_No:'' ?></td>
                                            <td><?= !empty($em->Gender)?$em->Gender:'' ?></td>
                                            
                                        </tr>

                                    <?php }
                                endif; ?>
                                </tbody>
                            </table>
                        
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>


        <!-- Beneficiaries -->

        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Beneficiaries</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Full Name</th>
                                    <th>Type</th>
                                    <th>Relationship</th>
                                    <th>Phone Number</th>
                                    <th>Email_Address</th>
                                    <th>Date_of_Birth</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Percentage</th>
                                    
                                    
                                </thead>
                                <tbody>
                                    <?php if(is_array($beneficiaries)):

                                        foreach($beneficiaries as $be){
                                     ?>

                                        <tr>
                                            <td><?= !empty($be->Full_Names)?$be->Full_Names:'' ?></td>
                                            <td><?= !empty($be->Type)?$be->Type:'' ?></td>
                                            <td><?= !empty($be->Relationship)?$be->Relationship:'' ?></td>
                                            <td><?= !empty($be->Phone_No)?$be->Phone_No:'' ?></td>
                                            <td><?= !empty($be->Email_Address)?$be->Email_Address:'' ?></td>
                                            <td><?= !empty($be->Date_of_Birth)?$be->Date_of_Birth:'' ?></td>
                                            <td><?= !empty($be->Age)?$be->Age:'' ?></td>
                                            <td><?= !empty($be->Gender)?$be->Gender:'' ?></td>
                                            <td><?= !empty($be->Percentage)?$be->Percentage:'' ?></td>
                                            
                                        </tr>

                                    <?php }
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>


        <!-- Qualifications -->


        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Qualifications</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    
                                    <th>Description</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Institution</th>
                                    <th>Specialization</th>
                                    
                                    
                                    
                                </thead>
                                <tbody>
                                    <?php if(is_array($qualifications)):

                                        foreach($qualifications as $be){
                                     ?>

                                        <tr>
                                            
                                            <td><?= !empty($be->Description)?$be->Description:'' ?></td>
                                            <td><?= !empty($be->From_Date)?$be->From_Date:'' ?></td>
                                            <td><?= !empty($be->To_Date)?$be->To_Date:'' ?></td>
                                            <td><?= !empty($be->Institution_Company)?$be->Institution_Company:'' ?></td>
                                            <td><?= !empty($be->Specialization)?$be->Specialization:'' ?></td>
                                                                                        
                                        </tr>

                                    <?php }
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>



        <!-- Qualifications -->


        <!-- Work Permits If Expertriate -->

<?php $m=1 ?>
<?php if($m==1): ?>

        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Work Permits</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    
                                    <th>Permit No</th>
                                    <th>Date of Issue</th>
                                    <th>Effective Date</th>
                                    <th>Expiry Date</th>
                                    <th>Renewal Date</th>
                                    <th>Permit Type</th>
                                    <th>Passport Number</th>
                                    <th>File Number</th>
                                    <th>Permit Status</th>
                                    
                                    
                                    
                                </thead>
                                <tbody>
                            
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

<?php endif; ?>
        <!-- /Work Permit  -->











        <?php ActiveForm::end(); ?>
    </div>
</div>
