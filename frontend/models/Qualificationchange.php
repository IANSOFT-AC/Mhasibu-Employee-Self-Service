<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Qualificationchange extends Model
{


    public $Qualification_Code;
    public $Description;
    public $From_Date;
    public $To_Date;
    public $Institution_Company;
    public $Comment;
    public $Action;
    public $Employee_No;
    public $Line_No;
    public $Change_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['From_Date','To_Date','Institution_Company'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
                
        ];
    }
}