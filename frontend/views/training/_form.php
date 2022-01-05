<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);


?>

<div class="row">
    
        
        

                    <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-app bg-success submitforapproval',
                        'data' => [
                            'confirm' => 'Are you sure you want to send this request for approval?',
                            'params'=>[
                                'No'=> $model->Application_No,
                                'employeeNo' =>Yii::$app->user->identity->employee[0]->No,
                            ],
                            'method' => 'get',
                    ],
                        'title' => 'Submit Imprest Approval'

                    ]):'' ?>

                    <?php if($model->Status == 'Pending_Approval'): ?>
                        

                            <?= Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-warning submitforapproval',
                                    'data' => [
                                    'confirm' => 'Are you sure you want to cancel imprest approval request?',
                                    'params'=>[
                                        'No'=> $model->Application_No,
                                    ],
                                    'method' => 'get',
                                    ],
                                    'title' => 'Confirm Attendance'

                                ]);
                            ?>

                    <?php  endif; ?>


                    <?php if($model->Status == 'Approved'): ?>
                        

                        <?= Html::a('<i class="fas fa-check"></i> Confirm Attendance',['confirm-training'],['class' => 'btn btn-warning submitforapproval',
                                'data' => [
                                'confirm' => 'Are you sure you want to confirm training?',
                                'params'=>[
                                    'No'=> $model->Application_No,
                                ],
                                'method' => 'get',
                                ],
                                'title' => 'Confirm Attendance'

                            ]);
                        ?>

                    <?php  endif; ?>




       
        
    
    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php
                    $form = ActiveForm::begin()

                     ?>
                <div class="row">
                    <div class="col-md-6">

                                    <?= $form->field($model, 'Application_No')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Training_Need')->dropDownList($trainingNeeds,['prompt' => 'Select ...']) ?>
                                    <?= $form->field($model, 'Date_of_Application')->textInput(['readonly' => true])?>
                                    <?= $form->field($model, 'Training_Calender')->textInput(['readonly' => true])?>
                                    <?= $form->field($model, 'Training_Need_Description')->textInput(['readonly' => true]); ?>
                                    <?= $form->field($model, 'Employee_No')->textInput(['readonly' => true]); ?>
                                    <?= $form->field($model, 'Employee_Name')->textInput(['readonly' => true]); ?>
                                    <?= $form->field($model, 'Job_Group')->textInput(['readonly' => true]); ?>
                                    <?= $form->field($model, 'Training_Plan_Calender')->textInput(['readonly' => true]); ?>
                                    <?= $form->field($model, 'Key')->hiddenInput()->label(false); ?>
                    </div>

                    <div class="col-md-6">

                                    <?= $form->field($model, 'Job_Title')->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'Status')->textInput(['readonly' => true])?>
                                    <?= $form->field($model, 'Start_Date')->textInput(['readonly' => true])?>
                                    <?= $form->field($model, 'End_Date')->textInput(['required' => true])?>
                                    <?= $form->field($model, 'Period')->textInput(['readonly' => true]); ?>
                                    <?= $form->field($model, 'Expected_Cost')->textInput(['type' => 'number']); ?>
                                    <?= $form->field($model, 'Trainer')->textInput(['type' => 'number']); ?>
                                    <?= $form->field($model, 'Exceeds_Expected_Trainees')->checkbox(['Exceeds_Expected_Trainees', $model->Exceeds_Expected_Trainees]); ?>
                                   
                    </div>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
     $('#training-training_need').on('change',(e) => {
        globalFieldUpdate('Training', false,"Training_Need", e,['Training_Calender','Training_Need_Description','Start_Date','End_Date','Expected_Cost']);
    });
JS;

$this->registerJs($script);
