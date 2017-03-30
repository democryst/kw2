<?php
require_once('../connect.php');


/*if(isset($_POST['form_name'])){*/
if (isset($_POST['data'])) {
	$dataparse = $_POST['data'];
	$form_name = $dataparse['form_name'];
	$form_description = $dataparse['form_description'];
	$adminid = $dataparse['form_admin_select'];
}
// else{
// 	// $adminid = 2;
// 	exit();
// }
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
