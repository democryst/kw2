<?php
require_once('connect.php');

/*
if(isset($_POST['form_name'])){
$form_name = $_POST['form_name'];
$form_description = "description";

$adminid = 2;
*/
//$state_array = $_POST['state_array'];
$user_id = $_POST['user_id'];

$filename_arr= $_POST['filename_arr'];
$WFRequestDocID_arr = $_POST['WFRequestDocID_arr'];

// $sys_adminid = 3;

$upload_destination = "uploads/";

$pathname;


$date_hrs = date("h-i-s");
$date_day = date("Y-m-d");
// $all_date = $date_hrs . '***' . $date_day;
if(!isset($_POST['all_date'])){die("all_date lost");}
$all_date = $_POST['all_date'];
$wfgeninfoID = $_POST['wfgeninfo'];

if(isset($_FILES['file_array'])){


	$name_array = $_FILES['file_array']['name'];
	$tmp_name_array = $_FILES['file_array']['tmp_name'];
	$type_array = $_FILES['file_array']['type'];
	$size_array = $_FILES['file_array']['size'];
	$error_array = $_FILES['file_array']['error'];  //return 1 if error

	$success_upload=false;
	for($i = 0; $i < count($tmp_name_array); $i++){
		if($tmp_name_array[$i]){


			$ext = explode('.', $name_array[$i]);
			$fname = strtolower(reset($ext));
			$ext = strtolower(end($ext));
			//$file = md5_file($tmp_name_array[$i]) . '_' . time() . '.' .$ext;
			//$file = $fname . '_' . $date_hrs . '.' .$ext;
				$file = $fname . '_' . time() . '.' .$ext;
			$dirname = 'u'.$user_id. '_' . $date_day;

			if(!is_dir($upload_destination . $dirname)){
				mkdir( $upload_destination . $dirname ,0777);
			}
			$pathname = $upload_destination . $dirname .'/';

			if(move_uploaded_file($tmp_name_array[$i], $pathname.$file)){
				$success_upload = 1;

				// to add destination fro storing it later in database
				$destination = $pathname . $file;

				$DocName = $fname . $ext;

				// $q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`) values('$wfgeninfoID', '$DocName', '$destination', CURRENT_TIMESTAMP) " ;
				// $mysqli->query($q_INSERT_wfdoc);

			}else{
				$success_upload = 2;
			}

		}else{
			$success_upload = 0;
		}



	}


	$q_SELECT_wfdoc = "SELECT * FROM `wfdoc` WHERE  `WFGenInfoID` = '$wfgeninfoID' ";
	// get WfgenInfoID
	$result_SELECT_wfdoc=$mysqli->query($q_SELECT_wfdoc);
	$data = array();
	$i = 0;
	while($row_SELECT_wfdoc=$result_SELECT_wfdoc->fetch_array()){
		// $wfgeninfoID = $row_SELECT_wfgeninfo['WFGenInfoID'];
		$data[$i] = $row_SELECT_wfdoc;
		$i++;
	}

	// $data=$result_SELECT_wfdoc->fetch_array();
	die(json_encode($data));

}

?>
