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
$this->params['breadcrumbs'][] = ['label' => 'imprests', 'url' => ['/imprest']];
$this->params['breadcrumbs'][] = ['label' => 'Imprest Card', 'url' => ['view','No'=> $model->No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/

$ApprovalDetails = Yii::$app->recruitment->getApprovaldetails($model->No);
// Yii::$app->recruitment->printrr($ApprovalDetails)

?>



<div class="row">
    <div class="col-md-12">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-success submitforapproval',
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

        <?php if($ApprovalDetails): ?>
            <?php if($ApprovalDetails->Sender_No == Yii::$app->user->identity->employee[0]->No): ?>

                <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-warning submitforapproval',
                        'data' => [
                        'confirm' => 'Are you sure you want to cancel imprest approval request?',
                        'params'=>[
                            'No'=> $_GET['No'],
                        ],
                        'method' => 'get',
                        ],
                        'title' => 'Cancel Imprest Approval Request'

                    ]):'' 
                ?>

            <?php endif; ?>

            <?php if($model->Status == 'Pending_Approval' && @$ApprovalDetails->Approver_No == Yii::$app->user->identity->Employee[0]->No):?>
            
                <?= 
                    Html::a('Approve',['approvals/approve-request', 'app'=> $model->No,
                    'empNo' => Yii::$app->user->identity->employee[0]->No,
                    'docType' => $ApprovalDetails->Document_Type ],['class' => 'btn btn-success ',
                        'data' => [
                            'confirm' => 'Are you sure you want to Approve this request?',
                            'method' => 'post',
                        ],
                        'title' => 'Approve.'
                    ])
                ?>

                <?= 
                    Html::a('Reject Request',['approvals/reject-request', 
                        'app'=> $model->No,
                        'empNo' => Yii::$app->user->identity->employee[0]->No,
                        'rel' => $ApprovalDetails->Document_No,
                        'rev' => $ApprovalDetails->Record_ID_to_Approve,
                        'name' => $ApprovalDetails->Table_ID,
                        'docType' => $ApprovalDetails->Document_Type ],
                    ['class' => 'btn btn-danger reject',
                        'title' => 'Reject.'
                    ])
                ?>

        <?php  endif; ?>
        <?php endif; ?>
    


        <?= Html::a('<i class="fas fa-file-pdf"></i> Print Imprest',['print-imprest'],['class' => 'btn btn-primary ',
            'data' => [
                'confirm' => 'Print Imprest?',
                'params'=>[
                    'No'=> $model->No,
                ],
                'method' => 'get',
            ],
            'title' => 'Print Imprest.'

        ]) ?>

        


    </div>
</div>
<br>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Imprest Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Imprest No : <?= $model->No?></h3>



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
                                

                                <?= $form->field($model, 'No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Purpose')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= '<p><span>Employee Balance</span> '.Html::a($model->Employee_Balance,'#'); '</p>' ?>
                                <?= '<p><span>Imprest Amount</span> '.Html::a($model->Imprest_Amount,'#'); '</p>'?>



                                <p class="parent"><span>+</span>




                                </p>


                            </div>
                            <div class="col-md-6">
                                <?= '<p><span> Amount LCY</span> '.Html::a($model->Amount_LCY,'#'); '</p>'?>
                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Expected_Date_of_Surrender')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Imprest_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                <p class="parent"><span>+</span>



                                </p>



                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->


            <!--Objectives card -->


            <?php

            Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval','employeeNo' =>Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-app submitforapproval',
                'data' => [
                    'confirm' => 'Are you sure you want to send imprest request for approval?',
                    'params'=>[
                        'No'=> $_GET['No'],
                        'employeeNo' =>Yii::$app->user->identity->employee[0]->No,
                    ],
                    'method' => 'get',
                ],
                'title' => 'Submit Imprest Approval'

            ])
            ?>

            <?php if(!$model->Status == 'New'): ?>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">   <?= Html::a('<i class="fa fa-plus-square"></i> New Imprest Line',['imprestline/create','Request_No'=>$model->No],['class' => 'add-objective btn btn-outline-info']) ?></div>
                </div>
            <?php endif; ?>


                <div class="card-body">





                    <?php
                    if(is_array($model->getLines($model->No))){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Transaction Type</b></td>
                                <td><b>Account No</b></td>
                                <td><b>Account Name</b></td>
                                <td><b>Description</b></td>
                                <td><b>Amount</b></td>
                                <td><b>Amount LCY</b></td>
                                <!-- <td><b>Budgeted Amount</b></td>
                                <td><b>Balance Before Entry</b></td>
                                <td><b>Total Expenditure</b></td>
                                <td><b>Balance Less Entry</b></td>
                                <td><b>Unbudgeted?</b></td> -->
                                <?php if(!$model->Status == 'New'): ?>
                                    <td><b>Actions</b></td>

                                <?php endif; ?>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($model->getLines($model->No) as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['imprestline/update','Line_No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['imprestline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Transaction_Type)?$obj->Transaction_Type:'Not Set' ?></td>
                                    <td><?= !empty($obj->Account_No)?$obj->Account_No:'Not Set' ?></td>
                                    <td><?= !empty($obj->Account_Name)?$obj->Account_Name:'Not Set' ?></td>
                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Amount_LCY)?$obj->Amount_LCY:'Not Set' ?></td>
                                    <!-- <td><?= !empty($obj->Budgeted_Amount)?$obj->Budgeted_Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Balance_Before_Entry)?$obj->Balance_Before_Entry:'Not Set' ?></td>
                                    <td><?= !empty($obj->Total_Expenditure)?$obj->Total_Expenditure:'Not Set' ?></td>
                                    <td><?= !empty($obj->Balance_Less_Entry)?$obj->Balance_Less_Entry:'Not Set' ?></td> -->
                                    <!-- <td><?= Html::checkbox('Unbudgeted',$obj->Unbudgeted) ?></td> -->
                                    <?php if(!$model->Status == 'New'): ?>
                                        <td><?= $updateLink.'|'.$deleteLink ?></td>
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

    <!--My Bs Modal template  --->




<?php
$absoluteUrl = \yii\helpers\Url::home(true);
if(!$ApprovalDetails === false){
    print '<input type="hidden" id="ab" value="'.$absoluteUrl.'" />';
    print '<input type="hidden" id="documentNo" value="'.$ApprovalDetails->Document_No.'" />';
    print '<input type="hidden" id="Record_ID_to_Approve" value="'.$ApprovalDetails->Record_ID_to_Approve.'" />';
    print '<input type="hidden" id="Table_ID" value="'.$ApprovalDetails->Table_ID.'" />';
    }

$script = <<<JS

    $(function(){


        /*Post Approval comment*/
    
    $('form#approval-comment').on('submit', function(e){
        e.preventDefault();
        var absolute = $('#ab').val(); 

        var url = absolute + 'approvals/reject-request'; 
        var data = $(this).serialize();
        
        
        $.post(url, data).done(function(msg){
          // $('#modal').modal('hide');
            var confirm = $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
            
            setTimeout(confirm, 1000);
            
        },'json');
        
       
    });
    
    
    /*Modal initialization*/
    
        $('.reject').on('click',function(e){
            e.preventDefault();
            console.table(this)
            var docno = $('#documentNo').val();
            var Record_ID_to_Approve = $('#Record_ID_to_Approve').val();;
            var Table_ID =$('#Table_ID').val();
            
            $('input[name=documentNo]').val(docno);
            $('input[name=Record_ID_to_Approve]').val(Record_ID_to_Approve);
            $('input[name=Table_ID]').val(Table_ID);
            
    
            $('.ApprovalModal').modal('show');                            
    
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
