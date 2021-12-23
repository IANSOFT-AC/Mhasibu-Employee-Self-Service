<?php
return [
    'generalTitle' => 'Employee - Self Service',
    'welcomeText' => 'Mhasibu Sacco Self Service Portal',
    'ClientCompany' => 'KEMRI WELLCOME TRUST ', //branding
    'demoCompany' => 'IANSOFT LTD',
    'VendorCompany' => 'IANSOFT TECHNOLOGIES LTD',
    'ltAppraisalHeader' => 'Long Term Performance Appraisal',
    'stAppraisalHeader' => 'Short Term Performance Appraisal',
    'probAppraisalHeader' => 'Probation Performance Appraisal',
    'adminEmail' => 'customer@softeboard.com',
    'supportEmail' => 'customer@softeboard.com',
    'senderEmail' => 'customer@softeboard.com',
    'senderName' => 'HRMIS mailer',
    'user.passwordResetTokenExpire' => 3600,
    'powered' => 'Iansoft Ltd',
    'NavisionUsername'=>env('NavisionUsername'),
    'NavisionPassword'=> env('NavisionPassword'),

    

    'server'=>env('server'),
    'WebServicePort'=>env('WebServicePort'),
    'ServerInstance'=>env('ServerInstance'),
    'CompanyName'=> env('CompanyName'),
    'DBCompanyName' => env('DBCompanyName'),
    'ldPrefix'=> '', //env('ldPrefix'),
    'adServer' => env('adServer'),

    //FMS CREDENTIALS

    'FMSUsername'=> 'DESKTOP-NBDBNIL\Admin', 
    'FMSPassword'=> 'iansoft', 

    // FMS ERP Configs

    'FMS-server' => 'keklf-fin05.kwtrp.org',
    'FMS-WebServicePort' => '7047',// '6048',
    'FMS-ServerInstance' => 'FmsLIVE',//'TEST',
    'FMS-CompanyName' => 'KEMRI%20Wellcome%20Trust',


    //sharepoint config
    'sharepointUrl' => '',//'https://ackads.sharepoint.com',
    'sharepointUsername' => '',//'francis@ackads.onmicrosoft.com',
    'sharepointPassword' => '',// Sp password
    'library' => '',// Sharepoint Library,
    'clientID' => '7e92ce54-e4bf-491a-bef6-eb94044ce297', // SP App Client ID
    'clientSecret' => 'Q6UJkB3bRlPkGBjWNgrQVCyyjL2vgi5rtP7THpLwJ+s=', // SP Client Secret

    'profileControllers' => [
        'applicantprofile',
        'experience',
        'qualification',
        'hobby',
        'language',
        'referee',
        'recruitment',
        'employeerequisition'
    ],
    'codeUnits' => [
        //'Portal_Workflows', //50019
        'JobApplication', //50002
        'AppraisalWorkflow', //50228 ********
        'PortalReports', //50064
        //'ContractRenewalStatusChange', // 50024
        'PortalFactory', // 50062
        'ImprestManagement', // 50017
        'EmployeeExitManagement',
        'HRAppraisalManagement', // 50209
    ],


    'SystemConfigs' => [
        'UsingNTLM' => env('UsingNTLM'),
    ],

    'ServiceName'=>[

        /**************************IMPREST*************************************/
        'ImprestRequestList' => 'ImprestRequestList', //64020 (Page)
        'ImprestRequestCard' => 'ImprestRequestCard', //64021 (Page)
        'ImprestRequestLine' => 'ImprestRequestLine', //64022 (Page)
        'ImprestRequestSubformPortal' => 'ImprestRequestSubformPortal', //64039


        'ImprestRequestListPortal' => 'ImprestRequestListPortal', //64028 (Page)
        'ImprestRequestCardPortal' => 'ImprestRequestCardPortal', //64029 (Page)

        'ImprestSurrenderList' => 'ImprestSurrenderList', // 64030 (Page)
        'ImprestSurrenderCard' => 'ImprestSurrenderCard', // 64031 (Page)
        'ImprestSurrenderCardPortal' => 'ImprestSurrenderCardPortal', //64059 (Page)
        'PostedImprestRequest' => 'PostedImprestRequest', //64026 (Page)
        'PostedReceiptsList' => 'PostedReceiptsList',//64056 (Page)

        'ImprestSurrenderLines'=>'ImprestSurrenderLines', //64032 Page



        /**************************Leave Plan*************************************/

        'LeavePlanList' => 'LeavePlanList', //50025
        'LeavePlanCard' => 'LeavePlanCard', //50028
        'LeavePlanLine' => 'LeavePlanLine', //50029

        /**************************Leave *************************************/

        'LeaveCard' => 'LeaveCard', //50011
        'LeaveList' => 'LeaveList', //50013
        'LeaveTypesSetup' => 'LeaveTypesSetup', // 50024
        'LeaveBalances' => 'LeaveBalances',//50041
        'LeaveRecallList' => 'LeaveRecallList', // 50065
        'LeaveRecallCard' => 'LeaveRecallCard', // 50064
        'LeaveAttachments' => 'LeaveAttachments', //50031


        /***************Leave Reimbursement*********************/

        'LeaveReimbursementList' => 'LeaveReimbursementList', // 50094
        'LeaveReimbursementCard' => 'LeaveReimbursementCard', //50095


        /************************** Fund Requisition *************************************/

        'AllowanceRequestList' => 'AllowanceRequestList', //64093(Page)
        'AllowanceRequestCard' => 'AllowanceRequestCard', // 64094(Page)
        'AllowanceRequestLine' => 'AllowanceRequestLine', //64095 (Page)
        'AllowanceRequestPendingApp' => 'AllowanceRequestPendingApp', //64096 (Page)
        'ApprovedAllowanceRequest' => 'ApprovedAllowanceRequest', //64097 (Page)
        'RejectedAllowanceRequest' => 'RejectedAllowanceRequest', //64098 (Page)
        'PostedAllowanceRequest' => 'PostedAllowanceRequest', // 64099 (Page)
        'RequisitionRates' => 'RequisitionRates', //65019 (Page)



        /**************************SALARY ADVANCE*************************************/

        'SalaryAdvanceList' => 'SalaryAdvanceList', //58027
        'SalaryAdvanceCard' => 'SalaryAdvanceCard', //58028
        'StaffLoans' => 'StaffLoans', //58031
        'SalaryAdvancePurpose' => 'SalaryAdvancePurpose', //64027



        /**************************Overtime*************************************/

        'OvertimeList' => 'OvertimeList', //50037
        'OvertimeCard' => 'OvertimeCard', //50038
        'OvertimeLine' => 'OvertimeLine', // 55027

        /**************************Medical Cover *************************************/

        'MedicalCoverList' => 'MedicalCoverList', //58022
        'MedicalCoverCard' => 'MedicalCoverCard', //58021
        'MedicalCoverTypes' => 'MedicalCoverTypes', //50049

        'Currencies' => 'Currencies', // Page 5
        'purchaseDocumentLines'=>'purchaseDocumentLines',//6405
        'UserSetup' => 'UserSetup', //119

        'EmployeeCard' => 'EmployeeCard', //50096
        'ExpetriateCard' => 'ExpetriateCard', // 52021
        'Employees' => 'Employees', //5201
        'EmpBeneficiaries' => 'EmpBeneficiaries',

        'DimensionValueList' => 'DimensionValueList', //560
        'PaymentTypes' => 'PaymentTypes', //64058

        'leaveApplicationList' => 'leaveApplicationList', // 71053
        'leaveApplicationCard' => 'leaveApplicationCard', //71075
        //'leaveBalance' => 'leaveBalance',//71153
        'leaveTypes' => 'leaveTypes', //70045
        'leaveRecallCard' => 'leaveRecallCard',//71076
        'leaveRecallList' => 'leaveRecallList',//71077
        'activeLeaveList' => 'activeLeaveList',//69005

        
        'ApprovalComments' => 'ApprovalComments', //660
        'RejectedApprovalEntries' => 'RejectedApprovalEntries', //50003

        'RequisitionEmployeeList' => 'RequisitionEmployeeList',//70029
        'RequisitionEmployeeCard' => 'RequisitionEmployeeCard',//70028


        /**********Active COGI PAGES*****************/

        'JobsList' => 'JobsList',//55057 --> Approved Requisitions
        'JobsCard' => 'JobsCard',//55055
        'RequirementSpecification'=> 'RequirementSpecification', //55049
        'ResponsibilitySpecification' => 'ResponsibilitySpecification', //55048
        'EducationQualifications'=>'EducationQualifications',//55064
        'EducationLevel'=>'EducationLevel', //55084
        'AcademicQualification'=>'AcademicQualification', //55085
        'ProffesionalQualifications'=>'ProffesionalQualifications', //55087
        'ProffesionalExaminers'=>'ProffesionalExaminers', //55086

        /**********Active COGI PAGES*****************/
        'JobApplicantProfile' => 'JobApplicantProfile', //55081
        'referees' => 'referees',//55060
        'applicantLanguages' => 'applicantLanguages', //55061
        'experience' => 'experience', //55062
        'hobbies' => 'hobbies', //55063
        'qualifications' => 'qualifications',//55064
        'JobResponsibilities' => 'JobResponsibilities',//69000 -->specs //Not in Tenwek
        'JobRequirements' => 'JobRequirements', //69001 ---> specs //Not in Tenwek
        'JobExperience' => 'JobExperience',//69004 //Not in Tenwek
        'Qualifications' => 'Qualifications', //5205
        'JobApplicantRequirementEntries' => 'JobApplicantRequirementEntries', //55065
        'HRJobApplicationsList' => 'HRJobApplicationsList', //70020 ----> Not published on client side
        'HRJobApplicationsCard'=>'HRJobApplicationsCard',//55059
        'JobApplicationList'=>'JobApplicationList', //55058

        'Countries' => 'Countries', //10
        'Religion' => 'Religion', //70085 //Not in Tenwek

        'HRTrainers' => 'HRTrainers', //56015

        //Appraisal--------------------------------------------------------------------------------
        'AppraisalRating' => 'AppraisalRating',//60023
        'AppraisalProficiencyLevel' => 'AppraisalProficiencyLevel', //60025
        'AppraisalList' => 'AppraisalList', //60007
        'AppraisalCard' => 'AppraisalCard',//60008
        'EmployeeAppraisalKPI' => 'EmployeeAppraisalKPI', //60010 --->Employee objectives
        'SubmittedAppraisals' => 'SubmittedAppraisals', //60012
        'ApprovedAppraisals' => 'ApprovedAppraisals', //60013 -- overview goal setting
        'MYAppraiseeList' => 'MYAppraiseeList',//60014
        'MYSupervisorList' => 'MYSupervisorList',//60015
        'MYAgreementList' => 'MYAgreementList', //60036
        
        'MYApprovedList' => 'MYApprovedList',//60016
        'EYAppraiseeList' => 'EYAppraiseeList',//60017
        'EYSupervisorList' => 'EYSupervisorList',//60018
        'EYPeer1List' => 'EYPeer1List',//60019 --- EY Overview List
        'EYPeer2List' => 'EYPeer2List',//60020 ---MY overview list
        'EYAgreementList' => 'EYAgreementList',//60021
        'ClosedAppraisalsList' => 'ClosedAppraisalsList',//60022

        'CareerDevelopmentPlan' => 'CareerDevelopmentPlan', //60038 -->Not Taken to live server NF
        'CareerDevStrengths' => 'CareerDevStrengths', //60039 -->Not Taken to live server
        'FurtherDevAreas' => 'FurtherDevAreas', //60040 -->Not Taken to live server
        'WeeknessDevPlan' => 'WeeknessDevPlan', //60041 -->Not Taken to live server
        'AppraisalTrainingNeed' => 'AppraisalTrainingNeed', //60086

        'SupervisorList' =>'SupervisorList', // 51005


        /*Probation*/
        'ObjectiveSettingList' => 'ObjectiveSettingList', // 60064
        'ProbationCard' => 'ProbationCard', //60065
        'LnManagerObjList' => 'LnManagerObjList',//60066
        'ProbationOverviewObjList' => 'ProbationOverviewObjList', // 60067
        'ProbationAppraiseeList' => 'ProbationAppraiseeList', // 60068
        'ProbationLnmanagerList' => 'ProbationLnmanagerList',// 60069
        'ProbationAgreementList' => 'ProbationAgreementList', //60071
        'OverviewSupervisorList' => 'OverviewSupervisorList', //60070
        'ClosedProbationAppraisal' => 'ClosedProbationAppraisal', //60072
        'ProbationKRAs' => 'ProbationKRAs', //60001
        'ProbationKPIs' => 'ProbationKPIs', //60002

        'EmployeeAppraisalAnswers' => 'EmployeeAppraisalAnswers', //60044
        'Resolution' => 'Resolution', //60087
        'ProbationHRList' => 'ProbationHRList', //60073


        /*Performance Improvement Program  - PIP*/

        'PIPCard' => 'PIPCard', // 60075
        'PIPAppraiseeList' => 'PIPAppraiseeList', //60076
        'PIPSupervisorList' => 'PIPSupervisorList', //60077
        'PIPAgreementList' => 'PIPAgreementList', //60079
        'PIPOverviewList' => 'PIPOverviewList', //60078
        'PIPClosedAppraisals' => 'PIPClosedAppraisals', //60080


        /*Short Term Probation*/

        'StObjectiveSettingList' => 'StObjectiveSettingList', // 60055
        'StProbationCard' => 'StProbationCard', //60056
        'StLnManagerObjList' => 'StLnManagerObjList',//60057
        'StProbationOverviewObjList' => 'StProbationOverviewObjList', // 60058
        'StProbationAppraiseeList' => 'StProbationAppraiseeList', // 60059
        'StProbationLnmanagerList' => 'StProbationLnmanagerList',// 60060
        'StProbationAgreementList' => 'StProbationAgreementList', //60062
        'StOverviewSupervisorList' => 'StOverviewSupervisorList', //60070
        'StOverviewList' => 'StOverviewList', // 60061 
        'StClosedProbationAppraisal' => 'StClosedProbationAppraisal', //60063
        'StProbationKRAs' => 'StProbationKRAs', //60001
        'StProbationKPIs' => 'StProbationKPIs', //60002
        'StEmployeeAppraisalCompetence' => 'StEmployeeAppraisalCompetence',//60033
        'StAreasofFurtherDev' => 'StAreasofFurtherDev', // 60040
        'ESS_Files' => 'ESS_Files',// 50097


        /*Appraisal List*/

        'ProbationStatusList' => 'ProbationStatusList', //60083
        'ShortTermStatusList' => 'ShortTermStatusList', //60084
        'LongTermAppraisal_Status' => 'LongTermAppraisal_Status', //60085



        'AppraisalWorkflow' => 'AppraisalWorkflow', // 50228 ---> Code Unit************************
        'PerformanceLevel' => 'PerformanceLevel',//60037 page

        'EmployeeAppraisalKRA' => 'EmployeeAppraisalKRA',//60009
        'TrainingPlan' => 'TrainingPlan', //60036*************************** NOT AVAILABLE *********
        'EmployeeAppraisalCompetence' => 'EmployeeAppraisalCompetence',//60033
        'EmployeeAppraisalBehaviours' => 'EmployeeAppraisalBehaviours', //60034
        'LearningAssessmentCompetence' => 'LearningAssessmentCompetence', //60035



        /*********************KEMRI CHANGE REQUEST************************************************/

        'ChangeRequestList' => 'ChangeRequestList', // 55014 -Page Emp Change Request List
        'ChangeRequestCard' => 'ChangeRequestCard', // 55015 -Page
        'EmployeeDepandants' => 'EmployeeDepandants', //50077
        'EmployeeRelativesChange' => 'EmployeeRelativesChange', // 50072
        'EmployeeBeneficiariesChange' => 'EmployeeBeneficiariesChange', //50073 ---No. instead of Line_No
        'EmployeeWorkHistoryChange' => 'EmployeeWorkHistoryChange', //50074
        'EmployeeProffesionalBodies' => 'EmployeeProffesionalBodies', // 50075
        'EmployeeQualificationsChange' => 'EmployeeQualificationsChange', //50079
        'EmployeeEmergencyContacts' => 'EmployeeEmergencyContacts', //50078
        'Miscinformation' => 'Miscinformation', //50080
        'Relatives' => 'Relatives', //5208
        'Professional' => 'Professional', //50071
        'Qualifications' => 'Qualifications', //5205
        'MiscArticles' => 'MiscArticles', //5218
        'EmployeeBioDataChange' => 'EmployeeBioDataChange', // 50103 



        /**********************KEMRI Salary Increment****************************************/

        'SalaryIncrementList' => 'SalaryIncrementList', // 55025
        'SalaryIncrementCard' => 'SalaryIncrementCard', // 55026
        'ContractChangeLines' => 'ContractChangeLines', //55018
        'PayrollScales' => 'PayrollScales', //58014
        'PayrollScalePointers' => 'PayrollScalePointers', //58023
        'ApprovedHRJobs' => 'ApprovedHRJobs', //55053
       



        /**********************KEMRI EXMPLOYEE EXIT*********************************************/

        'ExitList' => 'ExitList', //52002
        'ExitListCard' => 'ExitListCard', // 52003
        'FinalDues' => 'FinalDues', // 52034
        'ExitReasons' => 'ExitReasons', //52007

        'ClearanceFormList' => 'ClearanceFormList', //52025
        'ClearanceFormCard' => 'ClearanceFormCard', //52026
        'LibraryClearanceLines' => 'LibraryClearanceLines', //52027
        'LabClearanceLines' => 'LabClearanceLines', //52029
        'ICTClearanceLines' => 'ICTClearanceLines', //52030
        'StoreCLearanceForm' => 'StoreCLearanceForm', //52031
        'AssignedAssetsClearance' => 'AssignedAssetsClearance', //52033 --Asset Lines
        'ClearanceStatus' => 'ClearanceStatus', // 52035

        'AssetAssignmentList' => 'AssetAssignmentList', //55030
        'AssetAssignmentCard' => 'AssetAssignmentCard', //55031

        'SecurityClearanceForm' => 'SecurityClearanceForm', //52037
        'TrainingClearanceForm' => 'TrainingClearanceForm', // 52038
        'PayrollClearanceForm' => 'PayrollClearanceForm', //52039
        'PersonalAccountClearance' => 'PersonalAccountClearance', //52040
        'ArchivesClearance' => 'ArchivesClearance', //52041


        'EmployeeExitManagement' => 'EmployeeExitManagement', //50233 - CodeUnit--------------




        /*Vehicle Requisitions*/

        'BookingRequisitionList' => 'BookingRequisitionList', //70014
        'BookingRequisitionDocument' => 'BookingRequisitionDocument', //70012
        'BookingRequisitionPortal' => 'BookingRequisitionPortal',//70056
        'BookingRequisitionLine' => 'BookingRequisitionLine', //70013
        'ApprovedBookingRequisition' => 'ApprovedBookingRequisition', // 70020
        'AvailableVehicleLookUp' => 'AvailableVehicleLookUp', //70021
        'VehicleAvailabilityStatus' => 'VehicleAvailabilityStatus', // 70022


         /********Vehicle Repair Requisition ********************/

        'RepairRequisitionDocument' => 'RepairRequisitionDocument', // 70009
        'RepairRequisitionLine' => 'RepairRequisitionLine', // 70010
        'RepairRequisitionList' => 'RepairRequisitionList', // 70011
        'RepairsStatusMonitoring' => 'RepairsStatusMonitoring', //70015


        /********Fuelling **********/

        'FuelingDocumentPortal' => 'FuelingDocumentPortal', // 70055
        'FuelingList' => 'FuelingList', // 70008
        'FuelingLine' => 'FuelingLine', // 70007

        /********Work Tickets********************/

        'WorkTicketList' => 'WorkTicketList', // 70005
        'WorkTicketDocument' => 'WorkTicketDocument', //70003
        

        'Payrollperiods' => 'Payrollperiods', //58002

        //P9 report

        'P9YEARS' => 'P9YEARS', //50067

        /* Request to Approve */
        'RequeststoApprove' => 'RequeststoApprove', //654
        'RequestsTo_ApprovePortal'=> 'RequestsTo_ApprovePortal', // 67123
        'ApprovalCommentsWeb' => 'ApprovalCommentsWeb', // 50068


        /* Contract Renewal Services ---------------NOT PUBLISHED on live vm */

        'ContractRenewalList' => 'ContractRenewalList', //55016
        'ContractRenewalCard' => 'ContractRenewalCard', //55017
        'ContractRenewalLines' => 'ContractRenewalLines', //55018
        'EmployeeContracts' => 'EmployeeContracts', //5217

        'EmployeeDonors' => 'EmployeeDonors', //57993
        'NewEmployeeDonors' => 'NewEmployeeDonors', //57994
        'DonorList' => 'DonorList', // 60054
        'GrantActivity' => 'GrantActivity', //57995
        'GrantTypes' => 'GrantTypes', // 57996




        /**************************STORE REQUISITION*************************************/

        'StoreRequisitionList' => 'StoreRequisitionList', //66080
        'StoreRequisitionCard' => 'StoreRequisitionCard', //66081
        'StoreRequisitionLine' => 'StoreRequisitionLine', //66082
        'Locations' => 'Locations', //15
        'Items' => 'Items', //32

        /***************************PURCHASE REQUISITION**********************************/

        'PurchaseRequisitionList' => 'PurchaseRequisitionList', // 66090
        'PurchaseRequisitionCard' => 'PurchaseRequisitionCard', // 66091
        'PurchaseRequisitionLine' => 'PurchaseRequisitionLine', // 66092
        'Institutions' => 'Institutions', //90003
        'GLAccountList' => 'GLAccountList', //18
        'PostalCodes'=>'PostalCodes',

        /**************************Work Ticket****************************************/


        /************************************Drg Issuance*********************************/

        'prescriptionsIssueList' => 'prescriptionsIssueList', //66119
        'PrescriptionIssueLines' => 'PrescriptionIssueLines', //66120
        'PrescriptionIssueCard' => 'PrescriptionIssueCard', // 66121
        'IssuedPrescriptionsList' => 'IssuedPrescriptionsList', //66122


         /********************GRANTS SERVICE***************************************/

         'GrantList' => 'GrantList', // 60054

        /********************CODE UNITS SERVICES***************************************/
        'PortalFactory' => 'PortalFactory', //Code Unit 50062
        'ImprestManagement' => 'ImprestManagement', // 50017
        'Portal_Workflows' => 'Portal_Workflows', //50019 Approval code unit
        'JobApplication' => 'JobApplication', //50002 Job Aplication Management Code Unit
        'PortalReports' => 'PortalReports',//50064
        'HRAppraisalManagement' => 'HRAppraisalManagement', // 50209



    ],
    'QualificationsMimeTypes' => [

        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template'

    ],
    'Microsoft' => [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'application/vnd.ms-word.document.macroEnabled.12',
        'application/vnd.ms-word.template.macroEnabled.12',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.template.macroEnabled.12',
        'application/vnd.ms-excel.addin.macroEnabled.12',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.template',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'application/vnd.ms-access',
        'application/rtf',
        'application/octet-stream'
    ],

    'LeavemaxUploadFiles' => 1,
    'MimeTypes' => [
        //'application/msword',
        //'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        //'application/octet-stream',
        'application/pdf'
    ],
    'ActiveModules' => [
        'Recruitment' => 1,
        'ApprovalManagement' => 1,
        'LeaveManagement' => 1,
        'ChangeManagement' => 1,
        'SalaryAdvance' => 1,
        'OvertimeManagement' => 1,
        'HR-Reports' => 1,
        'LongTermAppraisal' => 1,
        'ProbationAppraisal' => 1,
        'ShortTermAppraisal' => 1,
        'PIPAppraisal' => 1,
        'ContractRenewal' => 1,
        'EmployeeExit' => 1,

    ],

    'FMS-ServiceName' => [
        'FMSGrants' => 'FMSGrants'
    ],


];
