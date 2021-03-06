<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->params['breadcrumbs'][] = $this->title;

?>


        <h2 class="text text-dark my-4">Log in to start your session</h2>


            <?php $form = ActiveForm::begin(['id' => 'login-form']);

                    if(Yii::$app->session->hasFlash('success'))
                    {
                        print '<div class="alert alert-success">'.Yii::$app->session->getFlash('success').'</div>';
                    }

                    if(Yii::$app->session->hasFlash('error')){
                         print '<div class="alert alert-danger">'.Yii::$app->session->getFlash('error').'</div>';
                    }

            ?>

                <?= $form->field($model, 'username',[
                    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span>{input}</div>',
                    ])
                    ->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Username',
                            'autocomplete' => 'off'
                    ])
                    ->label(false)
?>



                <?= $form->field($model, 'password',[
                    'inputTemplate' => '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span>{input}</div>'
                    ])->passwordInput([
                            'Placeholder' => 'Password',
                            'autocomplete' => 'off'
])
                        ->label(false)
?>



                <?php $form->field($model, 'rememberMe')->checkbox() ?>


                <!--<div class="form-group">

                     <?/*= '<p class="text-white">Click  here to '. Html::a('Reset Password', ['/site/request-password-reset'],['class' => '']). '.</p>' */?>
                </div>-->

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-warning', 'name' => 'login-button']) ?>

                   <!-- <?/*= '<p class="text-white">Click  here to '. Html::a('resend', ['/site/resend-verification-email'],['class' => '']). ' verification token .</p>' */?>

                    <?/*= '<p class="text-white">Don\'t have an account?  '. Html::a('signup', ['/site/signup'],['class' => '']). ' here .</p>' */?>
               --> </div>

    <?php ActiveForm::end(); ?>



<?php
$directory = Yii::getAlias('@frontend').'/web/background';
@chdir($directory);
$images = glob("*.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE);


$random_img = $images[array_rand($images)];



$style = <<<CSS
    body{
        background: #342F7C;
    }
    
    header > .logo{
        background:  #fff;
        max-width: 450px;
        padding: 10px;
    }

    .logo img{
        max-width: 430px;
    }

    h1.mhasibu-main  {
        color: #BFC035;
    }

    

    main {
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: space-between;
        color: #fff;
    }

    .form-content {
        width: 55%;
        padding: 2rem 1rem;
        border: 1px solid #fff;
        border-radius: 20px;
        background: #fff;
    }

    footer {
        position: absolute;
        display: block;
        bottom: 0px;
        height: 4rem;
        width: 100%;
        color: #fff;
        background: #AB502A;
    }

    @media (max-width: 760px) {
        main {
            flex-direction: column;
            justify-content: center;
            padding: auto;
        }

        .form-content{
            width: 100%;
        }

         p.tagline {
            display: none;
        }

        p.together {
            font-size: 20px;
            margin: 20px 30px;
        }

        footer {
            position: relative;
        }
    }




    .login-page { 
          background: url("../../background/$random_img") no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
         

    }


    .top-logo {
        display: flex;
        margin-left: 10px;
       
    }
     .top-logo img { 
                width: 120px;
                height: auto;
                position: absolute;
                left: 15px;
                top:15px;
                
          
            }
     .login-logo a  {
        color: #ffffff!important;
        font-family: sans-serif, Verdana;
        font-size: larger;
        font-weight: 400;
        text-shadow: 2px 2px 8px #21baff;

     }

    input.form-control {
        border-left: 0!important;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border: 1px solid #f6c844;
    }
    
    span.input-group-text {
        border-right: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border: 1px solid #f6c844;
    }
    
   .card {
    background-color: rgba(0,0,0,.6);
   }
   
   .login-card-body {
     background-color: rgba(0,0,0,.1);
   }

    
    
CSS;

$this->registerCss($style);






    






