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




                                    <?= $form->field($model, 'Appraisal_Code')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_Code')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Category')->textInput(['required' => true]); ?>
                                    <?= $form->field($model, 'Maximum_Weigth')->textInput(['disabled' => true, 'readonly' => true]); ?>
                                    <?= $form->field($model, 'Overal_Rating')->textInput(['disabled' => true, 'readonly' => true]); ?>
                                    <?= $form->field($model, 'Total_Weigth')->textInput(['disabled' => true, 'readonly' => true]); ?>

                                   
                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                     <?= $form->field($model, 'Line_No')->hiddenInput(['readonly'=> true])->label(false) ?>











                                </tbody>
                            </table>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success SaveButton','id'=>'SaveButton']) ?>
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


/*Set KPI weight*/

        $('#probationkpi-weight').change(function(e){

        const Weight = e.target.value;
        const Appraisal_No = $('#probationkpi-appraisal_no').val();
        const Line_No = $('#probationkpi-line_no').val();


        if(Appraisal_No.length){
            
            const url = $('input[name=url]').val()+'probation-kpi/setweight';
            $.post(url,{'Weight': Weight,'Appraisal_No': Appraisal_No,'Line_No': Line_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#probationkpi-key').val(msg.Key);
                  

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-probationkpi-weight');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-probationkpi-weight');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
            
        }     
     });

     /*Set Objective*/

        $('#probationkpi-objective').change(function(e){

        const Objective = e.target.value;
      

        if(Objective.length){
            
            const url = $('input[name=url]').val()+'probation-kpi/setkpi';
            $.post(url,{'Objective': Objective}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#probationkpi-key').val(msg.Key);
                   $('#probationkpi-line_no').val(msg.Line_No);
                  

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-probationkpi-objective');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-probationkpi-objective');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
            
        }     
     });


      function disableSubmit(){
             document.getElementById('SaveButton').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('SaveButton').removeAttribute("disabled");
        
        }



JS;

$this->registerJs($script);
