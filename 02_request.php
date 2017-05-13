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
						window.location = '01_createformType_multidoc.php';
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
		$("#Request").click(function(){
				// alert('Move to request!');
				window.location = '02_request.php';
		});
		$("#RequestList").click(function(){
				// alert('Move to current request form list!');
				window.location = '02_request_list.php';
		});
		<?php
			if ($_SESSION['gName'] == 'Approver') {
		?>
		$("#Approve").click(function(){
				// alert('Move to current work form list!');
				window.location = '03_approver.php';
		});
		<?php
			}
		?>
		//************************************************************

    $.post("request_handle/request_avialable_form.php", {requestor_id: user_id}, function(response){
			var all_form = JSON.parse(response);
			fn1_loopform(all_form);
		});



		// function fn1_loopform(all_f){
		// 	for (i = 0; i < all_f.length; i++) {
		// 		var c_form = all_f[i];
		// 		let formname = c_form.FormName;
		// 		let description = c_form.Description;
		// 		let wfgeninfo = c_form.WFGenInfoID;
		// 		fn2_strout(formname, description, wfgeninfo, i);
		// 	}
		// }
		//
		// function fn2_strout(formname, description, wfgeninfo, index){
		// 	var showformlist = "<div class='cardbox' style='margin-top:10px;font-size:small;color:black;'><div style='display:block;'><Text style='margin-left:10px;display:block;'>FormName : "+formname+"</Text><text style='margin-left:10px;display:block;'>Description : "+description+"</text></div> <input type=hidden value='"+wfgeninfo+"' name='wfgeninfoID' id='wfgeninfoID"+index+"'> <div style='direction: rtl;'><input type='button' value='Select' id='chose_form_btn_"+index+"' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></div> </div>";
		// 	// var showformlist = "<tr><td><Text>FormName : "+formname+"</Text></td><td><input type=hidden value='"+wfgeninfo+"' name='wfgeninfoID' id='wfgeninfoID"+index+"'><text>Description : "+description+"</text></td> <td><input type='button' value='Select' id='chose_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></td></tr>";
		// 	$(showformlist).appendTo("#all-form-table");
		// 	$("#chose_form_btn_"+index+"").click(function(){
		// 		//need to show wfrequestdetail of that particular form
		// 		fn_formdetail(wfgeninfo, index);
		//
		// 		// $("#file-download-table").empty();
		// 		// $("#file-upload-table").empty();
		// 		// // $.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: user_id}}, function(response){
		// 		// // 	doc_ret=JSON.parse(response);
		// 		// // 	fn3_fileshow(doc_ret);
		// 		// // });
		// 		// $.post("request_handle/showwfdoc.php", {data: {wfgeninfo: wfgeninfo, requestor_id: user_id}}, function(response){
		// 		// 	doc_ret=JSON.parse(response);
		// 		// 	fn3_fileshow(doc_ret);
		// 		// });
		//
		// 	});
		//
		// }
		//
		// function fn_formdetail(wfgeninfo, index) {
		// 	$.post("request_handle/showformdetail.php", {wfgeninfo: wfgeninfo}, function(res){
		// 		console.log(res);
		// 		//show some data
		//
		//
		// 		//request form
		// 		// $("#RequestBtn_"+index+"").click(function(){
		// 		// 	$.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: requestor_id}}, function(response){
		// 		// 		wfrequestid=JSON.parse(response);
		// 		// 		console.log(wfrequestid);
		// 		// 	});
		// 		// });
		// 	});
		//
		// }

		// function fn3_fileshow(doc){
		// 	// for (var j = 0; j < doc.length; j++) {
		// 	// 	doc_obj = doc[j];
		// 	// 	WFRequestDocID = doc_obj['WFRequestDocID'];
		// 	// 	filename = doc_obj['DocName'];
		// 	// 	filepath = doc_obj['DocURL'];
		// 	// 	str_f_download = "<tr> <tr><td><Text>filename : "+filename+"</Text></td></tr> <tr><td><a target="_tab" href='"+localhost+filepath+"'>Download</a></td></tr> </tr>";
		// 	// 	$(str_f_download).appendTo("#file-download-table");
		// 	//
		// 	// 	let str_f_upload = "<tr> <td><Text>filename : "+filename+"</Text><input type='hidden' value='"+user_id+"' name='user_id' ><input type='hidden' value='"+filename+"' name='filename_arr[]' ><input type='hidden' value='"+WFRequestDocID+"' name='WFRequestDocID_arr[]' ></td> <td><input type='file' name='file_array[]'></td> </tr>";
		// 	// 	console.log(str_f_upload);
		// 	// 	$(str_f_upload).appendTo("#file-upload-table");
		// 	// }
		// 	for (var j = 0; j < doc.length; j++) {
		// 		doc_obj = doc[j];
		// 		WFDocID = doc_obj['WFDocID'];
		// 		filename = doc_obj['DocName'];
		// 		filepath = doc_obj['DocURL'];
		// 		var requestor_id = doc_obj['requestor_id'];
		// 		var wfgeninfo = doc_obj['wfgeninfo'];
		// 		str_f_download = "<tr> <tr><td><a target='_tab' href='"+localhost+filepath+"'><img src='images/Document.ico' height='52' width='52'></a></td></tr> <tr><td><Text>filename : "+filename+"</Text></td></tr>  </tr>";
		// 		$(str_f_download).appendTo("#file-download-table");
		//
		// 		// let str_f_upload = "<tr> <td><Text>filename : "+filename+"</Text><input type='hidden' value='"+requestor_id+"' name='requestor_id' ><input type='hidden' value='"+filename+"' name='filename_arr[]' ><input type='hidden' value='"+WFDocID+"' name='WFDocID_arr[]' ></td> <td><input type='file' name='file_array[]'></td> </tr>";
		// 		let str_f_upload = "<tr> <td><table style='font-size:small;'><tr><td><img src='images/Document.ico' height='52' width='52'></td></tr><tr><td><Text>filename : "+filename+"</Text><input type='hidden' value='"+requestor_id+"' name='requestor_id' ><input type='hidden' value='"+filename+"' name='filename_arr[]' ><input type='hidden' value='"+WFDocID+"' name='WFDocID_arr[]' ></td></tr></table></td> <td><input type='file' name='file_array[]' id='uploadfile_"+j+"'></td> </tr>";
		// 		console.log(str_f_upload);
		// 		$(str_f_upload).appendTo("#file-upload-table");
		// 	}
		//
		// 	$("#file_upload").click(function(){
		// 		let chkval = 0;
		// 		for (var j = 0; j < doc.length; j++) {
		// 			let fileuploadname = $("#uploadfile_"+j+"").val();
		// 			if ( fileuploadname.length == 0) {
		// 				chkval = 1;
		// 			}else{
		// 				console.log(fileuploadname);
		// 			}
		// 		}
		// 		if (chkval == 0) {
		// 			// do post
		// 			console.log("can upload file");
		// 			$.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: requestor_id}}, function(response){
		// 				wfrequestid=JSON.parse(response);
		// 				str_f2_upload = "<tr><td><input type='hidden' value='"+wfrequestid+"' name='wf_requestid'></td></tr>";
		// 				$(str_f2_upload).appendTo("#file-upload-table");
		// 				// fn3_fileshow(doc_ret);
		// 			}).then(function(){
		// 				var formData = new FormData($('#upload_form')[0]);
		// 				$.ajax({
		// 					 url: 'request_handle/request_doc_handle.php',
		// 					 type: 'POST',
		// 					 data: formData,
		// 					 async: false,
		// 					 cache: false,
		// 					 contentType: false,
		// 					 enctype: 'multipart/form-data',
		// 					 processData: false,
		// 					 success: function (response) {
		// 					 console.log(response);
		// 					 }
		// 				});
		// 				return false;
		//
		// 			});
		// 		}else {
		// 			console.log("can't upload file");
		// 			alert('please upload required document!');
		// 		}
		// 		// $.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: requestor_id}}, function(response){
		// 		// 	wfrequestid=JSON.parse(response);
		// 		// 	str_f2_upload = "<tr><td><input type='hidden' value='"+wfrequestid+"' name='wf_requestid'></td></tr>";
		// 		// 	$(str_f2_upload).appendTo("#file-upload-table");
		// 		// 	// fn3_fileshow(doc_ret);
		// 		// }).then(function(){
		// 		// 	var formData = new FormData($('#upload_form')[0]);
		// 		// 	$.ajax({
		// 		// 		 url: 'request_handle/request_doc_handle.php',
		// 		// 		 type: 'POST',
		// 		// 		 data: formData,
		// 		// 		 async: false,
		// 		// 		 cache: false,
		// 		// 		 contentType: false,
		// 		// 		 enctype: 'multipart/form-data',
		// 		// 		 processData: false,
		// 		// 		 success: function (response) {
		// 		// 		 console.log(response);
		// 		// 		 }
		// 		// 	});
		// 		// 	return false;
		// 		//
		// 		// });
		//
		//
		// 	});
		//
		//
		// }

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
		var showformlist = "<div class='cardbox' style='margin-top:10px;font-size:small;color:black;'><div style='display:block;'><Text style='margin-left:10px;display:block;'>FormName : "+formname+"</Text><text style='margin-left:10px;display:block;'>Description : "+description+"</text></div> <input type=hidden value='"+wfgeninfo+"' name='wfgeninfoID' id='wfgeninfoID"+index+"'> <div style='direction: rtl;'><input type='button' value='Select' id='chose_form_btn_"+index+"' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></div> </div>";
		// var showformlist = "<tr><td><Text>FormName : "+formname+"</Text></td><td><input type=hidden value='"+wfgeninfo+"' name='wfgeninfoID' id='wfgeninfoID"+index+"'><text>Description : "+description+"</text></td> <td><input type='button' value='Select' id='chose_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></td></tr>";
		$(showformlist).appendTo("#all-form-table");
		$("#chose_form_btn_"+index+"").click(function(){
			//need to show wfrequestdetail of that particular form
			fn_formdetail(wfgeninfo, index);

		});

	}

	function fn_formdetail(wfgeninfo, index) {
		$.post("request_handle/showformdetail.php", {wfgeninfo: wfgeninfo}, function(res){
			console.log(res);
			ret_wfdetail_doc = JSON.parse(res);
			let ret_wfdetail = ret_wfdetail_doc[0];
			console.log(ret_wfdetail);
			let ret_wfdoc = ret_wfdetail_doc[1];
			console.log(ret_wfdoc);
			$("#form_wf").empty();
			let wfgeninfo = ret_wfdetail_doc[2];
			console.log(wfgeninfo);
			//show some data

			let str_state = "<div class='makeinline' id='formdoc' style='margin-top: 10'></div><div id='formdetail' style='margin-top: 10'></div>"
			$(str_state).appendTo("#form_wf");

			$("#formdoc").empty();
			$("#formdetail").empty();
			let str_doc_state = "<div ><b style='color:#D73289;'>Require documents</b></div>";
			str_doc_state = str_doc_state + "<div><table id='formdoc_box' style='font-size:small;'></table></div>";
			$(str_doc_state).appendTo("#formdoc");
			$("#formdoc_box").empty();
			let str_fn_formdetail = "<div><b style='color:#D73289;'>Form workflow</b></div>"
			$(str_fn_formdetail).appendTo("#formdetail");

			var str_doc_state_l = "<tr>";
			for (var j = 0; j < ret_wfdoc.length; j++) {
				let DocURL = ret_wfdoc[j].DocURL;
				let DocName = ret_wfdoc[j].DocName;
				str_doc_state_l = str_doc_state_l +"<td><div><a target='_tab' href='"+localhost+DocURL+"'><img src='images/Document.ico' height='52' width='52'></a></div> <div><Text>"+DocName+"</Text></div> </td> <td></td>";
			}
			str_doc_state_l = str_doc_state_l + "</tr>";
			$(str_doc_state_l).appendTo("#formdoc_box");

			for (var i = 0; i < ret_wfdetail.length; i++) {
				let c_wfdetail = ret_wfdetail[i];
				let str_fn_formdetail = "<div> <div class='makeinline'><Text>StateName : "+c_wfdetail.StateName+"</Text> <Text style='margin-left:10'>Deadline : "+c_wfdetail.Deadline+"</Text> <Text style='margin-left:10'>Access by : "+c_wfdetail.GroupName+"</Text> </div> </div>";
				$(str_fn_formdetail).appendTo("#formdetail");
			}

			//request form
			$("#RequestBtn").click(function(){
				if (ret_wfdetail.length != 0) {
					$.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: user_id}}, function(response){
						console.log(response);
						// wfrequestid=JSON.parse(response);
						// console.log(wfrequestid);
					});
				}
			});
		});

	}




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
        	<!-- <table id="all-form-table" style='margin-left:5%;'></table> -->
					<div id="all-form-table" style='margin-left:5%;'></div>
				</form>
      </div>
			<!-- <div id="download_page">
        <h2>file list</h2>
				<form id="download_form">
        	<table id="file-download-table" style="margin-left:5%;font-size:small;color:black;"></table>
				</form>
				<div class="right">
          <input type="button" value="next" id="next_upload_page" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;' >
        </div>
      </div>

			<div id="upload_page">
        <h2>Upload file</h2>
				<form id="upload_form">
        	<table id="file-upload-table" style="margin-left:5%;font-size:small;color:black;"></table>
				</form>
				<div class="right">
          <input type="button" value="upload" id="file_upload" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'">
        </div>
      </div> -->
			<div id="selectform_page">
				<h2>Form Workflow</h2>
				<div id="form_wf" style="margin-left:5%;font-size:small;"></div>
				<div class="right">
					<input type="button" value="Request" id="RequestBtn" style="">
				</div>
			</div>

		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
