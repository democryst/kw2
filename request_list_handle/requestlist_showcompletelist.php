<?php
require_once('../connect.php');

$userid =  $_POST['requestor_id'];
$data = array();
$q = "SELECT wfrequest.FormName,history.WFRequestDocID,wfrequest.CreateTime,history.WfdocType  FROM wfrequestdetail,history,wfrequest WHERE history.WFRequestDetailID = wfrequestdetail.WFRequestDetailID AND wfrequestdetail.WFRequestID=wfrequest.WFRequestID AND wfrequest.CreatorID='$userid' AND history.WhatDone='9'";
$result = $mysqli->query($q);
if ($result && $result->num_rows>=1) {
  while ( $row=$result->fetch_array() ) {
    $box = array();
    $doc = array();
    $box['FormName']= $row['FormName'];
    $box['CreateTime']= $row['CreateTime'];
    $box['WFRequestDocID']= unserialize($row['WFRequestDocID']);
    $WFRequestDocID_arr= unserialize($row['WFRequestDocID']);
    $box['WfdocType'] = $row['WfdocType'];
    if ($row['WfdocType'] == 0) {
      for ($i=0; $i < count($WFRequestDocID_arr); $i++) {
        $WFRequestDocID_cur = $WFRequestDocID_arr[$i];
        $q2 = "SELECT * FROM wfrequestdoc WHERE WFRequestDocID='$WFRequestDocID_cur'";
        $result2 = $mysqli->query($q2);
        $row2=$result2->fetch_array();
        $box2 = array();
        $box2['DocName'] = $row2['DocName'];
        $box2['DocURL'] = $row2['DocURL'];
        // $box2['WfdocType'] = $row2['WfdocType'];  //no use bc need to know where this doc come from bf select doc
        array_push($doc, $box2);
      }
    }else {
      for ($i=0; $i < count($WFRequestDocID_arr); $i++) {
        $WFRequestDocID_cur = $WFRequestDocID_arr[$i];
        $q2 = "SELECT * FROM wfrequestdoctemplate WHERE WFRequestTemplateDocID='$WFRequestDocID_cur'";
        $result2 = $mysqli->query($q2);
        $row2=$result2->fetch_array();
        $box2 = array();
        $box2['DocName'] = $row2['DocName'];
        $box2['DocURL'] = $row2['DocURL'];
        // $box2['WfdocType'] = $row2['WfdocType'];  //no use bc need to know where this doc come from bf select doc
        array_push($doc, $box2);
      }
    }



    $box['Document'] = $doc;
    array_push($data, $box);
  }
  echo json_encode($data);
}


?>
