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
// if(isset(Yii::$app->user->identity->profileID)){
    $profileAction = (Yii::$app->user->identity->profileID)?'applicantprofile/update?No='.Yii::$app->user->identity->profileID:'applicantprofile/view-profile';
// }

$CompanyColor = 'indigo';
$SecondaryColorHeaderColor = 'wheat';

// echo '<pre>';
// print_r(Yii::$app->user->identity);
// exit;

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

        <body class="hold-transition sidebar-mini layout-fixed">
            <?php $this->beginBody() ?>

                    <!-- Global Modal Here -->
                <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="modalContent">

                            <div class="modal-header" id="modalHeader">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel" style="position: absolute"></h4>
                            </div>

                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="wrapper">

                    <!-- Navbar -->
                    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: <?= $CompanyColor?>;color: white;">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                        <li class="nav-item" >
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: white;"></i></a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="<?= $absoluteUrl ?>" class="nav-link" style="color: white;">Home</a>
                        </li>
                      
                        </ul>

                  

                        <!-- Right navbar links -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Right navbar links -->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item" >
                                <a class="nav-link" href="<?= \yii\helpers\Url::to('site/logout', ['method'=>'post'])?>" role="button">
                                <span class="brand-text " style="font-size: revert; color:white; font-weight:bolder"> <?=Yii::$app->user->identity->email?> (Log Out)</span>
                                </a>
                            </li>
                        </ul>

                            <li class="nav-item" >
                                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                <i class="fas fa-user" style="background-color: <?=$CompanyColor ?>;color: white;"></i> 
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.navbar -->

                    <!-- Main Sidebar Container -->
                    <aside class="main-sidebar sidebar-dark-primary elevation-4">
                        <!-- Brand Logo -->
                        <a href="<?= $absoluteUrl ?>" class="brand-link" style="background-color: <?=$CompanyColor ?>;">
                        <img src="<?= $absoluteUrl ?>dist/img/TenwekLogo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                            style="opacity: .8">
                        <span class="brand-text font-weight-light" style="font-size: revert;"> Recruitment Portal</span>
                        </a>

                        <!-- Sidebar -->
                        <div class="sidebar" style="padding: 0px 8px;height: 100%;width: 100%;background-color: <?=$CompanyColor ?>;">
                        <!-- Sidebar user panel (optional) -->
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <!-- <p> Navigator </p> -->
                            </div>
                            <div class="info">
                            <a href="#" class="d-block"></a>
                            </div>
                        </div>

                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                with font-awesome or any other icon font library -->
                            
                            <li class="nav-item">
                                <a href="<?= $absoluteUrl ?>recruitment/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Browse Jobs
                                </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                
                                <a href="<?= $absoluteUrl. $profileAction ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    My Profile
                                </p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Job Applications
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                                </a>
                                <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>job-applications" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Submitted Applications</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Submitted Applications</p>
                                    </a>
                                </li> -->
                           
                            
                                </ul>
                            </li>
                            
                       
                        
                            </ul>
                        </nav>
                        <!-- /.sidebar-menu -->
                        </div>
                        <!-- /.sidebar -->
                    </aside>

                      <!-- Content Wrapper. Contains page content -->
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <div class="content-header" style="background-color: <?=$SecondaryColorHeaderColor ?>;border-radius: 10em;">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        
                                        <div class="col-sm-6">
                                            <h1 class="m-0 text-dark"> <?= $this->title ?></h1>
                                        </div><!-- /.col -->

                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                                            <li class="breadcrumb-item active">Dashboard v1</li>
                                            </ol>
                                        </div><!-- /.col -->

                                    </div><!-- /.row -->
                                </div><!-- /.container-fluid -->
                            </div>
                                <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <?= $content ?>
                                </div>
                            </section>

                        </div>
                            <!-- /.content-header -->

                          

                    <footer class="main-footer">
                            <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

                            <div class="float-right d-none d-sm-inline-block">
                                <p> <?= Yii::powered() ?> </p>
                            </div>
                    </footer>

                 </div>

            <?php $this->endBody() ?>
        </body>

        
        <script>
        //               (function (document, window, $) {
        // setTimeout(() => {
        //     }, 200);
        // })(document, window, jQuery);

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
