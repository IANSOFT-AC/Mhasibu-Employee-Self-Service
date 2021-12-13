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


class Overtimeline extends Model
{

public $Key;
public $Date;
public $Start_Time;
public $End_Time;
public $Hours_Worked;
public $Work_Done;
public $Application_No;
public $Employee_No;
public $Line_No;
public $isNewRecord;
public $Nature_of_Application;
public $Normal_Work_Start_Time;
public $Normal_Work_End_Time;
public $Line_Amount;
public $Department;


    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
            [['Date','Start_Time','End_Time','Work_Done', 'Nature_of_Application', 'Department'], 'required'],
            // ['Start_Time',  'format' =>'php:HH:mm'],

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }





}