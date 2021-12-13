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
            </div>
            <div class="card-body">



        <?php

            $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="row col-md-12">



                        <div class="col-md-6">

                            <!-- <?= $form->field($model, 'No')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->
                            <?= $form->field($model, 'Request_For')->dropDownList([
                                        'Self' => 'Self',
                                        'Other' => 'Other',
                                    ],['prompt' => 'Select Request_For']) 
                            ?>

                            <?= $form->field($model, 'Imprest_No')->dropDownList($imprests,['prompt' => 'select..']) ?>
                            <!-- <?= $form->field($model, 'Purpose')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->
                        



                        </div>

                        <div class="col-md-6">
                            <!-- <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly' => true,'disabled' => true]) ?>
                                <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Posting_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
                            -->
                            <?= $form->field($model, 'Employee_No')->dropDownList($employees,['prompt'=> 'Select Employee']) ?>
                            <?= $form->field($model, 'Receipt_No')->dropDownList($receipts,['prompt' => 'Select ... ']) ?>

                            <!-- <?= $form->field($model, 'Receipt_Amount')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                            <!-- <?= '<p><span> Approval Entries </span> '.Html::a($model->Approval_Entries,'#'); '</p>'?> -->




                            <!--                            <p class="parent"><span>+</span>-->



                            </p>



                        </div>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
<input type="hidden" id="EmpNo" value="<?= Yii::$app->user->identity->employee[0]->No ?>">

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

    $('#imprestsurrendercard-request_for').on('change', function(e){
        var requstForValue = $(this).val();
        console.log($('#EmpNo').val())  

        if(requstForValue == 'Self'){
            $('#imprestsurrendercard-employee_no').val($('#EmpNo').val()) 
            $('#imprestsurrendercard-employee_no').prop("disabled", true)
        }else{
            $('#imprestsurrendercard-employee_no').prop("disabled", false)
            $('#imprestsurrendercard-employee_no').empty();
            $.getJSON('/imprest/get-employees', function (data,e) {
                $('#imprestsurrendercard-employee_no').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Employee'));
                    $.each(data, function (key, entry) {
                        $('#imprestsurrendercard-employee_no').append($('<option id="itemId'+ entry.No+'"></option>').attr('value', entry.No).text(entry.No +' | ' +entry.Full_Name));
                        //alert(entry.No_);
                    })
            });
        }      

    });



    $('#imprestsurrendercard-employee_no').on('change', function(e){
        var employeeNo = $(this).val();  
        console.log(employeeNo)  
        //Load Imprest No's
        if(employeeNo){
            $('#imprestsurrendercard-imprest_no').empty();
            $.getJSON('/imprest/getmyimprests', {'EmpNo':employeeNo}, function (data,e) {
                $('#imprestsurrendercard-imprest_no').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Imprest'));
                    $.each(data, function (key, entry) {
                        $('#imprestsurrendercard-imprest_no').append($('<option id="itemId'+ entry.No+'"></option>').attr('value', entry.No).text(entry.No +' | ' +entry.detail));
                    })
            });
        }
    });


    $('#imprestsurrendercard-imprest_no').on('change', function(e){
        var imprestNo = $(this).val();  
        console.log(imprestNo)  
        //Load Imprest No's
        if(imprestNo){
            $('#imprestsurrendercard-receipt_no').empty();
            $.getJSON('/imprest/getimprestreceipts', {'imprestNo':imprestNo}, function (data,e) {
                $('#imprestsurrendercard-receipt_no').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Receipt'));
                    $.each(data, function (key, entry) {
                        $('#imprestsurrendercard-receipt_no').append($('<option id="itemId'+ entry.No+'"></option>').attr('value', entry.No).text(entry.No +' | ' +entry.detail));
                    })
            });
        }
    });



         
              



        // Set Imprest No to surrender
        
     $('#imprestsurrendercard-imprest_no').change(function(e){
        const No = $('#imprestsurrendercard-no').val();
        const Imprest_No = e.target.value;
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setimpresttosurrender';
            $.post(url,{'Imprest_No': Imprest_No,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    $('#imprestsurrendercard-global_dimension_1_code').val(msg.Global_Dimension_1_Code);
                    $('#imprestsurrendercard-global_dimension_2_code').val(msg.Global_Dimension_2_Code);
                    $('#imprestsurrendercard-purpose').val(msg.Purpose);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestcard-employee_no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        console.log('Found...');
                        console.log(msg.Global_Dimension_1_Code);
                        const parent = document.querySelector('.field-imprestcard-employee_no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
                       
                        
                    }
                    
                },'json');
        }
     });
     
     /*Set Program and Department dimension */
     
     $('#imprestcard-global_dimension_1_code').change(function(e){
        const dimension = e.target.value;
        const No = $('#imprestcard-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setdimension?dimension=Global_Dimension_1_Code';
            $.post(url,{'dimension': dimension,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    
                    
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestcard-global_dimension_1_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestcard-global_dimension_1_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
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
