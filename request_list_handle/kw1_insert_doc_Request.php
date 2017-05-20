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
	$q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`, `WFRequestDocID`) values('$c0_DoneBy', '$wfrequestid', '$c0_WFRequestDetailID', '0', '$c0_Priority', '0', '1', '$curtime_1', '$c0_WFRequestDocID') " ;
	$mysqli->query($q_INSERT_history);




?>
