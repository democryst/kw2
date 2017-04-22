<?php
require_once('../connect.php');
if (isset($_POST['requestor_id']) ) {
  $requestor_id = $_POST['requestor_id'];

  $notshowarr = array();
  $q_WFRequestDetailID = "SELECT WFRequestDetailID FROM currentworklist";
  $result_WFRequestDetailID = $mysqli->query($q_WFRequestDetailID);
  if ($result_WFRequestDetailID && $result_WFRequestDetailID->num_rows >= 1 ){
    while ($row_WFRequestDetailID=$result_WFRequestDetailID->fetch_array() ) {
      $WFRequestDetailID = $row_WFRequestDetailID['WFRequestDetailID'];

      $q_wfrequest = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$WFRequestDetailID'";
      $result_wfrequest = $mysqli->query($q_wfrequest);
      if ($result_wfrequest && $result_wfrequest->num_rows >= 1 ){
        $row_wfrequest=$result_wfrequest->fetch_array();
        $WFRequestID_c = $row_wfrequest['WFRequestID'];
        array_push($notshowarr, $WFRequestID_c);
      }
    }
  }

  $q_wfrequest_h = "SELECT WFRequestID FROM history";
  $result_wfrequest_h = $mysqli->query($q_wfrequest_h);
  if ($result_wfrequest_h && $result_wfrequest_h->num_rows >= 1 ){
    while($row_wfrequest_h=$result_wfrequest_h->fetch_array()){
      $WFRequestID_h = $row_wfrequest_h['WFRequestID'];
      array_push($notshowarr, $WFRequestID_h);
    }
  }
  sort($notshowarr);
  $notshowarr_u = array_values(array_unique($notshowarr));

$data = array();
$q = "SELECT * FROM wfrequest WHERE CreatorID='$requestor_id' ";
$result = $mysqli->query($q);
while ($row=$result->fetch_array() ) {
  // array_push($data, $row);
  $WFRequestID_a = $row['WFRequestID'];
  if (!in_array($WFRequestID_a,$notshowarr_u)) {
    array_push($data, $row);
  }
}

  echo json_encode($data);
}

?>
