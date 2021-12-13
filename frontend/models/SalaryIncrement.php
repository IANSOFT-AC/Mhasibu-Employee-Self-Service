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


class SalaryIncrement extends Model
{

public $Key;
public $No;
public $Employee_No;
public $Employee_Name;
public $Current_Grade;
public $Current_Pointer;
public $Current_Salary_Grade;
public $New_Grade;
public $New_Pointer;
public $New_Salary_Grade;
public $Approval_Entries;
public $isNewRecord;
public $Approval_Status;

    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
            [['Amount_Requested','Loan_Type','Purpose'], 'required'],
            ['Amount_Requested','integer','min'=> 1]
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }

    public function getLines(){
        $service = Yii::$app->params['ServiceName']['ContractChangeLines'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
       return $lines;
    }



}