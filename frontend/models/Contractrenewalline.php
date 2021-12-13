<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Contractrenewalline extends Model
{

public $Key;
public $Contract_Code;
public $Contract_Description;
public $Contract_Start_Date;
public $Contract_Period;
public $Contract_End_Date;
public $Notice_Period;
public $Employee_Title;
public $Job_Title;
public $Line_Manager;
public $Manager_Name;
public $Department;
public $Pointer;
public $Grade;
public $Salary;
public $New_Salary;
public $Status;
public $Change_No;
public $Line_No;
public $Employee_No;
public $Job_Code;
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