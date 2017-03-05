<?php
require_once('../connect.php');
$data_parse = $_POST['data'];
$wfreqdetailID = $data_parse['wfreqdetailID'];
$groupid = $data_parse['gid'];

$data = array();
array_push($data, $wfreqdetailID);
array_push($data, $groupid);
if (isset($data_parse['uid'])) {
  $approverid = $data_parse['uid'];
  array_push($data, $approverid);
}

// $q = "SELECT * FROM wfreqdetail WHERE WFRequestDetailID='$wfreqdetailID' ";



echo json_encode($data);

?>
