<?php
session_start();
if(isset($_SESSION['user_id'])){
	echo "<script type='text/javascript'>
					console.log(".$_SESSION['user_id'].");
				</script>";
}
echo "<script>var userid = " . $_SESSION['user_id'] . ";</script>";
if ($_SESSION['gName'] != "Approver") {
?>
<script type='text/javascript'>
	alert('You dont have permission!');
</script>
<?php
	if($_SESSION['gName'] == 'Requester'){
		echo "<script type='text/javascript'>
						window.location = '02_request_list.php';
					</script>";
	}
	// else if($_SESSION['gName'] == 'Approver'){
	// 	echo "<script type='text/javascript'>
	// 					window.location = '03_approver.php';
	// 				</script>";
	// }
	else if($_SESSION['gName'] == 'Flow_Admin'){
		echo "<script type='text/javascript'>
						window.location = '04_formmodify.php';
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

	// var userid = 1;//test approver id
	var cur_wfrqstate_id;
	var cmtbyname;
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
		// $("#Approve").click(function(){
		// 		alert('Move to current work form list!');
		// 		window.location = '03_approver.php';
		// });
		//************************************************************

		$("#current_work_list_page").show();
		$("#currentwork_select_page").hide();
		$("#file_upload_page").hide();
		$("#upload_btn").hide();
		$("#comment_page").hide();

		$("#Next_file_upload_page").click(function(){
			// $("#current_work_list_page").hide();
			// $("#currentwork_select_page").hide();
			$("#file_upload_page").show();
			$("#upload_btn").hide();
			$("#comment_page").hide();

		});

		$("#backtolistpage_btn").click(function(){
			$("#current_work_list_page").show();
			$("#currentwork_select_page").hide();
			$("#file_upload_page").hide();
			$("#upload_btn").hide();
			$("#comment_page").hide();

		});

		$("#reject_form").click(function(){
			$("#current_work_list_page").show();
			$("#currentwork_select_page").hide();
			$("#file_upload_page").hide();
			$("#upload_btn").hide();
			// $("#comment_page").hide();

		});

		$("#comment_btn").click(function(){
			console.log(cur_wfrqstate_id);
			cmttxt = $("#comment_text").val();
			console.log(cmttxt);
			$.post("approver_handle/cmt_save.php",{data: {comment: cmttxt, wfrequestdetailid: cur_wfrqstate_id, userid: userid}},function(response){
				console.log(response);
				json_ret_cmtsave = JSON.parse(response);
				console.log(json_ret_cmtsave);
				if (json_ret_cmtsave.length != 0) {
					cmtlist(json_ret_cmtsave.wfrequestdetailid);
				}

			});
		});


		//test
	  $.post("approver_handle/approver_show_worklist_handle.php", {cur_userid: userid}, function(data){
	 		var json_return_approve_currentworklist = JSON.parse(data);
	 		var approve_cur_arr_l = json_return_approve_currentworklist.length;
	 		showcurrentworklist(json_return_approve_currentworklist, approve_cur_arr_l);
	  });

	 function showcurrentworklist(json_return_approve_currentworklist, approve_cur_arr_l){
	 	for(i=0; i<approve_cur_arr_l; i++){
	 		var wfrequestdetailID = json_return_approve_currentworklist[i].WFRequestDetailID;
	 		var StateName = json_return_approve_currentworklist[i].StateName;
			// var CreateTime = json_return_approve_currentworklist[i].CreateTime;
			Create_Time = json_return_approve_currentworklist[i].CreateTime;
			CreateTime = Create_Time.replace("***", " ");
	 		showcurrentworklist_2(wfrequestdetailID, StateName, CreateTime, i);
	 	}
	 }

	 function showcurrentworklist_2(wfrequestdetailID, StateName, CreateTime, index){
	 	$.post("approver_handle/approver_worklist_wfrequest.php", {cur_wfrequestdetailID: wfrequestdetailID} ,function(data){
	 		 var json_return_approve_currentworklist_wfrequest = JSON.parse(data);
	 		 //use wfrequestdetailID to query in wfrequest --then--> use CreatorID to query in userid
	 		 	 let FormName = json_return_approve_currentworklist_wfrequest.FormName;
	 			 let requesterName = json_return_approve_currentworklist_wfrequest.Name + " " + json_return_approve_currentworklist_wfrequest.Surname;
				 //  var str_aprove_currentworklist = "<tr><td><Text>FormName : "+FormName+"</Text></td><td><input type=hidden value='"+wfrequestdetailID+"' name='wfrequestdetailID' id='wfrequestdetailID_"+index+"'><text>State : "+StateName+"</text></td> <td><text> Request By : "+requesterName+"</text></td> <td><text> CreateTime : "+CreateTime+"</text></td> <td><input type='button' value='comments' id='comment_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></td> <td><input type='button' value='Select' id='select_work_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></td></tr>";
				 var str_aprove_currentworklist = "<tr><td><div class='cardbox' style='margin-top:10px;display:-moz-box;'> <div><div><Text>FormName : "+FormName+"</Text></div> <input type=hidden value='"+wfrequestdetailID+"' name='wfrequestdetailID' id='wfrequestdetailID_"+index+"'> <div><text>State : "+StateName+"</text> <text style='margin-left:10'> Request By : "+requesterName+"</text> <text> CreateTime : "+CreateTime+"</text></div></div> <div ><div ><input type='button' value='comments' id='comment_btn_"+index+"' class='btn_select'></div> <div><input type='button' value='Select' id='select_work_btn_"+index+"' class='btn_select'></div></div> </div> </td> </tr>";
	 			 $(str_aprove_currentworklist).appendTo("#current-work-table");

				 	//show comment of that state
				  $("#comment_btn_"+index+"").click(function(){
						$("#comment_page").show();
						// console.log("comment_page");
						console.log("wfrequestdetailID :");
						console.log(wfrequestdetailID);
						cur_wfrqstate_id = wfrequestdetailID;
						cmtlist(wfrequestdetailID);
						// cur_wfrqstate_id = wfrequestdetailID;
					});

				 	$("#select_work_btn_"+index+"").click(function(){
								// 	$("#current_work_list_page").hide();
				 				$("#currentwork_select_page").show();
				 				$("#file_upload_page").hide();
				 				$("#comment_page").hide();

								let wfrequestdetailID = $("#wfrequestdetailID_"+index+"").attr('value');
								console.log(wfrequestdetailID);
								$.post("approver_handle/apporver_currentwork_wfrequestdoc.php", {data: wfrequestdetailID}, function(data){
									 var json_return_wfrequestdoc = JSON.parse(data);
									 console.log(json_return_wfrequestdoc);
									 var filepath = json_return_wfrequestdoc.DocURL;
 									 var filename = json_return_wfrequestdoc.DocName;
									 $("#file-download-table").empty();
									 var str_file_download_table = '<tr><td><Text>'+filename+'</Text></td></tr><tr><td><a target="_tab" href="'+localhost+filepath+'">Download</a><td></tr>';
									 $(str_file_download_table).appendTo("#file-download-table");

									var TimeStamp = json_return_wfrequestdoc.TimeStamp;
									console.log(TimeStamp);
									var datestring = Date.parse(TimeStamp);
 									var TimeStamp_unix =  datestring/1000; //for use in php need to divide by 1000
									console.log(TimeStamp_unix);

									var CurrentWorkListID = json_return_wfrequestdoc.CurrentWorkListID;
									var DocID = json_return_wfrequestdoc.WFRequestDocID;
									console.log("User id : "+userid);
									$("#file-upload-table").empty();
									var str_file_upload_table = '<tr><td><input type="hidden" value='+CurrentWorkListID+' name="CurrentWorkListID[]"><input type="hidden" value='+TimeStamp_unix+' name="TimeStamp"><input type="hidden" value='+userid+' name="userid"><input type="hidden" value='+DocID+' name="WFRequestDocID_arr[]"><Text>File:'+filename+'</Text></td><td><input type="file" name="file_array[]"></td></tr>';
									$(str_file_upload_table).appendTo("#file-upload-table");
								});

					});

	 	});
	 }
	//  $("#upload_btn").click(function(){
	// 	//  $("[name='CurrentWorkListID[]']").val();
	// 	//  $("[name='TimeStamp[]']").val();
	// 	//  $("[name='userid']").val();
	// 	//  $("[name='WFRequestDocID_arr[]']").val();
	// 	//  $("[name='file_array[]']").val();
	 //
	// 	 var formData = new FormData($('#upload_form')[0]);
	// 	 console.log(formData);  //json formdata
	// 	 $.ajax({
	// 			url: 'approver_handle/approver_doc_handle.php',
	// 			type: 'POST',
	// 			data: formData,
	// 			async: false,
	// 			cache: false,
	// 			contentType: false,
	// 			enctype: 'multipart/form-data',
	// 			processData: false,
	// 			success: function (response) {
	// 			console.log(response);
	// 			}
	// 	 });
	// 	 return false;
	//  });
	$("#upload_btn").click(function(){
	 //  $("[name='CurrentWorkListID[]']").val();
	 //  $("[name='TimeStamp[]']").val();
	 //  $("[name='userid']").val();
	 //  $("[name='WFRequestDocID_arr[]']").val();
	 //  $("[name='file_array[]']").val();
	 if($("[name='file_array[]']").val().length!=0){
		var formData = new FormData($('#upload_form')[0]);
 		console.log(formData);  //json formdata
 		$.ajax({
 			 url: 'approver_handle/approver_approve_btn.php',
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
	 }

	});

	 $("#upload_form_btn").click(function(){
		 if($("[name='file_array[]']").val().length!=0){
			 var formData = new FormData($('#upload_form')[0]);
			 console.log(formData);  //json formdata
			 $.ajax({
					url: 'approver_handle/approver_doc_handle.php',
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
			 $("#upload_btn").show();
			 return false;
		 }
	 });

	 function cmtlist(wfrequestdetailID){
		 	$.post("approver_handle/cmt_list.php",{data: {wfrequestdetail_ID: wfrequestdetailID, userid: userid}},function(response){
				console.log(response);
				json_ret_cmtlist = JSON.parse(response);
				console.log(json_ret_cmtlist);
				console.log(json_ret_cmtlist.length);
				$("#approver_comment-table").empty();
				if (json_ret_cmtlist.length != 0) {
					// $("#approver_comment-table").empty();
					// show cmt list
					for (var i = 0; i < json_ret_cmtlist.length; i++) {
						$.post("approver_handle/userid_name.php", {data:{userid:json_ret_cmtlist[i].CommentBy, jcmtlist_obj: json_ret_cmtlist[i]}}, function(res){
							console.log(res);
							json_ret_cmt_userid_name =JSON.parse(res);
							// json_ret_cmt_userid_name =res;
							jret_userinfo = json_ret_cmt_userid_name.userinfo;
							jret_jcmtlist_obj = json_ret_cmt_userid_name.jcmtlist_obj;
							cmtbyname = jret_userinfo.Name + " "+jret_userinfo.Surname;
							cmtlist_2(jret_jcmtlist_obj, cmtbyname);
						});
						// if (json_ret_cmtlist[i].CommentBy == userid) {
						// 	m_left = 65;
						// 	// m_color = "#3c8dbc";
						// 	m_color = "violet";
						// 	str_cmtlist = "<tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+cmtbyname+"</Text></td></tr> <tr><td><Text>"+json_ret_cmtlist[i].Comment+"</Text></td></tr> <tr><td><Text>"+json_ret_cmtlist[i].CommentTime+"</Text></table></td></tr>   </td> </tr>";
						// 	$(str_cmtlist).appendTo("#approver_comment-table");
						// }else{
						// 	m_left = 10;
						// 	m_color = "purple";
						// 	str_cmtlist = "<tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+cmtbyname+"</Text></td></tr> <tr><td><Text>"+json_ret_cmtlist[i].Comment+"</Text></td></tr> <tr><td><Text>"+json_ret_cmtlist[i].CommentTime+"</Text></table></td></tr>   </td> </tr>";
						// 	$(str_cmtlist).appendTo("#approver_comment-table");
						// }
						// str_cmtlist = "<tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+json_ret_cmtlist[i].CommentBy+"</Text></td></tr> <tr><td><Text>"+json_ret_cmtlist[i].Comment+"</Text></td></tr> <tr><td><Text>"+json_ret_cmtlist[i].CommentTime+"</Text></table></td></tr>   </td> </tr>";
						// // str_cmtlist = "<tr> <td><Text>CommentBy: "+json_ret_cmtlist[i].CommentBy+"</Text></td> <td><Text>Comment: "+json_ret_cmtlist[i].Comment+"</Text></td> <td><Text>CommentTime: "+json_ret_cmtlist[i].CommentTime+"</Text></td></tr>";
						// $(str_cmtlist).appendTo("#approver_comment-table");
					}
				}
			});
	 }

	 function cmtlist_2(jret_cmtlist, cmtbyname){
		 console.log(cmtbyname);
		 if (jret_cmtlist.CommentBy == userid) {
			 m_left = 65;
			 m_color = "violet";
		 }else{
			 m_left = 10;
			 m_color = "purple";
		 }
		 str_cmtlist = "<tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+cmtbyname+"</Text></td></tr> <tr><td><Text>"+jret_cmtlist.Comment+"</Text></td></tr> <tr><td><Text>"+jret_cmtlist.CommentTime+"</Text></table></td></tr>   ";
		 $(str_cmtlist).appendTo("#approver_comment-table");
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

			<p class="menu-color" id="Request">Request</p>
			<p class="menu-color" id="RequestList">Current request form list</p>
			<p class="menu-color" id="Approve">Current work form list</p>
			<p class="menu-color" id="Logout">Logout</p>

		</div>

		<div id="div_content" class="form">
      <div id="current_work_list_page">
        <h2>Approve list</h2>
				<form action="apporver_currentwork_wfrequestdoc.php" method="post" id="currentwork_wfrequestdoc">
        	<table id="current-work-table" style="margin-left:5%;font-size:small;"></table>
				</form>
      </div>

      <div id="currentwork_select_page">
        <h2>Student graduation form</h2><!--need to change name according to one that select-->
        <table id="file-download-table" style="margin-left:5%;font-size:small;"></table>
				<div class="right">
          <input type="button" value="Next" id="Next_file_upload_page" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'>
        </div>
      </div>

      <div id="file_upload_page">
        <h2>File upload</h2>
				<form id="upload_form">
        	<table id="file-upload-table" style="margin-left:5%;font-size:small;"></table>
				</form>
				<div class="right">
					<input type="button" value="Upload" id="upload_form_btn" style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'>
        <div class="right">
					<input type="button" value="Approve" id="upload_btn" style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'>
          <!--input type="button" value="Approve" id="approve_form" style="width: 90px;"-->
          <input type="button" value="Reject" id="reject_form" style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'>
        </div>
      </div>



		</div>

		<div id=comment_page>

				<h2>Comment</h2>
				<table id="approver_comment-table"></table>
				<table id="comment_submit" style="margin-left:5%;background-color:#8282fe;border-radius:3px;border:1px solid transparent;width:450px;height:18px;color:white;font-size:small;">
					<tr>
						<td style="width:100px"><Text>Comment box: </Text></td> <td><input type="text" id="comment_text" ></td> <td><input type="button" value="comment" id="comment_btn" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'></td>
					</tr>
				</table>

				<div class="right">
					<input type="button" value="back" id="backtolistpage_btn" style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;'>
				</div>

		</div>

	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
