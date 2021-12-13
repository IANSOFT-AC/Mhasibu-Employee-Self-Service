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


class Imprestsurrendercard extends Model
{

public $Key;
public $No;
public $Employee_No;
public $Employee_Name;
public $Imprest_No;
public $Purpose;
public $Employee_Balance;
public $Surrender_Amount;
public $Claim_Amount;
public $Status;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Posting_Date;
public $Receipt_No;
public $Receipt_Amount;
public $Approval_Entries;
public $Account_Type;
public $Paying_Bank;
public $Paying_Bank_Name;
public $Bank_Balance;
public $Pay_Mode;
public $Cheque_No;
public $EFT_No;
public $Request_For;
public $isNewRecord;
public $Created_On;
    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
            [['Request_For', 'Employee_No', 'Imprest_No'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Program',
            'Global_Dimension_2_Code' => 'Department'
        ];
    }

    public function getLines(){
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderLines'];
        $filter = [
            'Request_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
       return $lines;


    }



}