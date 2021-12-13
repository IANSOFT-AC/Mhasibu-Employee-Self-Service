<?php
use yii\helpers\Html;

if($model->Goal_Setting_Status == 'Overview_Manager' && $model->isOverview()): ?>
                        <div class="col-md-4 mx-1">

                            <?= Html::a('<i class="fas fa-backward"></i> Line Mgr.',['backtolinemgr','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'mx-1 btn btn-app bg-danger rejectgoals',
                                    'rel' => $_GET['Appraisal_No'],
                                    'rev' => $_GET['Employee_No'],
                                    'title' => 'Submit Probation  Back to Line Manager'

                            ]) ?>
                        </div>
                        
                        <div class="col-md-4 mx-1">

                            <?= Html::a('<i class="fas fa-forward"></i> Approve',['approvegoals','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-2 btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to approve goals ?',
                                'method' => 'post',
                            ],
                                'title' => 'Approve Set Probation Goals .'
                            ]) ?>

                        </div>

<?php endif; ?>

 <!-- Overview Manager Actions -->

 <?php
 

 
 if($model->Appraisal_Status == 'Overview_Manager' && $model->isOverview()): ?>
                        
                        <div class="col-md-4 mx-1">

                            <?= Html::a('<i class="fas fa-backward"></i> To Line Mgr.',['overviewbacktolinemgr','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'mx-1 btn btn-app bg-danger Overviewbacktolinemgr',
                                    'rel' => $_GET['Appraisal_No'],
                                    'rev' => $_GET['Employee_No'],
                                    'title' => 'Send Probation Appraisal Back to Line Manager'

                            ]) ?>

                        </div>

                        <div class="col-md-4 mx-1">

                            <?= Html::a('<i class="fas fa-check"></i> Approve',['approveprobationoverview','appraisalNo'=> $model->Appraisal_No,'employeeNo' => $model->Employee_No],
                                [

                                'class' => 'mx-1 btn btn-app bg-success submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to approve goals ?',
                                'method' => 'post',
                            ],
                                'title' => 'Approve Probation Appraisal.'
                            ]) ?>

                        </div>

<?php endif; ?>
