<?php
require_once('../connect.php');
$test = array();
if ( isset($_POST['data']) ) {
  $data_client = $_POST['data'];
  // http://stackoverflow.com/questions/6815520/cannot-use-object-of-type-stdclass-as-array
  $data_client_d = json_decode($data_client, true);
  $wfgeninfo = $data_client_d['wfgeninfo'];
  $all_date = $data_client_d['all_date'];
  $state_doc_array = $data_client_d['state_doc_array'];

  $ParentStateID = null;
  for ($i=0; $i < count($state_doc_array); $i++) {
    if ($state_doc_array[$i]) {
      $cur_state_doc_array = $state_doc_array[$i];
      $statename = $cur_state_doc_array['statename'];
      $deadline = $cur_state_doc_array['deadline'];
      $docarr = $cur_state_doc_array['docarr'];
      // http://stackoverflow.com/questions/3413291/how-to-store-an-array-into-mysql
      $string_docarray = serialize($docarr);
      $q_INSERT_wfdetail="INSERT INTO wfdetail(ParentID,StateName,CreateTime,ModifyTime,Deadline,WFDocID,WFGenInfoID) values('$ParentStateID' , '$statename' , '$all_date' , 'null' , '$deadline' , '$string_docarray', '$wfgeninfo') " ;
      $result_INSERT_wfdetail=$mysqli->query($q_INSERT_wfdetail);

      // get ParentID
      $q_SELECT_wfdetail="SELECT * FROM wfdetail where StateName = '$statename' AND CreateTime = '$all_date' ";
      $result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
      while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
        $ParentStateID = $row_SELECT_wfdetail['WFDetailID'];
      }
    }
  }

  $q_SELECT_wfdetail = "SELECT * FROM `wfdetail` WHERE  `WFGenInfoID` = '$wfgeninfo' ";
  // get WfgenInfoID
  $result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
  $data = array();
  $i = 0;
  while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
    // $wfgeninfoID = $row_SELECT_wfgeninfo['WFGenInfoID'];
    $data[$i] = $row_SELECT_wfdetail;
    $i++;
  }
  die(json_encode($data));
}


// $state_array = $_POST['state_array'];
// if(!isset($_POST['doc_id'])){echo 'dont get doc id';}
// $doc_id_array = $_POST['doc_id'];
// $deadline_arr = $_POST['deadline'];
//

// $date_hrs = date("h-i-s");
// $date_day = date("Y-m-d");
// $all_date = $date_hrs . '***' . $date_day;
// if(!isset($_POST['all_date'])){die("all_date lost");}
// $all_date = $_POST['all_date'];
// $wfgeninfoID = $_POST['wfgeninfo'];

// $ParentStateID = null;

// for($i = 0; $i < count($state_array); $i++){
//   if($state_array[$i]){
//     $q_INSERT_wfdetail="INSERT INTO wfdetail(ParentID,StateName,CreateTime,ModifyTime,Deadline,WFDocID,WFGenInfoID) values('$ParentStateID' , '$state_array[$i]' , '$all_date' , 'null' , '$deadline_arr[$i]' , '$doc_id_array[$i]', '$wfgeninfoID') " ;
//     $result_INSERT_wfdetail=$mysqli->query($q_INSERT_wfdetail);
//
//     // get ParentID
//     $q_SELECT_wfdetail="SELECT * FROM wfdetail where StateName = '$state_array[$i]' AND CreateTime = '$all_date' ";
//     $result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
//     while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
//       $ParentStateID = $row_SELECT_wfdetail['WFDetailID'];
//     }
//
//   }
// }
//
// $q_SELECT_wfdetail = "SELECT * FROM `wfdetail` WHERE  `WFGenInfoID` = '$wfgeninfoID' ";
// // get WfgenInfoID
// $result_SELECT_wfdetail=$mysqli->query($q_SELECT_wfdetail);
// $data = array();
// $i = 0;
// while($row_SELECT_wfdetail=$result_SELECT_wfdetail->fetch_array()){
//   // $wfgeninfoID = $row_SELECT_wfgeninfo['WFGenInfoID'];
//   $data[$i] = $row_SELECT_wfdetail;
//   $i++;
// }
// die(json_encode($data));


?>
