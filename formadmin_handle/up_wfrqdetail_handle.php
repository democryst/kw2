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
  $s_3_parent = $parent['ParentID'];
  $s_3_statename = $child['StateName'];
  $s_3_createtime = $child['CreateTime'];
  $s_3_modifytime = $child['ModifyTime'];
  $s_3_deadline = $child['Deadline'];
  $s_3_wfrequestdocid = $child['WFRequestDocID'];
  $s_3_state = $child['State'];
  $s_3_priority = $child['Priority'];
  $s_3_doneby = $child['DoneBy'];
  $s_3_status = $child['Status'];
  $s_3_starttime = $child['StartTime'];
  $s_3_endtime = $child['EndTime'];
    //test
    // $t1 = array();
    // array_push($t1,$s_3_parent);
    // array_push($t1,$s_3_statename);
    // array_push($t1,$s_3_createtime);
    // array_push($t1,$s_3_modifytime);
    // array_push($t1,$s_3_deadline);
    // array_push($t1,$s_3_wfrequestdocid);
    // array_push($t1,$s_3_priority);
    // array_push($t1,$s_3_doneby);
    // array_push($t1,$s_3_status);
    // array_push($t1,$s_3_starttime);
    // array_push($t1,$s_3_endtime);
  $q_update_ctop = "UPDATE `wfrequestdetail` SET `ParentID`='$s_3_parent', `StateName`='$s_3_statename', `CreateTime`='$s_3_createtime', `ModifyTime`='$s_3_modifytime', `Deadline`='$s_3_deadline', `WFRequestDocID`='$s_3_wfrequestdocid', `State`='$s_3_state', `Priority`='$s_3_priority', `DoneBy`='$s_3_doneby',`Status`='$s_3_status', `StartTime`='$s_3_starttime', `EndTime`='$s_3_endtime' WHERE `WFRequestDetailID`='$Parent_ID' ";
// echo json_encode($q_update_ctop);
  $result_update_ctop  = $mysqli->query($q_update_ctop);
  // (4)replace(update) child postion with (2)
  $s_4_parent = $child['ParentID'];
  $s_4_statename = $parent['StateName'];
  $s_4_createtime = $parent['CreateTime'];
  $s_4_modifytime = $parent['ModifyTime'];
  $s_4_deadline = $parent['Deadline'];
  $s_4_wfrequestdocid = $parent['WFRequestDocID'];
  $s_4_state = $parent['State'];
  $s_4_priority = $parent['Priority'];
  $s_4_doneby = $parent['DoneBy'];
  $s_4_status = $parent['Status'];
  $s_4_starttime = $parent['StartTime'];
  $s_4_endtime = $parent['EndTime'];
    //test
    // $t2 = array();
    // array_push($t2,$s_4_parent);
    // array_push($t2,$s_4_statename);
    // array_push($t2,$s_4_createtime);
    // array_push($t2,$s_4_modifytime);
    // array_push($t2,$s_4_deadline);
    // array_push($t2,$s_4_wfrequestdocid);
    // array_push($t2,$s_4_priority);
    // array_push($t2,$s_4_doneby);
    // array_push($t2,$s_4_status);
    // array_push($t2,$s_4_starttime);
    // array_push($t2,$s_4_endtime);
  $q_update_ptoc = "UPDATE `wfrequestdetail` SET `ParentID`='$s_4_parent', `StateName`='$s_4_statename', `CreateTime`='$s_4_createtime', `ModifyTime`='$s_4_modifytime', `Deadline`='$s_4_deadline', `WFRequestDocID`='$s_4_wfrequestdocid', `State`='$s_4_state', `Priority`='$s_4_priority', `DoneBy`='$s_4_doneby', `Status`='$s_4_status', `StartTime`='$s_4_starttime', `EndTime`='$s_4_endtime' WHERE `WFRequestDetailID`='$WFrqDetail_ID' ";
  $result_update_ptoc  = $mysqli->query($q_update_ptoc);


  // $retobj = array();
  // array_push($retobj, $parent);
  // array_push($retobj, $child);
  //   //test
  //   array_push($retobj, $t1);
  //   array_push($retobj, $t2);
  //test
  // echo json_encode($retobj);
  $q_select_wfrequestid = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$WFrqDetail_ID'";
  $result_select_wfrequestid = $mysqli->query($q_select_wfrequestid);
  $row_select_wfrequestid = $result_select_wfrequestid->fetch_array();
  echo json_encode($row_select_wfrequestid);

}


?>
