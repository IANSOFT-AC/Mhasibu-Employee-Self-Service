<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class ProbationAnswer extends Model
{

public $Key;
public $Line_No;
public $Appraisal_No;
public $Employee_No;
public $Question_Line_No;
public $Answer;
public $isNewRecord;

    public function rules()
    {
        return [
            ['Answer', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
                
        ];
    }


}