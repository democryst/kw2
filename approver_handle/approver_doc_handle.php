<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
$TimeStamp_mark_arr =  $_POST['TimeStamp'];
$userid =  $_POST['userid'];
$CurrentWorkListID_mark_arr = $_POST['CurrentWorkListID'];
$WFRequestDocID_arr = $_POST['WFRequestDocID_arr'];
for ($i=0; $i < count($CurrentWorkListID_mark_arr); $i++) {
	$TimeStamp_mark = date("Y-m-d H:i:s", $TimeStamp_mark_arr);
	$CurrentWorkListID_mark = $CurrentWorkListID_mark_arr[$i];
	$q_check_timestamp = "SELECT `TimeStamp` FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark' ";
	$result_check_timestamp = $mysqli->query($q_check_timestamp);
	$row_check_timestamp  = $result_check_timestamp->fetch_array();
echo "TimeStamp: ". $TimeStamp_mark_arr ."\n";
echo "date from timestamp: ".$TimeStamp_mark ."\n";
echo "date from sql: ".$row_check_timestamp['TimeStamp'] ."\n";

	if ($TimeStamp_mark == $row_check_timestamp['TimeStamp']) {
		echo "\nTimeStamp match allow to upload\n";
		$upload_destination = "../uploads/";
		$pathname;
		$date_hrs = date("H-i-s");
		$date_day = date("Y-m-d");

		if(isset($_FILES['file_array'])){


			$name_array = $_FILES['file_array']['name'];
			$tmp_name_array = $_FILES['file_array']['tmp_name'];
			$type_array = $_FILES['file_array']['type'];
			$size_array = $_FILES['file_array']['size'];
			$error_array = $_FILES['file_array']['error'];  //return 1 if error

			for($i = 0; $i < count($tmp_name_array); $i++){
				if($tmp_name_array[$i]){
		      $WFRequestDocID = $WFRequestDocID_arr[$i];

					$ext = explode('.', $name_array[$i]);
					$fname = strtolower(reset($ext));
					$ext = strtolower(end($ext));
					//$file = md5_file($tmp_name_array[$i]) . '_' . time() . '.' .$ext;
					//$file = $fname . '_' . $date_hrs . '.' .$ext;
						$file = $fname . '_' . time() . '.' .$ext;
					$dirname = "approver_" . $date_day;

					if(!is_dir($upload_destination . $dirname)){
						mkdir( $upload_destination . $dirname ,0777);
					}
					$pathname = $upload_destination . $dirname .'/';

					if(move_uploaded_file($tmp_name_array[$i], $pathname.$file)){

						// to add destination fro storing it later in database
		        $pathname = "uploads/" . $dirname .'/';
						$destination = $pathname . $file;

						$DocName = $fname . $ext;

		        $q_update_wfrequestdoc = "UPDATE `wfrequestdoc` SET `DocName`='$DocName',`DocURL`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDocID`='$WFRequestDocID' ";
		        $result_update_wfrequestdoc  = $mysqli->query($q_update_wfrequestdoc);


						// $q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`) values('$wfgeninfoID', '$DocName', '$destination', CURRENT_TIMESTAMP) " ;
						// $mysqli->query($q_INSERT_wfdoc);

					}else{
						exit();
					}

				}



			}
	//need to insert starttime endtime to wfrequestdetail

	// // need to remove currenworklist and insert history    //need get current wfrequestdetailID and match it as parentid
	// $q_SELECT_wfrequestdetail = "SELECT WFRequestDetailID FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark'";
	// $result_SELECT_wfrequestdetail = $mysqli->query($q_SELECT_wfrequestdetail);
	// $row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array();
	// $wfrequestdetailID_old = $row_SELECT_wfrequestdetail['WFRequestDetailID'];    // use to find WFRequestDetailID  that need for insert
	//
	// $q_SELECT_wfrequestdetail_n = "SELECT * FROM wfrequestdetail WHERE ParentID='$wfrequestdetailID_old'";
	// $result_SELECT_wfrequestdetail_n = $mysqli->query($q_SELECT_wfrequestdetail_n);
	//
	//  // use to insert
	//  while ($row_SELECT_wfrequestdetail_n=$result_SELECT_wfrequestdetail_n->fetch_array() ) {
	// 	 $c1_WFRequestDetailID = $row_SELECT_wfrequestdetail_n['WFRequestDetailID'];
	// 	 $c1_StateName = $row_SELECT_wfrequestdetail_n['StateName'];
	// 	 $c1_State = $row_SELECT_wfrequestdetail_n['State'];
	// 	 $c1_Priority = $row_SELECT_wfrequestdetail_n['Priority'];
	// 	 $c1_DoneBy = $row_SELECT_wfrequestdetail_n['DoneBy'];
	// 	 $c1_Status = $row_SELECT_wfrequestdetail_n['Status'];
	// 	 $c1_StartTime = $row_SELECT_wfrequestdetail_n['StartTime'];
	// 	 $c1_EndTime = $row_SELECT_wfrequestdetail_n['EndTime'];
	//
	//  }
	//
	// $q_delete = "DELETE FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark'";
	// $mysqli->query($q_delete);
	//
	// $q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$c1_WFRequestDetailID', '$c1_StateName', '$c1_State', '$c1_Priority', '$c1_DoneBy', '$c1_Status', '$c1_StartTime', '$c1_EndTime', '0', CURRENT_TIMESTAMP) " ;
	// $mysqli->query($q_INSERT_currentworklist);
	//
	// //need to update old wfdetail form currentworklist to history    ---> we want to use history to create permission to modify form state
	// //query data from old State
	// $q_select_old = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$wfrequestdetailID_old' ";
	// $result_select_old = $mysqli->query($q_select_old);
	// $row_select_old=$result_select_old->fetch_array();
	// $old_WFRequestDetailID = $row_select_old['WFRequestDetailID'];
	// $old_ParentID = $row_select_old['ParentID'];
	// $old_StateName = $row_select_old['StateName'];
	// $old_CreateTime = $row_select_old['CreateTime'];
	// $old_ModifyTime = $row_select_old['ModifyTime'];
	// $old_Deadline = $row_select_old['Deadline'];
	// $old_WFRequestDocID = $row_select_old['WFRequestDocID'];
	// $old_State = $row_select_old['State'];
	// $old_Priority = $row_select_old['Priority'];
	// $old_DoneBy = $row_select_old['DoneBy'];
	// $old_Status = $row_select_old['Status'];
	// $old_StartTime = $row_select_old['StartTime'];
	// $old_EndTime = $row_select_old['EndTime'];
	// $old_WFRequestID = $row_select_old['WFRequestID'];
	// $curtime_for_old = date("Y-m-d H:i:s", time() );   //--> wfdetail_old EndTime ,  history EndTime, wfdetail_new StartTime
	// //update old wfdetail doneby + endtime
	// $q_update_old = "UPDATE `wfrequestdetail` SET `DoneBy`='$userid', `EndTime`='$curtime_for_old' WHERE WFRequestDetailID='$wfrequestdetailID_old' ";
	// $result_update_old  = $mysqli->query($q_update_old);
	// //update new wfdetail StartTime
	// $q_update_new = "UPDATE `wfrequestdetail` SET `StartTime`='$curtime_for_old' WHERE WFRequestDetailID='$c1_WFRequestDetailID' ";
	// $result_update_new  = $mysqli->query($q_update_new);
	// //insert into history
	// $q_INSERT_history="INSERT INTO `history`(`UserID`, `WFRequestID`, `WFRequestDetailID`, `Comment`, `Priority`, `Late`, `WhatDone`, `TimeDone`) values('$userid', '$old_WFRequestID', '$old_WFRequestDetailID', '0', '0', '0', '0', '$curtime_for_old') " ;
	// $mysqli->query($q_INSERT_history);

		// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/
	}// file exist


	}   //TimeStamp check if not same mean someone done this work first
}



?>
