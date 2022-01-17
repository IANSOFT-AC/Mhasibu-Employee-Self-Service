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
               

                           

                
                                    <?= $form->field($model, 'Level')->dropDownList($levels,
                                        ['prompt' => '- Select ...']) 
                                    ?>

                                    <?= $form->field($model, 'Academic_Qualification')->dropDownList($academicQualifications,
                                        ['prompt' => '- Select ...']) 
                                    ?>

                                   
                                        
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date']) ?>
                              
                                
                                    <?= $form->field($model, 'Institution_Company')->textarea(['rows'=> 2, 'maxlength' =>  250]) ?>
                                    <?= $form->field($model, 'Description')->textarea(['rows'=> 2, 'maxlength' =>  250]) ?>
                              
                                
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
    
      
        $('#academic-level').change(function(e){   
            globalFieldUpdate('academic',false,"Level", e);
        });

        $('#academic-academic_qualification').change(function(e){   
            globalFieldUpdate('academic',false,"Academic_Qualification", e);
        });

        $('#academic-from_date').change(function(e){
            globalFieldUpdate('academic',false,"From_Date", e);
        });

        $('#academic-to_date').change(function(e){
            globalFieldUpdate('academic',false,"To_Date", e);
        });

        $('#academic-description').change(function(e){
            globalFieldUpdate('academic',false,"Description", e);
        });


        $('#academic-institution_company').change(function(e){
            globalFieldUpdate('academic',false,"Institution_Company", e);
        });


        $('#academic-attachment').change(function(e){
          globalUpload('qualifications','academic','attachment');
        });
      

JS;

$this->registerJs($script);

?>


