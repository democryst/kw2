<?php
require_once('../connect.php');
if (isset($_POST['data']) ) {
  $data_parse = $_POST['data'];
  $wfrequestdetail_id = $data_parse['wfrequestdetail_ID'];
  $userid = $data_parse['userid'];
  $speakto = $data_parse['speakto'];

  // get wfrequestid from wfrequestdetailid
  $q_s_wfrqdetailid = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$wfrequestdetail_id'";
  $result_s_wfrqdetailid = $mysqli->query($q_s_wfrqdetailid);
  $row_s_wfrqdetailid = $result_s_wfrqdetailid->fetch_array();
  $WFRequestID = $row_s_wfrqdetailid['WFRequestID'];
  // get userid of form admin
  $q_s_creatorid = "SELECT CreatorID FROM wfrequest WHERE WFRequestID='$WFRequestID'";
  $result_s_creatorid = $mysqli->query($q_s_creatorid);
  $row_s_creatorid = $result_s_creatorid->fetch_array();
  $talkto = $row_s_creatorid['CreatorID'];



  $data=array();
  if ($speakto == 0) {
    //talk with student
    $q = "SELECT * FROM comment WHERE WFRequestDetailID='$wfrequestdetail_id' AND ( (CommentTo='$userid' AND CommentBy='$talkto') OR (CommentTo='$talkto' AND CommentBy='$userid') )";
    $result = $mysqli->query($q);
    if($result && $result->num_rows >= 1){
      while ($row=$result->fetch_array() ) {
        array_push($data, $row);
      }
    }
  }else{
    //talk with teacher
    $q = "SELECT * FROM comment WHERE WFRequestDetailID='$wfrequestdetail_id' AND ( (CommentTo='$userid' AND CommentBy!='$talkto') OR (CommentTo!='$talkto' AND CommentBy='$userid') )";
    $result = $mysqli->query($q);
    if($result && $result->num_rows >= 1){
      while ($row=$result->fetch_array() ) {
        array_push($data, $row);
      }
    }
  }





  echo json_encode($data);
}

?>
