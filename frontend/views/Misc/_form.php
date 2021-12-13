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



                    <?php  $form = ActiveForm::begin();      ?>
                <div class="row">
                   

                            <table class="table">
                                <tbody>

                             <div class="col-md-6">
                                     <?= $form->field($model, 'Misc_Article_Code')->dropDownList(
                                        $articles,
                                        ['prompt' => 'Select ...']
                                    ) ?>
                                    <?= $form->field($model, 'Description')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date','min' => Date('Y-m-d') ]) ?>
                                    <?= $form->field($model, 'Value')->textInput(['type' => 'number']) ?>
                                   

                            </div>
                             <div class="col-md-6">
                                    <?= $form->field($model, 'Serial_No')->textInput() ?>
                                     <?= $form->field($model, 'Asset_Number')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date', 'min' => Date('Y-m-d')]) ?>
                                   

                                    <?= $form->field($model, 'Action')->dropDownList(
                                        ['Retain' => 'Retain','Remove' => 'Remove','New_Addition' => 'New_Addition'],
                                        ['prompt' => 'Select ...']
                                    ) ?>
                            </div>
                                    <?= $form->field($model, 'Change_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                    

                                </tbody>
                            </table>


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
