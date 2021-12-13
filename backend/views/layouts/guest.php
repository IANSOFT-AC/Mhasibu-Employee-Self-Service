<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminLTEAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AdminLTEAsset::register($this);
$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);
$CompanyColor = 'indigo';
$SecondaryColorHeaderColor = 'wheat';
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?php $this->registerCsrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>

        <body class="hold-transition login-page">
            <?php $this->beginBody() ?>
            <div class="login-box">
                <div class="login-logo">
                    <b>Tenwek Recruitment Portal </b>
                </div>

                <div class="card">
                        <?= $content ?>
                </div>
            </div>

            <?php $this->endBody() ?>
        </body>

        
        <script>


        $(document).ready(function () {
            $.blockUI({ message: '<h5><img src="<?=$absoluteUrl ?>dist/img/spinner.gif" /> Loading...</h5>' });

            setTimeout(() => {
                $.unblockUI();
            }, 900);
            $('.page-content').toggle();
        });
        
                 </script>
    </html>
<?php $this->endPage() ?>
