<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'Jobs on Offer';
$this->params['breadcrumbs'][] = ['label' => 'Recruitment ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Vacancies', 'url' => ['index']];
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> <?= $this->title ?></h3>


                <?php
                if(Yii::$app->session->hasFlash('success')){
                    print ' <div class="alert alert-success alert-dismissable">';
                    echo Yii::$app->session->getFlash('success');
                    print '</div>';
                }else if(Yii::$app->session->hasFlash('error')){
                    print ' <div class="alert alert-danger alert-dismissable">
                                ';
                    echo Yii::$app->session->getFlash('error');
                    print '</div>';
                }
                ?>



            </div>
            <div class="card-body">
                <table class="table table-bordered dt-responsive table-hover" id="requistions">
                </table>
            </div>
        </div>
    </div>
</div>


<?php
$absoluteUrl = \yii\helpers\Url::home(true);
print '<input type="hidden" id="ab" value="'.$absoluteUrl.'" />';
$script = <<<JS

    $(function(){
         /*Data Tables*/
         var absolute = $('#ab').val(); 
         
         //$.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#requistions').DataTable({
           
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            ajax: absolute +'recruitment/getexternalvacancies',
            paging: true,
            columns: [
                { title: 'Job Description' ,data: 'Job_Description'},
                { title: 'No of Posts' ,data: 'No_of_Posts'},
                { title: 'Application Start Date' ,data: 'Start_Date'},
                { title: 'Application End Date' ,data: 'End_Date'},
                { title: 'No of Positions' ,data: 'No_of_Posts'},
                { title: 'Lenght of Contract' ,data: 'Contract_Period'},                
                { title: 'Action', data: 'action' },
                
               
            ] ,                              
           language: {
                "zeroRecords": "No Open Vacancies to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
    //    var table = $('#requistions').DataTable(
    //        {
        
    //        }
    //    );
       //table.columns([3,4,5,6,]).visible(false);
    
    /*End Data tables*/
        $('#requistions').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);






