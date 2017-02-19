<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
$TimeStamp_mark_arr =  $_POST['TimeStamp'];
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
		$date_hrs = date("h-i-s");
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

					}

				}



			}
	//need to insert starttime endtime to wfrequestdetail

	// need to remove currenworklist and insert history    //need get current wfrequestdetailID and match it as parentid
	$q_SELECT_wfrequestdetail = "SELECT WFRequestDetailID FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark'";
	$result_SELECT_wfrequestdetail = $mysqli->query($q_SELECT_wfrequestdetail);
	$row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array();
	$wfrequestdetailID_old = $row_SELECT_wfrequestdetail['WFRequestDetailID'];    // use to find WFRequestDetailID  that need for insert

	$q_SELECT_wfrequestdetail_n = "SELECT * FROM wfrequestdetail WHERE ParentID='$wfrequestdetailID_old'";
	$result_SELECT_wfrequestdetail_n = $mysqli->query($q_SELECT_wfrequestdetail_n);

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

	$q_delete = "DELETE FROM currentworklist WHERE CurrentWorkListID='$CurrentWorkListID_mark'";
	$mysqli->query($q_delete);

	$q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$c1_WFRequestDetailID', '$c1_StateName', '$c1_State', '$c1_Priority', '$c1_DoneBy', '$c1_Status', '$c1_StartTime', '$c1_EndTime', '0', CURRENT_TIMESTAMP) " ;
	$mysqli->query($q_INSERT_currentworklist);

		// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/
	}// file exist


	}   //TimeStamp check if not same mean someone done this work first
}



?>
