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

$sys_adminid = 3;

$upload_destination = "../uploads/";

$pathname;


$date_hrs = date("h-i-s");
$date_day = date("Y-m-d");
// $all_date = $date_hrs . '***' . $date_day;
if(!isset($_POST['all_date'])){die("all_date lost");}
$all_date = $_POST['all_date'];
$wfgeninfoID = $_POST['wfgeninfo'];
/*
//upload to wfgeninfo
			// require user and user group to exist in DB
				$q_INSERT_wfgeninfo="INSERT INTO `wfgeninfo`(`CreateTime`, `FormName`, `Description`, `AdminID`) VALUES ('$all_date', '$form_name', '$form_description', '$adminid') ";
				$mysqli->query($q_INSERT_wfgeninfo);

				$q_SELECT_wfgeninfo = "SELECT * FROM `wfgeninfo` WHERE  `FormName` = '$form_name' ";
				// get WfgenInfoID
				$result_SELECT_wfgeninfo=$mysqli->query($q_SELECT_wfgeninfo);
				while($row_SELECT_wfgeninfo=$result_SELECT_wfgeninfo->fetch_array()){
					$wfgeninfoID = $row_SELECT_wfgeninfo['WFGenInfoID'];
				}

*/

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
			$dirname = $sys_adminid. '_' . $date_day;

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
				//upload into database
				// upload to wfdoc
				// require wfgeninfo to exist
				$q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`) values('$wfgeninfoID', '$DocName', '$destination', CURRENT_TIMESTAMP) " ;
				$mysqli->query($q_INSERT_wfdoc);

				//upload to wfdetail
				// require wfdoc to exist
				//$q_in_wfdetail="INSERT INTO wfdetail(ParentID,StateName,CreateTime,ModifyTime,Deadline,WFDocID) values('$wfgeninfoID') " ;

				/*
				$ParentStateID = null;
				for($i = 0; $i < count($state_array); $i++){
					if($state_array[$i]){
						$q_INSERT_wfdetail="INSERT INTO wfdetail(ParentID,StateName,CreateTime,ModifyTime,Deadline,WFDocID) values('$ParentStateID' , '$state_array[$i]' , '$all_date' , 'null' , 'null' , ' ') " ;
						$mysqli->query($q_INSERT_wfdetail);

						$q_SELECT_wfdetail="SELECT * FROM wfdetail where StateName = '$state_array[$i]' AND CreateTime = '$all_date' ";
						// get ParentID
						$result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
						while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
							$ParentStateID = $row_SELECT_wfdetail['ParentID'];
						}

					}
				}
				*/



				//upload to wfaccess
				// require wfdetail to exist
				//$q_in_wfaccess

			}else{
				$success_upload = 2;
			}

		}else{
			$success_upload = 0;
		}



	}

	// if($success_upload == 1){
	// 	echo "upload successfully";
	//
	//
	//
	// }else if($success_upload == 2){
	// 	echo "upload failed";
	// }else{
	// 	echo "upload source is missing";
	// }

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
// else{
// 	echo "file_array not set";
// }

/*

}else{
	echo "form name is not set";
}*/
?>
