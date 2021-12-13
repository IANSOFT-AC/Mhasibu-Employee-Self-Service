<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class Biodata extends Model
{

public $Key;
public $Line_No;
public $Change_No;
public $Employee_No;
public $Phone_Number;
public $Personal_E_mail;
public $Passport_No;
public $Status;
public $isNewRecord;



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