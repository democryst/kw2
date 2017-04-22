<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
/*
if(isset($_POST['form_name'])){
$form_name = $_POST['form_name'];
$form_description = "description";

$adminid = 2;
*/
//$state_array = $_POST['state_array'];
$user_id = $_POST['userid'];

$wfrequestid_arr = $_POST['wf_requestid'];
sort($wfrequestid_arr);
$wfrequestid_arr2 = array_values(array_unique($wfrequestid_arr));
$wfrequestid = $wfrequestid_arr2[0];

$wfrequestdetailid_arr= $_POST['stateid_arr'];
sort($wfrequestdetailid_arr);
$wfrequestdetailid_arr2 = array_values(array_unique($wfrequestdetailid_arr));
$wfrequestdetailid = $wfrequestdetailid_arr2[0];

$WFDocID_arr = $_POST['WFDocID_arr'];

// $sys_adminid = 3;

$upload_destination = "../uploads/";

$pathname;


$date_hrs = date("h-i-s");
$date_day = date("Y-m-d");
// $all_date = $date_hrs . '***' . $date_day;
// if(!isset($_POST['all_date'])){die("all_date lost");}
// $all_date = $_POST['all_date'];
// $wfgeninfoID = $_POST['wfgeninfo'];

if(isset($_FILES['file_array'])){


	$name_array = $_FILES['file_array']['name'];
	$tmp_name_array = $_FILES['file_array']['tmp_name'];
	$type_array = $_FILES['file_array']['type'];
	$size_array = $_FILES['file_array']['size'];
	$error_array = $_FILES['file_array']['error'];  //return 1 if error

	$success_upload=false;
	for($i = 0; $i < count($tmp_name_array); $i++){
		if($tmp_name_array[$i]){
      // $WFRequestDocID = $WFRequestDocID_arr[$i];
			$WFRequestDocID;
			//get doc template
			// need wfrequestdetail id
			$q_select_wfrequestdoc = "SELECT WFRequestTemplateDocID FROM wfrequestdoctemplate WHERE WFDocID='$WFDocID_arr[$i]' AND WFRequestID='$wfrequestid';";
			$result_select_wfrequestdoc = $mysqli->query($q_select_wfrequestdoc);
			while ($row_select_wfrequestdoc=$result_select_wfrequestdoc->fetch_array() ) {
			  $WFRequestDocID = $row_select_wfrequestdoc['WFRequestTemplateDocID'];
				// $WFDocID = $row_select_wfrequestdoc['WFDocID'];
			}

			$ext = explode('.', $name_array[$i]);
			$fname = strtolower(reset($ext));
			$ext = strtolower(end($ext));
			//$file = md5_file($tmp_name_array[$i]) . '_' . time() . '.' .$ext;
			//$file = $fname . '_' . $date_hrs . '.' .$ext;
				$file = $fname . '_' . time() . '.' .$ext;
			$dirname = 'u_'.$user_id. '_' . $date_day;

			if(!is_dir($upload_destination . $dirname)){
				mkdir( $upload_destination . $dirname ,0777);
			}
			$pathname = $upload_destination . $dirname .'/';

			if(move_uploaded_file($tmp_name_array[$i], $pathname.$file)){
				$success_upload = 1;

				// to add destination fro storing it later in database
        $pathname = "uploads/" . $dirname .'/';
				$destination = $pathname . $file;

				$DocName = $fname . $ext;


        // $q_update_wfrequestdoc = "UPDATE `wfrequestdoc` SET `DocName`='$DocName',`DocURL`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDocID`='$WFRequestDocID' ";
        // $mysqli->query($q_update_wfrequestdoc);

				$q_INSERT_wfrequestdoc="INSERT INTO `wfrequestdoc`(`WFRequestID`, `DocName`, `DocURL`, `TimeStamp`, `WFDocID`, `WFRequestDetailID`) values('$wfrequestid', '$DocName', '$destination', CURRENT_TIMESTAMP, '$WFDocID_arr[$i]', '$wfrequestdetailid') " ;
				$mysqli->query($q_INSERT_wfrequestdoc);




			}else{
				$success_upload = 2;
			}

		}else{
			$success_upload = 0;
		}



	}
	$WFRequestDocID_IN_ARR = array();
	$q_s_in_wfrequestdetail = "SELECT WFRequestDocID FROM wfrequestdoc WHERE WFRequestDetailID='$wfrequestdetailid' ";
	$result_s_in = $mysqli->query($q_s_in_wfrequestdetail);
	if ($result_s_in && $result_s_in->num_rows >= 0) {
		while ($row_s_in = $result_s_in->fetch_array()) {
			array_push($WFRequestDocID_IN_ARR, $row_s_in['WFRequestDocID']);
		}
	}
	$WFRequestDocID_IN_ARR_s = serialize($WFRequestDocID_IN_ARR); //put this into history --> we will use history to trace work

	$curtime_1 = date("Y-m-d H:i:s", time() );

	$q_update_wfrequestdetail_current = "UPDATE `wfrequestdetail` SET `StartTime`='$curtime_1', `EndTime`='$curtime_1', `DoneBy`='$user_id' WHERE WFRequestDetailID='$wfrequestdetailid' ";
	$result_update_wfrequestdetail_current  = $mysqli->query($q_update_wfrequestdetail_current) or trigger_error($mysqli->error."[$q_update_wfrequestdetail_current]");

	$q_select_c_state = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$wfrequestdetailid' ";
	$result_select_c_state = $mysqli->query($q_select_c_state) or trigger_error($mysqli->error."[$q_select_c_state]");
	while ($row_select_c_state=$result_select_c_state->fetch_array() ) {
		$c0_WFRequestDetailID = $row_select_c_state['WFRequestDetailID'];
		$c0_StateName = $row_select_c_state['StateName'];
		$c0_State = $row_select_c_state['State'];
		$c0_Priority = $row_select_c_state['Priority'];
		$c0_DoneBy = $row_select_c_state['DoneBy'];
		$c0_Status = $row_select_c_state['Status'];
		$c0_StartTime = $row_select_c_state['StartTime'];
		$c0_EndTime = $row_select_c_state['EndTime'];
		// $c0_WFRequestDocID = $WFRequestDocID_IN_ARR_s;
	}
	$q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`, `WFRequestDocID`) values('$c0_DoneBy', '$wfrequestid', '$c0_WFRequestDetailID', '0', '$c0_Priority', '0', '0', '$c0_EndTime', '$WFRequestDocID_IN_ARR_s') " ;
	$mysqli->query($q_INSERT_history);

	$q_update_wfrequestdetail = "UPDATE `wfrequestdetail` SET `StartTime`='$curtime_1' WHERE ParentID='$wfrequestdetailid'";
	$result_update_wfrequestdetail  = $mysqli->query($q_update_wfrequestdetail) or trigger_error($mysqli->error."[$q_update_wfrequestdetail]");
	//
	$q_SELECT_wfrequestdetail = "SELECT * FROM wfrequestdetail WHERE ParentID='$wfrequestdetailid' ";
	$result_SELECT_wfrequestdetail = $mysqli->query($q_SELECT_wfrequestdetail) or trigger_error($mysqli->error."[$q_SELECT_wfrequestdetail]");
	while ($row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array() ) {
		$c1_WFRequestDetailID = $row_SELECT_wfrequestdetail['WFRequestDetailID'];
		$c1_StateName = $row_SELECT_wfrequestdetail['StateName'];
		$c1_State = $row_SELECT_wfrequestdetail['State'];
		$c1_Priority = $row_SELECT_wfrequestdetail['Priority'];
		$c1_DoneBy = $row_SELECT_wfrequestdetail['DoneBy'];
		$c1_Status = $row_SELECT_wfrequestdetail['Status'];
		$c1_StartTime = $row_SELECT_wfrequestdetail['StartTime'];
		$c1_EndTime = $row_SELECT_wfrequestdetail['EndTime'];
	}
	//
	// //ApproveStatus 0 work 1 approve 2 reject
	$q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$c1_WFRequestDetailID', '$c1_StateName', '$c1_State', '$c1_Priority', '$c1_DoneBy', '$c1_Status', '$c1_StartTime', '$c1_EndTime', '0', CURRENT_TIMESTAMP) " ;
	$mysqli->query($q_INSERT_currentworklist);



// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/
}

?>
