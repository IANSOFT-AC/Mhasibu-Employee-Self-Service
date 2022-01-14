<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */

use yii\base\View;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
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
                              
                
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly' =>  true])->label(false) ?>
                             
                    </div>
                </div>

                <div class="row">

                   


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php

$script = <<<JS
    
      
        $('#qualification-professional_examiner').change(function(e){
           
            globalFieldUpdate('qualification',false,"Professional_Examiner", e);
        });

        $('#qualification-from_date').change(function(e){
            globalFieldUpdate('qualification',false,"From_Date", e);
        });

        $('#qualification-to_date').change(function(e){
            globalFieldUpdate('qualification',false,"To_Date", e);
        });

        $('#qualification-specialization').change(function(e){
            globalFieldUpdate('qualification',false,"Specialization", e);
        });

        $('#qualification-attachment').change(function(e){
          globalUpload('ProffesionalQualifications','qualification','attachment');
        });
      

JS;

$this->registerJs($script);

?>


