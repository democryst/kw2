<?php
require_once('../connect.php');

if (isset($_POST['data']) ) {
  $dataparse = $_POST['data'];
  $wfrqdetailid = $dataparse['wfrqdetailid'];
  $tempfilechose = $dataparse['tempfilechose'];
  $data_return = array();
  $data = array();
array_push($data_return, $wfrqdetailid);

  $q_wfdi = "SELECT WFRequestDocID, WFRequestID FROM wfrequestdetail WHERE WFRequestDetailID='$wfrqdetailid' ";
  $result_wfdi = $mysqli->query($q_wfdi);
  $row_wfdi=$result_wfdi->fetch_array();
  $WFRequestDocID_arr = unserialize($row_wfdi['WFRequestDocID']);
  $WFRequestID = $row_wfdi['WFRequestID'];

  if ($tempfilechose == 0 ) {
    $q = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestID='$WFRequestID' ";
    $result = $mysqli->query($q);
    while ($row=$result->fetch_array() ) {
      array_push($data, $row);
    }
  }else {
    $q_wfRD = "SELECT ParentID FROM wfrequestdetail WHERE WFRequestDetailID='$wfrqdetailid' ";
    $result_wfRD = $mysqli->query($q_wfRD);

    if ($result_wfRD && $result_wfRD->num_rows>=0) {
      $row_wfRD=$result_wfRD->fetch_array();
      $wfRD = $row_wfRD['ParentID'];

      $q_wl = "SELECT * FROM history WHERE WFRequestDetailID='$wfRD' ";
      $result_wl = $mysqli->query($q_wl);

      if ($result_wl && $result_wl->num_rows >= 1){
        $h_wl = array();
        while ($row_wl = $result_wl->fetch_array()) {
          // $WFRequestDocID = $row_wl['WFRequestDocID'];
          array_push($h_wl, unserialize($row_wl['WFRequestDocID']));
        }

        if (count($h_wl) != 0) {
          $cntwlindex = count($h_wl)-1;
          $last_WFRequestDocID_arr = $h_wl[$cntwlindex];

          for ($i=0; $i < count($last_WFRequestDocID_arr); $i++) {
            $WFRequestDocID_c = $last_WFRequestDocID_arr[$i];
            $q_doc = "SELECT * FROM wfrequestdoc WHERE WFRequestDocID='$WFRequestDocID_c' ";
            $result_doc = $mysqli->query($q_doc);
            if ($result_doc && $result_doc->num_rows >= 1){
              $row_doc = $result_doc->fetch_array();
              array_push($data, $row_doc);
            }
          }
        }else{
          $q = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestID='$WFRequestID' ";
          $result = $mysqli->query($q);
          while ($row=$result->fetch_array() ) {
            array_push($data, $row);
          }
        }
      }else {
        $q = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestID='$WFRequestID' ";
        $result = $mysqli->query($q);
        while ($row=$result->fetch_array() ) {
          array_push($data, $row);
        }
      }
    }else {
      $q = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestID='$WFRequestID' ";
      $result = $mysqli->query($q);
      while ($row=$result->fetch_array() ) {
        array_push($data, $row);
      }
    }



  }




array_push($data_return, $data);
array_push($data_return, $tempfilechose);

  echo json_encode($data_return);

  // echo json_encode($data);
}

?>
