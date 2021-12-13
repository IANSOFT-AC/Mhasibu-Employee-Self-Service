<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Leave Plan - '.$model->Plan_No;
$this->params['breadcrumbs'][] = ['label' => 'Leave Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Leave Plan Card', 'url' => ['view','Plan_No'=> $model->Plan_No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/
$ApprovalDetails = Yii::$app->recruitment->getApprovaldetails($model->No);

?>



    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Leave Plan Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                       
                  <div class="action-tab row" >

                        <?= ($model->Status == 'Open')?
                                Html::a('Send For Approval', ['send-for-approval', 'Plan_No' => $model->Plan_No,
                                'employeeNo' => Yii::$app->user->identity->{'Employee No_'}],
                                ['class' => 'btn btn-success']):'' 
                        ?>

                        
                        <?php if($ApprovalDetails->Sender_No = Yii::$app->user->identity->employee[0]->No): ?>

                            <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Request.',['cancel-request'],['class' => 'btn btn-warning submitforapproval',
                                    'data' => [
                                    'confirm' => 'Are you sure you want to cancel approval request?',
                                    'params'=>[
                                        'No'=>$model->Plan_N,
                                    ],
                                    'method' => 'get',
                                    ],
                                    'title' => 'Cancel Approval Request'

                                ]):'' 
                            ?>

                        <?php endif; ?>
                    
                 
                        <?=   Html::a('Close', ['index', ], ['class' => 'btn btn-warning']) ?>
                    </div> 
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
                                <?= $form->field($model, 'Plan_No')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                                <!-- <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Leave_Calender_Code')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Leave_Calendar_Description')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Leave_Calendar_Start_Date')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Leave_Calendar_End_Date')->textInput(['readonly'=> true,'disabled'=> true]) ?>

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
                        <?=($model->Status == 'Open')? 
                        
                        \yii\helpers\Html::button('New Leave Plan Item',
                         [  'value' => \yii\helpers\Url::to(['leaveplanline/create',
                            'Plan_No'=>$model->Plan_No
                            ]),
                            'title' => 'Leave Plan Item',
                            'class' => 'btn btn-success push-right showModalButton',
                             ]
                         ):'' 

                        ?>
                    </div>
                </div>

                <div class="card-body">





                    <?php if(is_array($model->lines)){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Plan No</b></td>
                                <td><b>Employee Code</b></td>
                                <td><b>Leave Code</b></td>
                                <td><b>Leave Type Description</b></td>
                                <td><b>Leave Balance</b></td>
                                <td><b>Start Date</b></td>
                                <td><b>End Date</b></td>
                                <td><b>Days Planned</b></td>
                                <td><b>Holidays</b></td>
                                <td><b>Weekend_Days</b></td>
                                <td><b>Total No Of Days</b></td>
                                <?php if($model->Status == 'Open'){ ?>
                                  <td><b>Action</b></td>
                                <?php } ?>



                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($model->lines as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['leaveplanline/update','Line_No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['leaveplanline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Plan_No)?$obj->Plan_No:'Not Set' ?></td>
                                    <td><?= !empty($obj->Employee_Code)?$obj->Employee_Code:'Not Set' ?></td>
                                    <td><?= !empty($obj->Leave_Code)?$obj->Leave_Code:'Not Set' ?></td>
                                    <td><?= !empty($obj->Leave_Type_Description)?$obj->Leave_Type_Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Leave_Balance)?$obj->Leave_Balance:'Not Set' ?></td>
                                    <td><?= !empty($obj->Start_Date)?$obj->Start_Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->End_Date)?$obj->End_Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->Days_Planned)?$obj->Days_Planned:'Not Set' ?></td>
                                    <td><?= !empty($obj->Holidays)?$obj->Holidays:'Not Set' ?></td>
                                    <td><?= !empty($obj->Weekend_Days)?$obj->Weekend_Days:'Not Set' ?></td>
                                    <td><?= !empty($obj->Total_No_Of_Days)?$obj->Total_No_Of_Days:'Not Set' ?></td>
                                <?php if($model->Status == 'Open'){ ?>
                                    <td><?= $updateLink.'|'.$deleteLink ?></td>
                                </tr>
                                 <?php } ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <!--End Lines -->

    </div>




<?php
if(!$ApprovalDetails === false){
    print '<input type="hidden" id="ab" value="'.$absoluteUrl.'" />';
    print '<input type="hidden" id="documentNo" value="'.$ApprovalDetails->Document_No.'" />';
    print '<input type="hidden" id="Record_ID_to_Approve" value="'.$ApprovalDetails->Record_ID_to_Approve.'" />';
    print '<input type="hidden" id="Table_ID" value="'.$ApprovalDetails->Table_ID.'" />';
    }
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
