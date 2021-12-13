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


    public $Employee_no;
    public $Exit_no;
    public $Line_No;
    public $Item_Description;
    public $Item_Worth;
    public $Form_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Item_Description','Employee_no','Exit_no','Form_No'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Number' => 'Item Cost',
        ];
    }
}