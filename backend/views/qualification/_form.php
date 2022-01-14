<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'professional',
                        'options' => ['enctype' => 'multipart/form-data'],
                        ]); ?>
               

                           

                
                                    <?= $form->field($model, 'Professional_Examiner')->dropDownList($examiners,
                                        ['prompt' => '- Select ...']) 
                                    ?>
                              

                                        
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date']) ?>
                              
                                
                                    <?= $form->field($model, 'Specialization')->textarea(['rows'=> 2, 'maxlength' =>  250]) ?>
                              
                                
                                    <?= $form->field($model, 'attachment')->fileInput(['accept' => 'application/*']) ?>
                              

                                

                
                                    <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                             
                    </div>
                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php

$script = <<<JS
    $(function(){
      
      
    });
JS;

$this->registerJs($script);

?>


