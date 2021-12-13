<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



            <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">



                            <table class="table">
                                <tbody>

                                   
                                    <?= $form->field($model, 'KRA')->textarea(['rows' => 2,'maxlength' => 250, 'required' => true]) ?>
                                    <?= ($model->isNewRecord)?$form->field($model, 'Employee_No')->hiddenInput(['value' => Yii::$app->user->identity->{'Employee No_'}])->label(false):'' ?>
                                    <?= ($model->isNewRecord)?$form->field($model, 'Appraisal_No')->hiddenInput()->label(false):'' ?>

                                   
                                    <?= ((Yii::$app->session->get('Goal_Setting_Status') == 'New' || Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level') && Yii::$app->session->get('isSupervisor') == false )?$form->field($model, 'Maximum_Weight')->textInput(['type'=> 'number', 'required' => true]):'' ?>

                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>



                                </tbody>
                            </table>



                    </div>

                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success SaveButton']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
    $('.SaveButton').on('click', function(e){
            e.preventDefault()
            const data = $('form').serialize();
            const url = $('form').attr('action');
            $.post(url,data).done(function(msg){
                    $('#modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
JS;

$this->registerJs($script);

