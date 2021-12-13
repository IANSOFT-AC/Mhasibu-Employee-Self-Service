<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// print '<pre>';
// print_r($model); exit;


?>

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
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                                 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}
?>

<!-- Default box -->
<div class="card">
        <div class="card-header">
          <h3 class="card-title">Job Details</h3>
          <input id="JobId" name="prodId" type="hidden" value="<?=$model->Job_Id ?>">
          <input id="ProfileNo" name="prodId" type="hidden" value="<?= isset(Yii::$app->user->identity->profileID)?Yii::$app->user->identity->profileID:'' ?>">
        
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-1 order-md-2">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">No of Posts</span>
                      <span class="info-box-number text-center text-muted mb-0"><?=$model->No_Posts?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Reason for Advertisement</span>
                      <span class="info-box-number text-center text-muted mb-0"><?=$model->Reasons_For_Requisition ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Job Title</span>
                      <span class="info-box-number text-center text-muted mb-0"><?=$model->Job_Description ?> <span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h4>Responsibilities</h4>
                  <hr>
                  
                    <div class="post clearfix">
                        <?php if(!empty($model->Hr_Job_Responsibilities->Hr_Job_Responsibilities) && sizeof($model->Hr_Job_Responsibilities->Hr_Job_Responsibilities)): ?>
                          <p>
                                <?php
                                  
                                      echo '<ol>';
                                        foreach($model->Hr_Job_Responsibilities->Hr_Job_Responsibilities as $resp){

                                            if(!empty($resp->Responsibility_Description)){
                                                print '<li>'.$resp->Responsibility_Description.'</li>'; 
                                            // echo (Yii::$app->recruitment->Responsibilityspecs($resp->Line_No));
                                            }

                                        }
                                    
                                    echo ' </ol>';
                                    
                                ?>
                          </p>
                          <?php else: ?>
                            <p> No Job Responsibilities</p>
                        <?php endif; ?>
                    </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-12">
                  <h4>Requirements</h4>
                  <hr>
                  
                    <div class="post clearfix">
                      <?php if(!empty($model->Hr_job_requirements->Hr_job_requirements) && sizeof($model->Hr_job_requirements->Hr_job_requirements)): ?>

                        <p>
                          
                              <?php                
                                    echo '<ol>';
                                      foreach($model->Hr_job_requirements->Hr_job_requirements as $resp){

                                          if(!empty($resp->Requirment_Description)){
                                              print '<li>'.$resp->Requirment_Description.'</li>'; 
                                          // echo (Yii::$app->recruitment->Responsibilityspecs($resp->Line_No));
                                          }

                                      }
                                
                                  echo ' </ol>';
                                  
                              ?>
                        </p>
                        <?php else: ?>
                        <p>
                          No Job Requirements 
                        </p>
                      <?php endif; ?>
                    </div>
                </div>
              </div>
              <hr>

            </div>
            <div class="col-12 col-md-12 col-lg-4 order-2 order-md-1">
              <h3 class="text-primary"> <?=$model->Job_Description ?></h3>
              <p class="text-muted"> Job Description Here</p>
              <br>
             
              <div class="col-12">
                  <p class="lead">Other Details</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Application Start Date:</th>
                        <td> <?= !empty($model->Start_Date)? Yii::$app->formatter->asDate($model->Start_Date):'Not Set' ?> </td>
                      </tr>
                      <tr>
                        <th>Application End Date:</th>
                        <td><?= !empty($model->End_Date)? Yii::$app->formatter->asDate($model->End_Date):'Not Set' ?> </td> </td>
                      </tr>
                      <tr>
                        <th>Employment Type</th>
                        <td><?=$model->Employment_Type ?></td>
                      </tr>
                      <tr>
                        <th>Contract Period</th>
                        <td><?=$model->Contract_Period ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              <div class="text-center mt-5 mb-3">
                <!-- <a href="#" class="btn btn-sm btn-primary">Add files</a>
                <a href="#" class="btn btn-sm btn-warning">Report contact</a> -->
              </div>

              

            </div>
            
          </div>
          <div class="row ">

                <div class="col-6">
                  <a href="/recruitment/index" class="btn btn-md btn-primary float-left">Close</a>

                </div>

                <div class="col-6">

                <?=  \yii\helpers\Html::button('Apply',
                    [  'value' => \yii\helpers\Url::to(['leave/create',
                        ]),
                        'title' => 'New Leave Application Request',
                        'class' => 'btn btn-warning float-right ApplyButton',
                         ]
                    ); 

                    
               ?>

                </div>

                </div>
              
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->



<?php

$script = <<<JS

                    $('.ApplyButton').on('click', function(){
                            $.get('can-apply',
                              {'ProfileId': $('#ProfileNo').val(),
                              'JobId': $('#JobId').val()
                              }, function(response){
                                  console.log(response)

                                  if(response.error == 1){ //Does not Meet Conditions
                                    Swal.fire("Warning", response.eror_message , "warning");
                                    return false;
                                  }

                                  if(response.success == 1){ // Meets Conditions
                                    Swal.fire("success", response.success_message , "success");
                                    return false;
                                  }
                                 
                          });
   
                    });

                  //   $('.ApplyButton').on('click',function(e){
                  //     e.preventDefault();
                  //     var url = '/recruitment/can-apply?ProfileId='+ $('#ProfileNo').val()+'&JobId='+$('#JobId').val();
                  //     console.log('clicking...');
                  //     $('.modal').modal('show').find('.modal-body').load(url); 
                  //  });
        
        /*Handle dismissal eveent of modal */
        $('.modal').on('hidden.bs.modal',function(){
            var reld = location.reload(true);
            setTimeout(reld,1000);
        });

    /*Parent-Children accordion*/ 
    
    $('td.parent').find('span').text('+');
    $('td.parent').find('span').css({"color":"red", "font-weight":"bolder", "margin-right": "10px"});    
    $('td.parent').nextUntil('td.parent').slideUp(1, function(){});    
    $('td.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('td.parent').slideToggle(100, function(){});
     });
JS;

$this->registerJs($script);

