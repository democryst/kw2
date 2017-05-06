<?php
require_once('../connect.php');

/*
if(isset($_POST['form_name'])){
$form_name = $_POST['form_name'];
$form_description = "description";

$adminid = 2;
*/
$state_array = $_POST['state_array'];
if(!isset($_POST['doc_id'])){echo 'dont get doc id';}
$doc_id_array = $_POST['doc_id'];
$deadline_arr = $_POST['deadline'];


$date_hrs = date("h-i-s");
$date_day = date("Y-m-d");
// $all_date = $date_hrs . '***' . $date_day;
if(!isset($_POST['all_date'])){die("all_date lost");}
$all_date = $_POST['all_date'];
$wfgeninfoID = $_POST['wfgeninfo'];

$ParentStateID = null;

for($i = 0; $i < count($state_array); $i++){
  if($state_array[$i]){
    $q_INSERT_wfdetail="INSERT INTO wfdetail(ParentID,StateName,CreateTime,ModifyTime,Deadline,WFDocID,WFGenInfoID) values('$ParentStateID' , '$state_array[$i]' , '$all_date' , 'null' , '$deadline_arr[$i]' , '$doc_id_array[$i]', '$wfgeninfoID') " ;
    $result_INSERT_wfdetail=$mysqli->query($q_INSERT_wfdetail);

    // get ParentID
    $q_SELECT_wfdetail="SELECT * FROM wfdetail where StateName = '$state_array[$i]' AND CreateTime = '$all_date' ";
    $result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
    while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
      $ParentStateID = $row_SELECT_wfdetail['WFDetailID'];
    }

  }
}

$q_SELECT_wfdetail = "SELECT * FROM `wfdetail` WHERE  `WFGenInfoID` = '$wfgeninfoID' ";
// get WfgenInfoID
$result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
$data = array();
$i = 0;
while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
  // $wfgeninfoID = $row_SELECT_wfgeninfo['WFGenInfoID'];
  $data[$i] = $row_SELECT_wfdetail;
  $i++;
}
die(json_encode($data));


?>
