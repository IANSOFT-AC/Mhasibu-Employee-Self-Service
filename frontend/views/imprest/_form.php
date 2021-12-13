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

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

                <div class="row float-right">
                    <!-- <div class="col-md-4"> -->

                        <?= ($model->Status == 'New')?Html::a('Send For Approval',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-success submitforapproval',
                            'data' => [
                                'confirm' => 'Are you sure you want to send imprest request for approval?',
                                'params'=>[
                                    'No'=> $_GET['No'],
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
                                'No'=> $_GET['No'],
                            ],
                            'method' => 'get',
                        ],
                            'title' => 'Cancel Imprest Approval Request'

                        ]):'' ?>


                        <?= Html::a('<i class="fas fa-file-pdf"></i> Print Imprest',['print-imprest'],['class' => 'btn btn-warning ',
                            'data' => [
                                'confirm' => 'Print Imprest?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'get',
                            ],
                            'title' => 'Print Imprest.'

                        ]) ?>
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



                        <div class="col-md-4">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>

                            <?= $form->field($model, 'Request_For')->dropDownList([
                                        'Self' => 'Self',
                                        'Other' => 'Other',
                                    ],['prompt' => 'Select Request_For']) 
                            ?>

                       
                            <?= $form->field($model, 'Imprest_Type')->dropDownList(['Local' => 'Local', 'International' => 'International'],['prompt' => 'Select ...']) ?>

                            <?= $form->field($model, 'Purpose')->textInput() ?>


                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?php if($model->Request_For == 'Self'): ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?php else: ?>
                                <?= $form->field($model, 'Employee_No')->dropDownList($employees,['prompt'=> 'Select Employee']) ?>
                            <?php endif; ?>
                            
                            <?= $form->field($model, 'Currency_Code')->dropDownList($currencies,['prompt' => 'Select ...','required' => true]) ?>
                            <?= $form->field($model, 'Imprest_Amount')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <!-- <?= $form->field($model, 'Expected_Date_of_Surrender')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->


                        </div>

                        <div class="col-md-4">
                          <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                          <?= $form->field($model, 'Employee_Balance')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                          <?= $form->field($model, 'Exchange_Rate')->textInput(['type'=> 'number','required' => true]) ?>



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


        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <?= Html::a('<i class="fa fa-plus-square"></i> New Imprest Line',['imprestline/create','Request_No'=>$model->No],['class' => 'add-line btn btn-outline-info',
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
                            $deleteLink = Html::a('<i class="fa fa-trash"></i>',['imprestline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                            ?>
                            <tr>

                                <td><?= !empty($obj->Transaction_Type)?$obj->Transaction_Type:'Not Set' ?></td>
                                <!-- <td><?= !empty($obj->Account_No)?$obj->Account_No:'Not Set' ?></td> -->
                                <td><?= !empty($obj->Account_Name)?$obj->Account_Name:'Not Set' ?></td>
                                <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                <td><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                <td><?= !empty($obj->Amount_LCY)?$obj->Amount_LCY:'Not Set' ?></td>
                                <!-- <td><?= !empty($obj->Budgeted_Amount)?$obj->Budgeted_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Commited_Amount)?$obj->Commited_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Total_Expenditure)?$obj->Total_Expenditure:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Available_Amount)?$obj->Available_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= Html::checkbox('Unbudgeted',$obj->Unbudgeted) ?></td> -->
                                <td><?= $updateLink.'|'.$deleteLink ?></td>
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


        var requstForValue = $('#imprestcard-request_for').val();
        var imprestType = $('#imprestcard-imprest_type').val();


        if(requstForValue == 'Self'){
            $('#imprestcard-employee_no').replaceWith('<input type="text" id="imprestcard-employee_no" value="'+$('#imprestcard-employee_no').val()+'"  class="form-control" name="Imprestcard[Employee_No]" readonly>');
        }
        

        if(imprestType == 'Local'){
            $('#imprestcard-currency_code').replaceWith('<input type="text" id="imprestcard-currency_code" value="N/A"  class="form-control" name="Imprestcard[Currency_Code]" readonly>');
            $('#imprestcard-exchange_rate').replaceWith('<input type="text" id="imprestcard-exchange_rate" value="N/A"  class="form-control" name="Imprestcard[Exchange_Rate]" readonly>');
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
     


        // Set other Employee
        
     $('#imprestcard-employee_no').change(function(e){
        const Employee_No = e.target.value;
        const No = $('#imprestcard-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setemployee';
            $.post(url,{'Employee_No': Employee_No,'No': No}).done(function(msg){
                   //populate empty form fields with new data
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
     
     /*Set Program and Department dimension */
     
     $('#imprestcard-global_dimension_1_code').change(function(e){
        const dimension = e.target.value;
        const No = $('#imprestcard-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setdimension?dimension=Global_Dimension_1_Code';
            $.post(url,{'dimension': dimension,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
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
                        
                        //  $('.modal').modal('show')
                        // .find('.modal-body')
                        // .html('<div class="alert alert-success">Imprest Type Update Successfully.</div>');
                        
                    }
                    
                },'json');
        }
     });
     
     
     /* Add Line */
     $('.add-line, .update-objective').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('#modal').modal('show')
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
