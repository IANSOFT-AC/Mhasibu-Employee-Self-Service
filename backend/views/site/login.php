<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->params['breadcrumbs'][] = $this->title;
?>
  <div class="card-body login-card-body">

            <?php $form = ActiveForm::begin(['id' => 'login-form']);
                if(Yii::$app->session->hasFlash('success'))
                {
                    print '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
                }?>

               

                <?= $form->field($model, 'email',[
                        'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span>{input}</div>',
                    ])->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Email'
                        ])->label(false) ?>

                <?= $form->field($model, 'password',[
                        'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span>{input}</div>'
                        ])->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>


                <div style="color:#999;margin:1em 0; display: none">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    <?= Html::a('signup', ['signup'],['class' => 'btn btn-warning']) ?>

                    <?= Html::a('Reset Password', ['request-password-reset'],['class' => 'btn btn-warning']) ?>
                </div>

            <?php ActiveForm::end(); ?>
 </div>








    






