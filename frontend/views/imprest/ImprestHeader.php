
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

            
<div class="card">
    <div class="card-header">
        <h3 class="card-title"> Imprest Head</h3>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model,'Key')->hiddenInput()->label(false) ?>
            <div class="row">
                <div class=" row col-md-12">

                    <div class="col-md-4">
                            <?= $form->field($model, 'Request_For')->dropDownList([
                                        'Self' => 'Self',
                                        'Other' => 'Other',
                                    ],['prompt' => 'Select Request_For']) 
                            ?>

                            <?= $form->field($model, 'Employee_No')->dropDownList($employees,['prompt'=> 'Select Employee']) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                    </div>

                    
                    <div class="col-md-4">
                            <?= $form->field($model, 'Imprest_Type')->dropDownList(['Local' => 'Local', 'International' => 'International'],['prompt' => 'Select ...']) ?>
                            <?= $form->field($model, 'Currency_Code')->dropDownList($currencies,['prompt' => 'Select ...','required' => true]) ?>
                            <?= $form->field($model, 'Exchange_Rate')->textInput(['type'=> 'number','required' => true]) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'Purpose')->textInput() ?>

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

<?php
$script = <<<JS

        var requstForValue = $('#imprestcard-request_for').val();
        var imprestType = $('#imprestcard-imprest_type').val();


        if(requstForValue == 'Self'){
            $('#imprestcard-employee_no').replaceWith('<input type="text" id="imprestcard-employee_no" value="'+$('#imprestcard-employee_no').val()+'"  class="form-control" name="Imprestcard[Employee_No]" readonly>');
        }else{
            $('#imprestcard-employee_no').replaceWith('<select id="imprestcard-employee_no" class="form-control" name="Imprestcard[Employee_No]"></select>')
            $.getJSON('/imprest/get-employees', function (data,e) {
                $('#imprestcard-employee_no').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Employee'));
                $.each(data, function (key, entry) {
                    $('#imprestcard-employee_no').append($('<option id="itemId'+ entry.No+'"></option>').attr('value', entry.No).text(entry.No +' | ' +entry.Full_Name));
                    //alert(entry.No_);
                })
            });
        }

        if(imprestType == 'Local'){
            $('#imprestcard-currency_code').replaceWith('<input type="text" id="imprestcard-currency_code" value="N/A"  class="form-control" name="Imprestcard[Currency_Code]" readonly>');
            $('#imprestcard-exchange_rate').replaceWith('<input type="text" id="imprestcard-exchange_rate" value="N/A"  class="form-control" name="Imprestcard[Exchange_Rate]" readonly>');
        }else{

            $.getJSON('/imprest/get-currencies', function (data,e) {
             $('#imprestcard-currency_code').replaceWith('<select id="imprestcard-currency_code" class="form-control" name="Imprestcard[Currency_Code]"></select>')
             $('#imprestcard-currency_code').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Currency'));  
             $.each(data, function (key, entry) {
                    $('#imprestcard-currency_code').append($('<option id="itemId'+ entry.Code+'"></option>').attr('value', entry.Code).text(entry.Code +' | ' +entry.Description));
                    //alert(entry.No_);
                })
            });

            $('#imprestcard-exchange_rate').replaceWith('<input type="number" id="imprestcard-exchange_rate"   class="form-control" name="Imprestcard[Exchange_Rate]">');
        
        }

       
                                    

    $('#imprestcard-request_for').on('change', function(e){
        var requstForValue = $(this).val();
        if(requstForValue == 'Self'){
            $('#imprestcard-employee_no').replaceWith('<input type="text" id="imprestcard-employee_no"  class="form-control" name="Imprestcard[Employee_No]" readonly>');
            return false;
        }
        $('#imprestcard-employee_no').replaceWith('<select id="imprestcard-employee_no" class="form-control" name="Imprestcard[Employee_No]"></select>')
        $.getJSON('/imprest/get-employees', function (data,e) {
            $('#imprestcard-employee_no').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Employee'));
            $.each(data, function (key, entry) {
                $('#imprestcard-employee_no').append($('<option id="itemId'+ entry.No+'"></option>').attr('value', entry.No).text(entry.No +' | ' +entry.Full_Name));
                //alert(entry.No_);
            })
        });
        

    });



    $('#imprestcard-imprest_type').on('change', function(e){
        var imprestType = $(this).val();
        if(imprestType == 'Local'){
            $('#imprestcard-currency_code').replaceWith('<input type="text" id="imprestcard-currency_code" value="N/A"  class="form-control" name="Imprestcard[Currency_Code]" readonly>');
            $('#imprestcard-exchange_rate').replaceWith('<input type="text" id="imprestcard-exchange_rate" value="N/A"  class="form-control" name="Imprestcard[Exchange_Rate]" readonly>');
            return false;
        }

        $.getJSON('/imprest/get-currencies', function (data,e) {
             $('#imprestcard-currency_code').replaceWith('<select id="imprestcard-currency_code" class="form-control" name="Imprestcard[Currency_Code]"></select>')
             $('#imprestcard-currency_code').append($('<option id="itemId" selected></option>').attr('value', '').text('Select Currency'));  
             $.each(data, function (key, entry) {
                    $('#imprestcard-currency_code').append($('<option id="itemId'+ entry.Code+'"></option>').attr('value', entry.Code).text(entry.Code +' | ' +entry.Description));
                    //alert(entry.No_);
                })
            });

        $('#imprestcard-exchange_rate').replaceWith('<input type="number" id="imprestcard-exchange_rate"   class="form-control" name="Imprestcard[Exchange_Rate]">');
        

    });
     

JS;
$this->registerJs($script);

                              