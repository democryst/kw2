<?php
//redirect to localhost and access with id root no password and database mapplacesort
$mysqli = new mysqli('localhost','root','','kw2_multi_doc');
if($mysqli->connect_errno){
  echo $mysqli->connect_errno.": ".$mysqli->connect_error;
}
//set database connect to be utf8
mysqli_set_charset($mysqli, 'utf8mb4');
?>
