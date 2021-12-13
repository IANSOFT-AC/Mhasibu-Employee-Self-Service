<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Store extends Model
{


    public $Employee_no;
    public $Exit_no;
    public $Item_Description;
    public $Returned;
    public $Item_Worth;
    public $Line_No;
    public $Form_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Item_Description','Employee_no','Exit_no','Form_No','Item_Worth'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Number' => 'Item Cost',
        ];
    }
}