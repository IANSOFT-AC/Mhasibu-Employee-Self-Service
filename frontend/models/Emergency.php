<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Emergency extends Model
{


   public $Full_Name;
   public $Relationship;
   public $Phone_No;
   public $Email_Address;
   public $Action;
   public $Line_No;
   public $Change_No;
   public $Employee_No;
   public $Key;
   public $isNewRecord;

    public function rules()
    {
        return [
            [['Full_Name','Relationship','Phone_No'], 'required'],
            ['Email_Address', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
                
        ];
    }
}