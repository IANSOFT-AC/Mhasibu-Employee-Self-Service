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


class Changerequest extends Model
{

public $Key;
public $No;
public $Nature_of_Change;
public $Employee_No;
public $Employee_Name;
public $Approval_Entries;
public $Status;
public $Approval_Status;
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

    /*Get Dependant*/
    public function getDependants(){
        $service = Yii::$app->params['ServiceName']['EmployeeDepandants'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get Relatives*/

    public function getRelatives(){
        $service = Yii::$app->params['ServiceName']['EmployeeRelativesChange'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get Beneficiaries*/

    public function getBeneficiaries(){
        $service = Yii::$app->params['ServiceName']['EmployeeBeneficiariesChange'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get work History*/

    public function getWorkHistory(){
        $service = Yii::$app->params['ServiceName']['EmployeeWorkHistoryChange'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get Proffessional Bodies*/
    public function getProfessional(){
        $service = Yii::$app->params['ServiceName']['EmployeeProffesionalBodies'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get Qualifications*/

    public function getQualifications(){
        $service = Yii::$app->params['ServiceName']['EmployeeQualificationsChange'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }


    /*Get Emergency Contacts*/

    public function getEmergency(){
        $service = Yii::$app->params['ServiceName']['EmployeeEmergencyContacts'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Miscellaneous shit*/

    public function getMisc(){
        $service = Yii::$app->params['ServiceName']['Miscinformation'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Bio Data shit */

    public function getBiodata(){
        $service = Yii::$app->params['ServiceName']['EmployeeBioDataChange'];
        $filter = [
            'Change_No' => $this->No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }





/*Drop downs*/
    public function getChanges()
    {

        $changes = [    
            ['Code' => '_blank_','Desc' => '_blank_'],
            ['Code' => 'Bio_Data' ,'Desc' =>'Bio_Data'],
           // ['Code' => 'Next_Of_Kin' ,'Desc' => 'Next_Of_Kin',],
           // ['Code' =>'Asset_Assignment' ,'Desc' => 'Asset_Assignment'],
            ['Code' => 'Emergency_Contacts' ,'Desc' => 'Emergency_Contacts / Next of Kin'],
            ['Code' => 'Beneficiaries' ,'Desc' => 'Beneficiaries'],
            ['Code' => 'Medical_Dependants' ,'Desc' => 'Medical_Dependants'],
            ['Code' => 'Qualifications' ,'Desc' => 'Qualifications'],
            ['Code' => 'Proffesional_Bodies' ,'Desc' => 'Proffesional_Bodies'],
            ['Code' => 'Work_History' ,'Desc' => 'Work_History'],
           // ['Code' => 'Contract_Renewal','Desc' => 'Contract_Renewal'],
           // ['Code' => 'New_Contract' ,'Desc' => 'New_Contract'],
           // ['Code' => 'salary_Increment' ,'Desc' => 'salary_Increment']
        ];

        return ArrayHelper::map($changes,'Code','Desc');
    }



}