<?php
require_once('../connect.php');
if (isset($_POST['requestor_id']) ) {
  $requestor_id = $_POST['requestor_id'];

// $data = array();
// $q = "SELECT * FROM wfrequest WHERE CreatorID='$requestor_id' ";
// $result = $mysqli->query($q);
// while ($row=$result->fetch_array() ) {
//   array_push($data, $row);
// }

  $data_select_curstate = array();
  $q_select_curstate = "SELECT WFRequestDetailID FROM currentworklist";
  $result_select_curstate = $mysqli->query($q_select_curstate);
  while ($row_select_curstate=$result_select_curstate->fetch_array() ) {
    array_push($data_select_curstate, $row_select_curstate);
  }

  $data_select_wfrequest = array();
  for ($i=0; $i < count($data_select_curstate); $i++) {
    $data_curstate = $data_select_curstate[$i];
    $wfrequestdetailid = $data_curstate['WFRequestDetailID'];
    $q_select_wfrequest = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$wfrequestdetailid' ";
    $result_select_wfrequest = $mysqli->query($q_select_wfrequest);
    $row_select_wfrequest=$result_select_wfrequest->fetch_array();
    array_push($data_select_wfrequest, $row_select_wfrequest);
  }

  $data_ret = array();
  for ($i=0; $i < count($data_select_wfrequest); $i++) {
     $data_curform = $data_select_wfrequest[$i];
     $wfrequestid = $data_curform['WFRequestID'];
     $q_select_wfrequest_2 = "SELECT * FROM wfrequest WHERE WFRequestID='$wfrequestid' AND CreatorID='$requestor_id' ";
     $result_select_wfrequest_2 = $mysqli->query($q_select_wfrequest_2);
     while ($row_select_wfrequest_2=$result_select_wfrequest_2->fetch_array() ) {
       array_push($data_ret, $row_select_wfrequest_2);
     }
  }


  echo json_encode($data_ret);

  // echo json_encode($data);
}

?>
