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


class ProffesionalQualifications extends Model
{
   public $Key;
   public $Employee_No;
   public $Professional_Examiner;
   public $From_Date;
   public $To_Date;
   public $Specialization;
   public $Attachement_path;
   public $Line_No;



    public function rules()
    {
        return [

            [['Employee_No', 'Professional_Examiner', 'From_Date','To_Date'],'required'],
            [['Attachement_path'],'file','mimeTypes' => Yii::$app->params['QualificationsMimeTypes']],
            [['Attachement_path'],'file','maxSize' => '5120000'],
            // ['Qualification_Code', 'string', 'min' => 5, 'max' => 150],

        ];
    }

    public function attributeLabels()
    {
        return [
            'To_Date' => 'Completion Date',
            'Employee_No' => 'Profile ID',
            'Attachement_path' => 'Qualification Attachment',
            'Professional_Examiner'=>'Examining Body',
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