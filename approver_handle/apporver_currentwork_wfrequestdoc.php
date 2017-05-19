<?php
require_once('../connect.php');
// test for 1 state -> 1 doc
if (isset($_POST['data']) ) {
  $wfrequestdetailid = $_POST['data'];
}

$q_SELECT_WFDocID = "SELECT WFRequestDocID,WFRequestID,TemplateFileChose,ParentID FROM `wfrequestdetail` WHERE WFRequestDetailID = '$wfrequestdetailid'";
$result_SELECT_WFDocID = $mysqli->query($q_SELECT_WFDocID);
// $row_SELECT_WFDocID = $result_SELECT_WFDocID->fetch_array();
// $WFRequestdocID = $row_SELECT_WFDocID['WFRequestDocID'];

$row_SELECT_WFDocID = $result_SELECT_WFDocID->fetch_array();
$WFRequestID = $row_SELECT_WFDocID['WFRequestID'];
$TemplateFileChose = $row_SELECT_WFDocID['TemplateFileChose'];
$ParentID = $row_SELECT_WFDocID['ParentID'];
$convert_WFRequestdocIDarr = unserialize($row_SELECT_WFDocID['WFRequestDocID']);
$doc_arr = array();

if ($TemplateFileChose == 0) {
  $q = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestID='$WFRequestID' ";
  $result = $mysqli->query($q);
  while ($row=$result->fetch_array() ) {
    // array_push($data, $row);
    $box = array();
    $box['DocName'] = $row['DocName'];
    $box['DocURL'] = $row['DocURL'];
    $box['WFRequestDocID'] = $row['WFRequestTemplateDocID'];
    $box['WFDocID'] = $row['WFDocID'];
    $box['WfdocType'] = $row['WfdocType'];
    array_push($doc_arr, $box);
  }


}else { //if templatefilechose ==1  -> check parentid = WFRequestDetailID in history and get WFRequestDocID of it
  $q_wl_R = "SELECT * FROM history WHERE WFRequestDetailID='$ParentID'";
  $result_wl_R = $mysqli->query($q_wl_R);
  if ($result_wl_R && $result_wl_R->num_rows >= 1){
    $h_wl = array();
    while ($row_wl_R = $result_wl_R->fetch_array()) {
      // $WFRequestDocID = $row_wl['WFRequestDocID'];
      array_push($h_wl, unserialize($row_wl_R['WFRequestDocID']));
    }

    if (count($h_wl) != 0) {
      $cntwlindex = count($h_wl)-1;
      $last_WFRequestDocID_arr = $h_wl[$cntwlindex];

      for ($i=0; $i < count($last_WFRequestDocID_arr); $i++) {
        $WFRequestDocID_c = $last_WFRequestDocID_arr[$i];
        $q_doc = "SELECT * FROM wfrequestdoc WHERE WFRequestDocID='$WFRequestDocID_c' ";
        $result_doc = $mysqli->query($q_doc);
        if ($result_doc && $result_doc->num_rows >= 1){
          $row_doc = $result_doc->fetch_array();
          // array_push($data, $row_doc);
          $box = array();
          $box['DocName'] = $row_doc['DocName'];
          $box['DocURL'] = $row_doc['DocURL'];
          $box['WFRequestDocID'] = $row_doc['WFRequestDocID'];
          $box['WFDocID'] = $row_doc['WFDocID'];
          $box['WfdocType'] = $row_doc['WfdocType'];
          array_push($doc_arr, $box);
        }
      }
    }
  }

  // for ($i=0; $i < count($convert_WFRequestdocIDarr); $i++) {
  //   $WFRequestdocID = $convert_WFRequestdocIDarr[$i];
  //   $q_SELECT_doc = "SELECT * FROM `wfrequestdoc` WHERE WFRequestDocID = '$WFRequestdocID'";
  //   $result_SELECT_doc = $mysqli->query($q_SELECT_doc);
  //   while($row_SELECT_doc = $result_SELECT_doc->fetch_array()){
  //     $box = array();
  //     $box['DocName'] = $row_SELECT_doc['DocName'];
  //     $box['DocURL'] = $row_SELECT_doc['DocURL'];
  //     $box['WFRequestDocID'] = $row_SELECT_doc['WFRequestDocID'];
  //     array_push($doc_arr, $box);
  //   }
  // }
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
