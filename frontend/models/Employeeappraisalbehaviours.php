<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Employeeappraisalbehaviours extends Model
{
public $Line_No;
public $Category_Line_No;
public $Employee_No;
public $Appraisal_Code;
public $Behaviour_Name;
public $Applicable;
public $Current_Proficiency_Level;
public $Expected_Proficiency_Level;
public $Behaviour_Description;
public $Self_Rating;
public $Appraiser_Rating;
public $Peer_1;
public $Peer_2;
public $Agreed_Rating;
public $Overall_Remarks;
public $Appraisee_Remark;
public $Peer_1_Remark;
public $Peer_2_Remark;


public $Weight;
public $Agree;
public $Disagreement_Comments;

public $Mid_Year_Agreement;
public $Mid_Year_Disagreement_Comments;
public $Mid_Year_Employee_Rating;
public $Mid_Year_Supervisor_Rating;
public $Mid_Year_Employee_Comments;
public $Mid_Year_Supervisor_Comments;

public $Key;
public $isNewRecord;

public $Level;


    public function rules()
    {
        return [
                ['Weight', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            
        ];
    }
}