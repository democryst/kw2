//WFGenInfoID   ok
//WFDetailID    need to pass from wfdetail
//UserID        ajax
//GroupID       q form userID ajax


<?php
require_once('connect.php');
$wfdetailID_array = $_POST['wfdetailID'];
$wfgeninfoID = $_POST['wfgeninfo'];
$user_id_array = $_POST['user_id'];
$groupid = array();
//********* only test this time b/c interface forget to let user to decide to depend on group or individual
for($i = 0; $i < count($user_id_array); $i++){
  if($user_id_array[$i]){
      echo($user_id_array[$i]);
      $q_SELECT_usergroup = "SELECT GroupID FROM usergroup WHERE UserID = '$user_id_array[$i]' ";
      $result_SELECT_usergroup = $mysqli->query($q_SELECT_usergroup);
      while($row_SELECT_usergroup=$result_SELECT_usergroup->fetch_array()){
        $groupid[$i] = $row_SELECT_usergroup['GroupID'];// it will produce error if user have many group
      }
  }
}

//**********************************************

for($i = 0; $i < count($wfdetailID_array); $i++){
  if($wfdetailID_array[$i]){

      $q_INSERT_wfaccess="INSERT INTO wfaccess(WFGenInfoID,WFDetailID,UserID,GroupID) values('$wfgeninfoID','$wfdetailID_array[$i]','$user_id_array[$i]','$groupid[$i]') " ;
      $result_INSERT_wfaccess=$mysqli->query($q_INSERT_wfaccess);
  }
}



?>
