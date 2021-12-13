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
                                    <h5><i class="icon fas fa-times"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



        <?php

            $form = ActiveForm::begin([
                    // 'id' => $model->formName()
            ]);

            ?>



                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">
                                <?= $form->field($model, 'Exit_No')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Job_Title')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>


                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Job_Description')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Payroll_Grade')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                            </div>
                        </div>
                    </div>

                    <p class="text-muted lead">Exit Details</p>

                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'Reason_For_Exit')->dropDownList($reasons,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Date_Of_Notice')->textInput(['type'=> 'date','min' => date('Y-m-d')]) ?>
                                
                                <?= $form->field($model, 'Notice_Period')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                
                                <?= $form->field($model, 'Reason_Description')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Notice_Period')->hiddenInput(['readonly'=> true])->label(false) ?>


                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Date_of_Exit')->textInput(['type'=> 'date','min' => date('Y-m-d')]) ?>
                                <?= $form->field($model, 'Expiry_of_Notice')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?php $form->field($model, 'Date_of_Exit_Interview')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Notice_Fully_Served')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Reasons_For_Not_Serving_Notice')->textArea(['rows' => 2]) ?>

                            </div>
                        </div>
                    </div>















                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success', 'id' => 'submit']) ?>
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

    $('#employeeexit-reasons_for_not_serving_notice').hide();

        // Set other fields
        
     $('#employeeexit-date_of_notice').change(function(e){

        const Date_Of_Notice = e.target.value;
        const Exit_No = $('#employeeexit-exit_no').val();
        if(Exit_No.length){
            const url = $('input[name=url]').val()+'exit/setfield?field='+'Date_Of_Notice';
            $.post(url,{'Date_Of_Notice': Date_Of_Notice,'Exit_No': Exit_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                   $('#employeeexit-date_of_notice').val(msg.Date_Of_Notice);
                  // $('#employeeexit-date_of_exit').val(msg.Date_of_Exit);
                   $('#employeeexit-notice_fully_served').val(msg.Notice_Fully_Served);
                   $('#employeeexit-key').val(msg.Key);
                    
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-employeeexit-date_of_notice');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-employeeexit-date_of_notice');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });
     
     $('#employeeexit-date_of_exit').change(function(e){

        const Date_of_Exit = e.target.value;
        const Exit_No = $('#employeeexit-exit_no').val();
        if(Exit_No.length){
            const url = $('input[name=url]').val()+'exit/setfield?field='+'Date_of_Exit';
            $.post(url,{'Date_of_Exit': Date_of_Exit,'Exit_No': Exit_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  // $('#employeeexit-date_of_notice').val(msg.Date_Of_Notice);
                   $('#employeeexit-date_of_exit').val(msg.Date_of_Exit);
                   $('#employeeexit-notice_fully_served').val(msg.Notice_Fully_Served);
                   $('#employeeexit-expiry_of_notice').val(msg.Expiry_of_Notice);
                   $('#employeeexit-key').val(msg.Key);

                   if( msg.Notice_Fully_Served === 'No') {
                        $('#employeeexit-reasons_for_not_serving_notice').show();
                   }else{
                        $('#employeeexit-reasons_for_not_serving_notice').hide();
                   }
                    
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-employeeexit-date_of_exit');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-employeeexit-date_of_exit');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });


      $('#employeeexit-reason_for_exit').change(function(e){

        const Reason_For_Exit = e.target.value;
        const Exit_No = $('#employeeexit-exit_no').val();
        if(Exit_No.length){
            const url = $('input[name=url]').val()+'exit/setfield?field='+'Reason_For_Exit';
            $.post(url,{'Reason_For_Exit': Reason_For_Exit,'Exit_No': Exit_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                   // $('#employeeexit-date_of_notice').val(msg.Date_Of_Notice);
                   //$('#employeeexit-date_of_exit').val(msg.Date_of_Exit);
                   $('#employeeexit-notice_fully_served').val(msg.Notice_Fully_Served);
                   $('#employeeexit-expiry_of_notice').val(msg.Expiry_of_Notice);
                   $('#employeeexit-key').val(msg.Key);

                   if( msg.Notice_Fully_Served === 'No') {
                        $('#employeeexit-reasons_for_not_serving_notice').show();
                   }else{
                        $('#employeeexit-reasons_for_not_serving_notice').hide();
                   }
                    
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-employeeexit-reason_for_exit');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-employeeexit-reason_for_exit');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
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
