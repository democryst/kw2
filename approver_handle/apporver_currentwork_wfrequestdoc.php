<?php
require_once('../connect.php');
// test for 1 state -> 1 doc
if (isset($_POST['data']) ) {
  $wfrequestdetailid = $_POST['data'];
}
$q_SELECT_WFDocID = "SELECT WFRequestDocID FROM `wfrequestdetail` WHERE WFRequestDetailID = '$wfrequestdetailid'";
$result_SELECT_WFDocID = $mysqli->query($q_SELECT_WFDocID);
$row_SELECT_WFDocID = $result_SELECT_WFDocID->fetch_array();
$WFRequestdocID = $row_SELECT_WFDocID['WFRequestDocID'];


$q_SELECT_doc = "SELECT * FROM `wfrequestdoc` WHERE WFRequestDocID = '$WFRequestdocID'";
$result_SELECT_doc = $mysqli->query($q_SELECT_doc);
while($row_SELECT_doc = $result_SELECT_doc->fetch_array()){
  $DocName = $row_SELECT_doc['DocName'];
  $DocURL= $row_SELECT_doc['DocURL'];
  $DocID= $row_SELECT_doc['WFRequestDocID'];
}

$response = array();


  $response['DocName'] = $DocName;
  $response['DocURL'] = $DocURL;
  $response['WFRequestDocID'] = $DocID;


echo json_encode($response);
?>
