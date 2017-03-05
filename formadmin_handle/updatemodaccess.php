<?php
require_once('../connect.php');
$data_parse = $_POST['data'];
$wfreqdetailID = $data_parse['wfreqdetailID'];
$groupid = $data_parse['gid'];

$data = array();
$data['wfreqdetailID'] =$wfreqdetailID;
$data['groupid'] =$groupid;
// array_push($data, $wfreqdetailID);
// array_push($data, $groupid);
if (isset($data_parse['uid'])) {
  $approverid = $data_parse['uid'];
  // array_push($data, $approverid);
  $data['approverid'] =$approverid;
}

$q_select_access = "SELECT WFRequestAccessID FROM wfrequestaccess WHERE WFRequestDetailID='$wfreqdetailID' ";
$result_select_access=$mysqli->query($q_select_access);
$row_select_access=$result_select_access->fetch_array();
$WFRequestAccessID = $row_select_access['WFRequestAccessID'];
// array_push($data, $WFRequestAccessID);
$data['WFRequestAccessID'] =$WFRequestAccessID;

if(isset($data_parse['uid'])){
  $q_update = "UPDATE `wfrequestaccess` SET `UserID`='$approverid', `GroupID`='$groupid' WHERE `WFRequestAccessID`='$WFRequestAccessID' ";
  $result_update  = $mysqli->query($q_update);
}else{
  $q_update = "UPDATE `wfrequestaccess` SET `UserID`=null, `GroupID`='$groupid' WHERE WFRequestAccessID='$WFRequestAccessID' ";
  $result_update  = $mysqli->query($q_update);
}


echo json_encode($data);

?>
