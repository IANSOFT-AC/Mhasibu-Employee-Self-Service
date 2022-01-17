<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class Academic extends Model
{
    public $Key;
    public $Employee_No;
    public $Level;
    public $Academic_Qualification;
    public $From_Date;
    public $To_Date;
    public $Description;
    public $Institution_Company;
    public $Comment;
    public $Attachement_path;
    public $Line_No;
    public $Type;
    public $Nature;
    public $attachment;



    public function rules()
    {
        return [

            [['Employee_No', 'Level','From_Date','To_Date'],'required'],
            ['Description', 'string', 'max' => 250],
            [['attachment'],'file','mimeTypes' => Yii::$app->params['QualificationsMimeTypes']],
            [['attachment'],'file','maxSize' => '5120000'], //50mb
        ];
    }

    public function attributeLabels()
    {
        return [
            'To_Date' => 'Completion Date',
            'Employee_No' => 'Profile ID',
            'Attachement_path' => 'Qualification Attachment',
            'Level'=>' Academic Level',
            'Academic_Qualification'=>'Academic Qualification',
            'Institution_Company'=>'Institution'
        ];
    }

    public function upload()
    {
        if ($this->validate('Attachement_path')) {
            $this->Attachement_path->saveAs('qualifications/' . str_replace(' ','',$this->Attachement_path->baseName) . '.' . $this->Attachement_path->extension);
            $this->Attachement_path = 'qualifications/'.str_replace(' ','',$this->Attachement_path->name);
            //You can then attach to sharepoint and unlink the resource on local file system

           // Yii::$app->recruitment->sharepoint_attach($this->Attachement_path);
            return true;
        } else {
            return $this->getErrors();
        }
    }


}