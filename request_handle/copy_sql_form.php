<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
if (isset($_POST['data']) ) {
   $postdata= $_POST['data'];
   $requestor_id = $postdata['requestor_id'];
   $wfgeninfo_id = $postdata['wfgeninfo'];
//copy
  if ($wfgeninfo_id != null){
    // $wfgeninfo_id = $_POST['wfgeninfo'];


    $data_select_wfgeninfo = array();
    $q_select_wfgeninfo = "SELECT * FROM wfgeninfo WHERE WFGenInfoID='$wfgeninfo_id' ";
    $result_select_wfgeninfo = $mysqli->query($q_select_wfgeninfo);
    while ($row_select_wfgeninfo=$result_select_wfgeninfo->fetch_array() ) {
      array_push($data_select_wfgeninfo, $row_select_wfgeninfo);
    }
    $date_hrs = date("H-i-s" ,time() );
    $date_day = date("Y-m-d" ,time() );
    $all_date = $date_hrs . '***' . $date_day;

    for ($i=0; $i < count($data_select_wfgeninfo); $i++) {
      $d1 =$data_select_wfgeninfo[$i];
      // $d1_createtime = $d1['CreateTime'];

      $d1_formname = $d1['FormName'];
      $d1_description = $d1['Description'];
      $d1_adminid = $d1['AdminID'];
    }
    $q_insert_wfrequest = "INSERT INTO `wfrequest`(`CreatorID`, `CreateTime`, `FormName`, `Description`, `AdminID`) values('$requestor_id', '$all_date', '$d1_formname', '$d1_description', '$d1_adminid') ";
    $mysqli->query($q_insert_wfrequest);

    $q_select_wfrequest = "SELECT WFRequestID FROM wfrequest WHERE CreatorID='$requestor_id' AND CreateTime='$all_date' AND FormName='$d1_formname' ";
    $result_select_wfrequest = $mysqli->query($q_select_wfrequest);
    $row_select_wfrequest=$result_select_wfrequest->fetch_array();
    $WFRequestID = $row_select_wfrequest['WFRequestID'];

    $data_select_wfdoc = array();
    $q_select_wfdoc = "SELECT * FROM wfdoc WHERE WFGenInfoID='$wfgeninfo_id' ";
    $result_select_wfdoc = $mysqli->query($q_select_wfdoc);
    while ($row_select_wfdoc=$result_select_wfdoc->fetch_array() ) {
      array_push($data_select_wfdoc, $row_select_wfdoc);
    }

    $doc_arr = array();

    for ($i=0; $i < count($data_select_wfdoc); $i++) {
      $d2 =$data_select_wfdoc[$i];
      $d2_docid = $d2['WFDocID'];
      $d2_docname = $d2['DocName'];
      $d2_docurl = $d2['DocURL'];
      $d2_timestamp = $d2['TimeStamp'];

      if($d2['DocName']){
        $q_insert_wfrequestdoc = "INSERT INTO `wfrequestdoc`(`WFRequestID`, `DocName`, `DocURL`, `TimeStamp`, `WFDocID`) values('$WFRequestID', '$d2_docname', '$d2_docurl', '$d2_timestamp', '$d2_docid') ";
        $mysqli->query($q_insert_wfrequestdoc);

        $q_select_wfrequestdoc = "SELECT * FROM wfrequestdoc WHERE WFRequestID='$WFRequestID' AND DocName='$d2_docname' AND DocURL='$d2_docurl' ";
        $result_select_wfrequestdoc = $mysqli->query($q_select_wfrequestdoc);
        while ($row_select_wfrequestdoc=$result_select_wfrequestdoc->fetch_array() ) {
          $doc_arr_inner = array();
          $doc_arr_inner['WFRequestDocID'] = $row_select_wfrequestdoc['WFRequestDocID'];
          $doc_arr_inner['DocName'] = $row_select_wfrequestdoc['DocName'];
          $doc_arr_inner['DocURL'] = $row_select_wfrequestdoc['DocURL'];
          $doc_arr_inner['TimeStamp'] = $row_select_wfrequestdoc['TimeStamp'];
          $doc_arr_inner['WFDocID'] = $row_select_wfrequestdoc['WFDocID'];
          array_push($doc_arr, $doc_arr_inner);
        }

      }
    }
    // wfrequestdetail need to copy parentid from wfdetail -->???
    $data_select_wfdetail = array();
    $q_select_wfdetail = "SELECT * FROM wfdetail WHERE WFGenInfoID='$wfgeninfo_id' ";
    $result_select_wfdetail = $mysqli->query($q_select_wfdetail) or trigger_error($mysqli->error."[$q_select_wfdetail]");
    while ($row_select_wfdetail=$result_select_wfdetail->fetch_array() ) {
      array_push($data_select_wfdetail, $row_select_wfdetail);
    }
$ParentStateID = 0;
$mapping_wfdetail_access = array();
    for ($i=0; $i < count($data_select_wfdetail); $i++) {
      $mapping = array();
      $d3 = $data_select_wfdetail[$i];
      $d3_statename = $d3['StateName'];
      $d3_deadline = $d3['Deadline'];
      $d3_wfdocid = $d3['WFDocID']; // array
      $d3_wfdetailid = $d3['WFDetailID'];
      //problem multi wfdocid and multi wfrequestdocid need to match them
      $this_state_request_docid = array();
      for ($j=0; $j < count($doc_arr); $j++) {
        $WFRequestDocID_l = $doc_arr[$j]['WFRequestDocID'];
        $DocName_l = $doc_arr[$j]['DocName'];
        $DocURL_l = $doc_arr[$j]['DocURL'];
        $DocTimestamp = $doc_arr[$j]['TimeStamp'];
        $DocID_l = $doc_arr[$j]['WFDocID'];
        // select WFRequestDocID that have same docname docurl in db as WFDocID
        $d3_wfdocid_array = unserialize($d3_wfdocid);
        for ($k=0; $k < count($d3_wfdocid_array); $k++) {
          if($d3_wfdocid_array[$k] == $DocID_l){
            array_push($this_state_request_docid, $WFRequestDocID_l);
          }
        }
        // if($d3_wfdocid == $DocID_l){
        //   $q_insert_wfrequestdetail = "INSERT INTO `wfrequestdetail`(`ParentID`, `StateName`, `CreateTime`, `Deadline`, `WFRequestDocID`, `WFRequestID`) values('$ParentStateID', '$d3_statename', '$all_date', '$d3_deadline', '$WFRequestDocID_l', '$WFRequestID') ";
        //   $mysqli->query($q_insert_wfrequestdetail) or trigger_error($mysqli->error."[$q_insert_wfrequestdetail]");
        //
        //   $q_SELECT_wfrequestdetail="SELECT * FROM wfrequestdetail where StateName = '$d3_statename' AND CreateTime = '$all_date' AND WFRequestDocID='$WFRequestDocID_l' AND WFRequestID='$WFRequestID' ";
        //   $result_SELECT_wfrequestdetail=$mysqli->query($q_SELECT_wfrequestdetail);
        //   while($row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array()){
        //     $ParentStateID = $row_SELECT_wfrequestdetail['WFRequestDetailID'];
        //     $mapping['WFDetailID'] = $d3_wfdetailid;
        //     $mapping['WFRequestDetailID']  = $row_SELECT_wfrequestdetail['WFRequestDetailID'];
        //     array_push($mapping_wfdetail_access, $mapping);
        //   }
        // }

      }
      $cur_request_docid = serialize($this_state_request_docid);
        $q_insert_wfrequestdetail = "INSERT INTO `wfrequestdetail`(`ParentID`, `StateName`, `CreateTime`, `Deadline`, `WFRequestDocID`, `WFRequestID`) values('$ParentStateID', '$d3_statename', '$all_date', '$d3_deadline', '$cur_request_docid', '$WFRequestID') ";
        $mysqli->query($q_insert_wfrequestdetail) or trigger_error($mysqli->error."[$q_insert_wfrequestdetail]");

        $q_SELECT_wfrequestdetail="SELECT * FROM wfrequestdetail where StateName = '$d3_statename' AND CreateTime = '$all_date' AND WFRequestDocID='$cur_request_docid' AND WFRequestID='$WFRequestID' ";
        $result_SELECT_wfrequestdetail=$mysqli->query($q_SELECT_wfrequestdetail);
        while($row_SELECT_wfrequestdetail=$result_SELECT_wfrequestdetail->fetch_array()){
          $ParentStateID = $row_SELECT_wfrequestdetail['WFRequestDetailID'];
          $mapping['WFDetailID'] = $d3_wfdetailid;
          $mapping['WFRequestDetailID']  = $row_SELECT_wfrequestdetail['WFRequestDetailID'];
          array_push($mapping_wfdetail_access, $mapping);
        }


    }

    //get wfaccess
    $q_SELECT_wfaccess="SELECT * FROM wfaccess where WFGenInfoID='$wfgeninfo_id' ";
    $result_SELECT_wfaccess=$mysqli->query($q_SELECT_wfaccess) or trigger_error($mysqli->error."[$q_SELECT_wfaccess]");
    while($row_SELECT_wfacess=$result_SELECT_wfaccess->fetch_array()){
      $access_wfdetail = $row_SELECT_wfacess['WFDetailID'];
      $access_userid = $row_SELECT_wfacess['UserID'];
      $access_groupid = $row_SELECT_wfacess['GroupID'];

      for ($i=0; $i < count($mapping_wfdetail_access) ; $i++) {
        $d_access = $mapping_wfdetail_access[$i];
        if($d_access['WFDetailID'] == $access_wfdetail){
          $WFRequestDetailID = $d_access['WFRequestDetailID'];

          $q_insert_wfrequestaccess = "INSERT INTO `wfrequestaccess`(`WFRequestID`, `WFRequestDetailID`, `UserID`, `GroupID`) values('$WFRequestID', '$WFRequestDetailID', '$access_userid', '$access_groupid' ) ";
          $mysqli->query($q_insert_wfrequestaccess) or trigger_error($mysqli->error."[$q_insert_wfrequestaccess]");
        }
      }
    }



      echo json_encode($WFRequestID);

  }else{
    echo "missing wfgeninfo";
  }
}else{
  echo "missing data";
}

?>
