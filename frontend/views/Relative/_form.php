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

                                    <?= $form->field($model, 'First_Name')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'Middle_Name')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'Last_Name')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'Phone_No')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'Relative_Code')->dropDownList($relations,['prompt' => 'select ...']) ?>

                            </div>
                             <div class="col-md-6">
                                    <?= $form->field($model, 'Birth_Date')->textInput(['type' => 'date']) ?>
                                    <?= $form->field($model, 'ID_Birth_Certificate_No')->textInput(['maxlength' => 150]) ?>
                                    <?= $form->field($model, 'Gender')->dropDownList(
                                        ['Male' => 'Male','Female' => 'Female','Unknown' => 'Unknown'],
                                        ['prompt' => 'Select ...']
                                    ) ?>

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
