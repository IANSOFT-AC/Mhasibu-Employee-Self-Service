<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - Leave Statement Report';
$this->params['breadcrumbs'][] = ['label' => 'PBI Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'BI', 'url' => ['index']];
?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">BI Report</h3>

                </div>
                <div class="card-body">

                    <!--<iframe src="data:application/pdf;base64,<?/*= $content; */?>" height="950px" width="100%"></iframe>-->
                   
                    <embed width="100%" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=1d3a2271-1f5c-4bf4-8b7a-82082d3ff14e&autoAuth=true&ctid=a5c0a820-c887-4727-ac66-403237d8c389&config=eyJjbHVzdGVyVXJsIjoiaHR0cHM6Ly93YWJpLWV1cm9wZS1ub3J0aC1iLXJlZGlyZWN0LmFuYWx5c2lzLndpbmRvd3MubmV0LyJ9" frameborder="0" allowFullScreen="true"></embed>


                </div>
            </div>
        </div>
    </div>

<?php
$script  = <<<JS
    $('select[name="payperiods"]').select2();
JS;

$this->registerJs($script, yii\web\View::POS_READY);










