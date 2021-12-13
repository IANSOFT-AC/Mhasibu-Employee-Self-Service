<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Asset Assignment - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Change Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Change Request Card', 'url' => ['view','No'=> $model->No]];
/** Status Sessions */


/* Yii::$app->session->set('MY_Appraisal_Status',$model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status',$model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor',false);*/
?>


    <div class="row">
        <div class="col-md-12">
            <div class="card-info">
                <div class="card-header">
                    <h3>Asset Assignment Document </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <div class="push-right">
                        
                        <?= ($model->Approval_Status == 'New')?Html::a('Send For Approval',['send-for-approval'],['class' => 'btn btn-success submitforapproval ',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to send this document for approval?',
                                        'params'=>[
                                            'No'=> $model->No,
                                            'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                                        ],
                                        'method' => 'get',
                                ],
                                    'title' => 'Submit Request Approval'

                                ]):'' 
                        ?>


                        <?= ($model->Approval_Status == 'Pending_Approval' && !Yii::$app->request->get('Approval'))?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
                            'data' => [
                            'confirm' => 'Are you sure you want to cancel imprest approval request?',
                            'params'=>[
                                'No'=> $model->No,
                            ],
                            'method' => 'get',
                        ],
                            'title' => 'Cancel Approval Request'

                        ]):'' 
                        ?>

                        <?=
                            Html::a('Go Back',['index'],['class' => 'btn btn-warning',
                                
                                'title' => 'Close The Current Page'

                                ]);
                        ?>

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
                                <?= $form->field($model, 'No')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>


                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true,'disabled'=> true]) ?>
                                <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true,'disabled'=> true]) ?>

                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->


            
            <!---Miscelleneous change Req-->
            

            <div class="card" id="Misc_artical_information_ch">
                <div class="card-header">
                    <div class="card-title">
                    <?= ($model->Approval_Status == 'New')?
                       

                       Html::button('Add ',
                       [  'value' => yii\helpers\Url::to(['misc/create',
                       'Change_No' => $model->No,
                       'assignee' => $model->Employee_No
                       ]),
                       'title' => 'Add Beneficiary Request',
                       'class' => 'btn btn-success push-right showModalButton',
                    ]):''

                        ?> 
                    </div>
                    
                </div>

                <div class="card-body">

                    <?php

                    if(is_array($model->misc)){ //show Lines ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td><b>Misc_Article_Code</b></td>
                                            <td><b>Description</b></td>
                                            <td><b>From_Date</b></td>
                                            <td><b>To_Date</b></td>
                                            <td><b>Serial</b></td>
                                            <td><b>Value</b></td>
                                            <td><b>Action</b></td>
                                            <td><b>Asset_Number</b></td>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                        // print '<pre>'; print_r($model->getObjectives()); exit;
                        foreach($model->misc as $miscobj):
                            $updateLink = Html::a('<i class="fa fa-edit"></i>',['misc/update','No'=> $miscobj->Line_No],['class' => 'update-miscobjective btn btn-outline-info btn-xs']);
                            $deleteLink = Html::a('<i class="fa fa-trash"></i>',['misc/delete','Key'=> $miscobj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                            ?>
                                            <tr>

                                                <td data-key="<?= $miscobj->Key ?>" data-name="Misc_Article_Code" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addDropDown(this, 'misc-code')"><?= !empty($miscobj->Misc_Article_Code)?$miscobj->Misc_Article_Code:'Not Set' ?></td>
                                                <td data-key="<?= $miscobj->Key ?>" data-name="Description" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addDropDown(this,'relatives')"><?= !empty($miscobj->Description)?$miscobj->Description:'Not Set' ?></td>
                                                <td data-key="<?= $miscobj->Key ?>" data-name="From_Date" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this, 'date')"><?= !empty($miscobj->From_Date)?$miscobj->From_Date:'Not Set' ?></td>
                                                <td data-key="<?= $miscobj->Key ?>" data-name="To_Date" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this, 'date')"><?= !empty($miscobj->To_Date)?$miscobj->To_Date:'Not Set' ?></td>
                                                
                                                <td data-key="<?= $miscobj->Key ?>" data-name="Serial_No" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this)"><?= !empty($miscobj->Serial_No)?$miscobj->Serial_No:'Not Set' ?></td>

                                                <td data-key="<?= $miscobj->Key ?>" data-name="Value" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this)"><?= !empty($miscobj->Value)?$miscobj->Value:'Not Set' ?></td>

                                                 <td data-key="<?= $miscobj->Key ?>" data-name="Action" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addDropDown(this,'action')"><?= !empty($miscobj->Action)?$miscobj->Action:'Not Set' ?></td>

                                                <td data-key="<?= $miscobj->Key ?>" data-name="Asset_Number" data-no="<?= $miscobj->Line_No ?>" data-filter-field="Line_No" data-service="Miscinformation" ondblclick="addInput(this)"><?= !empty($miscobj->Asset_Number)?$miscobj->Asset_Number:'Not Set' ?></td>


                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

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
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
      
    
    /*Evaluate KRA*/
        $('.evalkra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
        
        
      //Add  plan Line
    
     $('.add-line, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update a training plan
    
     $('.update-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
     
      
      
      
    
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
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
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
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
                 $('.modal').modal('show')
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
