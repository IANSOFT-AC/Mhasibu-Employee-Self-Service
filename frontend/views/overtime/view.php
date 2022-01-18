<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$ApprovalDetails = Yii::$app->recruitment->getApprovaldetails($model->No);
$this->title = 'Overtime - '.$model->No;
$this->params['breadcrumbs'][] = ['label' => 'Overtime List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Overtime Card', 'url' => ['view','No'=> $model->No]];


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

                        <?= ($model->Status == 'Open')?Html::a('<i class="fas fa-forward mx-1"></i>Send For Approval',['send-for-approval'],['class' => 'btn btn-app bg-success submitforapproval ',
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


                        <?= ($model->Status == 'Pending_Approval' && !Yii::$app->request->get('Approval'))?Html::a('<i class="fas fa-times mx-1"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
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

    



    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">Overtime Request </h3>
                </div>
                <div class="card-body">

                
<div class="row">
    <div class="col-md-12">
                    <?php $form = ActiveForm::begin(); ?>

                    
                        <div class="row">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'No')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                                    <?=  $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ; ?>
                                    <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                    <?= $form->field($model, 'Hours_Worked')->textInput(['readonly'=> true, 'disabled'=>true]) ?> 
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
                      Overtime Lines
                    </div>

                    <div class="card-tools">
                        <?= Html::a('<i class="fa fa-plus-square"></i> Add Line',['add-line'],[
                            'class' => 'add btn btn-outline-info',
                            'data-no' => $model->No,
                            'data-service' => 'OvertimeLine'
                            ]) ?>
                </div>
                </div>

                <div class="card-body">

                    <?php if(is_array($model->lines)){ //show Lines ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>

                                    <td><b>Date</b></td>
                                    <td><b>Start Time</b></td>
                                    <td><b>End Date</b></td>
                                    <td><b>Hours Worked</b></td>
                                    <td><b>Work Done</b></td>
                                    <?php if($model->Status == 'Open'):?>
                                    <td><b>Action</b></td>
                                    <?php endif; ?>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                               foreach($model->lines as $obj):
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['delete-line' ],[
                                    'class'=>'del btn btn-outline-danger btn-xs',
                                    'data-key' => $obj->Key,
                                    'data-service' => 'OvertimeLine'
                                ]);

                                   $updateLink = '';

                                 
                                    ?>
                                    <tr>

                                        <td data-key="<?= $obj->Key ?>" data-name="Date"  data-service="OvertimeLine" ondblclick="addInput(this, 'date')"><?= !empty($obj->Date)? $obj->Date:'Not Set' ?></td>
                                        <td data-key="<?= $obj->Key ?>" data-name="Start_Time"   data-service="OvertimeLine" ondblclick="addInput(this, 'time')"><?= !empty($obj->Start_Time)? Yii::$app->formatter->asTime($obj->Start_Time) :'Not Set' ?></td>
                                        <td data-validate="Hours_Worked" data-key="<?= $obj->Key ?>" data-name="End_Time"   data-service="OvertimeLine" ondblclick="addInput(this, 'time')" ><?= !empty($obj->End_Time)?Yii::$app->formatter->asTime($obj->End_Time):'Not Set' ?></td>
                                        <td id="Hours_Worked"><?= !empty($obj->Hours_Worked)?$obj->Hours_Worked:'Not Set' ?></td>
                                        <td data-key="<?= $obj->Key ?>" data-name="Work_Done" data-service="OvertimeLine" ondblclick="addInput(this, '')" ><?= !empty($obj->Work_Done)?$obj->Work_Done:'Not Set' ?></td>
                                        <?php if($model->Status == 'Open'):?>
                                            <td class="text-center"><?= $updateLink.$deleteLink ?></td>
                                        <?php endif; ?>

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


<?php

$script = <<<JS

    $(function(){
      
        // Trigger Creation of a line

    $('.add').on('click',function(e){
            e.preventDefault();
            let url = $(this).attr('href');
           
            let data = $(this).data();
            const payload = {
                'Document_No': data.no,
                'Service': data.service
            };
            //console.log(payload);
            //return;
            $('a.add').text('Inserting...');
            $('a.add').attr('disabled', true);

            $.get(url, payload).done((msg) => {
                console.log(msg);
                setTimeout(() => {
                   location.reload(true);
                },1500);
            });
        });


        
    $('.del').on('click',function(e){
            e.preventDefault();

            if(confirm('Are you sure about deleting this record?'))
            {
                let data = $(this).data();
                let url = $(this).attr('href');
                let Key = data.key;
                let Service = data.service;
                const payload = {
                    'Key': Key,
                    'Service': Service
                };

                $(this).text('Deleting...');
                $(this).attr('disabled', true);

                $.get(url, payload).done((msg) => {
                    console.log(msg);
                    setTimeout(() => {
                        location.reload(true);
                    },1000);
                });
            }
            
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
