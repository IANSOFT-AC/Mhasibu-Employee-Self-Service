<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Relative extends Model
{


    public $Relative_Code;
    public $First_Name;
    public $Middle_Name;
    public $Last_Name;
    public $Phone_No;
    public $Relative_x0027_s_Employee_No;
    public $Birth_Date;
    public $Age;
    public $ID_Birth_Certificate_No;
    public $Gender;
    public $Action;
    public $Change_No;
    public $Employee_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['First_Name','Middle_Name','Last_Name','Phone_No','Birth_Date','Gender'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
                'Relative_x0027_s_Employee_No' => 'Relative\'s Employee No',
                'Relative_Code' => 'Relationship',
        ];
    }
}