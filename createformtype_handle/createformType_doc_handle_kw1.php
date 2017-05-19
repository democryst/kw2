<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");


if(isset($_POST['data'])){
	$dataparse = $_POST['data'];
	$sys_adminid = $dataparse['adminid'];
	$all_date = $dataparse['all_date'];
	$wfgeninfoID = $dataparse['wfgeninfo'];
	$doc = $dataparse['doc'];
	for ($i=0; $i < count($doc); $i++) {
		$c_doc = $doc[$i];
		$kw1fn_index = $c_doc[0];
		$kw1form_name = $c_doc[1];

		$q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`, `WfdocType`) values('$wfgeninfoID', '$kw1form_name', '$kw1fn_index', CURRENT_TIMESTAMP, '1') " ;
		$mysqli->query($q_INSERT_wfdoc);
	}

	$q_SELECT_wfdoc = "SELECT * FROM `wfdoc` WHERE  `WFGenInfoID` = '$wfgeninfoID' ";
	$result_SELECT_wfdoc=$mysqli->query($q_SELECT_wfdoc);
	$data = array();
	$i = 0;
	while($row_SELECT_wfdoc=$result_SELECT_wfdoc->fetch_array()){
		$data[$i] = $row_SELECT_wfdoc;
		$i++;
	}

	die(json_encode($data));
}


?>
