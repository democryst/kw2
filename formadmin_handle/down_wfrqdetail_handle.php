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
    $q_update_ctocur = "UPDATE `wfrequestdetail` SET `ParentID`='$s_3_parent', `StateName`='$s_3_statename', `CreateTime`='$s_3_createtime', `ModifyTime`='$s_3_modifytime', `Deadline`='$s_3_deadline', `WFRequestDocID`='$s_3_wfrequestdocid', `State`='$s_3_state', `Priority`='$s_3_priority', `DoneBy`='$s_3_doneby', `Status`='$s_3_status', `StartTime`='$s_3_starttime', `EndTime`='$s_3_endtime' WHERE `WFRequestDetailID`='$WFrqDetail_ID' ";
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
    $q_update_curtoc = "UPDATE `wfrequestdetail` SET `ParentID`='$s_4_parent', `StateName`='$s_4_statename', `CreateTime`='$s_4_createtime', `ModifyTime`='$s_4_modifytime', `Deadline`='$s_4_deadline', `WFRequestDocID`='$s_4_wfrequestdocid', `State`='$s_4_state', `Priority`='$s_4_priority', `DoneBy`='$s_4_doneby', `Status`='$s_4_status', `StartTime`='$s_4_starttime', `EndTime`='$s_4_endtime' WHERE `WFRequestDetailID`='$child_wfrqdetailID' ";
    $result_update_ptoc  = $mysqli->query($q_update_curtoc);



    // $retobj = array();
    // array_push($retobj, $current);
    // array_push($retobj, $child);
    //   //test
    //   array_push($retobj, $t1);
    //   array_push($retobj, $t2);
    // //test
    // echo json_encode($retobj);
    $q_select_wfrequestid = "SELECT WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$WFrqDetail_ID'";
    $result_select_wfrequestid = $mysqli->query($q_select_wfrequestid);
    $row_select_wfrequestid = $result_select_wfrequestid->fetch_array();
    echo json_encode($row_select_wfrequestid);
  }





?>
