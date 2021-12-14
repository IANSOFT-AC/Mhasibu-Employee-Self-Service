<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);

//   echo '<pre>';
//             print_r( $model);
//             exit;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                <?php


                $disabled = (Yii::$app->session->get('Probation_Recomended_Action') == 'Extend_Probation' && !Yii::$app->session->get('Is_Short_Term')  )? true: false;


                $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">
                            <table class="table">
                                <tbody>
                                    <?= $form->field($model, 'Appraisal_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Question_Line_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= (Yii::$app->session->get('Goal_Setting_Status') == 'New')?
                                         $form->field($model, 'Answer')->textArea(['max-length' => 250, 'row' => 4,'placeholder' => 'Your Answer..']):
                                         $form->field($model, 'Answer')->textArea(['max-length' => 250, 'row' => 4,'placeholder' => 'Your Answer','readonly' => true,'disabled'=> true])
                                     ?>

                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                    <?= $form->field($model, 'Line_No')->hiddenInput(['readonly'=> true])->label(false) ?>
                                </tbody>
                            </table>

                    </div>
                </div>
                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="url" value="<?= $absoluteUrl ?>">

<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
 $('form#w0').on('submit', function(e){
            e.preventDefault();
          
            const data = $('form').serialize();
            const url = $(this).attr('action');

            console.log(data);
            console.log(url);

            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });


    



JS;

$this->registerJs($script);
