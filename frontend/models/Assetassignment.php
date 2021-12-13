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


class Assetassignment extends Model
{

public $Key;
public $No;
public $Employee_No;
public $Employee_Name;
public $Approval_Status;
public $Craeted_By;
public $isNewRecord;



    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }

    

    /*Miscellaneous shit*/

    public function getMisc(){
        $service = Yii::$app->params['ServiceName']['Miscinformation'];
        $filter = [
            'Change_No' => $this->No,
            //'Employee_No' => $this->Employee_No
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

   








}