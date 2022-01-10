<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
// Yii::$app->recruitment->printrr($employees);

?>

<div class="card">
    <div class="actions card-body">
            <?= ($model->Status == 'New')?Html::a('<i class="fas fa-forward"></i>Send For Approval',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-app bg-success btn-success submitforapproval',
                                'data' => [
                                    'confirm' => 'Are you sure you want to send imprest request for approval?',
                                    'params'=>[
                                        'No'=> $model->No,
                                        'employeeNo' =>Yii::$app->user->identity->employee[0]->No,
                                    ],
                                    'method' => 'get',
                            ],
                                'title' => 'Submit Imprest Approval'
    
                            ]):'' ?>
    
    
                            <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
                                'data' => [
                                'confirm' => 'Are you sure you want to cancel imprest approval request?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'get',
                            ],
                                'title' => 'Cancel Imprest Approval Request'
    
                            ]):'' ?>
    
    
                            <?= Html::a('<i class="fas fa-file-pdf"></i> Print Imprest',['print-imprest'],['class' => 'btn btn-app bg-warning ',
                                'data' => [
                                    'confirm' => 'Print Imprest?',
                                    'params'=>[
                                        'No'=> $model->No,
                                    ],
                                    'method' => 'get',
                                ],
                                'title' => 'Print Imprest.'
    
                            ]) ?>
    </div>

</div>

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

                <div class="row float-right">
                    <!-- <div class="col-md-4"> -->

                        
                    <!-- </div> -->
                </div>

                <div class= "row">
                       <?php if(Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success')?></div>
                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error')?></div>
                <?php endif; ?>
                </div>

           </div>

            <div class="card-body">



        <?php

            $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="row col-md-12">



                        <div class="col-md-6">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            
                            <?= $form->field($model, 'Request_For')->dropDownList([
                                'Self' => 'Self',
                                'Other' => 'Other',
                            ],['prompt' => 'Select Request_For']) 
                            ?>

                            <?= $form->field($model, 'Employee_No')->dropDownList( $employees,['prompt'=> 'Select ...']) ?>
                       
                            <?= $form->field($model, 'Imprest_Type')->dropDownList(['Local' => 'Local', 'International' => 'International'],['prompt' => 'Select ...']) ?>

                            <?= $form->field($model, 'Purpose')->textInput() ?>

                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            
                            
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    
                                    <?= $form->field($model, 'Currency_Code')->dropDownList($currencies,['prompt' => 'Select ...','required' => true]) ?>
                                    <?= $form->field($model, 'Imprest_Amount')->textInput(['type' => 'number','readonly'=> true, 'disabled'=>true]) ?>
                                    
                                    <?= $form->field($model, 'Employee_Balance')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    
                                    <?= $form->field($model, 'Exchange_Rate')->textInput(['type'=> 'number','required' => true]) ?>
                            <!-- <?= $form->field($model, 'Expected_Date_of_Surrender')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->


                        </div>
                  



                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <?php Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <div class="card-title">
                                    <h3>Imprest Lines</h3>
                </div>
                <div class="card-tools">
                        <?= Html::a('<i class="fa fa-plus-square"></i> New Imprest Line',['add-line'],[
                            'class' => 'add btn btn-outline-info',
                            'data-no' => $model->No,
                            'data-service' => 'ImprestRequestSubformPortal'
                            ]) ?>
                </div>
            </div>

            <div class="card-body">
                <?php if(is_array($model->getLines($model->No))){ //show Lines ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td><b>Transaction Type</b></td>
                            <!-- <td><b>Account No</b></td> -->
                            <td><b>Account Name</b></td>
                            <td><b>Description</b></td>
                            <td><b>Amount</b></td>
                            <td><b>Amount LCY</b></td>
                            <!-- <td><b>Budgeted Amount</b></td> -->
                            <!-- <td><b>Commited Amount</b></td> -->
                            <!-- <td><b>Total_Expenditure</b></td> -->
                            <!-- <td><b>Available Amount</b></td> -->
                            <!-- <td><b>Unbudgeted?</b></td> -->
                            <td><b>Actions</b></td>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // print '<pre>'; print_r($model->getLines($model->No)); exit;

                        foreach($model->getLines($model->No) as $obj):
                            $updateLink = Html::a('<i class="fa fa-edit"></i>',['imprestline/update','Line_No'=> $obj->Line_No, 'DocNum'=> $model->No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                            $deleteLink = Html::a('<i class="fa fa-trash"></i>',['delete-line' ],[
                                'class'=>'del btn btn-outline-danger btn-xs',
                                'data-key' => $obj->Key,
                                'data-service' => 'ImprestRequestSubformPortal'
                            ]);
                            ?>
                            <tr>

                                <td data-key="<?= $obj->Key ?>" data-name="Transaction_Type" data-service="ImprestRequestSubformPortal" ondblclick="addDropDown(this,'transactiontypes')"><?= !empty($obj->Transaction_Type)?$obj->Transaction_Type:'Not Set' ?></td>
                                <!-- <td><?= !empty($obj->Account_No)?$obj->Account_No:'Not Set' ?></td> -->
                                <td><?= !empty($obj->Account_Name)?$obj->Account_Name:'Not Set' ?></td>
                                <td data-key="<?= $obj->Key ?>" data-name="Description" data-service="ImprestRequestSubformPortal" ondblclick="addInput(this, '')"><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                <td data-key="<?= $obj->Key ?>" data-name="Amount" data-service="ImprestRequestSubformPortal" ondblclick="addInput(this,'number')"><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                <td><?= !empty($obj->Amount_LCY)?$obj->Amount_LCY:'Not Set' ?></td>
                                <!-- <td><?= !empty($obj->Budgeted_Amount)?$obj->Budgeted_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Commited_Amount)?$obj->Commited_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Total_Expenditure)?$obj->Total_Expenditure:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Available_Amount)?$obj->Available_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= Html::checkbox('Unbudgeted',$obj->Unbudgeted) ?></td> -->
                                <td><?= $deleteLink ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>






    </div>
</div>



<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS

    // Trigger Creation of a line

    $('.add').on('click',function(e){
            e.preventDefault();
            let url = $(this).attr('href');
           
            let data = $(this).data();
            const payload = {
                'Document_No': data.no,
                'Service': data.service
            };
            //console.log(payload);
            //return;
            $('a.add').text('Inserting...');
            $('a.add').attr('disabled', true);

            $.get(url, payload).done((msg) => {
                console.log(msg);
                setTimeout(() => {
                    location.reload(true);
                },3000);
            });
        });



    //hide EmpNo

    $('.field-imprestcard-employee_no').hide();
      
      // Conditionally Display Employee No
     $('#imprestcard-request_for').on('change', () => {
         let selectedValue = $('#imprestcard-request_for :selected').text();
         // console.log(selectedValue);
         if(selectedValue == 'Other')
         {
            $('.field-imprestcard-employee_no').fadeIn();
         }else{
            $('.field-imprestcard-employee_no').fadeOut();
         }
     });

     $('#imprestcard-request_for').on('change',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Request_For", e);
    });  


     $('#imprestcard-imprest_type').on('change',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Imprest_Type", e);
    });                      

    $('#imprestcard-employee_no').on('change',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Employee_No", e);
    });

     
     /*Set Program  */
    
     $('#imprestcard-global_dimension_1_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Global_Dimension_1_Code', e);
    });
     
     
     /* set department */
     
     $('#imprestcard-global_dimension_2_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Global_Dimension_2_Code', e);
    });

    /**Update Purpose */

    $('#imprestcard-purpose').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Purpose', e);
    });

    $('#imprestcard-exchange_rate').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Exchange_Rate', e);
    });

    $('#imprestcard-currency_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Currency_Code', e);
    });

    $('#imprestcard-imprest_amount').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Imprest_Amount', e);
    });

    $('.del').on('click',function(e){
            e.preventDefault();

            if(confirm('Are you sure about deleting this record?'))
            {
                let data = $(this).data();
                let url = $(this).attr('href');
                let Key = data.key;
                let Service = data.service;
                const payload = {
                    'Key': Key,
                    'Service': Service
                };

                $(this).text('Deleting...');
                $(this).attr('disabled', true);

                $.get(url, payload).done((msg) => {
                    console.log(msg);
                    setTimeout(() => {
                        location.reload(true);
                    },3000);
                });
            }
            
    });



       /* Add Line */
     $('.add-line, .update-objective').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
JS;

$this->registerJs($script);
