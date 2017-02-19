<?php
require_once('../connect.php');
//getuserid
$cur_userid = $_POST['cur_userid'];

$exist_current = array();
$q_2 = "SELECT * FROM `currentworklist` ";
$result_2 = $mysqli->query($q_2) or trigger_error($mysqli->error."[$q_2]");
while($row_2 = $result_2->fetch_array()){
  array_push($exist_current, $row_2['WFRequestDetailID']);
}


$exist_current_1 = array();
 for ($i=0; $i < count($exist_current); $i++) {
   $q_2_1 = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID = '$exist_current[$i]' ";
   $result_2_1 = $mysqli->query($q_2_1) or trigger_error($mysqli->error."[$q_2_1]");
   while($row_2_1 = $result_2_1->fetch_array()){
     array_push($exist_current_1, $row_2_1['WFRequestID']);
   }
 }

$all_wfrequest = array();
for ($i=0; $i < count($exist_current_1); $i++) {
  // $exist_current_1_l = $exist_current_1[$i];
  // $exist_WFRequestID = $exist_current_1_l['WFRequestID'];
  $q_1 = "SELECT * FROM wfrequest WHERE AdminID = '$cur_userid' AND WFRequestID = '$exist_current_1[$i]' ";
  $result_1 = $mysqli->query($q_1) or trigger_error($mysqli->error."[$q_1]");

  while($row_1 = $result_1->fetch_array()){
    // $cur_res = array();
    // $cur_res['WFRequestID'] = $row_1['WFRequestID'];
    // array_push($all_wfrequest, $cur_res);
    array_push($all_wfrequest, $row_1);
  }
}

echo json_encode($all_wfrequest);
?>
