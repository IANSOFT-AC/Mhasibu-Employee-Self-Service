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

                                     <?= $form->field($model, 'Relationship')->dropDownList(
                                        $relations,
                                        ['prompt' => 'Select ...']
                                    ) ?>

                                    <?= $form->field($model, 'ID_Birth_Certificate_No')->textInput() ?>
                                    <?= $form->field($model, 'Phone_No')->textInput() ?>
                                    <?= $form->field($model, 'Email_Address')->textInput(['type' => 'email']) ?>
                                    
  ;

                                    <?= $form->field($model, 'Date_of_Birth')->textInput(['type' => 'date', 'max'=> date("Y-m-d")]) ?>
                                                                       

                            </div>
                             <div class="col-md-6">
                                      <?= $form->field($model, 'Type')->dropDownList(
                                        ['Adult' => 'Adult','Minor'=> 'Minor'],
                                        ['prompt' => 'Select ...']
                                    ) ?>
                                     <?= $form->field($model, 'Full_Names')->textInput(['required' => true ]) ?>

                                     <?= $form->field($model, 'Gender')->dropDownList( 
                                        ['_blank_' => '_blank_','Male'=> 'Male','Female' => 'Female','Unknown' => 'Unknown'],
                                        ['prompt' => 'Select ...']) ?>

                                    <?= $form->field($model, 'Comments')->textArea(['rows' => 2 ]) ?>

                                    <?= $form->field($model, 'New_Allocation')->textInput(['type' => 'number' ,'required' => true ]) ?>
                                                                  

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
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
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
        $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data,function(msg){
                  var confirm =  $('.modal').modal('hide')
                    .find('.modal-body')
                    .html(msg.note);
                    setTimeout(confirm, 1000);
                });
        });
JS;

$this->registerJs($script);
