<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
$dataparse = $_POST['data'];

$user_id = $dataparse['userid'];

$wfrequestid_arr = $dataparse['wf_requestid'];
sort($wfrequestid_arr);
$wfrequestid_arr2 = array_values(array_unique($wfrequestid_arr));
$wfrequestid = $wfrequestid_arr2[0];

$wfrequestdetailid_arr= $dataparse['stateid_arr'];
sort($wfrequestdetailid_arr);
$wfrequestdetailid_arr2 = array_values(array_unique($wfrequestdetailid_arr));
$wfrequestdetailid = $wfrequestdetailid_arr2[0];

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
		$c0_WFRequestDocID = $row_select_c_state['WFRequestDocID'];;
	}
	$q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`, `WFRequestDocID`) values('$c0_DoneBy', '$wfrequestid', '$c0_WFRequestDetailID', '0', '$c0_Priority', '0', '0', '$c0_EndTime', '$c0_WFRequestDocID') " ;
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



?>
