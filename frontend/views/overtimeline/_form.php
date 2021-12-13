<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;

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
                                    <?= $form->field($model, 'Nature_of_Application')->dropDownList(
                                            ['working_Hours_Extension'=>'Working Hours Extension',
                                            'Leave_Recall'=>'Leave Recall',
                                            'Off_duty_Recall'=>'Off Duty Recall'
                                                ],['prompt' => 'Select Nature Of Application']) 
                                    ?>
                                    <?= $form->field($model, 'Date')->textInput(['type' => 'date'])?>
                                    <?= $form->field($model, 'Normal_Work_Start_Time')->textInput(['type' => 'time']) ?>
                                    <?= $form->field($model, 'Normal_Work_End_Time')->textInput(['type' => 'time']) ?>
                                    <?= $form->field($model, 'Department')->dropDownList($departments,['prompt' => '-- Select Depratment -- ']); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'Start_Time')->textInput(['type' => 'time']) ?>                                        
                                    <?= $form->field($model, 'End_Time')->textInput(['type' => 'time']) ?>                                   
                                    <?= $form->field($model, 'Hours_Worked')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Work_Done')->textarea(['rows' => 2,'maxlemgth' => 250]) ?>
                                    <?= $form->field($model, 'Application_No')->hiddenInput(['readonly' => true])->label(false); ?>
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly' => true])->label(false); ?>
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly'=> true])->label(false) ?>
                                </div>
                           </div>
                                                 
                        </div>

                        <div class="row">

                            <div class="form-group">
                                <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                            </div>


                        </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<input type="hidden" name="absolute" id="ApplicationNature" value="<?= $HeaderResult[0]->Nature_of_Application ?>">


<?php
$script = <<<JS


   // $('.timepicker').timepicker();

    //Submit form and get results in json    
        // $('form').on('submit', function(e){
        //     e.preventDefault()
        //     const data = $(this).serialize();
        //     const url = $(this).attr('action');
        //     $.post(url,data).done(function(msg){
        //             $('.modal').modal('show')
        //             .find('.modal-body')
        //             .html(msg.note);
        
        //         },'json');
        // });

        // alert($('#ApplicationNature').val())
        if( $('#overtimeline-nature_of_application').val() == 'working_Hours_Extension'){
            $('.field-overtimeline-normal_work_start_time').show();
            $('.field-overtimeline-normal_work_end_time').show();
        }else{
            $('.field-overtimeline-normal_work_start_time').hide();
            $('.field-overtimeline-normal_work_end_time').hide();
        }

        $('#overtimeline-nature_of_application').on('change', (e)=>{
            e.preventDefault();

            if( $('#overtimeline-nature_of_application').val() == 'working_Hours_Extension'){
                $('.field-overtimeline-normal_work_start_time').show();
                $('.field-overtimeline-normal_work_end_time').show();
            }else{
                $('.field-overtimeline-normal_work_start_time').hide();
                $('.field-overtimeline-normal_work_end_time').hide();
            }

            const url = $('input[name="absolute"]').val()+'overtimeline/set-nature-of-application';
            const Line_No = $('#overtimeline-line_no').val();
            const NatureOfApplication = $('#overtimeline-nature_of_application').val();

            
            $.post(url,{'NatureOfApplication': NatureOfApplication,'Line_No': Line_No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-overtimeline-nature_of_application');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-overtimeline-nature_of_application');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#overtimeline-key').val(msg.Key);
                                
                    $('#overtimeline-hours_worked').val(msg.Hours_Worked);

                    
                },'json');

        })
        $('#overtimeline-normal_work_end_time').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#overtimeline-line_no').val();
            const Normal_End_Time = $('#overtimeline-normal_work_end_time').val();
            const Date = $('#overtimeline-date').val();
            
            
            const url = $('input[name="absolute"]').val()+'overtimeline/setstarttime';
            $.post(url,{'Normal_End_Time': Normal_End_Time,'Line_No': Line_No,'Date': Date}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-overtimeline-normal_work_end_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-overtimeline-normal_work_end_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#overtimeline-key').val(msg.Key);
                                
                    $('#overtimeline-hours_worked').val(msg.Hours_Worked);

                    
                },'json');
        });

        $('#overtimeline-normal_work_start_time').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#overtimeline-line_no').val();
            const Normal_Start_Time = $('#overtimeline-normal_work_start_time').val();
            const Date = $('#overtimeline-date').val();
            
            
            const url = $('input[name="absolute"]').val()+'overtimeline/setstarttime';
            $.post(url,{'Normal_Start_Time': Normal_Start_Time,'Line_No': Line_No,'Date': Date}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-overtimeline-normal_work_start_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-overtimeline-normal_work_start_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#overtimeline-key').val(msg.Key);
                                
                    $('#overtimeline-hours_worked').val(msg.Hours_Worked);

                    
                },'json');
        });

        // Commit Start Time
        
        $('#overtimeline-start_time').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#overtimeline-line_no').val();
            const Start_Time = $('#overtimeline-start_time').val();
            const Date = $('#overtimeline-date').val();
            
            
            const url = $('input[name="absolute"]').val()+'overtimeline/setstarttime';
            $.post(url,{'Start_Time': Start_Time,'Line_No': Line_No,'Date': Date}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-overtimeline-start_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-overtimeline-start_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#overtimeline-key').val(msg.Key);
                                
                    $('#overtimeline-hours_worked').val(msg.Hours_Worked);

                    
                },'json');
        });


        /*Commit End Time */

         $('#overtimeline-end_time').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#overtimeline-line_no').val();
            const End_Time = $('#overtimeline-end_time').val();
            
            
            const url = $('input[name="absolute"]').val()+'overtimeline/setendtime';
            $.post(url,{'End_Time': End_Time,'Line_No': Line_No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-overtimeline-end_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-overtimeline-end_time');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#overtimeline-key').val(msg.Key);
                    $('#overtimeline-hours_worked').val(msg.Hours_Worked);
                    
                    
                   
                    
                },'json');
        });
         
         $('#purchaserequisitionline-quantity').on('change', function(e){
            e.preventDefault();
                  
            const Line_No = $('#purchaserequisitionline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'purchase-requisitionline/setquantity';
            $.post(url,{'Line_No': Line_No,'Quantity': $(this).val()}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-purchaserequisitionline-quantity');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-purchaserequisitionline-quantity');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#purchaserequisitionline-key').val(msg.Key);
                    $('#purchaserequisitionline-estimate_unit_price').val(msg.Estimate_Unit_Price);
                    $('#purchaserequisitionline-estimate_total_amount').val(msg.Estimate_Total_Amount);
                                        
                },'json');
        });
         
         
         
         // Set Location
         
        $('#purchaserequisitionline-location').on('change', function(e){
            e.preventDefault();
                  
            const No = $('#purchaserequisitionline-line_no').val();
            const Location = $('#purchaserequisitionline-location').val();
            
            
            const url = $('input[name="absolute"]').val()+'purchase-requisitionline/setlocation';
            $.post(url,{'Line_No': No,'Location': Location}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-purchaserequisitionline-no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-purchaserequisitionline-no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#purchaserequisitionline-key').val(msg.Key);
                   // $('#purchaserequisitionline-available_quantity').val(msg.Available_Quantity);
                    $('#purchaserequisitionline-estimate_unit_price').val(msg.Estimate_Unit_Price);
                    $('#purchaserequisitionline-estimate_total_amount').val(msg.Estimate_Total_Amount);
                   
                    
                },'json');
        });

        

        $('#overtimeline-nature_of_application').on('change', function(e){
            e.preventDefault();
            NatureOfApplication = $(this).val();
            // alert(NatureOfApplication)
        });
         
         
         
         
         
         
         function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }


JS;

$this->registerJs($script);
