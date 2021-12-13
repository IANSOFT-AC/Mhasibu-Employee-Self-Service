<?php

use yii\helpers\Html;

if($model->Appraisal_Status == 'HR_Level' && $model->Hr_UserId == Yii::$app->user->identity->getId() ): ?>

<div class="col-md-4">

    <?= Html::a('<i class="fas fa-forward"></i> Approve',['close','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],['class' => 'btn bg-success btn-app submitforapproval','data' => [
        'confirm' => 'Are you sure you want to approve this probation appraisal?',
        'method' => 'post',
    ],
        'title' => 'Approve and Close Probation Appraisal.'

    ]) ?>
</div>

<div class="col-md-4">&nbsp;</div>

<div class="col-md-4">

    <?= Html::a('<i class="fas fa-backward"></i> Send Back',['backtosuper','appraisalNo'=> $_GET['Appraisal_No'],'employeeNo' => $_GET['Employee_No']],['class' => 'btn btn-app bg-danger submitforapproval','data' => [
        'confirm' => 'Are you sure you want to send back this probation appraisal to supervisor ?',
        'method' => 'post',
    ],
        'title' => 'Send Probation Appraisal Back to Supervisor.'

    ]) ?>
</div>



<?php endif; ?>