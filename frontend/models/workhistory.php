<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Workhistory extends Model
{


    public $Work_Done;
    public $Institution_Company;
    public $From_Date;
    public $To_Date;
    public $Key_Experience;
    public $Salary_on_Leaving;
    public $Reason_For_Leaving;
    public $Comments;
    public $Change_No;
    public $Action;
    public $Employee_No;
    public $Line_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['From_Date','To_Date','Institution_Company','Work_Done','Key_Experience'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
                
        ];
    }
}