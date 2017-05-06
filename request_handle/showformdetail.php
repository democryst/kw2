<?php
require_once('../connect.php');
if (isset($_POST['wfgeninfo']) ) {
  $wfgeninfo_id= $_POST['wfgeninfo'];

  $data_f_ret = array();
  $data_return = array();
  $q_get_state = "SELECT * FROM wfdetail WHERE WFGenInfoID='$wfgeninfo_id' ";
  $result_get_state=$mysqli->query($q_get_state) or trigger_error($mysqli->error."[$q_get_state]");
  while($row_get_state=$result_get_state->fetch_array()){
    $ret_arr = array();
    $ret_arr['WFDetailID'] = $row_get_state['WFDetailID'];
    $c_wfdetailid = $row_get_state['WFDetailID'];

    $ret_arr['ParentID'] = $row_get_state['ParentID'];
    $ret_arr['StateName'] = $row_get_state['StateName'];
    $ret_arr['CreateTime'] = $row_get_state['CreateTime'];
    $ret_arr['ModifyTime'] = $row_get_state['ModifyTime'];
    $ret_arr['Deadline'] = $row_get_state['Deadline'];
    // $ret_arr['WFDocID'] = unserialize($row_get_state['WFDocID']);
    // $WFDocIDarr = unserialize($row_get_state['WFDocID']);
    $ret_arr['TemplateFileChose'] = $row_get_state['TemplateFileChose'];
    // $ret_arr['wfgeninfo'] = $wfgeninfo_id; //WFGenInfoID

      $q_get_access = "SELECT GroupID FROM wfaccess WHERE WFDetailID='$c_wfdetailid' ";
      $result_get_access = $mysqli->query($q_get_access) or trigger_error($mysqli->error."[$q_get_access]");
      $row_get_access=$result_get_access->fetch_array();
      // $ret_arr['GroupID'] = $row_get_access['GroupID'];
      $GroupID = $row_get_access['GroupID'];

      $q_get_groupname = "SELECT GroupName FROM ugroup WHERE GroupID='$GroupID'";
      $result_get_groupname = $mysqli->query($q_get_groupname) or trigger_error($mysqli->error."[$q_get_groupname]");
      $row_get_groupname=$result_get_groupname->fetch_array();
      $ret_arr['GroupName'] = $row_get_groupname['GroupName'];

      // $doc_arr = array();
      // for ($i=0; $i < count($WFDocIDarr); $i++) {
      //   $c_wfdocid = $WFDocIDarr[$i];
      //   $q_select_doc = "SELECT * FROM wfdoc WHERE WFDocID='$c_wfdocid' ";
      //   $result_get_doc = $mysqli->query($q_select_doc) or trigger_error($mysqli->error."[$q_select_doc]");
      //   $row_get_doc=$result_get_doc->fetch_array();
      //   $box = array();
      //   $box['WFDocID'] = $row_get_doc['WFDocID'];
      //   $box['DocName'] = $row_get_doc['DocName'];
      //   $box['DocURL'] = $row_get_doc['DocURL'];
      //   array_push($doc_arr, $box);
      // }
      // $ret_arr['doc_arr'] = $doc_arr;

    array_push($data_return, $ret_arr);
  }

  $doc_arr = array();
  $q_select_doc = "SELECT * FROM wfdoc WHERE WFGenInfoID='$wfgeninfo_id' ";
  $result_get_doc = $mysqli->query($q_select_doc) or trigger_error($mysqli->error."[$q_select_doc]");
  while ($row_get_doc=$result_get_doc->fetch_array()) {
    $box2 = array();
    $box2['WFDocID'] = $row_get_doc['WFDocID'];
    $box2['DocName'] = $row_get_doc['DocName'];
    $box2['DocURL'] = $row_get_doc['DocURL'];
    array_push($doc_arr, $box2);
  }

  array_push($data_f_ret, $data_return);
  array_push($data_f_ret, $doc_arr);
  array_push($data_f_ret, $wfgeninfo_id);

        // echo json_encode($data_return);
        echo json_encode($data_f_ret);
}

?>
