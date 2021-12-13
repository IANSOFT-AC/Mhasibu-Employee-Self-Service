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


class ExitForm extends Model
{

public $Key;
public $Form_No;
public $Exit_No;
public $Employee_No;
public $Employee_Name;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Global_Dimension_3_Code;
public $Global_Dimension_4_Code;
public $Global_Dimension_5_Code;
public $Action_ID;
public $Library_Clearance_Lines;
public $Lab_Clearance_Lines;
public $ICT_Clearance_Lines;
public $Store_CLearance_Form;
public $Assigned_Assets_Clearance;

public $Ict_Unpaid;
public $Library_Unpaid;
public $Lab_Unpaid;
public $Security_Uncleared_Item;
public $Payroll_Uncleared_Items;
public $Personal_Account_Uncleared;
public $Archives_Uncleared_Items;
public $HOD_Comments;
public $ED_Comments;
public $HR_Comments;





    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Division',
            'Global_Dimension_2_Code' => 'Department',
            'Global_Dimension_3_Code' => 'Section',
            'Global_Dimension_4_Code' => 'Unit',
            'Global_Dimension_5_Code' => 'Location',
            'Ict_Unpaid' => 'ICT Dues',
            'Library_Unpaid' => 'Library Dues',
            'Lab_Unpaid' => 'Lab Dues',
            'Security_Uncleared_Item' => 'Security Dues',
            'Payroll_Uncleared_Items' => 'Payroll Dues',
            'Personal_Account_Uncleared' => 'Personal Dues',
            'Archives_Uncleared_Items' => 'Archives Dues',


        ];
    }

    /*Get Library Clearance Lines*/
    public function getLibrary(){
        $service = Yii::$app->params['ServiceName']['LibraryClearanceLines'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }



    // get Archive Lines

     public function getArchives(){
        $service = Yii::$app->params['ServiceName']['ArchivesClearance'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }




    /*Get Lab Lines*/

    public function getLab(){
        $service = Yii::$app->params['ServiceName']['LabClearanceLines'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get ICT lINES*/

    public function getICT(){
        $service = Yii::$app->params['ServiceName']['ICTClearanceLines'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get Store Clearance Lines */

    public function getStore(){
        $service = Yii::$app->params['ServiceName']['StoreCLearanceForm'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /* Get Assigned Assets Lines*/
    public function getAssets(){
        $service = Yii::$app->params['ServiceName']['AssignedAssetsClearance'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    /*Get Security*/

    public function getSecurity(){
        $service = Yii::$app->params['ServiceName']['SecurityClearanceForm'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }


    /*Get Training*/

    public function getTraining(){
        $service = Yii::$app->params['ServiceName']['TrainingClearanceForm'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }


    /*get Payroll*/

     public function getPayroll(){
        $service = Yii::$app->params['ServiceName']['PayrollClearanceForm'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }



    /*Get Personal */

    public function getPersonal(){
        $service = Yii::$app->params['ServiceName']['PersonalAccountClearance'];
        $filter = [
            'Exit_no' => $this->Exit_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }


    /*gET Sacco*/


    /*Get Human Resources*/







/*Drop downs*/
    public function getChanges()
    {

        $changes = [
            ['Code' => '_blank_','Desc' => '_blank_'],
            ['Code' => 'Bio_Data' ,'Desc' =>'Bio_Data'],
            ['Code' => 'Next_Of_Kin' ,'Desc' => 'Next_Of_Kin',],
            ['Code' =>'Asset_Assignment' ,'Desc' => 'Asset_Assignment'],
            ['Code' => 'Emergency_Contacts' ,'Desc' => 'Emergency_Contacts'],
            ['Code' => 'Beneficiaries' ,'Desc' => 'Beneficiaries'],
            ['Code' => 'Medical_Dependants' ,'Desc' => 'Medical_Dependants'],
            ['Code' => 'Qualifications' ,'Desc' => 'Qualifications'],
            ['Code' => 'Proffesional_Bodies' ,'Desc' => 'Proffesional_Bodies'],
            ['Code' => 'Work_History' ,'Desc' => 'Work_History'],
            ['Code' => 'Contract_Renewal','Desc' => 'Contract_Renewal'],
            ['Code' => 'New_Contract' ,'Desc' => 'New_Contract'],
            ['Code' => 'salary_Increment' ,'Desc' => 'salary_Increment']
        ];

        return ArrayHelper::map($changes,'Code','Desc');
    }

    // Check section clearance Status

    public function CheckStatus($section)
    {
        $service = Yii::$app->params['ServiceName']['ClearanceStatus'];

        if($section == 'Lab')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'ICT')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Store')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            // return $result[0]->Status == 'Cleared'?'text-success':'';

            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Library')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            // return $result[0]->Status == 'Cleared'?'text-success':'';

             if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Archives')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status

            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }

        }
        elseif($section == 'Assets')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Training')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Security')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Payroll')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        elseif($section == 'Personal_Account')
        {
            $filter = [
                'Form_No' => $this->Form_No,
                'Section' => $section,
            ];
            //Get Status
            $result = Yii::$app->navhelper->getData($service, $filter);
            if(is_array($result)){
                return $result[0]->Status == 'Cleared'?'text-success':'';
            }else{
                return false;
            }
        }
        else{
            return false;
        }
    }


    public function getClearingEmployee()
    {
        $service = Yii::$app->params['ServiceName']['ClearanceStatus'];

        $filter = [
            'Exit_No' => $this->Exit_No ,
            'Form_No' => $this->Form_No ,
            'Employee_No' => $this->Employee_No,
            'Section' => $this->Action_ID
        ];

        $result = Yii::$app->navhelper->getData($service, $filter);

        return $result[0];
    }

    public function getAllowed()
    {
        $allowed = ['HOD','Human_Resources','Executive_Director','Security'];
        return $allowed;
    }

    public function getSequence()
    {
        $service = Yii::$app->params['ServiceName']['EmployeeExitManagement'];
        $result = Yii::$app->navhelper->codeunit($service,['formNo' => $this->Form_No],'IanGetNextSequence');

       if(!is_string($result))
       {
        return $result['return_value'];
       }

       return false;
    }


    



}