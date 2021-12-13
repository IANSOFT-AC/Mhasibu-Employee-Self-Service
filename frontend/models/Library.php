<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Library extends Model
{


    public $Employee_no;
    public $Exit_no;
    public $Book_Description;
    public $Book_Worth;
    public $Line_No;
    public $Form_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Book_Description','Employee_no','Exit_no','Form_No','Book_Worth'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            
        ];
    }
}