<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - P9 Report';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'P9 Report', 'url' => ['index']];
?>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">My P9 Reports</h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="<?= Yii::$app->recruitment->absoluteUrl().'p9/index'?>">
                                <?= \yii\helpers\Html::dropDownList('p9year','',$p9years,['prompt' =>'select P9 Year','class' => 'form-control']) ?>

                                <div class="form-group" style="margin-top: 10px">
                                <?= \yii\helpers\Html::submitButton('Generate P9',['class' => 'btn btn-primary']); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--<iframe src="data:application/pdf;base64,<?/*= $content; */?>" height="950px" width="100%"></iframe>-->
                    <?php
                    if(is_null($content)){
                        print '<p class="alert alert-info">P9 Report for Requested Year is Not Available. </p>';
                    }
                    if($report && !isset($message)){ ?>

                        <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>
                   <?php } ?>



                </div>
            </div>
        </div>
    </div>

<?php
$script  = <<<JS
    $('select[name="payperiods"]').select2();
JS;

$this->registerJs($script, yii\web\View::POS_READY);










