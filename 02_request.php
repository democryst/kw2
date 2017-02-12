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
  //user_id = $_SESSION['user_id'];
  user_id = 0;


	$(document).ready(function() {
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
			var showformlist = "<tr><td><Text>FormName : "+formname+"</Text></td><td><input type=hidden value='"+wfgeninfo+"' name='wfgeninfoID' id='wfgeninfoID"+index+"'><text>Description : "+description+"</text></td> <td><input type='button' value='Select' id='chose_form_btn_"+index+"'></td></tr>";
			$(showformlist).appendTo("#all-form-table");
			$("#chose_form_btn_"+index+"").click(function(){
				$.post("request_handle/copy_sql_form.php", {data: {wfgeninfo: wfgeninfo, requestor_id: user_id}}, function(response){
					doc_ret=JSON.parse(response);
					fn3_fileshow(doc_ret);
				});
			});

		}

		function fn3_fileshow(doc){
			for (var j = 0; j < doc.length; j++) {
				doc_obj = doc[j];
				WFRequestDocID = doc_obj['WFRequestDocID'];
				filename = doc_obj['DocName'];
				filepath = doc_obj['DocURL'];
				str_f_download = "<tr> <tr><td><Text>filename : "+filename+"</Text></td></tr> <tr><td><a href='"+localhost+filepath+"'>Download</a></td></tr> </tr>";
				$(str_f_download).appendTo("#file-download-table");

				let str_f_upload = "<tr> <td><Text>filename : "+filename+"</Text><input type='hidden' value='"+user_id+"' name='user_id' ><input type='hidden' value='"+filename+"' name='filename_arr[]' ><input type='hidden' value='"+WFRequestDocID+"' name='WFRequestDocID_arr[]' ></td> <td><input type='file' name='file_array[]'></td> </tr>";
				console.log(str_f_upload);
				$(str_f_upload).appendTo("#file-upload-table");
			}
			$("#file_upload").click(function(){
				var formData = new FormData($('#upload_form')[0]);
				// $.ajax({
				// 	 url: 'request_handle/request_doc_handle.php',
				// 	 type: 'POST',
				// 	 data: formData,
				// 	 async: false,
				// 	 cache: false,
				// 	 contentType: false,
				// 	 enctype: 'multipart/form-data',
				// 	 processData: false,
				// 	 success: function (response) {
				// 	 console.log(response);
				// 	 }
				// });
				// return false;
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
          <input type="button" value="next" id="next_upload_page" style="width: 90px;">
        </div>
      </div>

			<div id="upload_page">
        <h2>Upload file</h2>
				<form id="upload_form">
        	<table id="file-upload-table"></table>
				</form>
				<div class="right">
          <input type="button" value="upload" id="file_upload" style="width: 90px;">
        </div>
      </div>


		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
