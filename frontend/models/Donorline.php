<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Donorline extends Model
{

public $Key;
public $Grant_Code;
public $Grant_Name;
public $Grant_Activity;
public $Grant_Type;
public $Grant_Start_Date;
public $Grant_End_Date;
public $Percentage;
public $Grant_Status;
public $Employee_No;
public $Contract_Code;
public $Change_No;
public $Contract_Line_No;
public $Line_No;
public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}