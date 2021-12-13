<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Contract Renewal Card - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Contract Renewals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Contract Renewal Card', 'url' => ['view','No'=> $model->No]];
$ApprovalDetails = Yii::$app->recruitment->getApprovaldetails($model->No);

?>

<div class="row">
    <div class="col-md-12">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-success submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send imprest request for approval?',
                'params'=>[
                    'No'=> $model->No,
                    'employeeNo' =>Yii::$app->user->identity->employee[0]->No,
                ],
                'method' => 'get',
        ],
            'title' => 'Approve'

        ]):'' ?>

        <?php if(!$ApprovalDetails === false): ?>
            <?php if($ApprovalDetails->Sender_No = Yii::$app->user->identity->employee[0]->No): ?>

                    <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-warning submitforapproval',
                            'data' => [
                            'confirm' => 'Are you sure you want to cancel approval request?',
                            'params'=>[
                                'No'=> $_GET['No'],
                            ],
                            'method' => 'get',
                            ],
                            'title' => 'Cancel Approval Request'

                        ]):'' 
                    ?>

            <?php endif; ?>

            <?php if($model->Status == 'Pending_Approval' && $ApprovalDetails->Approver_No == Yii::$app->user->identity->Employee[0]->No):?>
            
                <?= 
                    Html::a('Approve',['approvals/approve-request', 'app'=> $model->No,
                    'empNo' => Yii::$app->user->identity->employee[0]->No,
                    'docType' => 'Requisition_Header'],['class' => 'btn btn-success ',
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

       

      


    </div>
</div>
<br>

    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Contract Renewal Document </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h3 class="card-title">Renewal No : <?= $model->No?></h3>

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

                                <?= $form->field($model, 'No')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                            </div>
                            <div class="col-md-6">

                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?php $form->field($model, 'Approval_Entries')->textInput(['readonly'=> true,'disabled'=> true]) ?>

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
                        <?=($model->Approval_Status == 'New')?Html::a('<i class="fa fa-plus-square"></i> Add Line',['contractrenewalline/create','No'=>$model->No, 'Employee_No' => $model->Employee_No ],['class' => 'add-line btn btn-outline-info',
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
                                    <td><b>Contract Start_Date</b></td>
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
                                    <!-- <td><b>New Salary</b></td> -->
                                    <td><b>Status</b></td>

                                    <?php if($model->Approval_Status == 'New'): ?><td><b>Actions</b></td> <?php endif; ?>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // print '<pre>'; print_r($model->lines); exit;

                                foreach($model->lines as $obj):

                                    if(!empty($obj->Contract_Code)) {
                                        $updateLink = Html::a('<i class="fa fa-edit"></i>', ['contractrenewalline/update', 'No' => $obj->Line_No], ['class' => 'update-objective btn btn-outline-info btn-xs']);
                                       $deleteLink = Html::a('<i class="fa fa-trash"></i>', ['contractrenewalline/delete', 'Key' => $obj->Key], ['class' => 'delete btn btn-outline-danger btn-xs']);

                                        $donorDetails = Html::a('<i class="fa fa-plus"></i>', ['donorline/create',

                                                    'Contract_Code' => $obj->Contract_Code,
                                                    'Contract_Line_No' => $obj->Line_No,
                                                    'Employee_No' => $model->Employee_No,
                                                    'Change_No' => $model->No,
                                                    'Grant_Start_Date' => $obj->Contract_Start_Date,
                                                    'Grant_End_Date' => $obj->Contract_End_Date
                                        ],

                                        [
                                            'class' => 'update-objective btn btn-success btn-xs', 'title' => 'Add Donor Details',
                                            'title' => 'Add Donor Line.',
                                            
                                            
                                        ]
                                         
                                    );




                                        ?>
                                        <tr class="parent">

                                            <td><?= !empty($obj->Contract_Code) ? $obj->Contract_Code : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Contract_Description) ? $obj->Contract_Description : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Contract_Start_Date) ? $obj->Contract_Start_Date : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Contract_Period) ? $obj->Contract_Period : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Contract_End_Date) ? $obj->Contract_End_Date : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Notice_Period) ? $obj->Notice_Period : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Job_Title) ? $obj->Job_Title : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Line_Manager) ? $obj->Line_Manager : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Manager_Name) ? $obj->Manager_Name : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Department) ? $obj->Department : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Pointer) ? $obj->Pointer : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Grade) ? $obj->Grade : 'Not Set' ?></td>
                                            <td><?= !empty($obj->Salary) ? $obj->Salary : 'Not Set' ?></td>
                                           <!--  <td><?php !empty($obj->New_Salary) ? $obj->New_Salary : 'Not Set' ?></td> -->
                                            <td><?= !empty($obj->Status) ? $obj->Status : 'Not Set' ?></td>

                                            <?php if($obj->Status == 'New'): ?>
                                                <td><?= $updateLink .'|' . $donorDetails ?></td>
                                            <?php endif; ?>
                                        </tr>
                                        <tr class="child">
                                            <td colspan="16">
                                                


                                                    <table class="table table-hover table-borderless table-info">
                                                        <thead>
                                                            <tr>
                                                                <td><b>Grant Code</b></td>  
                                                                <td><b>Grand Name</b></td>  
                                                                <td><b>Grant Activity</b></td>  
                                                                <td><b>Grant Type</b></td>  
                                                                <td><b>Grant Start Date</b></td>  
                                                                <td><b>Grant End Date</b></td>  
                                                                <td><b>Percentage</b></td>  
                                                                <td><b>Grant Status</b></td> 
                                                                <td>Action</td>
                                                            </tr> 
                                                        </thead>
                                            <tbody>
                                                 <?php if(is_array($model->getDonorLine($obj->Contract_Code,$obj->Line_No))){
                                                    foreach($model->getDonorLine($obj->Contract_Code,$obj->Line_No) as $d):  

                                                        $donorUpdate = Html::a('<i class="fa fa-edit"></i>', ['donorline/update', 'Line_No' => $d->Line_No], ['class' => 'update-objective btn btn-success btn-xs', 'title' => 'Update Donor Details']);
                                        
                                                        $deletedonor = Html::a('<i class="fa fa-trash"></i>', ['donorline/delete', 'Key' => $d->Key], ['class' => 'delete btn btn-outline-danger btn-xs']);
                                                    ?>


                                                        <tr>
                                                            <td><?= !empty($d->Grant_Code)?$d->Grant_Code:'' ?></td>
                                                            <td><?= !empty($d->Grant_Name)?$d->Grant_Name:'' ?></td>
                                                            <td><?= !empty($d->Grant_Activity)?$d->Grant_Activity:'' ?></td>
                                                            <td><?= !empty($d->Grant_Type)?$d->Grant_Type:'' ?></td>
                                                            <td><?= !empty($d->Grant_Start_Date)?$d->Grant_Start_Date:'' ?></td>
                                                            <td><?= !empty($d->Grant_End_Date)?$d->Grant_End_Date:'' ?></td>
                                                            <td><?= !empty($d->Percentage)?$d->Percentage:'' ?></td>
                                                            <td><?= !empty($d->Grant_Status)?$d->Grant_Status:'' ?></td>
                                                            <td><?=($model->Approval_Status == 'New')? $donorUpdate.' | '.$deletedonor:'' ?></td>

                                                        </tr>

                                                <?php
                                            endforeach;
                                                 } ?>
                                                        </tbody>
                                                    </table>


                                            </td>                                          
                                              
                                        </tr>
                                        <?php
                                    }
                                endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php } ?>
                </div>
            </div>

            <!--End Lines -->

    </div>



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
          table td:nth-child(7) {
                display: none;
        }
    }
    
     @media (max-width: 550px) {
          table td:nth-child(7) {
                display: none;
        }
    }
    
    @media (max-width: 650px) {
          table td:nth-child(7) {
                display: none;
        }
    }


    @media (max-width: 1500px) {
          table td:nth-child(7) {
                display: none;
        }
    }
CSS;

$this->registerCss($style);
