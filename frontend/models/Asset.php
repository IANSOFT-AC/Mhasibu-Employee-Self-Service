<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Asset extends Model
{


    public $Employee_No;
    public $Misc_Article_Code;
    public $Description;
    public $Asset_Number;
    public $Condition;
    public $Returned;
    public $Value_on_Return;
    public $Line_No;
    public $Exit_no;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Description','Employee_No','Exit_no','Value_on_Return'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Number' => 'Item Cost',
        ];
    }
}