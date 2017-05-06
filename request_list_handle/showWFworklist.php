<?php
require_once('../connect.php');
if (isset($_POST['wfrequestid']) ) {
  $wfrequestor_id = $_POST['wfrequestid'];

  $data=array();
  $q = "SELECT * FROM wfrequestdetail WHERE WFRequestID='$wfrequestor_id' ";
  $result = $mysqli->query($q);
  while ($row=$result->fetch_array() ) {
    array_push($data, $row);
  }

  echo json_encode($data);
}

?>
