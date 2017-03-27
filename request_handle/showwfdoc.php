<?php
require_once('../connect.php');
if (isset($_POST['data']) ) {
  $postdata= $_POST['data'];
  $requestor_id = $postdata['requestor_id'];
  $wfgeninfo_id = $postdata['wfgeninfo'];

  $data_return = array();
  $q_get_file = "SELECT * FROM wfdoc WHERE WFGenInfoID='$wfgeninfo_id' ";
  $result_get_file=$mysqli->query($q_get_file) or trigger_error($mysqli->error."[$q_get_file]");
  while($row_get_file=$result_get_file->fetch_array()){
    $ret_arr = array();
    $ret_arr['WFDocID'] = $row_get_file['WFDocID'];
    $ret_arr['DocName'] = $row_get_file['DocName'];
    $ret_arr['DocURL'] = $row_get_file['DocURL'];
    $ret_arr['requestor_id'] = $requestor_id;
    $ret_arr['wfgeninfo'] = $wfgeninfo_id;
    array_push($data_return, $ret_arr);
  }

        echo json_encode($data_return);
}

?>
