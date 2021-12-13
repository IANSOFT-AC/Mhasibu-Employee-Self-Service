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




                $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">



                        <table class="table">
                            <tbody>

                        
                            <?= (Yii::$app->session->get('Goal_Setting_Status') == 'New')?
                            $form->field($model, 'Behaviour_Name')->textInput(['maxlength' => 150, 'readonly' => true]):
                            $form->field($model, 'Behaviour_Name')->textInput(['maxlength' => 150,'disabled' => true, 'readonly' => true]) ?>




                            <?= (Yii::$app->session->get('Goal_Setting_Status') == 'New')?
                            $form->field($model, 'Weight')->textInput(['type' => 'number','required' => true, 'readonly' => true]):
                            $form->field($model, 'Weight')->textInput(['type' => 'number','disabled' => true, 'readonly' => true]) ?>


                            <?php (Yii::$app->session->get('Goal_Setting_Status') == 'New' )?$form->field($model, 'Applicable')->checkbox(['value' => true,['enclosedByLabel' => true]]):'' ?>

                             <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Agreement_Level' &&  Yii::$app->session->get('isAppraisee'))?
                                    $form->field($model, 'Agree')->dropDownList([
                                        true => 'I agree', false => 'I disagree'
                                     ]):
                                    '' ?>


                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Agreement_Level' && Yii::$app->session->get('isAppraisee'))?
                                     $form->field($model, 'Mid_Year_Agreement')->dropDownList([
                                        true => 'I agree', false => 'I disagree'
                                     ]): '' ?>
                                    <?= (Yii::$app->session->get('MY_Appraisal_Status') == 'Agreement_Level' && Yii::$app->session->get('isAppraisee'))?
                                    $form->field($model, 'Mid_Year_Disagreement_Comments')->textarea(['rows' => 3, 'maxlength' => 250]):'' ?>
                                    

                            


                            <?= ( Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isAppraisee'))?

                                    $form->field($model, 'Mid_Year_Employee_Rating')->dropDownList($ratings,['prompt' => 'Select Rating'])

                                    

                            :

                            ''  ?>


                             <?= ( Yii::$app->session->get('MY_Appraisal_Status') == 'Appraisee_Level' && Yii::$app->session->get('isAppraisee'))?

                                   

                                    $form->field($model, 'Mid_Year_Employee_Comments')->textarea(['rows' => 3, 'maxlength' => 250])

                            :

                            ''  ?>


                            <?= ( Yii::$app->session->get('MY_Appraisal_Status') == 'Supervisor_Level' && Yii::$app->session->get('isSupervisor'))?

                                    $form->field($model, 'Mid_Year_Supervisor_Rating')->dropDownList($ratings,['prompt' => 'Select Rating'])

                                    

                            :

                            ''  ?>


                            <?= ( Yii::$app->session->get('MY_Appraisal_Status') == 'Supervisor_Level' && Yii::$app->session->get('isSupervisor'))?

                                    

                                    $form->field($model, 'Mid_Year_Supervisor_Comments')->textarea(['rows' => 3, 'maxlength' => 250])

                            :

                            ''  ?>



                            <?= 
                                (

                                 Yii::$app->session->get('isAppraisee') &&
                                 Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' 
                                    )?$form->field($model, 'Self_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= 

                                (
                                 Yii::$app->session->get('isAppraisee') &&
                                 Yii::$app->session->get('EY_Appraisal_Status') == 'Appraisee_Level' 

                             )?$form->field($model, 'Appraisee_Remark')->textarea(['rows' => 3, 'maxlength' => 250]):'' ?>



                            <?= (

                                Yii::$app->user->identity->isSupervisor() &&
                                (
                                Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level' ||
                                Yii::$app->session->get('Appraisal_Status') == 'Supervisor_Level')

                            )?$form->field($model, 'Appraiser_Rating')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>

                            <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Peer_1_Level')?$form->field($model, 'Peer_1')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Peer_1_Level')?$form->field($model, 'Peer_1_Remark')->textarea(['rows' => 3, 'maxlength' => 250]):'' ?>


                            <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Peer_2_Level')?$form->field($model, 'Peer_2')->dropDownList($ratings,['prompt' => 'Select Rating']):'' ?>
                            <?= (Yii::$app->session->get('EY_Appraisal_Status') == 'Peer_2_Level')?$form->field($model, 'Peer_2_Remark')->textarea(['rows' => 3, 'maxlength' => 250]):'' ?>


                            <?= (!Yii::$app->session->get('isAppraisee') && Yii::$app->session->get('EY_Appraisal_Status') == 'Agreement_Level')?$form->field($model, 'Agreed_Rating')->textInput(['type' => 'number','required' => true]):'' ?>
                            <?= (
                                !Yii::$app->session->get('isAppraisee') && (
                                Yii::$app->session->get('EY_Appraisal_Status') == 'Supervisor_Level' ||
                                Yii::$app->session->get('Appraisal_Status') == 'Supervisor_Level')
                                    
                            )?$form->field($model, 'Overall_Remarks')->textarea(['rows' => 4,'max-length'=> 250]):'' ?>

                            <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>











                            </tbody>
                        </table>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::Button(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success SaveButton']) ?>
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


        // Mid year comment and disagreement status toggle

$('#employeeappraisalbehaviours-mid_year_disagreement_comments').hide();
$('label[for="employeeappraisalbehaviours-mid_year_disagreement_comments"]').hide();


$('#employeeappraisalbehaviours-mid_year_agreement').on('change', function(){
    const status = $(this).val();
    console.log('status is: '+status);
    if(status == 1) {
        $('#employeeappraisalbehaviours-mid_year_disagreement_comments').hide();
        $('label[for="employeeappraisalbehaviours-mid_year_disagreement_comments"]').hide();
    }else{
        $('#employeeappraisalbehaviours-mid_year_disagreement_comments').show();
        $('label[for="employeeappraisalbehaviours-mid_year_disagreement_comments"]').show();
    }
});


JS;

$this->registerJs($script);
