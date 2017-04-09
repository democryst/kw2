<?php
require_once('../connect.php');
date_default_timezone_set("Asia/Bangkok");
$data = $_POST['data'];

$userid =  $data['userid'];
$docid =  $data['docid'];
$fileupdate =  $data['fileupdate'];

		$upload_destination = "../uploads/";
		$pathname;
		$date_hrs = date("H-i-s");
		$date_day = date("Y-m-d");

		if(isset($_FILES['file_array'])){


			$name_array = $_FILES['file_array']['name'];
			$tmp_name_array = $_FILES['file_array']['tmp_name'];
			$type_array = $_FILES['file_array']['type'];
			$size_array = $_FILES['file_array']['size'];
			$error_array = $_FILES['file_array']['error'];  //return 1 if error

			for($i = 0; $i < count($tmp_name_array); $i++){
				if($tmp_name_array[$i]){
		      $WFRequestDocID = $WFRequestDocID_arr[$i];

					$ext = explode('.', $name_array[$i]);
					$fname = strtolower(reset($ext));
					$ext = strtolower(end($ext));
					//$file = md5_file($tmp_name_array[$i]) . '_' . time() . '.' .$ext;
					//$file = $fname . '_' . $date_hrs . '.' .$ext;
						$file = $fname . '_' . time() . '.' .$ext;
					$dirname = "approver_" . $date_day;

					if(!is_dir($upload_destination . $dirname)){
						mkdir( $upload_destination . $dirname ,0777);
					}
					$pathname = $upload_destination . $dirname .'/';

					if(move_uploaded_file($tmp_name_array[$i], $pathname.$file)){

						// to add destination fro storing it later in database
		        $pathname = "uploads/" . $dirname .'/';
						$destination = $pathname . $file;

						$DocName = $fname . $ext;

		        $q_update_wfrequestdoc = "UPDATE `wfrequestdoc` SET `DocName`='$DocName',`DocURL`='$destination',`TimeStamp`=CURRENT_TIMESTAMP WHERE `WFRequestDocID`='$WFRequestDocID' ";
		        $result_update_wfrequestdoc  = $mysqli->query($q_update_wfrequestdoc);


						// $q_INSERT_wfdoc="INSERT INTO `wfdoc`(`WFGenInfoID`, `DocName`, `DocURL`, `TimeStamp`) values('$wfgeninfoID', '$DocName', '$destination', CURRENT_TIMESTAMP) " ;
						// $mysqli->query($q_INSERT_wfdoc);

					}else{
						exit();
					}

				}



			}

		// Synchronous XMLHttpRequest on the main thread is deprecated because of its detrimental effects to the end user’s experience. For more help http://xhr.spec.whatwg.org/
	}// file exist

}



?>
