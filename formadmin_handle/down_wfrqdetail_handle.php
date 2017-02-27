<?php
require_once('../connect.php');
$data_parse = $_POST['data_obj'];
$WFrqDetail_ID = $data_parse['WFrqDetail_ID'];
$Parent_ID = $data_parse['Parent_ID'];
$WFrqDoc_ID = $data_parse['WFrqDoc_ID'];

  // (1)query wfrequestdetail where WFRequestDetailID = $WFrqDetail_ID (+ trade parentid of it with child id)
  $q_select_current = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$WFrqDetail_ID'";
  $result_select_current = $mysqli->query($q_select_current);
  $current = array();
  while ($row_select_current = $result_select_current->fetch_array()) {
    $current['WFRequestDetailID'] = $row_select_current['WFRequestDetailID'];
    $current['ParentID'] = $row_select_current['ParentID'];
    $current['StateName'] = $row_select_current['StateName'];
    $current['CreateTime'] = $row_select_current['CreateTime'];
    $current['ModifyTime'] = $row_select_current['ModifyTime'];
    $current['Deadline'] = $row_select_current['Deadline'];
    $current['WFRequestDocID'] = $row_select_current['WFRequestDocID'];
    $current['State'] = $row_select_current['State'];
    $current['Priority'] = $row_select_current['Priority'];
    $current['DoneBy'] = $row_select_current['DoneBy'];
    $current['Status'] = $row_select_current['Status'];
    $current['StartTime'] = $row_select_current['StartTime'];
    $current['EndTime'] = $row_select_current['EndTime'];
    $current['WFRequestID'] = $row_select_current['WFRequestID'];
  }
  // (1.2) find child of (1)  --> and if no child make it not echo any value
  $q_1_2 = "SELECT WFRequestDetailID FROM wfrequestdetail WHERE ParentID='$WFrqDetail_ID'";
  $result_1_2 = $mysqli->query($q_1_2);
  if($result_1_2 && $result_1_2->num_rows >= 1){
    $row_1_2 = $result_1_2->fetch_array();
    $child_wfrqdetailID=$row_1_2['WFRequestDetailID'];


    // (2)query wfrequestdetail where WFRequestDetailID =  (get parentid of (1) and replace it parentid)
    $q_select_child = "SELECT * FROM wfrequestdetail WHERE WFRequestDetailID='$child_wfrqdetailID'";
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
    // (2.5.0) get WFRequestID
    $q_select_wfrequestid = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$WFrqDetail_ID'";
    $result_select_wfrequestid = $mysqli->query($q_select_wfrequestid);
    $row_select_wfrequestid = $result_select_wfrequestid->fetch_array();

    // (2.5.1) check current exist in history if exist then exit() script --> dont want to allow user to work with finish work
    $q_select_his_1 = "SELECT * FROM history WHERE WFRequestDetailID='$WFrqDetail_ID' ";
    $result_select_his_1 = $mysqli->query($q_select_his_1);
    if($result_select_his_1 && $result_select_his_1->num_rows >= 1){
      die( json_encode($row_select_wfrequestid) );
    }

    // (2.5.2) check child exist in history if exist then exit() script  --> dont want to allow user to work with finish work
    $q_select_his_2 = "SELECT * FROM history WHERE WFRequestDetailID='$child_wfrqdetailID' ";
    $result_select_his_2 = $mysqli->query($q_select_his_1);
    if($result_select_his_2 && $result_select_his_2->num_rows >= 1){
      die( json_encode($row_select_wfrequestid) );
    }

    // (3)replace(update) current position with (3)
    $s_3_parent = $current['ParentID'];
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

    $q_update_ctocur = "UPDATE `wfrequestdetail` SET `ParentID`='$s_3_parent', `StateName`='$s_3_statename', `CreateTime`='$s_3_createtime', `ModifyTime`='$s_3_modifytime', `Deadline`='$s_3_deadline', `WFRequestDocID`='$s_3_wfrequestdocid', `State`='$s_3_state', `Priority`='$s_3_priority', `DoneBy`='$s_3_doneby', `Status`='$s_3_status' WHERE `WFRequestDetailID`='$WFrqDetail_ID' ";
    $result_update_ctop  = $mysqli->query($q_update_ctocur);

    // (4)replace(update) child postion with (1)
    $s_4_parent = $child['ParentID'];
    $s_4_statename = $current['StateName'];
    $s_4_createtime = $current['CreateTime'];
    $s_4_modifytime = $current['ModifyTime'];
    $s_4_deadline = $current['Deadline'];
    $s_4_wfrequestdocid = $current['WFRequestDocID'];
    $s_4_state = $current['State'];
    $s_4_priority = $current['Priority'];
    $s_4_doneby = $current['DoneBy'];
    $s_4_status = $current['Status'];
    $s_4_starttime = $current['StartTime'];
    $s_4_endtime = $current['EndTime'];

    $q_update_curtoc = "UPDATE `wfrequestdetail` SET `ParentID`='$s_4_parent', `StateName`='$s_4_statename', `CreateTime`='$s_4_createtime', `ModifyTime`='$s_4_modifytime', `Deadline`='$s_4_deadline', `WFRequestDocID`='$s_4_wfrequestdocid', `State`='$s_4_state', `Priority`='$s_4_priority', `DoneBy`='$s_4_doneby', `Status`='$s_4_status' WHERE `WFRequestDetailID`='$child_wfrqdetailID' ";
    $result_update_ptoc  = $mysqli->query($q_update_curtoc);

    // (5) Is current currentworklist check
    $q_select_curwl_1 = "SELECT * FROM currentworklist WHERE WFRequestDetailID='$WFrqDetail_ID' ";
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
      $q_INSERT_currentworklist="INSERT INTO `currentworklist`(`WFRequestDetailID`, `StateName`, `State`, `Priority`, `DoneBy`, `Status`, `StartTime`, `EndTime`, `ApproveStatus`, `TimeStamp`) values('$WFrqDetail_ID', '$s_3_statename', '$s_3_state', '$s_3_priority', '$s_3_doneby', '$s_3_status', '$s_4_starttime', '$s_4_endtime', '0', CURRENT_TIMESTAMP) " ;
      // $mysqli->query($q_INSERT_currentworklist);
      $result_INSERT_currentworklist = $mysqli->query($q_INSERT_currentworklist) or trigger_error($mysqli->error."[$q_INSERT_currentworklist]");
    }
    echo json_encode($row_select_wfrequestid);
  }





?>
