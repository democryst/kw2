<?php
// need to check group or individual
require_once('connect.php');
$q_SELECT_usergroup = "SELECT UserID FROM `usergroup` WHERE  `GroupID` = '1' "; //approver group

$result_SELECT_usergroup=$mysqli->query($q_SELECT_usergroup);

$userid = array();
$i = 0;
while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
  $userid[$i] = $row_SELECT_usergroup['UserID'];
  $i++;
}

$data = array();
for($i=0; $i< sizeof($userid); $i++){
  $q_SELECT_user = "SELECT * FROM `user` WHERE  `UserID` = '$userid[$i]' ";
  $result_SELECT_user=$mysqli->query($q_SELECT_user);

  while($row_SELECT_user=$result_SELECT_user->fetch_array()){
    $data[$i] = $row_SELECT_user;
  }
}

die(json_encode($data));


?>
