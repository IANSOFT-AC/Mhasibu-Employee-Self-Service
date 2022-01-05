<?php
use yii\helpers\Html;


if($model->Goal_Setting_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>
                        <div class="col-md-4 mx-1">

                            <?= Html::a('<i class="fas fa-forward"></i> To Overview',['submittooverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],['class' => 'btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to submit this appraisal to Overview Manager ?',
                                'method' => 'post',
                            ],
                                'title' => 'Submit Goals for Approval'

                            ]) ?>
                        </div>
                       
                        <div class="col-md-4 mx-1">

                            <?= Html::a('<i class="fas fa-backward"></i>Send Back',['backtoemp','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                ['
                                class' => 'mx-1 btn btn-app bg-danger rejectgoalsettingbyoverview',
                                'rel' => $_GET['Appraisal_No'],
                                'rev' => $_GET['Employee_No'],
                                'title' => 'Reject KRAs and Send them Back to Appraisee.'

                            ]) ?>
                        </div>

                        
                        



<?php endif; ?>


<!-- To OverView -->

<?php if($model->Appraisal_Status == 'Agreement_Level' || $model->Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>
                        <!-- Send Probation to Overview -->
   <div class="col-md-4 mx-1">
            <?= Html::a('<i class="fas fa-forward"></i> To Overview ',['submitprobationtooverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                [

                'class' => 'mx-1 btn btn-app submitforapproval','data' => [
                'confirm' => 'Are you sure you want to Submit Probation Appraisal to Overview Manager ?',
                'method' => 'post',
            ],
                'title' => 'Submit Probation to Overview Manager '
            ]) ?>

    </div>

                        
                        



<?php endif; ?>




 <!-- Line Mgr Actions on complete goals -->

 <?php if($model->Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()): ?>

    <div class="col-md-4 mx-1">

            <?= Html::a('<i class="fas fa-backward"></i> To Appraisee.',['probationbacktoappraisee','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                [
                    'class' => 'btn btn-app bg-danger rejectappraiseesubmition',
                    'rel' => $_GET['Appraisal_No'],
                    'rev' => $_GET['Employee_No'],
                    'title' => 'Submit Probation  Back to Appraisee'

            ]) ?>

    </div>


   

                        <div class="col-md-4 mx-1">
                                <?php Html::a('<i class="fas fa-check"></i> Agreement',['agreementlevel','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],[
                                            'class' => 'btn btn-app bg-success submitforapproval',
                                            'title' => 'Move Appraisal to  Agreement Level',
                                            'data' => [
                                            'confirm' => 'Are you sure you want to send this End-Year Appraisal to Agreement Level ?',
                                            'method' => 'post',
                                            ]
                                    ])
                                ?>

                        </div>


  



<?php endif; ?>