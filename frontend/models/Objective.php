<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Objective extends Model
{
public $Line_No;
public $Appraisal_No;
public $Employee_No;
public $KRA;
public $Overall_Rating;
public $Total_Weigth;
public $Maximum_Weight;
public $Key;
public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'KRA' => 'Key Result Area',
            'New_Emp_Comments' => 'Appraisee Comment',
            'New_Emp_Supervisor_Rating' => 'Supervisor Rating',
            'New_Emp_Supervisor_Comment' => 'Supervisor Comment',
            'New_Emp_Hr_Rating' => 'HR Rating',
            'New_Emp_Hr_Comments' => 'HR Comments'
        ];
    }


    public function getKpi(){
        $service = Yii::$app->params['ServiceName']['ProbationKPIs'];
        $filter = [
            'KRA_Line_No' => $this->KRA_Line_No,
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result;
    }
}