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
                    $form = ActiveForm::begin();

                     ?>
                <div class="row">
                    <div class="col-md-12">


                                    <?= $form->field($model, 'Exit_no')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_no')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Form_No')->hiddenInput(['readonly' => true])->label(false)?>

                                    <?= $form->field($model, 'Item_Description')->textInput(['required' => true])?>

                                    <?= $form->field($model, 'Item_Worth')->textInput(['type' => 'number']) ?>

                                      

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
