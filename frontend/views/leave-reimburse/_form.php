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
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

                <?php if(Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success')?></div>
                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error')?></div>
                <?php endif; ?>

                <?= ($model->Status == 'New')?
                                Html::a('Send For Approval', ['send-for-approval', 'No' => $_GET['No'],
                                'employeeNo' => Yii::$app->user->identity->{'Employee No_'}],
                                ['class' => 'btn btn-primary float-right']):'' 
                        ?>
                    
                        <?php ($model->Status == 'Pending_Approval')?
                            Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],
                            ['class' => 'btn btn-app submitforapproval',
                                'data' => [
                                'confirm' => 'Are you sure you want to cancel imprest approval request?',
                                'params'=>[
                                    'No'=> $_GET['No'],
                                ],
                                'method' => 'get',
                            ],
                                'title' => 'Cancel Leave Approval Request'
                            ]):'' 
                        ?>
                
                <?=   Html::a('Close', ['index', ], ['class' => 'btn btn-warning float-right']) ?>


            </div>
            <div class="card-body">



        <?php

            $form = ActiveForm::begin([
                    // 'id' => $model->formName()
            ]); ?>
                <div class="row">
                    <div class="row col-md-12">

                    <?php if($model->isNewRecord ==true): ?>
                         <div class="col-md-6">
    
                            <?= $form->field($model, 'Employee_No')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Days_To_Reimburse')->textInput(['type'=> 'number','required' => true]) ?>                         

                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'Comments')->textArea(['rows'=> 2, 'required'=>true]) ?>                         

                        </div>

                        <?php else: ?>
                         <div class="col-md-6"> 

                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'Days_To_Reimburse')->textInput(['type'=> 'number','required' => true]) ?>
                            <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <!-- <?= '<p><span>Employee Name</span> '.Html::a($model->Employee_Name,'#'); '</p>' ?> -->
                            <?= $form->field($model, 'Application_No')->textInput(['required' => true, 'readonly'=>true]) ?>
                            <?= $form->field($model, 'Application_Date')->textInput(['required' => true, 'disabled'=>true]) ?>
                            <!-- <?= $form->field($model, 'Leave_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->
                            <?= $form->field($model, 'Leave_Type_Decription')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                          

                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'Comments')->textArea(['rows'=> 2, 'required'=>true]) ?>
                            <?= $form->field($model, 'Leave_balance')->textInput(['readonly'=> true,'disabled'=>true]) ?>
                            <?= $form->field($model, 'Balance_After')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Phone_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <!-- <?= $form->field($model, 'E_Mail_Address')->textInput(['type' => 'email','readonly'=> true, 'disabled'=>true]) ?> -->
                            <!-- <?= $form->field($model, 'Grade')->textInput(['type' => 'email','readonly'=> true, 'disabled'=>true]) ?> -->
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <!-- <?= '<p><span>Approval_Entries</span> '.Html::a($model->Approval_Entries,'#'); '</p>' ?> -->

                            

                        </div>
                    <?php endif; ?>

                    </div>

                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success',]) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>



    </div>
</div>



    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Imprest Management</h4>
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
 //Submit Rejection form and get results in json    
       /* $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });*/

        // Set Leave to recall
        
     $('#leaverecall-leave_no_to_recall').change(function(e){
        const Leave_No_To_Recall = e.target.value;
        const Recall_No = $('#leaverecall-recall_no').val();
        if(Leave_No_To_Recall.length){
            const url = $('input[name=url]').val()+'leaverecall/setleave';
            $.post(url,{'Leave_No_To_Recall': Leave_No_To_Recall,'Recall_No': Recall_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                   $('#leaverecall-start_date').val(msg.Start_Date);
                   $('#leaverecall-end_date').val(msg.End_Date);
                   $('#leaverecall-days_applied').val(msg.Days_Applied);
                   $('#leaverecall-total_no_of_days').val(msg.Total_No_Of_Days);
                   $('#leaverecall-holidays').val(msg.Holidays);
                   $('#leaverecall-weekend_days').val(msg.Weekend_Days);
                   $('#leaverecall-balance_after').val(msg.Balance_After);
                   $('#leaverecall-reporting_date').val(msg.Reporting_Date);
                   $('#leaverecall-comments').val(msg.Comments);
                   $('#leaverecall-supervisor_code').val(msg.Supervisor_Code);
                   $('#leaverecall-reliever_name').val(msg.Reliever_Name);
                   $('#leaverecall-key').val(msg.Key);
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leaverecall-leave_no_to_recall');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaverecall-leave_no_to_recall');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });
     
     
     /*Set Days to Recall*/
     
      $('#leavereimburse-days_to_reimburse1').blur(function(e){
        const Days_To_Reimburse = e.target.value;
        const Application_No = $('#leavereimburse-application_no').val();
        if(Days_To_Reimburse.length){
            const url = $('input[name=url]').val()+'leave-reimburse/setdays';
            $.post(url,{'Days_To_Reimburse': Days_To_Reimburse,'Application_No': Application_No}).done(function(msg){
                   //populate empty form fields with new data
                    
                
                     $('#leavereimburse-leave_balance').val(msg.Leave_balance);
                     $('#leavereimburse-balance_after').val(msg.Balance_After);
                     $('#leavereimburse-key').val(msg.Key);
                   
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leavereimburse-days_to_reimburse');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leavereimburse-days_to_reimburse');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });

     
     /*Set Days to go on leave */
     
     $('#leave-days_to_go_on_leave').blur(function(e){
        const Days_To_Go_on_Leave = e.target.value;
        const No = $('#leave-application_no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'leave/setdays';
            $.post(url,{'Days_To_Go_on_Leave': Days_To_Go_on_Leave,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                   
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-end_date').val(msg.End_Date);
                    $('#leave-total_no_of_days').val(msg.Total_No_Of_Days);
                    $('#leave-reporting_date').val(msg.Reporting_Date);
                    $('#leave-holidays').val(msg.Holidays);
                    $('#leave-weekend_days').val(msg.Weekend_Days);
                    $('#leave-balance_after').val(msg.Balance_After);                    
                    $('#medicalcover-key').val(msg.Key);
                   
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-days_to_go_on_leave');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                         disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-days_to_go_on_leave');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = '';
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });
     
     
     /* set department */
     
     $('#imprestcard-global_dimension_2_code').change(function(e){
        const dimension = e.target.value;
        const No = $('#imprestcard-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setdimension?dimension=Global_Dimension_2_Code';
            $.post(url,{'dimension': dimension,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestcard-global_dimension_2_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestcard-global_dimension_2_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
                    }
                    
                },'json');
        }
     });
     
     
     /*Set Imprest Type*/
     
     $('#imprestcard-imprest_type').change(function(e){
        const Imprest_Type = e.target.value;
        const No = $('#imprestcard-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setimpresttype';
            $.post(url,{'Imprest_Type': Imprest_Type,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestcard-imprest_type');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestcard-imprest_type');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = '';
                        
                         $('.modal').modal('show')
                        .find('.modal-body')
                        .html('<div class="alert alert-success">Imprest Type Update Successfully.</div>');
                        
                    }
                    
                },'json');
        }
     });
     
     
     /* Add Line */
     $('.add-line').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     
        function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
     
     
JS;

$this->registerJs($script);
