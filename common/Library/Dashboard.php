<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:27 PM
 */

namespace common\library;
use yii;
use yii\base\Component;
use common\models\Hruser;


class Dashboard extends Component
{

    public function getStaffCount(){
        $service = Yii::$app->params['ServiceName']['Employees'];
        $filter = [];
        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result fails
            return false;
        }
        return count($result);
    }

    /*My Rejected Approval Requests*/

    public function getRejectedApprovals(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Sender_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter results to false
            return 0;
        }
        return count($result);
    }

    /* My Approved Requests */

    public function getApprovedApprovals(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Sender_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    /* Get Pending Approvals */

    public function getOpenApprovals(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Sender_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Open'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }



    /*Request I have approved*/

    public function getSuperApproved(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Approver_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /* Requests I have Rejected */

    public function getSuperRejected(){

        $service = Yii::$app->params['ServiceName']['RequestsTo_ApprovePortal'];
        $filter = [
            'Approver_No' => Yii::$app->user->identity->{'Employee No_'},
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /*Get Number of job vacancies available*/

    public function getVacancies(){
        return 0;
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
            'No_of_Posts' => '>0',

        ];
        $res = [];
        $result = Yii::$app->navhelper->getData($service,$filter);
        foreach($result as $req){
            $RequisitionType = Yii::$app->recruitment->getRequisitionType($req->Job_ID);
            if(($req->No_of_Posts >= 0 && !empty($req->Job_Description) && !empty($req->Job_ID)) && ($RequisitionType == 'Internal' || $RequisitionType == 'Both' ) ) {
                $res[] = $req->Job_Description;
            }
        }

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($res);
    }

    /*Get Staff on Leave*/

    public function getOnLeave(){
        return 0;
        $service = Yii::$app->params['ServiceName']['activeLeaveList'];
        $filter = [];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    //Get Number of Job Applications made by an AAS  employee

    public function getInternalapplications(){
        return 0;
        if(!Yii::$app->user->isGuest){
            $srvc = Yii::$app->params['ServiceName']['employeeCard'];
            $filter = [
                'No' => Yii::$app->user->identity->employee[0]->No
            ];
            $Employee = Yii::$app->navhelper->getData($srvc,$filter);
            if(empty($Employee[0]->ProfileID)){
                return 0;
            }
            $profileID = $Employee[0]->ProfileID;

        }else{ //if for some reason this check is called by a guest ,return false;
            return 0;
        }

        $service = Yii::$app->params['ServiceName']['HRJobApplicationsList'];
        $filter = [
            'Applicant_No' => $profileID
        ];
        $result = \Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the result is false
            return 0;
        }
        return count($result);

    }


    /*Get no. Probation Appraisals*/


     public function getProbations(){

        $service = Yii::$app->params['ServiceName']['ProbationStatusList'];
        $filter = [
           
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    /*Get no of short term probations*/

    public function getShortterms(){

        $service = Yii::$app->params['ServiceName']['ShortTermStatusList'];
        $filter = [
           
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /* Get no. of Long Term Probations*/


     public function getLongterms(){

        $service = Yii::$app->params['ServiceName']['LongTermAppraisal_Status'];
        $filter = [
           
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    public function getAppraisalStatus()
    {
         $service = Yii::$app->params['ServiceName']['PortalFactory'];
         $data = [
            'empNo' => Yii::$app->user->identity->{'Employee No_'}
         ];

         $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanGetAppraisalStatus');

         if(!is_string($result))
         {
            return $result['return_value'];
         }
         else{
            return 'We have no idea, Sorry';
         }
    }

    // Exists in PIP Appraisee list

     public function inAppraiseePIPList(){

        $service = Yii::$app->params['ServiceName']['PIPAppraiseeList'];
        $filter = [
           'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    // Exists in pip supervisor list

    public function inSupervisorPIPList(){

        $service = Yii::$app->params['ServiceName']['PIPSupervisorList'];
        $filter = [
           'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


        // Exists in supervisor list

    public function inSupervisorList(){

        $service = Yii::$app->params['ServiceName']['SupervisorList'];
        $filter = [
           'Emp_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

     // Exists in pip overview list

     public function inOverviewPIPList(){

        $service = Yii::$app->params['ServiceName']['PIPOverviewList'];
        $filter = [
           'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    // Exists in pip Agreement list

    public function inAgreementPIPList(){

        $service = Yii::$app->params['ServiceName']['PIPAgreementList'];
        $filter = [
           'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    // Exists in pip Closed list

    public function inClosedPIPList(){

        $service = Yii::$app->params['ServiceName']['PIPClosedAppraisals'];
        $filter = [
           'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }



}