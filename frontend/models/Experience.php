<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Experience extends Model
{
    public $Job_Application_No;
    public $Position;
    public $Job_Description;
    public $Institution;
    public $Period;
    public $Start_Date;
    public $End_Date;
    public $Key;
    public $Line_No;
    public $No_of_People_Reporting_to_You;  
    public $Reporting_To;
    public $Job_Responsibility;
    public $Currently_Working_Here;

    public function rules()
    {
        return [
            [['Start_Date', 'End_Date', 'Institution','Position','Job_Description', 'Job_Responsibility'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Job_Description' => 'Job Description',
            'No_of_People_Reporting_to_You' => 'No. of People Reporting To You',
            'Job_Responsibility'=>'Job Responsibility',
            'Currently_Working_Here'=> 'I am currently working in this role'
        ];
    }
}