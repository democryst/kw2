<?php
require_once('../connect.php');

$data = array();
$q = "SELECT * FROM wfgeninfo";
$result = $mysqli->query($q);
while ($row=$result->fetch_array() ) {
  array_push($data, $row);
}

echo json_encode($data);


?>
