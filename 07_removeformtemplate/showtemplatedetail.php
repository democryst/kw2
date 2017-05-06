<?php
require_once('../connect.php');

if (isset($_POST['data'])) {
  $dataparse = $_POST['data'];
  $userid = $dataparse['userid'];
  $wfgeninfoid = $dataparse['wfgeninfo_id'];

  $wfdetailarray = array();
  $q = "SELECT * FROM wfdetail WHERE WFGenInfoID='$wfgeninfoid'";
  $result = $mysqli->query($q);
  while ($row=$result->fetch_array() ) {
    array_push($wfdetailarray, $row);
  }

  $wfdocarray = array();
  $q2 = "SELECT * FROM wfdoc WHERE WFGenInfoID='$wfgeninfoid'";
  $result2 = $mysqli->query($q2);
  while ($row2=$result2->fetch_array() ) {
    array_push($wfdocarray, $row2);
  }

  $data = array();
  $data['wfdoc'] = $wfdocarray;
  $data['wfdetail'] = $wfdetailarray;

  echo json_encode($data);
}

?>
