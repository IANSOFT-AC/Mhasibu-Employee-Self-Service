<?php
use yii\helpers\Html;

if(($model->Goal_Setting_Status == 'New' && $model->isAppraisee()) || $model->Appraisal_Status == 'Agreement_Level'): ?>

<div class="col-md-4 mx-1">

    <?= Html::a('<i class="fas fa-forward"></i> submit',['submit','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],['class' => 'btn btn-app submitforapproval','data' => [
            'confirm' => 'Are you sure you want to submit this probation appraisal to supervisor ?',
            'method' => 'post',
        ],
        'title' => 'Submit KRAs to Line Manager.'

    ]) ?>
</div>

<?php endif; ?>


  <!-- Send Probation to Line Mgr -->

  <?php if($model->Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()): ?>

        <div class="col-md-4">

            <?= Html::a('<i class="fas fa-forward"></i> Submit ',['submitprobationtolinemgr','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                [

                'class' => 'mx-1 btn btn-app submitforapproval','data' => [
                'confirm' => 'Are you sure you want to Submit Probation Appraisal to Line Manager ?',
                'method' => 'post',
            ],
                'title' => 'Submit Probation to Line Manager.'
            ]) ?>

        </div>

<?php endif; ?>