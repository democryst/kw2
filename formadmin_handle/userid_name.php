<?php
require_once('../connect.php');
if (isset($_POST['data'])) {
  $dataparse = $_POST['data'];
  $userid=$dataparse['userid'];
  $jcmtlist_obj=$dataparse['jcmtlist_obj'];
  $data = array();
  $q="SELECT * FROM user WHERE UserID = '$userid' ";
  $res = $mysqli -> query($q);
	if ($res && $res->num_rows == 1 ){
    $row = $res -> fetch_array();
    $data['userinfo']=$row;
    $data['jcmtlist_obj']=$jcmtlist_obj;
    echo json_encode($data);
  }
}
?>
