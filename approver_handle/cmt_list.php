<?php
require_once('../connect.php');
if (isset($_POST['data']) ) {
  $data_parse = $_POST['data'];
  $wfrequestdetail_id = $data_parse['wfrequestdetail_ID'];
  $userid = $data_parse['userid'];
  $data=array();
  $q = "SELECT * FROM comment WHERE WFRequestDetailID='$wfrequestdetail_id' AND (CommentTo='$userid' OR CommentBy='$userid')";
  $result = $mysqli->query($q);
  if($result && $result->num_rows >= 1){
    while ($row=$result->fetch_array() ) {
      array_push($data, $row);
    }
  }



  echo json_encode($data);
}

?>
