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


class Appraisalcard extends Model
{

public $Key;
public $Appraisal_No;
public $Employee_No;
public $Employee_Name;
public $Employee_User_Id;
public $Level_Grade;
public $Job_Title;
public $Appraisal_Period;
public $Appraisal_Start_Date;
public $Goal_Setting_Start_Date;
public $Goal_Setting_End_Date;
public $MY_Start_Date;
public $MY_End_Date;
public $EY_Start_Date;
public $EY_End_Date;
public $Goal_Setting_Status;
public $MY_Appraisal_Status;
public $EY_Appraisal_Status;
public $Supervisor_No;
public $Supervisor_Name;
public $Supervisor_User_Id;
public $Overview_Manager;
public $Overview_Manager_Name;
public $Overview_Manager_UserID;
public $Over_View_Manager_Comments;
public $Supervisor_Overall_Comments;
public $Overall_Score;
public $Is_Long_Term;
public $Recomended_Action;

public $Overview_Rejection_Comments;
public $Supervisor_Rejection_Comments;
public $Overview_Mid_Year_Comments;

public $Mid_Year_Overrall_rating;



    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'MY_End_Date' => 'Mid Year Appraisal End Date',
            'MY_Start_Date' => 'Mid Year Appraisal Start Date',
            'EY_End_Date' => 'End Year Appraisal End Date',
            'EY_Start_Date' =>  'End Year Start Date',
            'EY_Appraisal_Status' => 'End Year Appraisal Status',
            'MY_Appraisal_Status' => 'Mid Year Appraisal Status'


        ];
    }

    public function getKPI($KRA_Line_No){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPI'];
        $filter = [
            'Appraisal_No' => $this->Appraisal_No,
            'KRA_Line_No' => $KRA_Line_No
        ];

        $kpas = Yii::$app->navhelper->getData($service, $filter);
        return $kpas;
    }

    public function getAppraisalbehaviours($Category_Line_No){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalBehaviours'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_No,
            'Category_Line_No' => $Category_Line_No
        ];

        $behaviours = Yii::$app->navhelper->getData($service, $filter);
        return $behaviours;
    }

    public function getCareerdevelopmentstrengths($Goal_Line_No){
        $service = Yii::$app->params['ServiceName']['CareerDevStrengths'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_No,
            'Goal_Line_No' => $Goal_Line_No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result;
    }

    public function getWeaknessdevelopmentplan($Wekaness_Line_No){
        $service = Yii::$app->params['ServiceName']['WeeknessDevPlan'];
        $filter = [
            'Appraisal_No' => $this->Appraisal_No,
            'Wekaness_Line_No' => $Wekaness_Line_No
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result;
    }


    //get supervisor status

    public function isSupervisor()
    {

        return (Yii::$app->user->identity->{'Employee No_'} == $this->Supervisor_No);

    }


     public function isOverView()
    {

        return (Yii::$app->user->identity->{'Employee No_'} == $this->Overview_Manager);

    }

     public function isAppraisee()
    {
        
        return (Yii::$app->user->identity->{'Employee No_'} == $this->Employee_No);

    }





}