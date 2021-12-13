<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/11/2020
 * Time: 3:51 AM
 */

namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Essfile extends Model
{

    /**
     * @var UploadedFile
     */
public $Line_No;
public $Name;
public $File_path;
public $Key;
public $attachmentfile;
public $docFile;
public $File_Name;
public $File_Path;


    public function rules()
    {
        return [
            [['attachmentfile'],'file','maxFiles'=> Yii::$app->params['LeavemaxUploadFiles']],
            [['attachmentfile'],'file','mimeTypes'=> Yii::$app->params['MimeTypes']],
            [['attachmentfile'],'file','maxSize' => '5120000'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'docFile' => 'File to Upload',
            'File_Name' => 'File Description',
        ];
    }

    public function upload($docId=false)
    {
        $model = $this;

        $imageId = Yii::$app->security->generateRandomString(8);

        $imagePath = Yii::getAlias('@frontend/web/ess_attachments/'.$imageId.'.'.$this->attachmentfile->extension);

        if($model->validate()){
            // Check if directory exists, else create it
            if(!is_dir(dirname($imagePath))){
                FileHelper::createDirectory(dirname($imagePath));
            }

            $this->attachmentfile->saveAs($imagePath);

            //Post to Nav
          
            
                $service = Yii::$app->params['ServiceName']['ESS_Files'];
                $model->File_path = basename($imagePath) ;
                $model->File_Name = $model->File_Name;

                $data = [
                    'File_Path' => basename($imagePath),
                    'File_Name' => $model->File_Name
                ];
                 
                $result = Yii::$app->navhelper->postData($service, $data);

                
                if(is_string($result)){
                        Yii::$app->session->setFlash('error',$result);
                        return false;
                }else{
                    Yii::$app->session->setFlash('success', 'File Uploaded Successfully.');
                    return true;
                }
           
           
        }else{
            return false;
            print '<Pre>';
            print_r($model->getErrors());
            
        }
    }

    public function getPath($DocNo=''){
        if(!$DocNo){
            return false;
        }
        $service = Yii::$app->params['ServiceName']['ESS_Files'];
        $filter = [
            'Document_No' => $DocNo
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)) {
            return basename($result[0]->File_path);
        }else{
            return false;
        }

    }

    public function read($DocNo)
    {
        $service = Yii::$app->params['ServiceName']['ESS_Files'];
        $filter = [
            'Line_No' => $DocNo
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);

        /*print '<pre>';
        print_r($result); exit;*/


        $path = $result[0]->File_Path;
        $imagePath = Yii::getAlias('@frontend/web/ess_attachments/'. $path);


        if(is_file($imagePath))
        {
            $binary = file_get_contents($imagePath);
            $content = chunk_split(base64_encode($binary));
            return $content;
        }
    }

    public function getAttachments()
    {

        $service = Yii::$app->params['ServiceName']['ESS_Files'];
       

        $result = Yii::$app->navhelper->getData($service,[]);
        if(is_array($result)){
            return $result;
        }else{
            return false;
        }

    }

    public function getFileProperties($binary)
    {
        $bin  = base64_decode($binary);
        $props =  getImageSizeFromString($bin);
        return $props['mime'];
    }
}