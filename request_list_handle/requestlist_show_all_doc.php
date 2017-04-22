<?php
require_once('../connect.php');
if (isset($_POST['wfrequest_id']) ) {
  $wfrequest_id = $_POST['wfrequest_id'];

  $data = array();
  $q = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestID='$wfrequest_id' ";
  $result = $mysqli->query($q);
  while ($row=$result->fetch_array() ) {
    array_push($data, $row);
  }



  echo json_encode($data);

  // echo json_encode($data);
}

?>
