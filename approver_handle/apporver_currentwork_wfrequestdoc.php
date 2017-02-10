<?php
require_once('../connect.php');
// test for 1 state -> 1 doc
if (isset($_POST['data']) ) {
  $wfrequestdetailid = $_POST['data'];
}
$q_SELECT_WFDocID = "SELECT WFDocID FROM `wfdetail` WHERE WFDetailID = '$wfrequestdetailid'";
$result_SELECT_WFDocID = $mysqli->query($q_SELECT_WFDocID);
$row_SELECT_WFDocID = $result_SELECT_WFDocID->fetch_array();
$WFdocID = $row_SELECT_WFDocID['WFDocID'];


$q_SELECT_doc = "SELECT * FROM `wfdoc` WHERE WFDocID = '$WFdocID'";
$result_SELECT_doc = $mysqli->query($q_SELECT_doc);
while($row_SELECT_doc = $result_SELECT_doc->fetch_array()){
  $DocName = $row_SELECT_doc['DocName'];
  $DocURL= $row_SELECT_doc['DocURL'];
  $DocID= $row_SELECT_doc['WFDocID'];
}

$response = array();


  $response['DocName'] = $DocName;
  $response['DocURL'] = $DocURL;
  $response['WFDocID'] = $DocID;


echo json_encode($response);
?>
