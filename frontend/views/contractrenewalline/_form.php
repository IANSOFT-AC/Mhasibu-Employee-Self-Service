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

                            <div class="col-md-12">
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Contract_Code')->dropDownList($contracts, ['prompt' => 'Select Contract Type...']) ?>
                                    <?= $form->field($model, 'Contract_Start_Date')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Contract_Period')->textInput(['maxlength' => '15']) ?>

                                    


                                    <?= $form->field($model, 'Grade')->dropDownList($grades, [
                                    'prompt' => 'Select Scale ...',
                                    'onchange' => '$.post("../contractrenewalline/pointer-dd?scale="+$(this).val(), (data) => {
                                                    $("select#contractrenewalline-pointer").html( data );
                                                })'
                                     ]) ?>




                                    <?= $form->field($model, 'Pointer')->dropDownList($pointers,['prompt' => 'Select ....']) ?>
                                    <?= $form->field($model, 'Job_Code')->dropDownList($jobs,['prompt' => 'Select ...']) ?>





                                    <?= $form->field($model, 'Contract_End_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>




                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Change_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly'=> true])->label(false) ?>
                            </div>
                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success SaveButton','id'=>'SaveButton']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
        $('.SaveButton').on('click', function(e){
            e.preventDefault()
            const data = $('form').serialize();
            const url = $('form').attr('action');
            $.post(url,data).done(function(msg){
                    $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });

         $('#contractrenewalline-contract_code').on('change', function(e){
            e.preventDefault();
                  
            const Contract_Code = e.target.value;
            const Line_No = $('#contractrenewalline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'contractrenewalline/setfield?field='+'Contract_Code';
            $.post(url,{'Contract_Code': Contract_Code,'Line_No': Line_No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-contractrenewalline-contract_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contractrenewalline-contract_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#contractrenewalline-key').val(msg.Key);
                    $('#contractrenewalline-contract_start_date').val(msg.Contract_Start_Date);
                    
                   
                    
                },'json');
        });
         
         // Set Contract start date
         
         $('#contractrenewalline-contract_start_date').on('change', function(e){
            e.preventDefault();
                  
            const Contract_Start_Date = e.target.value;
            const Line_No = $('#contractrenewalline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'contractrenewalline/setfield?field='+'Contract_Start_Date';
            $.post(url,{'Contract_Start_Date': Contract_Start_Date,'Line_No': Line_No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-contractrenewalline-contract_start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contractrenewalline-contract_start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#contractrenewalline-key').val(msg.Key);
                    
                   
                    
                },'json');
        });
         
         // set contract Period
         
         
         $('#contractrenewalline-contract_period').on('change', function(e){
            e.preventDefault();
                  
            const Contract_Period = e.target.value;
            const Line_No = $('#contractrenewalline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'contractrenewalline/setfield?field='+'Contract_Period';
            $.post(url,{'Contract_Period': Contract_Period,'Line_No': Line_No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-contractrenewalline-contract_period');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contractrenewalline-contract_period');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#contractrenewalline-key').val(msg.Key);
                    $('#contractrenewalline-contract_end_date').val(msg.Contract_End_Date);
                    
                   
                    
                },'json');
        });
         
         
         
         // Set Location
         
         $('#storerequisitionline-location').on('change', function(e){
            e.preventDefault();
                  
            const No = $('#storerequisitionline-line_no').val();
            const Location = $('#storerequisitionline-location').val();
            
            
            const url = $('input[name="absolute"]').val()+'storerequisitionline/setlocation';
            $.post(url,{'Line_No': No,'Location': Location}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-storerequisitionline-no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-storerequisitionline-no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    $('#storerequisitionline-key').val(msg.Key);
                    $('#storerequisitionline-available_quantity').val(msg.Available_Quantity);
                   
                    
                },'json');
        });
         
         
         
         
         
         
         function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
JS;

$this->registerJs($script);
