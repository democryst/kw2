<?php
require_once('../connect.php');
if (isset($_POST['userid'])) {
  $userid=$_POST['userid'];
  $q="SELECT * FROM user WHERE UserID = '$userid' ";
  $res = $mysqli -> query($q);
	if ($res && $res->num_rows == 1 ){
    $row = $res -> fetch_array();
    echo json_encode($row);
  }
}
?>
