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


class Contractrenewal extends Model
{

public $Key;
public $Status;
public $No;
public $Employee_No;
public $Employee_Name;
public $Approval_Entries;
public $Approval_Status;

public $Craeted_By;
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

    public function getLines(){
        $service = Yii::$app->params['ServiceName']['ContractRenewalLines'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }


    public function getDonorLine($Contract_Code,$Contract_Line_No) {
        $service = Yii::$app->params['ServiceName']['NewEmployeeDonors'];
        $filter = [
            'Change_No' => $this->No,
            'Employee_No' => $this->Employee_No,
            'Contract_Code' => $Contract_Code,
            'Contract_Line_No' => $Contract_Line_No
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;
    }



}