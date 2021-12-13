<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


    <div class="col-md-12">
            <div class="card card-grey">
                <!-- <div class="card-header">
                    <h3 class="card-title">Submit Application </h3>
                </div> -->

                <div class="card-body">
                     <h4 class="alert alert-info">Kindly, Mark if you meet following qualifications.</h4>

                <table class="table table-hover table-bordered">
                    <thead>
                        <th>Requirement Specification</th>
                        <th>Met</th>

                    </thead>
                    <tbody>
                        <?php
                            foreach($Requirements as $req){
                                print '<tr>
                                        <td>'.$req->Requirement_Specification.'</td>
                                        <td>'.Html::checkbox('requirement',$req->Met,['rel'=> $req->Key,'rev' => $req->Line_No]).'</td>
                                    </tr>';
                            }
                        ?>
                    </tbody>



                </table>
                <input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">

                <?= Html::a('Complete Application',['applicantprofile/update','No' => $ProfileId],['class' => 'btn btn-success','style' => 'margin-top: 10px']);?>
                </div>

                <?php

$script = <<<JS
     $(function(){
         $('.submit').hide();
        $('.confirm').click(function(){
            if($(this).is(':checked')){
                //alert('checked..');
                $('.submit').show();
            }else{
                $('.submit').hide();
            }
        });
        
        //Marking the checklist
        var absolute = $('input[name=absolute]').val();
        $('input[name=requirement]').on('click', function(e){
            //e.preventDefault();
            var key = $(this).attr('rel');
            var Line_No = $(this).attr('rev');
            $.post(absolute+'recruitment/requirementscheck',{"Key": key,"Line_No": Line_No }).done(function(msg){
                console.log(msg);
            });
            // location.reload();
        });
    });
JS;

$this->registerJs($script);

           