<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Employeeappraisalkpi extends Model
{


    public $Appraisal_No;
    public $Employee_No;
    public $Objective;
    public $Weight;
    public $Mid_Year_Appraisee_Assesment;
    public $Mid_Year_Appraisee_Comments;
    public $Mid_Year_Supervisor_Assesment;
    public $Mid_Year_Supervisor_Comments;
    public $Appraisee_Self_Rating;
    public $Employee_Comments;
    public $Appraiser_Rating;
    public $End_Year_Supervisor_Comments;
    public $Agree;
    public $Disagreement_Comments;
    public $KRA_Line_No;
    public $Line_No;
    public $Due_Date;
    public $Move_To_PIP;
    public $Key;
    public $isNewRecord;

    public $Target;
    public $Target_Status;
    public $Non_Achievement_Reasons;

    public $Mid_Year_Agreement;
    public $Mid_Year_Disagreement_Comment;

    public function rules()
    {
        return [
            [['Appraisal_No','Employee_No','Objective','Objective'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}