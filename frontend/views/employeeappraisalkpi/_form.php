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



                   

                $disabled = (Yii::$app->session->get('Goal_Setting_Status') == 'Closed' )? true: false;

                     ?>
                <div class="row">
                    <div class="col-md-12">



                            <table class="table">
                                <tbody>




                                    <?= $form->field($model, 'Appraisal_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'KRA_Line_No')->hiddenInput(['readonly' => true])->label(false)?>

                                    <?= (
                                        Yii::$app->session->get('Goal_Setting_Status') == 'New' || 
                                        $model->isNewRecord ||
                                        Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level'
                                    )?
                                    $form->field($model, 'Objective')->textArea(['max-length' => 250, 'row' => 4,'placeholder' => 'Your KPI']):
                                     $form->field($model, 'Objective')->textArea(['max-length' => 250, 'row' => 4,'placeholder' => 'Your KPI','readonly' => true,'disabled'=> true])
                                     ?>

                                     <?= (
                                        Yii::$app->session->get('Goal_Setting_Status') == 'New' || 
                                        Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level'
                                    )?$form->field($model, 'Weight')->textInput(['type' => 'number']):'' ?>

                                       


                                    <?= (Yii::$app->session->get('Goal_Setting_Status') == 'New' || $model->isNewRecord || Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level')?
                                      $form->field($model, 'Target')->textArea(['rows' => 2, 'maxlength' => 250,'required' => true]):
                                      $form->field($model, 'Target')->textArea(['rows' => 2, 'maxlength' => 250, 'readonly' => true, 'disabled' => true]) ?>

                                       <?=
                                     ( 
                                        (Yii::$app->session->get('Goal_Setting_Status') == 'Closed' || Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level') || Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level')?
                                     $form->field($model, 'Target_Status')->dropDownList(['Achieved' => 'Achieved','Not_Achieved' => ' Not Achieved'],['prompt' => 'Select ...'])
                                     :
                                     $form->field($model, 'Target_Status')->dropDownList(['Achieved' => 'Achieved','Not_Achieved' => 'Not Achieved'],['prompt' => 'Select ...','disabled' => true,'readonly' => true]) ?>



                                     <?=
                                     ( Yii::$app->session->get('Goal_Setting_Status') == 'Closed' && 

                                        (Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' || Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level'))?
                                     $form->field($model, 'Non_Achievement_Reasons')->textArea(['rows' => 2, 'maxlength' => 250])
                                     :
                                     $form->field($model, 'Non_Achievement_Reasons')->textArea(['rows' => 2, 'maxlength' => 250,'disabled' => true,'readonly' => true]) ?>

                                      <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Agreement_Level' && Yii::$app->session->get('isAppraisee'))?
                                     $form->field($model, 'Mid_Year_Agreement')->dropDownList([
                                        true => 'I agree', false => 'I disagree'
                                     ]): '' ?>

                                      <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Agreement_Level' && Yii::$app->session->get('isAppraisee'))?
                                     $form->field($model, 'Mid_Year_Disagreement_Comment')->textarea(['rows' => 2,'maxlength' => 250]): '' ?>

                                   


                                     <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isAppraisee'))?$form->field($model, 'Mid_Year_Appraisee_Assesment')->dropDownList($ratings,['prompt' => 'Select Assement...']):'' ?>   

                                      <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isAppraisee')) ? $form->field($model, 'Mid_Year_Appraisee_Comments')->textArea(['rows' => 2,'maxlength' => 250]):'' ?> 


                                       <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Supervisor_Level'  && Yii::$app->session->get('isSupervisor'))?$form->field($model, 'Mid_Year_Supervisor_Assesment')->dropDownList($ratings,['prompt' => 'Select Assement...']) :'' ?>   

                                      <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Supervisor_Level' && Yii::$app->session->get('isSupervisor'))?$form->field($model, 'Mid_Year_Supervisor_Comments')->textArea(['rows' => 2,'maxlength' => 250]):'' ?> 






                                     <?=
                                     ( 

                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level'
    
                                    )?
                                     $form->field($model, 'Appraisee_Self_Rating')->dropDownList($ratings,['prompt' => 'Select Rating...',$disabled])
                                     :$form->field($model, 'Appraisee_Self_Rating')->textInput(['readonly' => true]) ?>

                                    


                                     <?= (!$disabled && Yii::$app->session->get('Goal_Setting_Status') == 'Closed' &&

                                      (Yii::$app->session->get('Appraisal_Status') == 'Appraisee_Level' ||
                                      Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level')

                                  )? 

                                     $form->field($model, 'Employee_Comments')->textInput(['type' => 'text'])
                                     :
                                     (Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level')?$form->field($model, 'Employee_Comments')->textInput(['type' => 'text']):'' 
                                      ?>




                                      <?= (

                                        Yii::$app->session->get('isSupervisor') && 
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level'
                                    )?$form->field($model, 'Appraiser_Rating')->dropDownList($ratings,['prompt' => 'Select Rating...']):'' ?>


                                       <?php (
                                        Yii::$app->session->get('isSupervisor') &&
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level')?$form->field($model, 'Move_To_PIP')->dropDownList([
                                        true => 'Yes', false => 'No'
                                     ]): '' ?>



                                     <?= (
                                        Yii::$app->session->get('isSupervisor') && 
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level'
                                    )? $form->field($model, 'End_Year_Supervisor_Comments')->textInput(['type' => 'text']): '' ?>

                                     <?= (
                                        Yii::$app->session->get('isAppraisee') &&
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Agreement_Level'
                                    )?$form->field($model, 'Agree')->dropDownList([
                                        true => 'I agree', false => 'I disagree'
                                     ]): '' ?>

                                      <?= (
                                        Yii::$app->session->get('isAppraisee') &&
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Agreement_Level'
                                    )? $form->field($model, 'Disagreement_Comments')->textArea(['max-length' => 250, 'row' => 4,'placeholder' => 'Your Comment']):'' ?>

                                      <?= (
                                        Yii::$app->session->get('isOverview') &&
                                        Yii::$app->session->get('EY_Appraisal_Status') == 'Overview_Manager'
                                        )? $form->field($model, 'Overview_Manager_Comments')->textArea(['max-length' => 250, 'row' => 4,'placeholder' => 'Over View Manager Comment']):'' ?>







                                    <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                     <?= ($model->isNewRecord)?$form->field($model, 'Line_No')->hiddenInput(['readonly'=> true])->label(false):'' ?>












                                </tbody>
                            </table>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::Button(($model->isNewRecord)?'Save Objective':'Update', ['class' => 'btn btn-success SubmitObj']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS



// Hide non achievement reasons if achieved
 $('#employeeappraisalkpi-non_achievement_reasons').hide();
 $('label[for="employeeappraisalkpi-non_achievement_reasons"]').hide();

$('#employeeappraisalkpi-target_status').on('change', function(){
    const status = $(this).val();
    console.log('status is:' + status);
    if(status == 'Achieved') {
        $('#employeeappraisalkpi-non_achievement_reasons').hide();
        $('label[for="employeeappraisalkpi-non_achievement_reasons"]').hide();
    }else{
        $('#employeeappraisalkpi-non_achievement_reasons').show();
        $('label[for="employeeappraisalkpi-non_achievement_reasons"]').show();
    }
});


$('#employeeappraisalkpi-disagreement_comments').hide();
$('label[for="employeeappraisalkpi-disagreement_comments"]').hide();


$('#employeeappraisalkpi-agree').on('change', function(){
    const status = $(this).val();
    console.log('status is: '+status);
    if(status == 1) {
        $('#employeeappraisalkpi-disagreement_comments').hide();
        $('label[for="employeeappraisalkpi-disagreement_comments"]').hide();
    }else{
        $('#employeeappraisalkpi-disagreement_comments').show();
        $('label[for="employeeappraisalkpi-disagreement_comments"]').show();
    }
});



// Mid year comment and disagreement status toggle

$('#employeeappraisalkpi-mid_year_disagreement_comment').hide();
$('label[for="employeeappraisalkpi-mid_year_disagreement_comment"]').hide();


$('#employeeappraisalkpi-mid_year_agreement').on('change', function(){
    const status = $(this).val();
    console.log('status is: '+status);
    if(status == 1) {
        $('#employeeappraisalkpi-mid_year_disagreement_comment').hide();
        $('label[for="employeeappraisalkpi-mid_year_disagreement_comment"]').hide();
    }else{
        $('#employeeappraisalkpi-mid_year_disagreement_comment').show();
        $('label[for="employeeappraisalkpi-mid_year_disagreement_comment"]').show();
    }
});


 //Submit Rejection form and get results in json    
        $('.SubmitObj').on('click', function(e){
            e.preventDefault()
            e.stopImmediatePropagation();

            const data = $('form').serialize();
            const url = $('form').attr('action');
            $('button[type=submit], input[type=submit]').prop('disabled',true);

            $.post(url, data, function(msg){
                console.log('Submitting......')
                $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
            });

            // $.post(url,data).done(function(msg){
            //         $('.modal').modal('show')
            //         .find('.modal-body')
            //         .html(msg.note);
        
            //     },'json');
        });
JS;

$this->registerJs($script);
