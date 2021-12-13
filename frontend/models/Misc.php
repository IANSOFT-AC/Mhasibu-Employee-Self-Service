<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Misc extends Model
{


    public $Misc_Article_Code;
    public $Description;
    public $From_Date;
    public $To_Date;
    public $Serial_No;
    public $Asset_Number;
    public $Change_No;
    public $Action;
    public $Employee_No;
    public $Key;
    public $isNewRecord;
    public $Value;

    public function rules()
    {
        return [
            [['Description','From_Date','To_Date','Asset_Number','Misc_Article_Code','Value','Serial_No'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
                'From_Date' => 'Date of Issue',
                'To_Date' => 'Return Date',
        ];
    }
}