<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
if (isset($_POST['data']) ) {
  $data_parse = $_POST['data'];
  $comment = $data_parse['comment'];
  $wfrequestdetail_id = $data_parse['WFRequestDetailID'];
  $userid = $data_parse['userid'];
  $datetime = date("Y-m-d H:i:s", time() );
  $q="INSERT INTO `comment`(`Comment`, `CommentTime`, `WFRequestDetailID`, `CommentBy`) VALUES ('$comment', '$datetime', '$wfrequestdetail_id', '$userid')";
  $result = $mysqli->query($q);

  echo json_encode($data_parse);
}

?>
