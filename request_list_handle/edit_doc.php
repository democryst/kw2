<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$userid =  $_POST['userid'];
$docid =  $_POST['docid'];


		$upload_destination = "../uploads/";
		$pathname;
		$date_hrs = date("H-i-s");
		$date_day = date("Y-m-d");

		if(isset($_FILES['file'])){


			$file_name= $_FILES['file']['name'];
			$file_tmp_name = $_FILES['file']['tmp_name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_error = $_FILES['file']['error'];  //return 1 if error
      if($file_tmp_name){
        $ext = explode('.', $file_name);
        $fname = strtolower(reset($ext));
        $ext = strtolower(end($ext));
        $file = $fname . '_' . time() . '.' .$ext;
        $dirname = 'u_' . $userid . '_' .$date_day;
      }

      if(!is_dir($upload_destination . $dirname)){
        mkdir( $upload_destination . $dirname ,0777);
      }
      $pathname = $upload_destination . $dirname .'/';

      if(move_uploaded_file($file_tmp_name, $pathname.$file)){

        // to add destination fro storing it later in database
        $pathname = "uploads/" . $dirname .'/';
        $destination = $pathname . $file;

        $DocName = $fname . $ext;

        $q_update_wfrequestdoc = "UPDATE `wfrequestdoc` SET `DocName`='$DocName',`DocURL`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDocID`='$docid' ";
        $result_update_wfrequestdoc  = $mysqli->query($q_update_wfrequestdoc);


      }else{
        exit();
      }


			// for($i = 0; $i < count($tmp_name_array); $i++){
			// 	if($tmp_name_array[$i]){
		  //     $WFRequestDocID = $WFRequestDocID_arr[$i];
      //
			// 		$ext = explode('.', $name_array[$i]);
			// 		$fname = strtolower(reset($ext));
			// 		$ext = strtolower(end($ext));
			// 		//$file = md5_file($tmp_name_array[$i]) . '_' . time() . '.' .$ext;
			// 		//$file = $fname . '_' . $date_hrs . '.' .$ext;
			// 			$file = $fname . '_' . time() . '.' .$ext;
			// 		$dirname = "approver_" . $date_day;
      //
			// 		if(!is_dir($upload_destination . $dirname)){
			// 			mkdir( $upload_destination . $dirname ,0777);
			// 		}
			// 		$pathname = $upload_destination . $dirname .'/';
      //
			// 		if(move_uploaded_file($tmp_name_array[$i], $pathname.$file)){
      //
			// 			// to add destination fro storing it later in database
		  //       $pathname = "uploads/" . $dirname .'/';
			// 			$destination = $pathname . $file;
      //
			// 			$DocName = $fname . $ext;
      //
		  //       $q_update_wfrequestdoc = "UPDATE `wfrequestdoc` SET `DocName`='$DocName',`DocURL`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDocID`='$WFRequestDocID' ";
		  //       $result_update_wfrequestdoc  = $mysqli->query($q_update_wfrequestdoc);
      //
      //
			// 			// $q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`) values('$wfgeninfoID', '$DocName', '$destination', CURRENT_TIMESTAMP) " ;
			// 			// $mysqli->query($q_INSERT_wfdoc);
      //
			// 		}else{
			// 			exit();
			// 		}
      //
			// 	}
      //
      //
      //
			// }

		// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/
	}// file exist





?>
