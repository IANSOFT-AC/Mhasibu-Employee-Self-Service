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


class Dependant extends Model
{

public $Key;
public $Full_Name;
public $ID_Birth_Certificate_No;
public $Is_Student;
public $Date_of_Birth;
public $Age;
public $Relationship;
public $Gender;
public $Action;
public $Change_No;
public $Employee_No;
public $Line_No;
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

    public function getGender()
    {
        $changes = [
            ['Code' => '_blank_','Desc' => '_blank_'],
            ['Code' => 'Male' ,'Desc' =>'Male'],
            ['Code' => 'Female' ,'Desc' => 'Female'],
            ['Code' =>'Unknown' ,'Desc' => 'Unknown'],
        ];

        $data =  ArrayHelper::map($changes,'Code','Desc');

        return $data;
    }





}