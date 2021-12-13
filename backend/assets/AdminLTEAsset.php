<?php
namespace backend\assets;
use yii\web\AssetBundle;

class AdminLTEAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'plugins/fontawesome-free/css/all.min.css',
        'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'plugins/jqvmap/jqvmap.min.css',
        'dist/css/adminlte.min.css',
        'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'plugins/daterangepicker/daterangepicker.css',
        'plugins/summernote/summernote-bs4.css',
        // 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700', 
        'https://fonts.googleapis.com/css?family=Merriweather+Sans',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css',
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',


    ];

    public $js = [
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        // 'plugins/jquery/jquery.min.js',
        'Js/blockUI.js',
        'plugins/jquery-ui/jquery-ui.min.js',
        'plugins/chart.js/Chart.min.js',
        'plugins/sparklines/sparkline.js',
        'plugins/jqvmap/jquery.vmap.min.js',
        'plugins/jqvmap/maps/jquery.vmap.usa.js',
        'plugins/jquery-knob/jquery.knob.min.js',
        'plugins/moment/moment.min.js',
        'plugins/daterangepicker/daterangepicker.js',
        'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
        'plugins/summernote/summernote-bs4.min.js',
        'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        'dist/js/adminlte.js',
        'dist/js/pages/dashboard.js',
        'dist/js/demo.js',
        'https://cdn.jsdelivr.net/npm/sweetalert2@9',

        'Js/ShowModal.js', // Helps in Global Modal4
        // 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js',

        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js',
        // 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
        // 'https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js ',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js',

        
        'plugins/datatables/jquery.dataTables.min.js',
        'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        'plugins/datatables-responsive/js/dataTables.responsive.min.js',
        'plugins/datatables-responsive/js/responsive.bootstrap4.min.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}

?>