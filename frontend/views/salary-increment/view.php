<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Salary Increment Requisition - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Salary Increment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Salary Increment Card', 'url' => ['view','No'=> $model->No]];

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
    <div class="col-md-4">

        <?= ($model->Approval_Status== 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval'],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send this document for approval?',
                'params'=>[
                    'No'=> $model->No,
                    'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                ],
                'method' => 'get',
        ],
            'title' => 'Submit Document for Approval'

        ]):'' ?>


        <?= ($model->Approval_Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
            'data' => [
            'confirm' => 'Are you sure you want to cancel document approval request?',
            'params'=>[
                'No'=> $model->No,
            ],
            'method' => 'get',
        ],
            'title' => 'Cancel Document Approval Request'

        ]):'' ?>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Salary Increment Requisition Document </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h3 class="card-title">Requisition No : <?= $model->No?></h3>


                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'No')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Current_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Current_Pointer')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            </div>
                            <div class="col-md-6">

                                <?= $form->field($model, 'Current_Salary_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'New_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'New_Pointer')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'New_Salary_Grade')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Approval_Entries')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                               

                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->

            <!--Lines -->

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <?php ($model->Approval_Status == 'New')?Html::a('<i class="fa fa-plus-square"></i> Add Line',['purchase-requisitionline/create','No'=>$model->No],['class' => 'add-line btn btn-outline-info',
                        ]):'' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php if(is_array($model->lines)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td><b>Contract Code</b></td>
                                    <td><b>Contract Description</b></td>
                                    <td><b>Contract Start Date</b></td>
                                    <td><b>Contract Period</b></td>
                                    <td><b>Contract End Date</b></td>
                                    <td><b>Notice Period</b></td>

                                    <td><b>Job Title</b></td>
                                    <td><b>Line Manager</b></td>
                                    <td><b>Manager Name</b></td>
                                    <td><b>Department</b></td>
                                    <td><b>Pointer</b></td>
                                    <td><b>Grade</b></td>
                                    <td><b>Salary</b></td>
                                    <td><b>New Salary</b></td>
                                    <td><b>Approval Status</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->getObjectives()); exit;

                                foreach($model->lines as $obj):

                                    ?>
                                    <tr>

                                        <td><?= !empty($obj->Contract_Code)?$obj->Contract_Code:'Not Set' ?></td>
                                        <td><?= !empty($obj->Contract_Description)?$obj->Contract_Description:'Not Set' ?></td>
                                        <td><?= !empty($obj->Contract_Start_Date)?$obj->Contract_Start_Date:'Not Set' ?></td>
                                        <td><?= !empty($obj->Contract_Period)?$obj->Contract_Period:'Not Set' ?></td>
                                        <td><?= !empty($obj->Contract_End_Date)?$obj->Contract_End_Date:'Not Set' ?></td>
                                        <td><?= !empty($obj->Notice_Period)?$obj->Notice_Period:'Not Set' ?></td>
                                        <td><?= !empty($obj->Job_Title)?$obj->Job_Title:'Not Set' ?></td>
                                        <td><?= !empty($obj->Line_Manager)?$obj->Line_Manager:'Not Set' ?></td>
                                        <td><?= !empty($obj->Manager_Name)?$obj->Manager_Name:'Not Set' ?></td>

                                        <td><?= !empty($obj->Department)?$obj->Department:'Not Set' ?></td>
                                        <td><?= !empty($obj->Pointer)?$obj->Pointer:'Not Set' ?></td>
                                        <td><?= !empty($obj->Grade)?$obj->Grade:'Not Set' ?></td>

                                        <td><?= !empty($obj->Salary)?$obj->Salary:'Not Set' ?></td>
                                        <td><?= !empty($obj->New_Salary)?$obj->New_Salary:'Not Set' ?></td>
                                        <td><?= !empty($obj->Approval_Status)?$obj->Approval_Status:'Not Set' ?></td>

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                </div>
            </div>

            <!--End Lines -->

    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Store Requisitions</h4>
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

    tbody {
      display: inline-block;
      overflow-y:auto;
    }
    thead, tbody tr {
      display:table;
      width: 100%;
      table-layout:fixed;
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
