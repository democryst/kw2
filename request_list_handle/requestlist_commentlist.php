<?php
require_once('../connect.php');
if (isset($_POST['WFRequestDetailID']) ) {
  $wfrequestdetail_id = $_POST['WFRequestDetailID'];
  $data=array();
  $q = "SELECT * FROM comment WHERE WFRequestDetailID='$wfrequestdetail_id' ";
  $result = $mysqli->query($q);
  if($result && $result->num_rows >= 1){
    while ($row=$result->fetch_array() ) {
      array_push($data, $row);
    }
  }



  echo json_encode($data);
}

?>
