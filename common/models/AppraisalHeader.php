<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 1/4/2021
 * Time: 3:16 PM
 */

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Model;


class AppraisalHeader extends ActiveRecord
{
    public static function tableName()
    {
        return Yii::$app->params['DBCompanyName'].'Appraisal Header ';
    }

    public static function getDb(){
        return Yii::$app->nav;
    }
}