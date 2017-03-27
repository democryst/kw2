<?php
require_once('../connect.php');
if (isset($_POST['requestor_id']) ) {
  $requestor_id = $_POST['requestor_id'];

$data = array();
$q = "SELECT * FROM wfgeninfo";
$result = $mysqli->query($q);
while ($row=$result->fetch_array() ) {
  array_push($data, $row);
}

  echo json_encode($data);
}

?>
