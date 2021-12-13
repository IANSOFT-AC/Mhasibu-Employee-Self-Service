<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php
                    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row">
                    <div class="col-md-12">

<?php
// echo '<pre>';
// print_r($qlist);
// echo '..............';
// print_r($Complete);
// exit;
// exit;

?>

                            <table class="table">
                                <tbody>

                                

                                <tr>
                                    <?= $form->field($model, 'Professional_Examiner')->dropDownList($ProffesionalExaminers,
                                        ['prompt' => '- Select Professional Examiner -']) 
                                    ?>
                                </tr>
                                

                                <tr>
                                    <?= $form->field($model, 'From_Date')->textInput(['type' => 'date']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'To_Date')->textInput(['type' => 'date']) ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Specialization')->textInput() ?>
                                </tr>
                                <tr>
                                    <?= $form->field($model, 'Attachement_path')->fileInput(['accept' => 'application/*']) ?>
                                </tr>

                                <tr>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['value' => Yii::$app->user->identity->profileID, 'readonly' => 'true'])->label(false) ?>
                                    <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>
                                </tr>











                                </tbody>
                            </table>



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
        $('#qualification-level').on('change', function(){
            var selected =  $('#qualification-level').val();

            $.post( "/qualification/education-qualifications?Level="+selected, function( data ) {
                $('#Academic_Qualification').empty();
                $('#Academic_Qualification').append($('<option id="itemId" selected="selected"></option>').attr('value', '').text('Select Qualification'));

                 data.forEach(item=> {
                 
                  $('#Academic_Qualification').append($('<option id="itemId'+ item.Code+'" ></option>').attr('value', item.Code).text(item.Description));

                });
           });
            
        });

        $('#qualification-qualification_code').select2();
    });
JS;

$this->registerJs($script);

?>


