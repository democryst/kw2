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
  $q_1 = "SELECT * FROM wfrequest WHERE AdminID = '$cur_userid' AND WFRequestID = '$exist_current_1[$i]' ";
  $result_1 = $mysqli->query($q_1) or trigger_error($mysqli->error."[$q_1]");

  while($row_1 = $result_1->fetch_array()){
    $cur_res = array();
    $cur_res['WFRequestID'] = $row_1['WFRequestID'];
    $cur_res['CreatorID'] = $row_1['CreatorID'];
    $cur_res['CreateTime'] = $row_1['CreateTime'];
    $cur_res['FormName'] = $row_1['FormName'];
    $cur_res['Description'] = $row_1['Description'];
    array_push($all_wfrequest, $cur_res);

  }
}
$all_wfrequest_and_creator = array();
for ($i=0; $i < count($all_wfrequest); $i++) {
  $all_wfrq = $all_wfrequest[$i];
  $CreatorID = $all_wfrq['CreatorID'];
  $q_3 = "SELECT * FROM user WHERE UserID = '$CreatorID' ";
  $result_3 = $mysqli->query($q_3);
  while ($row_3 = $result_3->fetch_array()) {
    $box = array();
    $box['Name'] = $row_3['Name'];
    $box['Surname'] = $row_3['Surname'];
    $box['WFRequestID'] = $all_wfrq['WFRequestID'];
    // $box['CreatorID'] = $all_wfrq['CreatorID'];
    $box['CreateTime'] = $all_wfrq['CreateTime'];
    $box['FormName'] = $all_wfrq['FormName'];
    $box['Description'] = $all_wfrq['Description'];
    array_push($all_wfrequest_and_creator, $box);
  }
}


echo json_encode($all_wfrequest_and_creator);
?>
