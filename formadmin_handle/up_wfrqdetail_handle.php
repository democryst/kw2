<?php
require_once('../connect.php');
$data_parse = $_POST['data_obj'];
$WFrqDetail_ID = $data_parse['WFrqDetail_ID'];
$Parent_ID = $data_parse['Parent_ID'];
$WFrqDoc_ID = $data_parse['WFrqDoc_ID'];
if ($Parent_ID != 0) {
  //get wfrequestaccess of currentstate --> Later we will to change WFRequestDetailID of this access
  $q_s_wfa = "SELECT * FROM wfrequestaccess WHERE WFRequestDetailID='$WFrqDetail_ID' ";
  $result_s_wfa = $mysqli->query($q_s_wfa);
  $row_s_wfa = $result_s_wfa->fetch_array();
  $cur_wfa = $row_s_wfa['WFRequestAccessID'];

  //get wfrequestaccess of parent --> Later we will to change WFRequestDetailID of this access
  $q_s_wfa_p = "SELECT * FROM wfrequestaccess WHERE WFRequestDetailID='$Parent_ID' ";
  $result_s_wfa_p = $mysqli->query($q_s_wfa_p);
  $row_s_wfa_p = $result_s_wfa_p->fetch_array();
  $cur_wfa_parent = $row_s_wfa_p['WFRequestAccessID'];

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
  // (2.5.0) get WFRequestID
  $q_select_wfrequestid = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$WFrqDetail_ID'";
  $result_select_wfrequestid = $mysqli->query($q_select_wfrequestid);
  $row_select_wfrequestid = $result_select_wfrequestid->fetch_array();

  // (2.5.1) check parent exist in history if exist then exit() script --> dont want to allow user to work with finish work
  $q_select_his_1 = "SELECT * FROM history WHERE WFRequestDetailID='$Parent_ID' ";
  $result_select_his_1 = $mysqli->query($q_select_his_1);
  if($result_select_his_1 && $result_select_his_1->num_rows >= 1){
    die( json_encode($row_select_wfrequestid) );
  }

  // (2.5.2) check current exist in history if exist then exit() script  --> dont want to allow user to work with finish work
  $q_select_his_2 = "SELECT * FROM history WHERE WFRequestDetailID='$WFrqDetail_ID' ";
  $result_select_his_2 = $mysqli->query($q_select_his_1);
  if($result_select_his_2 && $result_select_his_2->num_rows >= 1){
    die( json_encode($row_select_wfrequestid) );
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

  $q_update_ctop = "UPDATE `wfrequestdetail` SET `ParentID`='$s_3_parent', `StateName`='$s_3_statename', `CreateTime`='$s_3_createtime', `ModifyTime`='$s_3_modifytime', `Deadline`='$s_3_deadline', `WFRequestDocID`='$s_3_wfrequestdocid', `State`='$s_3_state', `Priority`='$s_3_priority', `DoneBy`='$s_3_doneby',`Status`='$s_3_status' WHERE `WFRequestDetailID`='$Parent_ID' ";
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

  $q_update_ptoc = "UPDATE `wfrequestdetail` SET `ParentID`='$s_4_parent', `StateName`='$s_4_statename', `CreateTime`='$s_4_createtime', `ModifyTime`='$s_4_modifytime', `Deadline`='$s_4_deadline', `WFRequestDocID`='$s_4_wfrequestdocid', `State`='$s_4_state', `Priority`='$s_4_priority', `DoneBy`='$s_4_doneby', `Status`='$s_4_status' WHERE `WFRequestDetailID`='$WFrqDetail_ID' ";
  $result_update_ptoc  = $mysqli->query($q_update_ptoc);

  //update access
  $q_update_cur_access = "UPDATE `wfrequestaccess` SET `WFRequestDetailID`='$Parent_ID' WHERE `WFRequestAccessID`='$cur_wfa' ";
  $result_cur_access  = $mysqli->query($q_update_cur_access);

  $q_update_parent_access = "UPDATE `wfrequestaccess` SET `WFRequestDetailID`='$WFrqDetail_ID' WHERE `WFRequestAccessID`='$cur_wfa_parent' ";
  $result_parent_access  = $mysqli->query($q_update_parent_access);

  // (5) Is parent currentworklist check
  $q_select_curwl_1 = "SELECT * FROM currentworklist WHERE WFRequestDetailID='$Parent_ID' ";
  $result_select_curwl_1 = $mysqli->query($q_select_curwl_1);
  if($result_select_curwl_1 && $result_select_curwl_1->num_rows >= 1){
    while ($row_select_curwl_1 = $result_select_curwl_1->fetch_array() ) {
      $cur1_CurrentWorkListID = $row_select_curwl_1['CurrentWorkListID'];
    }
    //need to delete old currentworklist
    $q_delete_1 = "DELETE FROM currentworklist WHERE CurrentWorkListID='$cur1_CurrentWorkListID'";
    // $mysqli->query($q_delete_1);
  	$result_delet_1 = $mysqli->query($q_delete_1) or trigger_error($mysqli->error."[$q_delete_1]");
    //insert new currentworklist
    $newwfrqdetailid = $child['WFRequestDetailID'];
    $q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$Parent_ID', '$s_3_statename', '$s_3_state', '$s_3_priority', '$s_3_doneby', '$s_3_status', '$s_4_starttime', '$s_4_endtime', '0', CURRENT_TIMESTAMP) " ;
  	// $mysqli->query($q_INSERT_currentworklist);
    $result_INSERT_currentworklist = $mysqli->query($q_INSERT_currentworklist) or trigger_error($mysqli->error."[$q_INSERT_currentworklist]");
  }

  echo json_encode($row_select_wfrequestid);

}


?>
