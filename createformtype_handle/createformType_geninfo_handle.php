<?php
require_once('../connect.php');


/*if(isset($_POST['form_name'])){*/
$form_name = $_POST['form_name'];
$form_description = $_POST['form_description'];

$adminid = 2;
$sys_adminid = 3;
// time()  return unix timestamp
$date_hrs = date("h-i-s");
$date_day = date("Y-m-d");
$all_date = $date_hrs . '***' . $date_day;

//upload to wfgeninfo
			// require user and user group to exist in DB
				$q_INSERT_wfgeninfo="INSERT INTO `wfgeninfo`(`CreateTime`, `FormName`, `Description`, `AdminID`) VALUES ('$all_date', '$form_name', '$form_description', '$adminid') ";
				$mysqli->query($q_INSERT_wfgeninfo);

				$q_SELECT_wfgeninfo = "SELECT * FROM `wfgeninfo` WHERE  `FormName` = '$form_name' AND `CreateTime` = '$all_date'";
				// get WfgenInfoID
				$result_SELECT_wfgeninfo=$mysqli->query($q_SELECT_wfgeninfo);
				// while($row_SELECT_wfgeninfo=$result_SELECT_wfgeninfo->fetch_array()){
				// 	$wfgeninfoID = $row_SELECT_wfgeninfo['WFGenInfoID'];
				// }

				$data=$result_SELECT_wfgeninfo->fetch_array();
				echo json_encode( $data );


/*

}else{
	echo "form name is not set";
}*/
?>
