<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class ImprestSurrenderLines extends Model
{

   public $Key;
   public $Account_No;
   public $Account_Name;
   public $Description;
   public $Amount;
   public $Amount_LCY;
   public $Imprest_Amount;
   public $Global_Dimension_1_Code;
   public $Global_Dimension_2_Code;
   public $Sortcut_Dimension_3_Code;
   public $Request_No;
   public $Surrender;
   public $Budgeted_Amount;
   public $Commited_Amount;
   public $Total_Expenditure;
   public $Available_Amount;
   public $Unbudgeted;
   public $Line_No;
   public $isNewRecord;


    public function rules()
    {
        return [
            [['Amount_LCY', 'Description', 'Amount'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
    
                'Amount' => 'Actual Spent',
                'Imprest_Amount' => 'Imprest Amount'

        ];
    }
}