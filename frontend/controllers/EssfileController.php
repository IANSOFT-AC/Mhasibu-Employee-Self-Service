<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Essfile;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\web\Response;

class EssfileController extends Controller
{
    public function actionIndex()
    {
        $model = new Essfile();

        if (Yii::$app->request->isPost) {
            $model->File_Name = Yii::$app->request->post()['Essfile']['File_Name'];
            $model->attachmentfile = UploadedFile::getInstance($model, 'docFile');
            if ($model->upload()) {
                // file is uploaded successfully
                $this->redirect(['index']);
            }
        }

        return $this->render('index', ['model' => $model]);
    }


    public function actionRead($No)
    {
       $model = new Essfile();
       $content = $model->read($No);

       /*print '<pre>';
       print_r($content);
       exit;*/

       return $this->render('read',['content' => $content]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['ESS_Files'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        
        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Document Deleted Successfully.');
            $this->redirect(['index']);
        }else{
           Yii::$app->session->setFlash('error', 'Error Deleting Document:  '.$result);
            $this->redirect(['index']);
        }
    }



    public function actionList(){
        $model = new Essfile();

        $results = $model->attachments;

        $result = [];
        foreach($results as $item){
           
                if(empty($item->File_Name))
                {
                    continue;
                }
            
                $link = Html::a('<i class="fas fa-paper-plane mx-1"></i>',['read','No'=> $item->Line_No ],['title'=>'Read File','class'=>'btn btn-primary btn-xs']);
                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['delete','Key'=> $item->Key],['class'=>'btn btn-danger btn-xs']);

                 $docLink = Html::a($item->File_Name,['read','No'=> $item->Line_No],['class'=>'btn btn-success btn-xs','target'=> '_blank']);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'File_Name' => $docLink,
                'view' => $link.$deleteLink
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

}