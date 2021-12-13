<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - ESS File Uploads';
$this->params['breadcrumbs'][] = ['label' => 'File Uploads', 'url' => ['index']];



if(Yii::$app->session->hasFlash('success')){
            print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
            echo Yii::$app->session->getFlash('success');
            print '</div>';
        }else if(Yii::$app->session->hasFlash('error')){
            print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
            echo Yii::$app->session->getFlash('error');
            print '</div>';
        }


?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ESS File Uploads</h3>

                </div>
                <div class="card-body">
                    
                    <?php
                        use yii\widgets\ActiveForm;
                        ?>

                        <?php $form = ActiveForm::begin(
                            [
                                 'id' => 'login-form',
                                'encodeErrorSummary' => false,
                                'errorSummaryCssClass' => 'help-block',
                            ],
                            ['options' => [
                            'enctype' => 'multipart/form-data']]
                        ) ?>

                            <?= $form->errorSummary($model) ?>


                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'File_Name')->textInput(['required' => true]) ?>

                                </div>
                                <div class="col-md-6">

                                    <?= $form->field($model, 'docFile')->fileInput() ?>

                                </div>

                            </div>

                            <button>Submit</button>

                        <?php ActiveForm::end() ?>


                </div>
            </div>



            <!-- Uploads Table -->

            <div class="card">
            <div class="card-body">
                 <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="appraisal">
                    </table>
                </div>
            </div>


            <!-- End of Uploads Table -->


        </div>
    </div>

<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<?php

$script = <<<JS

    $(function(){
        var absolute = $('input[name=absolute]').val();
         /*Data Tables*/
         
        // $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#appraisal').DataTable({
            
            ajax: absolute+'essfile/list',
            paging: true,
            columns: [
                { title: 'Document Title' ,data: 'File_Name'},
                { title: 'Actions' ,data: 'view'},   
               
            ] ,                              
           language: {
                "zeroRecords": "No Documents to display"
            },
            
            //order : [[ 6, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#appraisal').DataTable();
       //table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#appraisal').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);










