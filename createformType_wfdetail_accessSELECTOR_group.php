<?php

require_once('connect.php');
$q_SELECT_usergroup = "SELECT UserID FROM `usergroup` WHERE  `GroupID` = '1' "; //approver groupID = 1

$result_SELECT_usergroup=$mysqli->query($q_SELECT_usergroup);

$userid = array();
$i = 0;
while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
  $userid[$i] = $row_SELECT_usergroup['UserID'];
  $i++;
}

$groupid = array();
$j = 0;
for($i=0; $i< sizeof($userid); $i++){
  $q_SELECT_usergroup = "SELECT * FROM `usergroup` WHERE `UserID` = '$userid[$i]' ";
  $result_SELECT_usergroup = $mysqli->query($q_SELECT_usergroup);

  while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
      $groupid[$j] = $row_SELECT_usergroup['GroupID'];
      $j++;
  }
}
$groupid_unique = array_unique($groupid);
$group_send = array();

for($i=0; $i< sizeof($groupid_unique); $i++){
  if($groupid_unique[$i]){
    $q_SELECT_ugroup = "SELECT * FROM `ugroup` WHERE `GroupID` = '$groupid_unique[$i]' ";
    $result_SELECT_ugroup=$mysqli->query($q_SELECT_ugroup);
    while($row_SELECT_ugroup=$result_SELECT_ugroup->fetch_array()){
      $group_send[$i] = $result_SELECT_ugroup->fetch_array();
    }

  }
}



die( json_encode($group_send) );


?>
