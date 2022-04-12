<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 4:19 PM
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AdminlteAsset;
use common\widgets\Alert;

AdminlteAsset::register($this);
$this->title = Yii::$app->params['welcomeText'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition">
<?php $this->beginBody() ?>

            <div class="container">
                <header class="mb-md-5">

                        <!-- Add Logo here -->
                        <div class="logo">
                            <img src="<?= \yii\helpers\Url::to('/images/logo.png')?>" alt="">
                        </div>
                        
                </header>
                <main class="my-3">
                            <div class="left-content">
                                <h2 class="text mb-md-4 mt-3 text-bold">The SACCO For Professionals</h2>
                                <h1 class="text mhasibu-main text-bold mb-md-5">Welcome to Mhasibu Staff Portal</h1>
                                <p class="text tagline lead mb-5 mb-md-5 text-bold">Experience Service Excellence!</p>

                                <p class="together h2 text-bold">Together We Make The Difference!</p>
                            </div>
                            <!-- Login form and Helo content -->
                            <div class="form-content">
                                <?= $content?>
                            </div>
                            
                </main>
               
            </div>
            <footer class="footer">
                <div class="container p-3">
                            <strong>Copyright &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>.</strong>
                                    All rights reserved.
                </div>
                                    
            </footer>


</body>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>


