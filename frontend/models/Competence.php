<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Competence extends Model
{
public $Line_No;
public $Appraisal_Code;
public $Employee_Code;
public $Category;
public $Maximum_Weigth;
public $Overal_Rating;
public $Total_Weigth;

public $Mid_Year_Overall_Rating;


public $Key;
public $isNewRecord;

    public function rules()
    {
        return [
            [['Category'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Maximum_Weigth' => 'Maximum_Weight'
        ];
    }


}