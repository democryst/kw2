<?php
require_once('../connect.php');
$group_id = $_POST['group_id'];


$q_SELECT_usergroup = "SELECT UserID FROM `usergroup` WHERE  `GroupID` = '$group_id' "; //approver groupID = 1

$result_SELECT_usergroup=$mysqli->query($q_SELECT_usergroup);

$userid = array();
$i = 0;
while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
  $userid[$i] = $row_SELECT_usergroup['UserID'];
  $i++;
}

$userid_u = array_unique($userid);

$data = array();
for($i=0; $i< count($userid_u); $i++){
  $q_SELECT_user = "SELECT * FROM `user` WHERE  `UserID` = '$userid_u[$i]' ";
  $result_SELECT_user=$mysqli->query($q_SELECT_user);

  while($row_SELECT_user=$result_SELECT_user->fetch_array()){
    $data[$i] = $row_SELECT_user;
  }
}

echo json_encode($data);

?>
