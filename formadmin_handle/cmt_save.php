<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
if (isset($_POST['data']) ) {
  $data_parse = $_POST['data'];
  $comment = $data_parse['comment'];
  $wfrequestdetail_id = $data_parse['wfrequestdetailid'];
  $userid = $data_parse['userid'];
  $speakto = $data_parse['speakto'];
  $datetime = date("Y-m-d H:i:s", time() );


  $q="INSERT INTO `comment`(`Comment`, `CommentTime`, `WFRequestDetailID`, `CommentBy`, `CommentTo`) VALUES ('$comment', '$datetime', '$wfrequestdetail_id', '$userid', '$speakto')";
  $result = $mysqli->query($q);

  echo json_encode($data_parse);
}
?>
