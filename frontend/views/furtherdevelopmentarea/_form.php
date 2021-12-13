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



                    <?php




                    $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">



                            <table class="table">
                                <tbody>




                                    <?= $form->field($model, 'Appraisal_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= (
                                        
                                        Yii::$app->session->get('Goal_Setting_Status') == 'New' || 
                                        Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' || 
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level'
                                    )?
                                        $form->field($model, 'Weakness')->textarea(['placeholder' => 'Further Development Area','max-length'=>250,'rows' => 3])
                                        :

                                        $form->field($model, 'Weakness')->textarea(['placeholder' => 'Further Development Area','max-length'=>250,'rows' => 3,'readonly' => true, 'disabled' =>  true])


                                         ?>

                                    <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isAppraisee'))?
                                        $form->field($model, 'Training_Needed')->dropDownlist([ 1 => 'Yes', 0 => 'No'],['prompt' => 'Select ...']):
                                        '' ?>

                                    <?= $form->field($model, 'Support_Needed')->textInput(['maxlength' => 250]) ?>

                                    <?= ( 
                                        (Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' || Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' ) && Yii::$app->session->get('isAppraisee'))?
                                    $form->field($model, 'Status_Comment')->textarea(['rows' => 2,'maxlength' => 250]):
                                    '' ?>


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