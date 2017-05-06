<?php
require_once('../connect.php');
if (isset($_POST['requestor_id']) ) {
  $requestor_id = $_POST['requestor_id'];

$data = array();
$q = "SELECT * FROM wfgeninfo";
$result = $mysqli->query($q);
while ($row=$result->fetch_array() ) {
  $wfgeninfoID = $row['WFGenInfoID'];

  $q2 = "SELECT * FROM wfdetail WHERE ParentID='0' AND WFGenInfoID='$wfgeninfoID'";
  $result2 = $mysqli->query($q2);
  $row2=$result2->fetch_array();
  $WFDetailID = $row2['WFDetailID'];

  $q3 = "SELECT * FROM wfaccess WHERE WFDetailID='$WFDetailID' AND WFGenInfoID='$wfgeninfoID'";
  $result3 = $mysqli->query($q3);
  while ($row3=$result3->fetch_array() ) {
    $GroupID = $row3['GroupID'];
    if ($GroupID = 7) { //ICT student
      array_push($data, $row);
    }
  }
}



  echo json_encode($data);
}

?>
