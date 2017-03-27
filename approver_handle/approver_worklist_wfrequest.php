<?php
require_once('../connect.php');

if (isset($_POST['cur_wfrequestdetailID']) ) {
  $wfrequestdetailid = $_POST['cur_wfrequestdetailID'];
}else {
  $wfrequestdetailid = 1;
}
$q_SELECT_FormName = "SELECT WFRequestID FROM `wfrequestdetail` WHERE WFRequestDetailID = '$wfrequestdetailid'";
$result_SELECT_FormName = $mysqli->query($q_SELECT_FormName);
$row_SELECT_FormName = $result_SELECT_FormName->fetch_array();
$WFrequestID = $row_SELECT_FormName['WFRequestID'];


$q_SELECT_CreatorID = "SELECT * FROM `wfrequest` WHERE WFRequestID = '$WFrequestID'";
$result_SELECT_CreatorID = $mysqli->query($q_SELECT_CreatorID);
while($row_SELECT_CreatorID = $result_SELECT_CreatorID->fetch_array()){
  $CreatorID = $row_SELECT_CreatorID['CreatorID'];
  $FormName = $row_SELECT_CreatorID['FormName'];
}

if (empty($CreatorID)) { //for test
  $CreatorID = 0;
}


$response = array();




$q_SELECT_CreatorName = "SELECT * FROM `user` WHERE `UserID` = '$CreatorID'";
$result_SELECT_CreatorName = $mysqli->query($q_SELECT_CreatorName);
$row_SELECT_CreatorName = $result_SELECT_CreatorName->fetch_array();

  $response['Name'] = $row_SELECT_CreatorName['Name'];
  $response['Surname'] = $row_SELECT_CreatorName['Surname'];
  $response['FormName'] = $FormName;


echo json_encode($response);
?>
