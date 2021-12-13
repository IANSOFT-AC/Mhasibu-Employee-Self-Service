<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/4/2020
 * Time: 12:06 PM
 */

namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

class LeaveReimburse extends Model
{

    public $Key;
    public $Employee_No;
    public $Employee_Name;
    public $_x003C_Global_Dimension_1_Code_x003E_;
    public $Global_Dimension_2_Code;
    public $Application_No;
    public $Application_Date;
    public $User_ID;
    public $Leave_Code;
    public $Leave_Type_Decription;
    public $Days_To_Reimburse;
    public $Leave_balance;
    public $Balance_After;
    public $Comments;
    public $Phone_No;
    public $E_Mail_Address;
    public $Grade;
    public $Status;
    public $Approval_Entries;
    public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_x003C_Global_Dimension_1_Code_x003E_' => 'Program Code',
            'Global_Dimension_2_Code' => 'Department Code',
        ];
    }


}