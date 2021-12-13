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

            $form = ActiveForm::begin([
                    'id' => $model->formName()
            ]);



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
                    <div class="row col-md-12">



                        <div class="col-md-6">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>

                            <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Purpose_Code')->dropDownList($purpose,['required' => true, 'prompt' => 'Select ...']) ?>
                            <?= '<p><span>Employee Balance</span> '.Html::a($model->Employee_Balance,'#'); '</p>' ?>

                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Global_Dimension_1_Code')->dropDownList($programs,['prompt' => 'Select ..','readonly'=> true]) ?>
                            <?= $form->field($model, 'Global_Dimension_2_Code')->dropDownList($departments, ['prompt' => 'select ...','readonly'=> true]) ?>
                            <?= $form->field($model, 'Loan_Type')->dropDownList($loans, ['prompt' => 'select ...','required' => true,'readonly'=> true]) ?>


                        </div>

                        <div class="col-md-6">
                            
                            <?= $form->field($model, 'Basic_Pay', ['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->Basic_Pay)]])->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, '_x0031__3_of_Basic',['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->_x0031__3_of_Basic)]])->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Current_Net_Pay',['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->Current_Net_Pay)]])->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Take_Home', ['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->Take_Home)]])->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Amount_Requested')->textInput(['required'=> true]) ?>
                           
                            <?= $form->field($model, 'Repayment_Period')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Months_Paid')->textInput(['readonly'=> true,'disabled'=>true]) ?>
                            <?= $form->field($model, 'Instalments')->textInput(['readonly'=> true, 'disabled'=>true]) ?>







                           <p class="parent"><span>+</span>



                            </p>



                        </div>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id' => 'submit']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>



                <!---Upload Leave Attachment File-->

                <?php $atform = \yii\widgets\ActiveForm::begin(['id'=>'attachmentform'],['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $atform->errorSummary($Attachmentmodel)?>
                    <button class="btn btn-primary btn-file"><?= $Attachmentmodel->getPath($model->No)?'<i class="fa fa-upload"></i>&nbsp;&nbsp;Update Attachment':'<i class="fa fa-upload"></i>&nbsp;&nbsp;Upload Attachment' ?>
                        <?= $atform->field($Attachmentmodel,'attachmentfile')->fileInput(['id' => 'attachmentfile', 'name' => 'attachmentfile' ])->label(false);?>
                    </button>

                    <?= $atform->field($Attachmentmodel,'Document_No')->hiddenInput(['value' => $model->No])->label(false);?>
                    <?= Html::submitButton(($model->isNewRecord)?'':'', ['class' => '']) ?>

                <?php \yii\widgets\ActiveForm::end(); ?>

                <!-- End File Upload form -->

                <?php if($Attachmentmodel->getPath($model->No)){   ?>

                <iframe src="data:application/pdf;base64,<?= $Attachmentmodel->readAttachment($model->No); ?>" height="950px" width="100%"></iframe>
                <?php }  ?>





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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Salary Advance Management</h4>
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

 $('#attachmentform').hide();


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




   /*Check if Purpose requires an attachment */
     
     $('#salaryadvance-purpose_code').change(function(e){
         e.preventDefault();
          const Purpose_Code = e.target.value;
          // Check if leave required an attachment or not
            const Vurl = $('input[name=url]').val()+'salaryadvance/requiresattachment?Code='+Purpose_Code;
            
            $.post(Vurl).done(function(msg){
                console.log(msg);
                if(msg.Requires_Attachment){
                    $('#attachmentform').show();

                    //Hide parent submit form
                    $('#submit').hide();
                }else{
                    $('#attachmentform').hide();
                    //show parent submit form
                    $('#submit').show();
                }
            });

            // Post Code to Nav
             const No = $('#salaryadvance-no').val();
             const postUrl = $('input[name=url]').val()+'salaryadvance/setcode';
             $.post(postUrl,{'Purpose_Code': Purpose_Code,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                
                   $('#salaryadvance-key').val(msg.Key);
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-salaryadvance-purpose_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-salaryadvance-purpose_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
                    }
                    
                },'json');
         
     });








    /*Trigger submit for doc upload*/

     $('#attachmentfile').change((e) => {
        $(e.target).closest('form').trigger('submit');
        console.log('Upload Submitted ...');
    });







        // Set Loan Type
        
     $('#salaryadvance-loan_type').change(function(e){
        const loan = e.target.value;
        const No = $('#salaryadvance-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'salaryadvance/setloantype';
            $.post(url,{'loan': loan,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                   
                   $('#salaryadvance-repayment_period').val(msg.Repayment_Period);
                   $('#salaryadvance-key').val(msg.Key);
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestcard-employee_no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestcard-employee_no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
                    }
                    
                },'json');
        }
     });
     
     /*Set Requested Amount */
     
     $('#salaryadvance-amount_requested').blur(function(e){
        const amount = e.target.value;
        const No = $('#salaryadvance-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'salaryadvance/setamount';
            $.post(url,{'amount': amount,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                   $('#salaryadvance-take_home').val(msg.Take_Home);
                   $('#salaryadvance-key').val(msg.Key);
                   
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-salaryadvance-amount_requested');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-salaryadvance-amount_requested');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
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
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
    
    
    function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
    }
        
    function enableSubmit(){
        document.getElementById('submit').removeAttribute("disabled");
    
    }
     
     
     
JS;

$this->registerJs($script);

$style = <<<CSS
    
    
    .btn-file {
        display: flex;
        position: relative;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    
    }

    .btn-file input {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
    }
    
   

CSS;

$this->registerCss($style);
