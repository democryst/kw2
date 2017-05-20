<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
$datapares = $_POST['data'];
$TimeStamp_mark_arr =  $datapares['TimeStamp'];
sort($TimeStamp_mark_arr);
$TimeStamp_mark_arr_u = array_values(array_unique($TimeStamp_mark_arr));
$TimeStamp_mark_arr_u_0 = $TimeStamp_mark_arr_u[0];

$userid =  $datapares['userid'];
$CurrentWorkListID_mark_arr = $datapares['CurrentWorkListID'];

// $WFRequestDocID_arr = $datapares['wfrequestdocarr_new'];
// $WFRequestDocID_arr = $datapares['WFRequestDocID_arr'];
// $WFRequestDocID_arr_new = $datapares['wfrequestdocarr_new'];
// $WFRequestDocID_arr_s = serialize($WFRequestDocID_arr);

// $TimeStamp_mark_arr =  $_POST['TimeStamp'];
// $userid =  $_POST['userid'];
// $CurrentWorkListID_mark_arr = $_POST['CurrentWorkListID'];
// $WFRequestDocID_arr = $_POST['WFRequestDocID_arr'];
for ($i=0; $i < count($CurrentWorkListID_mark_arr); $i++) {
	$TimeStamp_mark = date("Y-m-d H:i:s", $TimeStamp_mark_arr_u_0);
	// $TimeStamp_mark = date("Y-m-d H:i:s", $TimeStamp_mark_arr);
	$CurrentWorkListID_mark = $CurrentWorkListID_mark_arr[$i];
	$q_check_timestamp = "SELECT `TimeStamp` FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark' ";
	$result_check_timestamp = $mysqli->query($q_check_timestamp);
	$row_check_timestamp  = $result_check_timestamp->fetch_array();
// echo "TimeStamp: ". $TimeStamp_mark_arr ."\n";
// echo "date from timestamp: ".$TimeStamp_mark ."\n";
// echo "date from sql: ".$row_check_timestamp['TimeStamp'] ."\n";

	if ($TimeStamp_mark == $row_check_timestamp['TimeStamp']) {
		// echo "\nTimeStamp match allow to upload\n";
		// $upload_destination = "../uploads/";
		// $pathname;
		// $date_hrs = date("H-i-s");
		// $date_day = date("Y-m-d");

	//need to insert starttime endtime to wfrequestdetail

	// need to remove currenworklist and insert history    //need get current wfrequestdetailID and match it as parentid
	$q_SELECT_wfrequestdetail = "SELECT WFRequestDetailID FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark'";
	$result_SELECT_wfrequestdetail = $mysqli->query($q_SELECT_wfrequestdetail);
	$row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array();
	$wfrequestdetailID_old = $row_SELECT_wfrequestdetail['WFRequestDetailID'];    // use to find WFRequestDetailID  that need for insert

	$q_SELECT_wfrequestdetail_n = "SELECT * FROM wfrequestdetail WHERE ParentID='$wfrequestdetailID_old'";
	$result_SELECT_wfrequestdetail_n = $mysqli->query($q_SELECT_wfrequestdetail_n);
	if ($result_SELECT_wfrequestdetail_n && $result_SELECT_wfrequestdetail_n->num_rows >= 1 ){
		// use to insert
 	 while ($row_SELECT_wfrequestdetail_n=$result_SELECT_wfrequestdetail_n->fetch_array() ) {
 		 $c1_WFRequestDetailID = $row_SELECT_wfrequestdetail_n['WFRequestDetailID'];
 		 $c1_StateName = $row_SELECT_wfrequestdetail_n['StateName'];
 		 $c1_State = $row_SELECT_wfrequestdetail_n['State'];
 		 $c1_Priority = $row_SELECT_wfrequestdetail_n['Priority'];
 		 $c1_DoneBy = $row_SELECT_wfrequestdetail_n['DoneBy'];
 		 $c1_Status = $row_SELECT_wfrequestdetail_n['Status'];
 		 $c1_StartTime = $row_SELECT_wfrequestdetail_n['StartTime'];
 		 $c1_EndTime = $row_SELECT_wfrequestdetail_n['EndTime'];

 	 }
	}


	$q_delete = "DELETE FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark'";
	$mysqli->query($q_delete);

// if ($result_SELECT_wfrequestdetail_n && $result_SELECT_wfrequestdetail_n->num_rows >= 1 ){
// 	$q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$c1_WFRequestDetailID', '$c1_StateName', '$c1_State', '$c1_Priority', '$c1_DoneBy', '$c1_Status', '$c1_StartTime', '$c1_EndTime', '0', CURRENT_TIMESTAMP) " ;
// 	$mysqli->query($q_INSERT_currentworklist);
// }

	//need to update old wfdetail form currentworklist to history    ---> we want to use history to create permission to modify form state
	//query data from old State
	$q_select_old = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$wfrequestdetailID_old' ";
	$result_select_old = $mysqli->query($q_select_old);
	$row_select_old=$result_select_old->fetch_array();
	$old_WFRequestDetailID = $row_select_old['WFRequestDetailID'];
	$old_ParentID = $row_select_old['ParentID'];
	$old_StateName = $row_select_old['StateName'];
	$old_CreateTime = $row_select_old['CreateTime'];
	$old_ModifyTime = $row_select_old['ModifyTime'];
	$old_Deadline = $row_select_old['Deadline'];
	$old_WFRequestDocID = $row_select_old['WFRequestDocID'];
	$old_State = $row_select_old['State'];
	$old_Priority = $row_select_old['Priority'];
	$old_DoneBy = $row_select_old['DoneBy'];
	$old_Status = $row_select_old['Status'];
	$old_StartTime = $row_select_old['StartTime'];
	$old_EndTime = $row_select_old['EndTime'];
	$old_WFRequestID = $row_select_old['WFRequestID'];
	$curtime_for_old = date("Y-m-d H:i:s", time() );   //--> wfdetail_old EndTime ,  history EndTime, wfdetail_new StartTime
	//update old wfdetail doneby + endtime
	$q_update_old = "UPDATE `wfrequestdetail` SET `DoneBy`='$userid', `EndTime`='$curtime_for_old' WHERE WFRequestDetailID='$wfrequestdetailID_old' ";
	$result_update_old  = $mysqli->query($q_update_old);
	//update new wfdetail StartTime
if ($result_SELECT_wfrequestdetail_n && $result_SELECT_wfrequestdetail_n->num_rows >= 1 ){
	$q_update_new = "UPDATE `wfrequestdetail` SET `StartTime`='$curtime_for_old' WHERE WFRequestDetailID='$c1_WFRequestDetailID' ";
	$result_update_new  = $mysqli->query($q_update_new);
}
	// //insert into history
	// $q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`, `WFRequestDocID`) values('$userid', '$old_WFRequestID', '$old_WFRequestDetailID', '0', '0', '0', '0', '$curtime_for_old', '$WFRequestDocID_arr_s') " ;
	// $mysqli->query($q_INSERT_history);

		// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/

	//select new requestdetail after it update
	$q_s_wfrd_new = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$c1_WFRequestDetailID'";
	$result_s_wfrd_new  = $mysqli->query($q_s_wfrd_new);
	if ($result_s_wfrd_new && $result_s_wfrd_new->num_rows >= 1 ){
		while ($row_s_wfrd_new=$result_s_wfrd_new->fetch_array() ) {
			$c2_WFRequestDetailID = $row_s_wfrd_new['WFRequestDetailID'];
			$c2_StateName = $row_s_wfrd_new['StateName'];
			$c2_State = $row_s_wfrd_new['State'];
			$c2_Priority = $row_s_wfrd_new['Priority'];
			$c2_DoneBy = $row_s_wfrd_new['DoneBy'];
			$c2_Status = $row_s_wfrd_new['Status'];
			$c2_StartTime = $row_s_wfrd_new['StartTime'];
			$c2_EndTime = $row_s_wfrd_new['EndTime'];
		}

		//insert new currentworklist after starttime , endtime was update
		$q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$c2_WFRequestDetailID', '$c2_StateName', '$c2_State', '$c2_Priority', '$c2_DoneBy', '$c2_Status', '$c2_StartTime', '$c2_EndTime', '0', CURRENT_TIMESTAMP) " ;
		$mysqli->query($q_INSERT_currentworklist);

		//insert into history
		$q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`, `WFRequestDocID`) values('$userid', '$old_WFRequestID', '$old_WFRequestDetailID', '0', '0', '0', '0', '$curtime_for_old', '$old_WFRequestDocID') " ;
		$mysqli->query($q_INSERT_history);
	}else {
		//insert into history
		$q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`, `WFRequestDocID`) values('$userid', '$old_WFRequestID', '$old_WFRequestDetailID', '0', '0', '0', '9', '$curtime_for_old', '$old_WFRequestDocID') " ;
		$mysqli->query($q_INSERT_history);
	}

	}   //TimeStamp check if not same mean someone done this work first
}



?>
