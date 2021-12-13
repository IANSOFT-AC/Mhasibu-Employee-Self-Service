<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Imprest - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'imprest Surrenders', 'url' => ['surrenderlist']];
$this->params['breadcrumbs'][] = ['label' => 'Imprest Surrender Card', 'url' => ['view-surrender','No'=> $model->No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/

// Yii::$app->recruitment->printrr($model->getLines());
?>

<div class="row">
    <div class="col-md-4">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send imprest request for approval?',
                'params'=>[
                    'No'=> $_GET['No'],
                    'employeeNo' => Yii::$app->user->identity->employee[0]->No,
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


        <?= Html::a('<i class="fas fa-file-pdf"></i> Print Surrender',['print-surrender'],['class' => 'btn btn-app ',
            'data' => [
                'confirm' => 'Print Surrender?',
                'params'=>[
                    'No'=> $model->No,
                ],
                'method' => 'get',
            ],
            'title' => 'Print Surrender.'

        ]) ?>

    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Imprest Surrender Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Surrender No : <?= $model->No?></h3>



                    <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('error');
                        print '</div>';
                    }
                    ?>
                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">

                        
                            <div class="col-md-4">
                                
                                <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>

                                  <?= $form->field($model, 'Request_For')->dropDownList([
                                            'Self' => 'Self',
                                            'Other' => 'Other',
                                        ],['prompt' => 'Select Request_For']) 
                                ?>


                            </div>
  
                            <div class="col-md-4">

                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Imprest_No')->dropDownList($imprests,['prompt' => 'select..']) ?>

                            </div>

                            <div class="col-md-4">
                        
                                <?= $form->field($model, 'Employee_No')->dropDownList($employees,['prompt'=> 'Select Employee']) ?>
                                <?= $form->field($model, 'Receipt_No')->dropDownList($receipts,['prompt' => 'Select ... ']) ?>
                                <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                                <input type="hidden" id="EmpNo" value="<?= Yii::$app->user->identity->employee[0]->No ?>">


                                </p>

                            </div>

                        </div>
                    </div>


                       <div class="row">

                    <div class="form-group">
                        <?php if($model->Status == 'New'): ?>
                            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                        <?php endif; ?>
                    </div>


                </div>

                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->


            <!--Objectives card -->


            <?php

            Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-app submitforapproval',
                'data' => [
                    'confirm' => 'Are you sure you want to send imprest request for approval?',
                    'params'=>[
                        'No'=> $_GET['No'],
                        'employeeNo' => Yii::$app->user->identity->employee[0]->No,
                    ],
                    'method' => 'get',
                ],
                'title' => 'Submit Imprest Approval'

            ])
            ?>



            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Imprest Lines  </div>
                </div>



                <div class="card-body">





                    <?php
                    if($model->Imprest_No && is_array($model->getLines($model->Imprest_No))){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Description</b></td>
                                <!-- <td><b>Account No</b></td> -->
                                <td><b> Imprest Amount</b></td>
                                <td><b>Actual Spent</b></td>
                                <!-- <td><b>Budgeted Amount</b></td>
                                <td><b>Commited Amount</b></td>
                                <td><b>Total_Expenditure</b></td>
                                <td><b>Available Amount</b></td>
                                <td><b>Unbudgeted?</b></td> -->
                                <td><b>Actions</b></td>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($model->getLines($model->No) as $obj):
                               $updateLink = Html::a('<i class="fa fa-edit"></i>',['imprest-surrender-line/update','Line_No'=> $obj->Line_No, 'DocNum'=>$model->No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['imprest-surrender-line/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Imprest_Amount)?$obj->Imprest_Amount:'0' ?></td>
                                     <td><?= !empty($obj->Amount_LCY)?$obj->Amount_LCY:'Not Set' ?></td> 

                                     <?php if($model->Status == 'New'): ?>
                                        <td><?= (!$obj->Surrender)?$updateLink.'|'.$deleteLink:'N/A' ?></td>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <!--objectives card -->








        </>
    </div>

<?php

$script = <<<JS

    $(function(){

        
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

      
        
     /*Deleting Records*/
     
     $('.delete, .delete-objective').on('click',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $.get(url).done(function(msg){
             $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
      
    
    /*Evaluate KRA*/
        $('.evalkra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
      //Add a training plan
    
     $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update a training plan
    
     $('.update-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('#modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
     
      
      
      
    
    /*Handle modal dismissal event  */
    $('#modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    /*Parent-Children accordion*/ 
    
    $('tr.parent').find('span').text('+');
    $('tr.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('tr.parent').nextUntil('tr.parent').slideUp(1, function(){});    
    $('tr.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('tr.parent').slideToggle(100, function(){});
     });
    
    /*Divs parenting*/
    
     $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });
    
        //Add Career Development Plan
        
        $('.add-cdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
           
            
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('#modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         /*End Add Weakness Development Plan*/

         //Change Action taken

         $('select#probation-action_taken').on('change',(e) => {

            const key = $('input[id=Key]').val();
            const Employee_No = $('input[id=Employee_No]').val();
            const Appraisal_No = $('input[id=Appraisal_No]').val();
            const Action_Taken = $('#probation-action_taken option:selected').val();
           
              

            /* var data = {
                "Action_Taken": Action_Taken,
                "Appraisal_No": Appraisal_No,
                "Employee_No": Employee_No,
                "Key": key

             } 
            */
            $.get('./takeaction', {"Key":key,"Appraisal_No":Appraisal_No, "Action_Taken": Action_Taken,"Employee_No": Employee_No}).done(function(msg){
                 $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
                });


            });
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

$style = <<<CSS
    p span {
        margin-right: 50%;
        font-weight: bold;
    }

    /* table td:nth-child(11), td:nth-child(12) {
                text-align: center;
    } */
    
    /* Table Media Queries */
    
     /* @media (max-width: 500px) {
          table td:nth-child(2),td:nth-child(3),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
     @media (max-width: 550px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
    @media (max-width: 650px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }


    @media (max-width: 1500px) {
          table td:nth-child(2),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    } */
CSS;

$this->registerCss($style);
