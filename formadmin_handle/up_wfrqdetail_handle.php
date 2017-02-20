<?php
require_once('../connect.php');
$data_parse = $_POST['data_obj'];
$WFrqDetail_ID = $data_parse['WFrqDetail_ID'];
$Parent_ID = $data_parse['Parent_ID'];
$WFrqDoc_ID = $data_parse['WFrqDoc_ID'];
if ($Parent_ID != 0) {
  // (1)query wfrequestdetail where WFRequestDetailID = $WFrqDetail_ID (+ trade parentid of child with parentid of parent)
  $q_select_child = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$WFrqDetail_ID'";
  $result_select_child = $mysqli->query($q_select_child);
  $child = array();
  while ($row_select_child = $result_select_child->fetch_array()) {
    $child['WFRequestDetailID'] = $row_select_child['WFRequestDetailID'];
    $child['ParentID'] = $row_select_child['ParentID'];
    $child['StateName'] = $row_select_child['StateName'];
    $child['CreateTime'] = $row_select_child['CreateTime'];
    $child['ModifyTime'] = $row_select_child['ModifyTime'];
    $child['Deadline'] = $row_select_child['Deadline'];
    $child['WFRequestDocID'] = $row_select_child['WFRequestDocID'];
    $child['State'] = $row_select_child['State'];
    $child['Priority'] = $row_select_child['Priority'];
    $child['DoneBy'] = $row_select_child['DoneBy'];
    $child['Status'] = $row_select_child['Status'];
    $child['StartTime'] = $row_select_child['StartTime'];
    $child['EndTime'] = $row_select_child['EndTime'];
    $child['WFRequestID'] = $row_select_child['WFRequestID'];
  }

  // (2)query wfrequestdetail where WFRequestDetailID = $Parent_ID  (+ trade parentid of parent with child id)
  $q_select_parent = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$Parent_ID'";
  $result_select_parent = $mysqli->query($q_select_parent);
  $parent = array();
  while ($row_select_parent = $result_select_parent->fetch_array()) {
    $parent['WFRequestDetailID'] = $row_select_parent['WFRequestDetailID'];
    $parent['ParentID'] = $row_select_parent['ParentID'];
    $parent['StateName'] = $row_select_parent['StateName'];
    $parent['CreateTime'] = $row_select_parent['CreateTime'];
    $parent['ModifyTime'] = $row_select_parent['ModifyTime'];
    $parent['Deadline'] = $row_select_parent['Deadline'];
    $parent['WFRequestDocID'] = $row_select_parent['WFRequestDocID'];
    $parent['State'] = $row_select_parent['State'];
    $parent['Priority'] = $row_select_parent['Priority'];
    $parent['DoneBy'] = $row_select_parent['DoneBy'];
    $parent['Status'] = $row_select_parent['Status'];
    $parent['StartTime'] = $row_select_parent['StartTime'];
    $parent['EndTime'] = $row_select_parent['EndTime'];
    $parent['WFRequestID'] = $row_select_parent['WFRequestID'];
  }
  // (3)replace(update) parent position with (1)
  // $q_update_ctop = "UPDATE `wfrequestdetail` SET `WFRequestDetailID`='$child['WFRequestDetailID']',`ParentID`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDetailID`='$Parent_ID' ";
  // $result_update_ctop  = $mysqli->query($q_update_ctop);
  // (4)replace(update) child postion with (2)
  // $q_update_ptoc = "UPDATE `wfrequestdetail` SET `WFRequestDetailID`='$child['WFRequestDetailID']',`ParentID`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDetailID`='$WFrqDetail_ID' ";
  // $result_update_ptoc  = $mysqli->query($q_update_ptoc);


  $retobj = array();
  array_push($retobj, $child);
  array_push($retobj, $parent);
  //test
  echo json_encode($retobj);
}


?>
