<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
if (isset($_POST['data']) ) {
  $data_parse = $_POST['data'];
  $comment = $data_parse['comment'];
  $wfrequestdetail_id = $data_parse['WFRequestDetailID'];
  $userid = $data_parse['userid'];
  $datetime = date("Y-m-d H:i:s", time() );
  // $q="INSERT INTO `comment`(`Comment`, `CommentTime`, `WFRequestDetailID`, `CommentBy`) VALUES ('$comment', '$datetime', '$wfrequestdetail_id', '$userid')";
  // $result = $mysqli->query($q);
  //
  // // get wfrequestid from wfrequestdetailid
  // $q_s_wfrqdetailid = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$wfrequestdetail_id'";
  // $result_s_wfrqdetailid = $mysqli->query($q_s_wfrqdetailid);
  // $row_s_wfrqdetailid = $result_s_wfrqdetailid->fetch_array();
  // $WFRequestID = $row_s_wfrqdetailid['WFRequestID'];
  // // get userid of form admin
  // $q_s_formadmin = "SELECT AdminID FROM wfrequest WHERE WFRequestID='$WFRequestID'";
  // $result_s_formadmin = $mysqli->query($q_s_formadmin);
  // $row_s_formadmin = $result_s_formadmin->fetch_array();
  // $talkto = $row_s_formadmin['AdminID'];

  // $q="INSERT INTO `comment`(`Comment`, `CommentTime`, `WFRequestDetailID`, `CommentBy`, `CommentTo`) VALUES ('$comment', '$datetime', '$wfrequestdetail_id', '$userid', '$talkto')";
  $q="INSERT INTO `comment`(`Comment`, `CommentTime`, `WFRequestDetailID`, `CommentBy`, `CommentTo`) VALUES ('$comment', '$datetime', '$wfrequestdetail_id', '$userid', '2')";
  $result = $mysqli->query($q);


  echo json_encode($data_parse);
}

?>
