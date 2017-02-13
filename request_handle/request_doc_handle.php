<?php
require_once('../connect.php');

/*
if(isset($_POST['form_name'])){
$form_name = $_POST['form_name'];
$form_description = "description";

$adminid = 2;
*/
//$state_array = $_POST['state_array'];
$user_id = $_POST['requestor_id'];
$wfrequestid = $_POST['wf_requestid'];
$filename_arr= $_POST['filename_arr'];
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
			$q_select_wfrequestdoc = "SELECT WFRequestDocID FROM wfrequestdoc WHERE WFDocID='$WFDocID_arr[$i]' AND WFRequestID='$wfrequestid';";
			$result_select_wfrequestdoc = $mysqli->query($q_select_wfrequestdoc);
			while ($row_select_wfrequestdoc=$result_select_wfrequestdoc->fetch_array() ) {
			  $WFRequestDocID = $row_select_wfrequestdoc['WFRequestDocID'];
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

        $q_update_wfrequestdoc = "UPDATE `wfrequestdoc` SET `DocName`='$DocName',`DocURL`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDocID`='$WFRequestDocID' ";
        $mysqli->query($q_update_wfrequestdoc);

				// $q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`) values('$wfgeninfoID', '$DocName', '$destination', CURRENT_TIMESTAMP) " ;
				// $mysqli->query($q_INSERT_wfdoc);


			}else{
				$success_upload = 2;
			}

		}else{
			$success_upload = 0;
		}



	}
	$q_SELECT_wfrequestdetail = "SELECT * FROM wfrequestdetail WHERE WFRequestID='$wfrequestid' AND ParentID='0' ";
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
	//ApproveStatus 0 work 1 approve 2 reject
	$q_INSERT_wfdoc="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$c1_WFRequestDetailID', '$c1_StateName', '$c1_State', '$c1_Priority', '$c1_DoneBy', '$c1_Status', '$c1_StartTime', '$c1_EndTime', '0', CURRENT_TIMESTAMP) " ;
	$mysqli->query($q_INSERT_wfdoc);

// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/
}

?>
