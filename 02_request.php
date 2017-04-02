<?php
session_start();
if(isset($_SESSION['user_id'])){
	echo "<script type='text/javascript'>
					console.log(".$_SESSION['user_id'].");
				</script>";
}
echo "<script>var user_id = " . $_SESSION['user_id'] . ";</script>";
if ( ($_SESSION['gName'] != "Requester") && ($_SESSION['gName'] != "Approver") ) {
?>
<script type='text/javascript'>
	alert('You dont have permission!');
</script>
<?php
	// if($_SESSION['gName'] == 'Requester'){
	// 	echo "<script type='text/javascript'>
	// 					window.location = '02_request_list.php';
	// 				</script>";
	// }else if($_SESSION['gName'] == 'Approver'){
	// 	echo "<script type='text/javascript'>
	// 					window.location = '03_approver.php';
	// 				</script>";
	// }else
	if($_SESSION['gName'] == 'Flow_Admin'){
		echo "<script type='text/javascript'>
						window.location = '04_formmodify.php?user_id=".$_SESSION['user_id']."';
					</script>";
	}else if($_SESSION['gName'] == 'Sys_Admin'){
		echo "<script type='text/javascript'>
						window.location = '01_createformType.php';
					</script>";
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<!--style type="text/css">
	</style-->
	<link rel="stylesheet" href="default.css">

	<title>KW2</title>

	<!-- //this line redirect to get jquery in current computer   -->
	<script src="scripts/jquery-2.0.0.min.js"></script>

	<script type="text/javascript">
	var localhost = "http://localhost:8080/kw2/";

  // user_id = 0;


	$(document).ready(function() {
		//************************************************************
		$("#Logout").click(function(){
				window.location = '06_logout.php';
		});
		// $("#Request").click(function(){
		// 		alert('Move to request!');
		// 		window.location = '02_request.php';
		// });
		$("#RequestList").click(function(){
				// alert('Move to current request form list!');
				window.location = '02_request_list.php';
		});
		<?php
			if ($_SESSION['gName'] == 'Approver') {
		?>
		$("#Approve").click(function(){
				// alert('Move to current work form list!');
				window.location = '02_request_list.php';
		});
		<?php
			}
		?>
		//************************************************************

    $.post("request_handle/request_avialable_form.php", {requestor_id: user_id}, function(response){
			var all_form = JSON.parse(response);
			fn1_loopform(all_form);
		});



		function fn1_loopform(all_f){
			for (i = 0; i < all_f.length; i++) {
				var c_form = all_f[i];
				let formname = c_form.FormName;
				let description = c_form.Description;
				let wfgeninfo = c_form.WFGenInfoID;
				fn2_strout(formname, description, wfgeninfo, i);
			}
		}

		function fn2_strout(formname, description, wfgeninfo, index){
			var showformlist = "<tr><td><Text>FormName : "+formname+"</Text></td><td><input type=hidden value='"+wfgeninfo+"' name='wfgeninfoID' id='wfgeninfoID"+index+"'><text>Description : "+description+"</text></td> <td><input type='button' value='Select' id='chose_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></td></tr>";
			$(showformlist).appendTo("#all-form-table");
			$("#chose_form_btn_"+index+"").click(function(){
				// $.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: user_id}}, function(response){
				// 	doc_ret=JSON.parse(response);
				// 	fn3_fileshow(doc_ret);
				// });
				$.post("request_handle/showwfdoc.php", {data: {wfgeninfo: wfgeninfo, requestor_id: user_id}}, function(response){
					doc_ret=JSON.parse(response);
					fn3_fileshow(doc_ret);
				});
			});

		}

		function fn3_fileshow(doc){
			// for (var j = 0; j < doc.length; j++) {
			// 	doc_obj = doc[j];
			// 	WFRequestDocID = doc_obj['WFRequestDocID'];
			// 	filename = doc_obj['DocName'];
			// 	filepath = doc_obj['DocURL'];
			// 	str_f_download = "<tr> <tr><td><Text>filename : "+filename+"</Text></td></tr> <tr><td><a href='"+localhost+filepath+"'>Download</a></td></tr> </tr>";
			// 	$(str_f_download).appendTo("#file-download-table");
			//
			// 	let str_f_upload = "<tr> <td><Text>filename : "+filename+"</Text><input type='hidden' value='"+user_id+"' name='user_id' ><input type='hidden' value='"+filename+"' name='filename_arr[]' ><input type='hidden' value='"+WFRequestDocID+"' name='WFRequestDocID_arr[]' ></td> <td><input type='file' name='file_array[]'></td> </tr>";
			// 	console.log(str_f_upload);
			// 	$(str_f_upload).appendTo("#file-upload-table");
			// }
			for (var j = 0; j < doc.length; j++) {
				doc_obj = doc[j];
				WFDocID = doc_obj['WFDocID'];
				filename = doc_obj['DocName'];
				filepath = doc_obj['DocURL'];
				var requestor_id = doc_obj['requestor_id'];
				var wfgeninfo = doc_obj['wfgeninfo'];
				str_f_download = "<tr> <tr><td><Text>filename : "+filename+"</Text></td></tr> <tr><td><a href='"+localhost+filepath+"'>Download</a></td></tr> </tr>";
				$(str_f_download).appendTo("#file-download-table");

				let str_f_upload = "<tr> <td><Text>filename : "+filename+"</Text><input type='hidden' value='"+requestor_id+"' name='requestor_id' ><input type='hidden' value='"+filename+"' name='filename_arr[]' ><input type='hidden' value='"+WFDocID+"' name='WFDocID_arr[]' ></td> <td><input type='file' name='file_array[]'></td> </tr>";
				console.log(str_f_upload);
				$(str_f_upload).appendTo("#file-upload-table");
			}

			$("#file_upload").click(function(){

				$.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: requestor_id}}, function(response){
					wfrequestid=JSON.parse(response);
					str_f2_upload = "<tr><td><input type='hidden' value='"+wfrequestid+"' name='wf_requestid'></td></tr>";
					$(str_f2_upload).appendTo("#file-upload-table");
					// fn3_fileshow(doc_ret);
				}).then(function(){
					var formData = new FormData($('#upload_form')[0]);
					$.ajax({
						 url: 'request_handle/request_doc_handle.php',
						 type: 'POST',
						 data: formData,
						 async: false,
						 cache: false,
						 contentType: false,
						 enctype: 'multipart/form-data',
						 processData: false,
						 success: function (response) {
						 console.log(response);
						 }
					});
					return false;
				});


			});


		}

	});





	</script>
</head>
<body>

<div id="wrapper">
	<div id="div_header">
		SIIT Form Workflow System
	</div>
	<div id="div_subhead">

	</div>
	<div id="div_main">
		<div id="div_left">

				<!-- <p class="menu-color" id="Login">Login</p> -->
				<p class="menu-color" id="Request">Request</p>
				<p class="menu-color" id="RequestList">Current request form list</p>
				<?php
					if ($_SESSION['gName'] == 'Approver') {
				?>
				<p class="menu-color" id="Approve">Current work form list</p>
				<?php
					}
				?>
				<p class="menu-color" id="Logout">Logout</p>

		</div>

		<div id="div_content" class="form">
      <div id="current_work_list_page">
        <h2>Request list</h2>
				<form id="chose_available_form">
        	<table id="all-form-table"></table>
				</form>
      </div>
			<div id="download_page">
        <h2>file list</h2>
				<form id="download_form">
        	<table id="file-download-table"></table>
				</form>
				<div class="right">
          <input type="button" value="next" id="next_upload_page" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;' >
        </div>
      </div>

			<div id="upload_page">
        <h2>Upload file</h2>
				<form id="upload_form">
        	<table id="file-upload-table"></table>
				</form>
				<div class="right">
          <input type="button" value="upload" id="file_upload" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'">
        </div>
      </div>


		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
