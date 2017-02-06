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
	$("#currentwork_select_page").hide();
	$("#file_upload_page").hide();
	$("#comment_page").hide();
	$.post("approver_worklist_handle.php", {data: userid}, function(data){
		 var json_return_approve_currentworklist = JSON.parse(data);
	}).then({
		for(i=0; i<json_return_approve_currentworklist.length; i++){
			let wfrequestdetailID = json_return_approve_currentworklist[i].WFRequestDetailID;
			let StateName = json_return_approve_currentworklist[i].StateName;
			$.post("approver_worklist_wfrequest.php", {data: wfrequestdetailID}, function(data){
				 var json_return_approve_currentworklist_wfrequest = JSON.parse(data);
				 //use wfrequestdetailID to query in wfrequest --then--> use CreatorID to query in userid
			}).then({
				let requesterName = json_return_approve_currentworklist_wfrequest.Name + " " + json_return_approve_currentworklist_wfrequest.Surname;
				var str_aprove_currentworklist = "<tr><td><input type=hidden value='"+wfrequestdetailID+"' name='wfrequestdetailID'><text>"+StateName+"</text></td> <td><text>requestor : "+requesterName+"</text></td><td><input type='button' value='Select' id='select_work_btn'></td></tr>";
				$(str_aprove_currentworklist).appendTo("#current-work-table");

				$("#select_work_btn").click(function(){
					$("#current_work_list_page").hide();
					$("#currentwork_select_page").show();
					$("#file_upload_page").hide();
					$("#comment_page").hide();
					var formData = new FormData($('#currentwork_wfrequestdoc')[0]);
					$.ajax({
						 url: 'currentwork_wfrequestdoc.php',
						 type: 'POST',
						 data: formData,
						 async: false,
						 cache: false,
						 contentType: false,
						 enctype: 'multipart/form-data',
						 processData: false,
						 success: function (response) {
						//  console.log(response);
						 json_return_wfrequestdoc = JSON.parse(response);

						 }
					}).then(function(json_return_wfrequestdoc){
						var str_file_download_table+'<tr>';
						for(j=0; j<json_return_wfrequestdoc.length; j++){

							var filename = json_return_wfrequestdoc[j].DocName;
							str_file_download_table = str_file_download_table+'<td> <tr><td><text>'+filename+'<text><td></tr> <tr><td> <input type="button" value="Download" id="file_download_'+j+'"></td></tr> </td>';
						}
						str_file_download_table = str_file_download_table+'</tr>';
						$(str_file_download_table).appendTo("#file-download-table");

						for(j=0; j<json_return_wfrequestdoc.length; j++){
							// var filepath = json_return_wfrequestdoc[j].DocURL;
							$('file_download_'+j+'').click({
								$.post("approver_work_filedownload.php", {data: json_return_wfrequestdoc[j].DocURL}, function(data){
									 //file download
 // http://php.net/manual/en/function.readfile.php

								});
							});
						}
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
				<form action="currentwork_wfrequestdoc.php" method="post" id="currentwork_wfrequestdoc">
        	<table id="current-work-table"></table>
				</form>
      </div>

      <div id="currentwork_select_page">
        <h2>Student graduation form</h2><!--need to change name according to one that select-->
        <table id="file-download-table"></table>
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
