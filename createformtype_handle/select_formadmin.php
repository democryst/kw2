<?php

require_once('../connect.php');
$data = array();
$q = 'SELECT user.UserID, user.UserName, user.Name, user.Surname, userpriority.PriorityID FROM user, userpriority, priority WHERE user.UserID = userpriority.UserID AND userpriority.PriorityID = priority.PriorityID AND priority.PriorityID = "3" ';
$result = $mysqli -> query($q);
if ($result && $result->num_rows >= 1 ){
  while($row = $result -> fetch_array()){
    array_push($data, $row);
  }
  echo json_encode($data);
}


?>
