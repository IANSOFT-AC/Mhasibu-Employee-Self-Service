<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Request - '.$model->Exit_No;
$this->params['breadcrumbs'][] = ['label' => 'Change Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Change Request Card', 'url' => ['view','No'=> $model->Exit_No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/
$ApprovalDetails = Yii::$app->recruitment->getApprovaldetails($model->No);

?>

<div class="row">
    <div class="col-md-4">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval'],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document for approval?',
                'params'=>[
                    'No'=> $model->Exit_No,
                    'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                ],
                'method' => 'get',
        ],
            'title' => 'Send Request for Approval'

        ]):'' ?>


        <?= ($model->Status == 'Pending_Approval' && !Yii::$app->request->get('Approval'))?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
            'data' => [
            'confirm' => 'Are you sure you want to cancel  approval request?',
            'params'=>[
                'No'=> $model->Exit_No,
            ],
            'method' => 'get',
        ],
            'title' => 'Cancel Approval Request'

        ]):'' ?>


        <?= ($model->Status == 'Approved')?Html::a('<i class="fas fa-file"></i> Generate Exit Form',['gen-exit-form'],['class' => 'btn btn-app',
            'data' => [
                'confirm' => 'Are you sure you want to Generate Exit Form ?',
                'params'=>[
                    'No'=> $model->Exit_No,
                ],
                'method' => 'get',
            ],
            'title' => 'Cancel Approval Request'

        ]):'' ?>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Employee Exit Document </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Request No : <?= $model->Exit_No?></h3>



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
                                <?= $form->field($model, 'Date_of_Exit')->textInput(['readonly'=> true]) ?>
                                <?php $form->field($model, 'Interview_Conducted_By')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Reason_For_Exit')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Reason_Description')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Notice_Period')->hiddenInput(['readonly'=> true])->label(false) ?>


                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Date_Of_Notice')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Expiry_of_Notice')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?php $form->field($model, 'Date_of_Exit_Interview')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Notice_Fully_Served')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Reasons_For_Not_Serving_Notice')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->

            <!--Medical Dependants -->

            <div class="card" id="Medical_Dependants">
                <div class="card-header">
                    <div class="card-title">
                        Final Dues Calculations <?php Html::a('Add',['dues/create','No' => $model->Exit_No],['class' => 'add-line btn btn-sm btn-info']) ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php
                    // Yii::$app->recruitment->printrr($model->dues);
                    if(is_array($model->dues)){ //show Lines ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Employee No</b></td>
                                <td><b>Exit No</b></td>
                                <td><b>Description</b></td>
                                <td><b>Amount</b></td>
                                

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;
                            foreach($model->dues as $obj):

                                if(!empty($obj->Employee_No)){
                                               
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Employee_No)?$obj->Employee_No:'Not Set' ?></td>
                                    <td ><?= !empty($obj->Exit_No)?$obj->Exit_No:'Not Set' ?></td>
                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Amount)?number_format($obj->Amount):'Not Set' ?></td>
                                    


                                </tr>
                            <?php
                                } // End if condition for Line_No
                             endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php } ?>
                </div>
            </div>


            <!--End Dues Lines -->

    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Change Request Management</h4>
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


<?php

$script = <<<JS

    $(function(){
      
        
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
        
        
      //Add  plan Line
    
     $('.add-line, .update-objective').on('click',function(e){
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

    table td:nth-child(11), td:nth-child(12) {
                text-align: center;
    }
    
    /* Table Media Queries */
    
     @media (max-width: 500px) {
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
    }
CSS;

$this->registerCss($style);
