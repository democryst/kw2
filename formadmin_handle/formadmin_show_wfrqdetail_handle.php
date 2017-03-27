<?php
require_once('../connect.php');
//getuserid
$WFRequestID = $_POST['wfrequest_id'];
$q = "SELECT * FROM wfrequestdetail WHERE WFRequestID = '$WFRequestID' ";
$result = $mysqli->query($q);

$data = array();
while ($row = $result->fetch_array()) {
  // $box = array();
  // $box['WFRequestDetailID'] = $row['WFRequestDetailID'];
  // array_push($data, $box);
  array_push($data, $row);
}

echo json_encode($data);
?>
