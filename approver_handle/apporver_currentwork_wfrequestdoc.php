<?php
require_once('../connect.php');
// test for 1 state -> 1 doc
if (isset($_POST['data']) ) {
  $wfrequestdetailid = $_POST['data'];
}


$q_SELECT_WFDocID = "SELECT WFRequestDocID FROM `wfrequestdetail` WHERE WFRequestDetailID = '$wfrequestdetailid'";
$result_SELECT_WFDocID = $mysqli->query($q_SELECT_WFDocID);
// $row_SELECT_WFDocID = $result_SELECT_WFDocID->fetch_array();
// $WFRequestdocID = $row_SELECT_WFDocID['WFRequestDocID'];

$row_SELECT_WFDocID = $result_SELECT_WFDocID->fetch_array();
$convert_WFRequestdocIDarr = unserialize($row_SELECT_WFDocID['WFRequestDocID']);
$doc_arr = array();
for ($i=0; $i < count($convert_WFRequestdocIDarr); $i++) {
  $WFRequestdocID = $convert_WFRequestdocIDarr[$i];
  $q_SELECT_doc = "SELECT * FROM `wfrequestdoc` WHERE WFRequestDocID = '$WFRequestdocID'";
  $result_SELECT_doc = $mysqli->query($q_SELECT_doc);
  while($row_SELECT_doc = $result_SELECT_doc->fetch_array()){
    $box = array();
    $box['DocName'] = $row_SELECT_doc['DocName'];
    $box['DocURL'] = $row_SELECT_doc['DocURL'];
    $box['WFRequestDocID'] = $row_SELECT_doc['WFRequestDocID'];
    array_push($doc_arr, $box);
  }
}
$response = array();
$q_SELECT_currentworklist = "SELECT * FROM currentworklist WHERE WFRequestDetailID='$wfrequestdetailid' ";
$result_SELECT_currentworklist = $mysqli->query($q_SELECT_currentworklist);
while($row_SELECT_currentworklist = $result_SELECT_currentworklist->fetch_array() ){
  $response['TimeStamp'] = $row_SELECT_currentworklist['TimeStamp'];
  $response['CurrentWorkListID'] =$row_SELECT_currentworklist['CurrentWorkListID'];
}
$response['Document'] = $doc_arr;

// $q_SELECT_doc = "SELECT * FROM `wfrequestdoc` WHERE WFRequestDocID = '$WFRequestdocID'";
// $result_SELECT_doc = $mysqli->query($q_SELECT_doc);
// while($row_SELECT_doc = $result_SELECT_doc->fetch_array()){
//   $DocName = $row_SELECT_doc['DocName'];
//   $DocURL= $row_SELECT_doc['DocURL'];
//   $DocID= $row_SELECT_doc['WFRequestDocID'];
// }
//
// $response = array();
//
// $q_SELECT_currentworklist = "SELECT * FROM currentworklist WHERE WFRequestDetailID='$wfrequestdetailid' ";
// $result_SELECT_currentworklist = $mysqli->query($q_SELECT_currentworklist);
// while($row_SELECT_currentworklist = $result_SELECT_currentworklist->fetch_array() ){
//   $response['TimeStamp'] = $row_SELECT_currentworklist['TimeStamp'];
//   $response['CurrentWorkListID'] =$row_SELECT_currentworklist['CurrentWorkListID'];
// }
//
//   $response['DocName'] = $DocName;
//   $response['DocURL'] = $DocURL;
//   $response['WFRequestDocID'] = $DocID;
//
//
echo json_encode($response);
?>
