<?php
require_once('../connect.php');
$data = array();
$q = "SELECT * FROM ugroup";
$result = $mysqli -> query($q);
if ($result && $result->num_rows >= 1 ){
  while($row = $result -> fetch_array()){
    array_push($data, $row);
  }
  echo json_encode($data);
}


?>
