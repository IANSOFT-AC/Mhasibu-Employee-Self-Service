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
// Yii::$app->recruitment->printrr($employees);

?>

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

                <div class="row float-right">
                    <!-- <div class="col-md-4"> -->

                        <?= ($model->Status == 'New')?Html::a('Send For Approval',['send-for-approval','employeeNo' => Yii::$app->user->identity->employee[0]->No],['class' => 'btn btn-success submitforapproval',
                            'data' => [
                                'confirm' => 'Are you sure you want to send imprest request for approval?',
                                'params'=>[
                                    'No'=> $_GET['No'],
                                    'employeeNo' =>Yii::$app->user->identity->employee[0]->No,
                                ],
                                'method' => 'get',
                        ],
                            'title' => 'Submit Imprest Approval'

                        ]):'' ?>


                        <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
                            'data' => [
                            'confirm' => 'Are you sure you want to cancel imprest approval request?',
                            'params'=>[
                                'No'=> $_GET['No'],
                            ],
                            'method' => 'get',
                        ],
                            'title' => 'Cancel Imprest Approval Request'

                        ]):'' ?>


                        <?= Html::a('<i class="fas fa-file-pdf"></i> Print Imprest',['print-imprest'],['class' => 'btn btn-warning ',
                            'data' => [
                                'confirm' => 'Print Imprest?',
                                'params'=>[
                                    'No'=> $model->No,
                                ],
                                'method' => 'get',
                            ],
                            'title' => 'Print Imprest.'

                        ]) ?>
                    <!-- </div> -->
                </div>

                <div class= "row">
                       <?php if(Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success"><?= Yii::$app->session->getFlash('success')?></div>
                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error')?></div>
                <?php endif; ?>
                </div>

           </div>

            <div class="card-body">



        <?php

            $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="row col-md-12">



                        <div class="col-md-4">

                            <?= $form->field($model, 'No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>

                            <?= $form->field($model, 'Request_For')->dropDownList([
                                        'Self' => 'Self',
                                        'Other' => 'Other',
                                    ],['prompt' => 'Select Request_For']) 
                            ?>

                       
                            <?= $form->field($model, 'Imprest_Type')->dropDownList(['Local' => 'Local', 'International' => 'International'],['prompt' => 'Select ...']) ?>

                            <?= $form->field($model, 'Purpose')->textInput() ?>


                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?php if($model->Request_For == 'Self'): ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?php else: ?>
                                <?= $form->field($model, 'Employee_No')->dropDownList($employees,['prompt'=> 'Select Employee']) ?>
                            <?php endif; ?>
                            
                            <?= $form->field($model, 'Currency_Code')->dropDownList($currencies,['prompt' => 'Select ...','required' => true]) ?>
                            <?= $form->field($model, 'Imprest_Amount')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <!-- <?= $form->field($model, 'Expected_Date_of_Surrender')->textInput(['readonly'=> true, 'disabled'=>true]) ?> -->


                        </div>

                        <div class="col-md-4">
                          <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                          <?= $form->field($model, 'Employee_Balance')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                          <?= $form->field($model, 'Exchange_Rate')->textInput(['type'=> 'number','required' => true]) ?>



                        </div>



                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <?php Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <?= Html::a('<i class="fa fa-plus-square"></i> New Imprest Line',['imprestline/create','Request_No'=>$model->No],['class' => 'add-line btn btn-outline-info',
                    ]) ?>
                </div>
            </div>

            <div class="card-body">





                <?php if(is_array($model->getLines($model->No))){ //show Lines ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td><b>Transaction Type</b></td>
                            <!-- <td><b>Account No</b></td> -->
                            <td><b>Account Name</b></td>
                            <td><b>Description</b></td>
                            <td><b>Amount</b></td>
                            <td><b>Amount LCY</b></td>
                            <!-- <td><b>Budgeted Amount</b></td> -->
                            <!-- <td><b>Commited Amount</b></td> -->
                            <!-- <td><b>Total_Expenditure</b></td> -->
                            <!-- <td><b>Available Amount</b></td> -->
                            <!-- <td><b>Unbudgeted?</b></td> -->
                            <td><b>Actions</b></td>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // print '<pre>'; print_r($model->getLines($model->No)); exit;

                        foreach($model->getLines($model->No) as $obj):
                            $updateLink = Html::a('<i class="fa fa-edit"></i>',['imprestline/update','Line_No'=> $obj->Line_No, 'DocNum'=> $model->No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                            $deleteLink = Html::a('<i class="fa fa-trash"></i>',['imprestline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                            ?>
                            <tr>

                                <td><?= !empty($obj->Transaction_Type)?$obj->Transaction_Type:'Not Set' ?></td>
                                <!-- <td><?= !empty($obj->Account_No)?$obj->Account_No:'Not Set' ?></td> -->
                                <td><?= !empty($obj->Account_Name)?$obj->Account_Name:'Not Set' ?></td>
                                <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                <td><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                <td><?= !empty($obj->Amount_LCY)?$obj->Amount_LCY:'Not Set' ?></td>
                                <!-- <td><?= !empty($obj->Budgeted_Amount)?$obj->Budgeted_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Commited_Amount)?$obj->Commited_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Total_Expenditure)?$obj->Total_Expenditure:'Not Set' ?></td> -->
                                <!-- <td><?= !empty($obj->Available_Amount)?$obj->Available_Amount:'Not Set' ?></td> -->
                                <!-- <td><?= Html::checkbox('Unbudgeted',$obj->Unbudgeted) ?></td> -->
                                <td><?= $updateLink.'|'.$deleteLink ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>






    </div>
</div>



<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
      


    $('#imprestcard-employee_no').on('blur',(e) => {
        globalFieldUpdate("Imprestcard",'imprest',"Employee_No", e);
    });

     
     /*Set Program  */
    
     $('#imprestcard-global_dimension_1_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Global_Dimension_1_Code', e);
    });
     
     
     /* set department */
     
     $('#imprestcard-global_dimension_2_code').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Global_Dimension_2_Code', e);
    });

    /**Update Purpose */

    $('#imprestcard-purpose').change((e) => {
       globalFieldUpdate('Imprestcard','imprest','Purpose', e);
    });



       /* Add Line */
     $('.add-line, .update-objective').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
JS;

$this->registerJs($script);
