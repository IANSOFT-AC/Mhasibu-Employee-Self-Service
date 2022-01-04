<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Training extends Model
{

    public $Application_No;
    public $Training_Need;
    public $Date_of_Application;
    public $Training_Calender;
    public $Training_Need_Description;
    public $Employee_No;
    public $Employee_Name;
    public $Job_Group;
    public $Job_Title;
    public $Status;
    public $Start_Date;
    public $End_Date;
    public $Period;
    public $Expected_Cost;
    public $Trainer;
    public $Exceeds_Expected_Trainees;
    public $Training_Start_Date;
    public $isNewRecord;
    public $Key;

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