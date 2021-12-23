<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Resolution extends Model
{

    public $Appraisal_No;
    public $Employee_No;
    public $Line_No;
    public $Resolution;
    public $Key;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['Appraisal_No','Employee_No'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            
        ];
    }


}