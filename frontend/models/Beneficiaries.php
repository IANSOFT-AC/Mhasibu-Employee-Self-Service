<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Beneficiaries extends Model
{


  public $Full_Names;
  public $Type;
  public $Relationship;
  public $ID_Birth_Certificate_No;
  public $Phone_No;
  public $Email_Address;
  public $Date_of_Birth;
  public $Age;
  public $Gender;
  public $Comments;
  public $Percentage;
  public $Action;
  public $New_Allocation;
  public $No;
  public $Employee_No;
  public $Change_No;
  public $Key;
  public $isNewRecord;

    public function rules()
    {
        return [
            [['Full_Names','Relationship','Phone_No','Gender','New_Allocation'], 'required'],
            ['Email_Address', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
                
        ];
    }
}