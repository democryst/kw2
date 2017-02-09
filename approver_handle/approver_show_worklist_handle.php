<?php
require_once('../connect.php');
//getuserid
$cur_userid = $_POST['cur_userid'];

$currentworklist_GroupID_arr = array();
$q_SELECT_usergroup = "SELECT GroupID FROM usergroup WHERE UserID = '$cur_userid' ";
$result_SELECT_usergroup = $mysqli->query($q_SELECT_usergroup);
$index_1 = 0;
while ($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array() ) {
  $currentworklist_GroupID_arr[$index_1] = $row_SELECT_usergroup['GroupID'];
  $index_1++;
}

// //get userid or groupid from currentworklist according to wfrequestdetailaccess
// $currentworklist_WFDetailID_arr = array();
// $q_SELECT_currentworklist = "SELECT WFRequestDetailID FROM currentworklist";
// $result_SELECT_currentworklist = $mysqli->query($q_SELECT_currentworklist);
// $index_2 = 0;
// while($row_SELECT_currentworklist = $result_SELECT_currentworklist->fetch_array() ){
//   $currentworklist_WFDetailID_arr[$index_2] = $row_SELECT_currentworklist['WFRequestDetailID'];
//   $index_2++;
// }
// $wfquestdetailID_arr = array();
// for($i=0; $i< count($currentworklist_WFDetailID_arr); $i++){
//   for($j=0; $j<count($currentworklist_GroupID_arr); $j++){
//     $q_SELECT_wfrequestaccess = "SELECT * FROM wfrequestaccess WHERE (WFRequestDetailID = '$currentworklist_WFDetailID_arr[$i]') AND (GroupID = '$currentworklist_GroupID_arr[$j]' OR UserID = '$cur_userid')";
//     $result_SELECT_wfrequestaccess = $mysqli->query($q_SELECT_wfrequestaccess);
//     $row_SELECT_wfrequestaccess=$result_SELECT_wfrequestaccess->fetch_array()
//     if(empty($row_SELECT_wfrequestaccess) ){
//       $wfquestdetailID_arr[$i][$j] = 0;
//     }else{
//       $wfquestdetailID_arr[$i][$j] = $row_SELECT_wfrequestaccess['WFRequestDetailID'];
//     }
//   }
// }
// $data = array();
// for ($i=0; $i < count($currentworklist_WFDetailID_arr); $i++) {
//   for($j=0; $j<count($currentworklist_GroupID_arr); $j++){
//     $box = $wfquestdetailID_arr[$i];
//     array_push($data,$box[$j]);
//   }
// }
//

//-------------------------------------------------------
$currentworklist_WFDetailID_arr = array();
$q_SELECT_currentworklist = "SELECT WFDetailID FROM wfdetail";
$result_SELECT_currentworklist = $mysqli->query($q_SELECT_currentworklist);
$index_2 = 0;
while($row_SELECT_currentworklist = $result_SELECT_currentworklist->fetch_array() ){
  $currentworklist_WFDetailID_arr[$index_2] = $row_SELECT_currentworklist['WFDetailID'];
  $index_2++;
}

$wfquestdetailID_arr = array();
for($i=0; $i< count($currentworklist_WFDetailID_arr); $i++){
  for($j=0; $j<count($currentworklist_GroupID_arr); $j++){
    $q_SELECT_wfrequestaccess = "SELECT * FROM wfaccess WHERE (WFDetailID = '$currentworklist_WFDetailID_arr[$i]') AND (GroupID = '$currentworklist_GroupID_arr[$j]' OR UserID = '$cur_userid')";
    $result_SELECT_wfrequestaccess = $mysqli->query($q_SELECT_wfrequestaccess);
    $row_SELECT_wfrequestaccess=$result_SELECT_wfrequestaccess->fetch_array();
    if(empty($row_SELECT_wfrequestaccess) ){
      $wfquestdetailID_arr[$i][$j] = 0;
    }else{
      $wfquestdetailID_arr[$i][$j] = $row_SELECT_wfrequestaccess['WFDetailID'];
    }
  }
}
$data = array();
for ($i=0; $i < count($currentworklist_WFDetailID_arr); $i++) {
  for($j=0; $j<count($currentworklist_GroupID_arr); $j++){
    $box = $wfquestdetailID_arr[$i];
    if($box[$j] != 0){
      array_push($data, $box[$j]);
    }
  }
}
//----------------------------------------------------------------
sort($data);
$data_u = array_values(array_unique($data));
//now have wfrequestid we will get wfrequest state statename etc...

// v1 test
$data_l = array();
for ($i=0; $i < count($data_u); $i++) {
  $q_SELECT_wfrequestdetail = "SELECT * FROM wfdetail WHERE WFDetailID = $data_u[$i]";
  $result_SELECT_wfrequestdetail = $mysqli->query($q_SELECT_wfrequestdetail);
  $row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array();
  array_push($data_l, $row_SELECT_wfrequestdetail);
}
// // v2 use
// $data_l = array();
// for ($i=0; $i < count($data_u); $i++) {
//   $q_SELECT_wfrequestdetail = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID = $data_u[$i]";
//   $result_SELECT_wfrequestdetail = $mysqli->query($q_SELECT_wfrequestdetail);
//   $row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array();
//   array_push($data_l, $row_SELECT_wfrequestdetail);
// }

die(json_encode($data_l) );
?>
