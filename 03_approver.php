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

	let userid = 1;//test approver id

	$(document).ready(function() {
		$("#current_work_list_page").show();
		$("#currentwork_select_page").hide();
		$("#file_upload_page").hide();
		$("#comment_page").hide();

		$("#Next_file_upload_page").click(function(){
			$("#current_work_list_page").hide();
			$("#currentwork_select_page").hide();
			$("#file_upload_page").show();
			$("#comment_page").hide();

		});

		//test
	  $.post("approver_handle/approver_show_worklist_handle.php", {cur_userid: userid}, function(data){
	 		var json_return_approve_currentworklist = JSON.parse(data);
	 		var approve_cur_arr_l = json_return_approve_currentworklist.length;
	 		showcurrentworklist(json_return_approve_currentworklist, approve_cur_arr_l);
	  });

	 function showcurrentworklist(json_return_approve_currentworklist, approve_cur_arr_l){
	 	for(i=0; i<approve_cur_arr_l; i++){
	 		var wfrequestdetailID = json_return_approve_currentworklist[i].WFDetailID;
	 		var StateName = json_return_approve_currentworklist[i].StateName;
	 		showcurrentworklist_2(wfrequestdetailID, StateName, i);
	 	}
	 }

	 function showcurrentworklist_2(wfrequestdetailID, StateName, index){
	 	$.post("approver_handle/approver_worklist_wfrequest.php", {cur_wfrequestdetailID: wfrequestdetailID} ,function(data){
	 		 var json_return_approve_currentworklist_wfrequest = JSON.parse(data);
	 		 //use wfrequestdetailID to query in wfrequest --then--> use CreatorID to query in userid
	 		 	 let FormName = json_return_approve_currentworklist_wfrequest.FormName;
	 			 let requesterName = json_return_approve_currentworklist_wfrequest.Name + " " + json_return_approve_currentworklist_wfrequest.Surname;
	 			 var str_aprove_currentworklist = "<tr><td><Text>FormName : "+FormName+"</Text></td><td><input type=hidden value='"+wfrequestdetailID+"' name='wfrequestdetailID' id='wfrequestdetailID_"+index+"'><text>State : "+StateName+"</text></td> <td><text> Request By : "+requesterName+"</text></td><td><input type='button' value='Select' id='select_work_btn_"+index+"'></td></tr>";
	 			 $(str_aprove_currentworklist).appendTo("#current-work-table");

				 	$("#select_work_btn_"+index+"").click(function(){
				 				$("#current_work_list_page").hide();
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
									 var str_file_download_table = '<tr><td><Text>'+filename+'</Text></td></tr><tr><td><a target="_tab" href="'+localhost+filepath+'">Download</a><td></tr>';
									 $(str_file_download_table).appendTo("#file-download-table");
									//  var str_file_download_table = str_file_download_table+'<tr>';
									// 	for(j=0; j<json_return_wfrequestdoc.length; j++){
									// 		var filepath = json_return_wfrequestdoc[j].DocURL;
									// 		var filename = json_return_wfrequestdoc[j].DocName;
									// 		str_file_download_table = str_file_download_table+'<td> <tr><td><text>'+filename+'<text><td></tr> <tr><td> <a href="'+localhost+filepath+'">Download</a></td></tr> </td>';
									// 	}
									// str_file_download_table = str_file_download_table+'</tr>';
									// $(str_file_download_table).appendTo("#file-download-table");

									var DocID = json_return_wfrequestdoc.WFDocID;
									var str_file_upload_table = '<tr><td><input type="hidden" value='+DocID+' name="fileupload[]"><Text>File:'+filename+'</Text></td><td><input type="file" value="upload" id="file_array[]"></td></tr>';
									str_file_upload_table = str_file_upload_table+'<tr><td><input type="button" value="Upload" id="upload_btn"></td></tr>';
									$(str_file_upload_table).appendTo("#file-upload-table");
								});

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

				<p class="menu-color" id="Login">Login</p>
				<p class="menu-color" id="Request">Request</p>
				<p class="menu-color" id="Approve">Current form list</p>

		</div>

		<div id="div_content" class="form">
      <div id="current_work_list_page">
        <h2>Approve list</h2>
				<form action="apporver_currentwork_wfrequestdoc.php" method="post" id="currentwork_wfrequestdoc">
        	<table id="current-work-table"></table>
				</form>
      </div>

      <div id="currentwork_select_page">
        <h2>Student graduation form</h2><!--need to change name according to one that select-->
        <table id="file-download-table"></table>
				<div class="right">
          <input type="button" value="Next" id="Next_file_upload_page" style="width: 90px;">
        </div>
      </div>

      <div id="file_upload_page">
        <h2>File upload</h2>
        <table id="file-upload-table"></table>
        <div class="right">
          <input type="button" value="Approve" id="approve_form" style="width: 90px;">
          <input type="button" value="Reject" id="reject_form" style="width: 90px;">
        </div>
      </div>

      <div id=comment_page>
        <h2>Comment</h2>
        <table id="approver_comment-table"></table>
      </div>

		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
