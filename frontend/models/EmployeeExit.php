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
use yii\helpers\ArrayHelper;


class EmployeeExit extends Model
{

public $Key;
public $Exit_No;
public $Employee_No;
public $Employee_Name;
public $Job_Title;
public $Job_Description;
public $Payroll_Grade;
public $Global_Dimension_1_Code;
public $Status;
public $Date_of_Exit;
public $Interview_Conducted_By;
public $Reason_For_Exit;
public $Reason_Description;
public $Notice_Period;
public $Date_Of_Notice;
public $Expiry_of_Notice;
public $Date_of_Exit_Interview;
public $Notice_Fully_Served;
public $Reasons_For_Not_Serving_Notice;
public $isNewRecord;



    public function rules()
    {
        return [
                ['Date_of_Exit', 'required'],

                ['Reasons_For_Not_Serving_Notice', 'required', 'when' => function($model) {
                        return $model->Notice_Fully_Served == 'No';
                    }, 'whenClient' => "function (attribute, value) {
                        return $('#employeeexit-notice_fully_served').val() == 'No';
                    }"
                ],
               


        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Department Code'
        ];
    }

    /*Get Dues*/
    public function getDues(){
        $service = Yii::$app->params['ServiceName']['FinalDues'];
        $filter = [
            'Exit_No' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }




}