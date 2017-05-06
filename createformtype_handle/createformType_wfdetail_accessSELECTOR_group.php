<?php

require_once('../connect.php');

$pr_userid = array();
// $q_SELECT_userpriority = "SELECT UserID FROM `userpriority` WHERE `PriorityID`='2' ";
$q_SELECT_userpriority = "SELECT UserID FROM `userpriority` WHERE `PriorityID`='2' OR `PriorityID`='1'";
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


die(json_encode($data));

?>
