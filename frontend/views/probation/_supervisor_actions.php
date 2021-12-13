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


   <!-- Send Probation to Overview -->
   <div class="col-md-4 mx-1">
            <?= Html::a('<i class="fas fa-forward"></i> Submit ',['submitprobationtooverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                [

                'class' => 'mx-1 btn btn-app submitforapproval','data' => [
                'confirm' => 'Are you sure you want to Submit Probation Appraisal to Overview Manager ?',
                'method' => 'post',
            ],
                'title' => 'Submit Probation to Overview Manager.'
            ]) ?>

    </div>


  



<?php endif; ?>