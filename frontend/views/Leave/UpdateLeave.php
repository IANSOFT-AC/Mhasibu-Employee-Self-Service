<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\VarDumper;
use yii\helpers\Url;
$absoluteUrl = \yii\helpers\Url::home(true);
//VarDumper::dump( $model, $depth = 10, $highlight = true)
?>
<style type="text/css">
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
</style>

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

                
                  <div class="action-tab row" >

                        <?= ($model->Status == 'New')?
                                Html::a('Send For Approval', ['send-for-approval', 'No' => $_GET['No'],
                                'employeeNo' => Yii::$app->user->identity->{'Employee No_'}],
                                ['class' => 'btn btn-primary']):'' 
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


                        <?=   Html::a('Close', ['index', ], ['class' => 'btn btn-warning']) ?>
                    </div>           
                  
                
            </div>

            <div class="card-body">



        <?php

            $form = ActiveForm::begin([
                    'id' => $model->formName()
            ]); ?>

            



            <?php if(!$model->isNewRecord): ?>
                <div class="row">
                    <div class="row col-sm-12">



                            <div class="col-md-6">


                                <?= $form->field($model, 'Employee_No')->hiddenInput()->label(false); ?>
                                <?= $form->field($model, 'Application_No')->hiddenInput()->label(false); ?>
                                <?= $form->field($model, 'Leave_Code')->dropDownList($leavetypes,['prompt' => 'Select Leave Type', 'options' =>['id'=>'LeaveCode']]) ?>
                                <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','required' => true]) ?>
                                <?= $form->field($model, 'Days_To_Go_on_Leave')->textInput(['type' => 'number','required' =>  true,'min'=> 1]) ?>
                                <?= $form->field($model, 'Reliever')->dropDownList($employees,['prompt' => 'Select ..','required'=> true]) ?>
                                <?= $form->field($model, 'Comments')->textarea(['rows'=> 2,'maxlength' => 250]) ?>



                            </div>

                       
                            <div class="col-sm-6">



                                <div class="row">
                                    <div class="col-md-6 col-sm-12">

                                        <?= $form->field($model, 'End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Total_No_Of_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Leave_balance')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Reliever_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    </div>
                                    <div class="col-md-6 col-sm-12">


                                        <?= $form->field($model, 'Holidays')->textInput(['readonly'=> true,'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Weekend_Days')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Balance_After')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Reporting_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Application_Date')->textInput(['required' => true, 'disabled'=>true]) ?>
                                        <?= $form->field($model, 'Key')->hiddenInput(['required' => true, 'disabled'=>true])->label(false) ?>
                                    </div>
                                </div>

                            
                            </div>
                            
                    </div>
                </div>
                <?php else: ?>
                <div class="row">
                    <div class="row col-md-12">


                            <div class="col-md-6">

                                <?= $form->field($model, 'Employee_No')->hiddenInput()->label(false); ?>
                                <?= $form->field($model, 'Leave_Code')->dropDownList($leavetypes,['prompt' => 'Select Leave Type', 'options' =>['id'=>'LeaveCode']]) ?>
                                <?= $form->field($model, 'Days_To_Go_on_Leave')->textInput(['type' => 'number','required' =>  true,'min'=> 1]) ?>
                                <?= $form->field($model, 'Comments')->textarea(['rows'=> 2,'maxlength' => 250]) ?>



                            </div>

                       
                            <div class="col-md-6">
                                    <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','required' => true]) ?>
                                    <?= $form->field($model, 'Reliever')->dropDownList($employees,['prompt' => 'Select ..','required'=> true]) ?>
                            </div>

                               


                    </div>
                            
                </div>
              
            <?php endif; ?>

            <div class="row">

                <div class="form-group">
                    <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id' => 'submit']) ?>
                    
                    <?=   \yii\helpers\Html::button('Upload Leave Attachement',
                        [  'value' => Url::to(['leave/attach','No'=>$model->Application_No
                            ]),
                            'title' => 'Upoad Leave Attachement',
                            'class' => 'btn btn-info push-right showModalButton',
                            ]
                        ); 
                    ?>

                </div>


            </div>
            <?php ActiveForm::end(); ?>

    
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Leave Attachement List</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered dt-responsive table-hover" id="table">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
          

           
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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Leave Management</h4>
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
<input type="hidden" name="url"  id="url" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
   $('#attachmentform').hide();
        // Set Leave Type

        // Set Leave to recall
        
     //  $('#leave-leave_code').change(function(e){
    //     const Leave_Code = e.target.value;
    //     const No = $('#leave-application_no').val();
    //     if(No.length){
            
    //         const url = $('input[name=url]').val()+'leave/setleavetype';
    //         $.post(url,{'Leave_Code': Leave_Code,'No': No}).done(function(msg){
    //                //populate empty form fields with new data
                   
    //                $('#leave-leave_balance').val(msg.Leave_balance);  
    //                $('#leave-key').val(msg.Key);
    //                 console.log(typeof msg);
    //                 console.table(msg);
    //                 if((typeof msg) === 'string') { // A string is an error
    //                     const parent = document.querySelector('.field-leave-leave_code');
    //                     const helpbBlock = parent.children[2];
    //                     helpbBlock.innerText = msg;
    //                     disableSubmit();
                        
    //                 }else{ // An object represents correct details
    //                     const parent = document.querySelector('.field-leave-leave_code');
    //                     const helpbBlock = parent.children[2];
    //                     helpbBlock.innerText = ''; 
    //                     enableSubmit();
                        
    //                 }
                    
    //             },'json');
            
    //     }     
    //  });

     
     
         /*Set Start Date*/
     
         $('#leave-start_date').blur(function(e){
        const Start_Date = e.target.value;
        const No = $('#leave-application_no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'leave/setstartdate';
            $.post(url,{'Start_Date': Start_Date,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-key').val(msg.Key);
                   
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     })
     
     /*Set Days to go on leave */
     
     $('#leave-reliever').change(function(e){
        const Reliever = e.target.value;
        const No = $('#leave-application_no').val();
        if(No.length){
            
            const url = $('input[name=url]').val()+'leave/setreliever';
            $.post(url,{'Reliever': Reliever,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                   
                   $('#leave-reliever').val(msg.Reliever);  
                   $('#leave-key').val(msg.Key);
                   $('#leave-reliever_name').val(msg.Reliever_Name);

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-reliever');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-reliever');
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
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     const DaysApplied = $('#leave-days_to_go_on_leave').val();

        function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
     
     /*Handle modal dismissal event  */
    $('#modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 

    $('#attachmentfile').change((e) => {
        $//(e.target).closest('form').trigger('submit');
        console.log('Upload Submitted ...');
    }); 

      
    /*Divs parenting*/
    
    $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });

     
     
     $.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'leave/attachement-list?No='+$('#leave-application_no').val(),
            paging: true,
            columns: [
             
                { title: 'Description' ,data: 'Description'},
              
                { title: 'View', data: 'view' },
                {title:'Delete', data:'delete'}
               
            ] ,                              
           language: {
                "zeroRecords": "No Leave Applications to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
      // table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','tr', function(){
            
        });
              /*Check if Leave Type requires an attachment */
     
     $('#leave-leave_code').change(function(e){
         e.preventDefault();
          const Leave_Code = e.target.value;
          // Check if leave required an attachment or not
            const Vurl = $('input[name=url]').val()+'leave/requiresattachment?Code='+Leave_Code;
            $.post(Vurl).done(function(msg){
                console.log(msg);
                if(msg.Requires_Attachment){
                    $('#attachmentform').show();
                }else{
                    $('#attachmentform').hide();
                }
            });
         
     });
     $('#leave-leave_code').change(function(e){
         e.preventDefault();
          const Leave_Code = e.target.value;
          // Check if leave required an attachment or not
            const Vurl = $('input[name=url]').val()+'leave/requiresattachment?Code='+Leave_Code;
            $.post(Vurl).done(function(msg){
                console.log(msg);
                if(msg.Requires_Attachment){
                    $('#attachmentform').show();
                }else{
                    $('#attachmentform').hide();
                }
            });
         
     });


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
                    $('#leave-key').val(msg.Key);
                   
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
     
JS;

$this->registerJs($script);