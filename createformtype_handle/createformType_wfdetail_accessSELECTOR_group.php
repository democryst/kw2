<?php

require_once('../connect.php');
// $q_SELECT_usergroup = "SELECT UserID FROM `usergroup` WHERE  `GroupID` = '1' "; //approver groupID = 1
//
// $result_SELECT_usergroup=$mysqli->query($q_SELECT_usergroup);
//
// $userid = array();
// $i = 0;
// while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
//   $userid[$i] = $row_SELECT_usergroup['UserID'];
//   $i++;
// }
//
// $groupid = array();
// $j = 0;
// for($i=0; $i< sizeof($userid); $i++){
//   $q_SELECT_usergroup = "SELECT * FROM `usergroup` WHERE `UserID` = '$userid[$i]' ";
//   $result_SELECT_usergroup = $mysqli->query($q_SELECT_usergroup);
//
//   while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
//       $groupid[$j] = $row_SELECT_usergroup['GroupID'];
//       $j++;
//   }
// }
// $groupid_unique = array_unique($groupid);
// $group_send = array();
//
// for($i=0; $i< sizeof($groupid_unique); $i++){
//   if($groupid_unique[$i]){
//     $q_SELECT_ugroup = "SELECT * FROM `ugroup` WHERE `GroupID` = '$groupid_unique[$i]' ";
//     $result_SELECT_ugroup=$mysqli->query($q_SELECT_ugroup);
//     while($row_SELECT_ugroup=$result_SELECT_ugroup->fetch_array()){
//       $group_send[$i] = $result_SELECT_ugroup->fetch_array();
//     }
//
//   }
// }
//
//
//
// die( json_encode($group_send) );
$pr_userid = array();
$q_SELECT_userpriority = "SELECT UserID FROM `userpriority` WHERE `PriorityID`='2' ";
$result_SELECT_userpriority=$mysqli->query($q_SELECT_userpriority);
while ($row_SELECT_userpriority=$result_SELECT_userpriority->fetch_array()) {
  array_push($pr_userid, $row_SELECT_userpriority['UserID']);
}

$approver_group_arr = array();
for ($i=0; $i < count($pr_userid); $i++) {
  $approver_userid = $pr_userid[$i];
  $q_SELECT_usergroup = "SELECT GroupID FROM `usergroup` WHERE `UserID`='$approver_userid' ";
  $result_SELECT_usergroup=$mysqli->query($q_SELECT_usergroup);
  while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array() ){
    array_push($approver_group_arr, $row_SELECT_usergroup['GroupID']);
  }
}
sort($approver_group_arr);
$approver_group_arr_u = array_values(array_unique($approver_group_arr));

$data = array();
for ($i=0; $i < count($approver_group_arr_u); $i++) {
  $a_gid = $approver_group_arr_u[$i];
  $q_SELECT_group = "SELECT * FROM `ugroup` WHERE `GroupID`='$a_gid' ";
  $result_SELECT_group=$mysqli->query($q_SELECT_group);
  while( $row_SELECT_group=$result_SELECT_group->fetch_array() ){
    array_push($data, $row_SELECT_group);
  }
}

// $q_SELECT_group = "SELECT * FROM `ugroup` WHERE `GroupID` != '0' AND `GroupID` != '1' AND `GroupID` != '2' AND `GroupID` != '3' ";
// $data = array();
// $i = 0;
// $result_SELECT_group=$mysqli->query($q_SELECT_group);
// while( $row_SELECT_group=$result_SELECT_group->fetch_array() ){
//   $data[$i] = $row_SELECT_group;
//   $i++;
// }
die(json_encode($data));

?>
