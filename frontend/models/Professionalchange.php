<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Professionalchange extends Model
{


    public $Body_Code;
    public $Name;
    public $From_Date;
    public $To_Date;
    public $Action;
    public $Membership_No;
    public $Change_No;
    public $Line_No;
    public $Employee_No;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['From_Date','To_Date','Body_Code','Membership_No'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
                
        ];
    }
}