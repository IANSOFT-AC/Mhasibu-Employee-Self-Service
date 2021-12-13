<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'];
$this->params['breadcrumbs'][] = ['label' => 'Exit Form List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Clearance Status', 'url' => ['clearance_status']];
$url = \yii\helpers\Url::home(true);
?>
<!--<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
        <?php /*\yii\helpers\Html::a('New Change Request',['create'],['class' => 'btn btn-info push-right', 'data' => [
            'confirm' => 'Are you sure you want to create a new Request?',
            'method' => 'get',
        ],]) */?>
            </div>
        </div>
    </div>
</div>-->


<?php
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
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Clearance Status</h3>

            </div>
            <div class="card-body">
                <div class="responsive-table">
                    <table class="table table-bordered dt-responsive table-hover">
                        <thead>
                            <tr>
                                <!-- <td>Exit No</td>
                                <td>Form_No</td>
                                <td>Employee_No</td> -->
                                <td>Clearing Employee</td>
                                <td>Clearing Employee Name</td>
                                <td>Section</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            foreach($model as $status):
                                $cleared = (!empty($status->Status) && $status->Status == 'Cleared')?'text-success text-bold':'';
                                ?>
                                    <tr class="<?= $cleared ?>">
                                        <!-- <td><?= !empty($status->Exit_No)?$status->Exit_No:''  ?></td>
                                        <td><?= !empty($status->Form_No)?$status->Form_No:'' ?></td>
                                        <td><?= !empty($status->Employee_No)?$status->Employee_No:'' ?></td> -->
                                        <td><?= !empty($status->Clearing_Employee)?$status->Clearing_Employee:'' ?></td>
                                        <td><?= !empty($status->Clearing_Employee_Name)?$status->Clearing_Employee_Name:'' ?></td>
                                        <td><?= !empty($status->Section)?$status->Section:'' ?></td>
                                        <td><?= !empty($status->Status)?$status->Status:'' ?></td>
                                    </tr>
                            <?php endforeach;

                                
                             ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

    <input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
         // $.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'exit-form/list',
            paging: true,
            columns: [
                { title: 'No' ,data: 'No'},
                { title: 'Exit_No' ,data: 'Exit_No'},
                { title: 'Employee_No' ,data: 'Employee_No'},
                { title: 'Employee_Name' ,data: 'Employee_Name'},
                { title: 'Action', data: 'Action' },
                               
            ] ,                              
           language: {
                "zeroRecords": "No Exit Form to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
      // table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    table td:nth-child(7), td:nth-child(8), td:nth-child(9) {
        text-align: center;
    }
CSS;

$this->registerCss($style);







