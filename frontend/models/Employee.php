<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace frontend\models;


use yii\base\Model;
use Yii;

class Employee extends Model
{
    public $Key;
    public $Allocated_Leave_Days;
    public $ProfileID;
    public $CBS_Member_Id;
    public $Inpatient_Cover_Balance;
    public $Outpatient_Cover_Balance;
    public $Employee_Relatives;
    public $Manager;
    public $Flout_1_3_Rule;
    public $Pay_Via_Waumini;
    public $EFT_Format;
    public $Is_Long_Term;
    public $No;
    public $Title;
    public $First_Name;
    public $Middle_Name;
    public $Last_Name;
    public $Full_Name;
    public $Gender;
    public $Country_Region_Code;
    public $County_of_Origin;
    public $Sub_County;
    public $Location;
    public $Sub_Location;
    public $Village;
    public $National_ID;
    public $Passport_Number;
    public $Marital_Status;
    public $Ethnic_Origin;
    public $Religion;
    public $Driving_License;
    public $Health_Conditions;
    public $Phone_No;
    public $Alternative_Phone_No;
    public $E_Mail;
    public $Company_E_Mail;
    public $City;
    public $Address;
    public $Post_Code;
    public $Address_2;
    public $ShowMap;
    public $Alt_Address_Code;
    public $Birth_Date;
    public $Age;
    public $Employment_Date;
    public $Service_Period;
    public $Period_To_Retirement;
    public $End_of_Probation_Period;
    public $Probabtion_Extended_By;
    public $New_Probation_Period_End_Date;
    public $Reasons_For_Extension;
    public $Contract_Start_Date;
    public $Contract_End_Date;
    public $Date_of_joining_Medical_Scheme;
    public $Grade;
    public $Pointer;
    public $Job_Title;
    public $Job_Description;
    public $Global_Dimension_1_Code;
    public $Global_Dimension_2_Code;
    public $Global_Dimension_3_Code;
    public $Global_Dimension_4_Code;
    public $Global_Dimension_5_Code;
    public $Probation_Period_Extended;
    public $Notice_Period;
    public $Probation_Status;
    public $Manager_No;
    public $Overview_Manager;
    public $User_ID;
    public $Long_Term;
    public $Cause_of_Inactivity_Code;
    public $Termination_Date;
    public $Grounds_for_Term_Code;
    public $Suspend_Leave_Application;
    public $Nature_Of_Employment;
    public $Disabled;

    public $Line_Manager_Name;
    public $Overview_Manager_Name;
    public $Grant_Approver_Name;



    public $Disability_Id;
    public $Status;
    public $Covered_Medically;
    public $Payment_Methods;
    public $Currency;
    public $KRA_Number;
    public $NHIF_Number;
    public $NSSF_Number;
    public $Employee_Posting_Group;
    public $Bank_Code;
    public $Bank_Name;
    public $Bank_Branch_No;
    public $Branch_Name;
    public $Bank_Account_No;

    public $Payroll_Grade;
    public $Probation_Period;
    public $Global_Dimension_6_Code;
    public $Grant_Approver;

    public $_x002B_;

    public $Type_of_Employee;
    public $Allien_Number;
    public $Starting_Date;

    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Program Code',
            'Global_Dimension_2_Code' => 'Department Code',
            'Global_Dimension_3_Code' => 'Section Code',
            'Global_Dimension_4_Code' => 'Unit',
            'Global_Dimension_5_Code' => 'Location',
            'Job_Description' => 'Job Title',
            'Job_Title' => 'Job Code'
        ];
    }

    

}