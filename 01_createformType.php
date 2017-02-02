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

		$(document).ready(function() {

			$("#CreateFormType_wfdoc").hide();
			$("#CreateFormType_wfdetail").hide();
			$("#CreateFormType_wfaccess").hide();

			$("#add_more_doc_btn").click(function(){
				var str='<tr> <td><input type="file" name="file_array[]"></td></tr>' ;
				$(str).appendTo("#upload_doc_table");
			});
			$("#add_more_state_btn").click(function(){
				var str='<tr> <td><text> Step: </text></td> <td><input type="text" name="state_array[]"></td></tr>' ;
				$(str).appendTo("#upload_state_table");
			});

			$("#Create_Form_submit_wfgeninfo").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdetail").hide();
					$("#CreateFormType_wfaccess").hide();
					$("#CreateFormType_wfdoc").show();
					  // //evt.preventDefault();
					  var formData = new FormData($('#CreateFormType_wfgeninfo')[0]);
						var json_return_wfgeninfo;
					  $.ajax({
						   url: 'createformType_geninfo_handle.php',
						   type: 'POST',
						   data: formData,
						   async: false,
						   cache: false,
						   contentType: false,
						   enctype: 'multipart/form-data',
						   processData: false,
						   success: function (response) {
							 console.log(response);
							 json_return_wfgeninfo = JSON.parse(response);

						   }
					  });
					  return false;

						//need to return WfgenInfoID
						// and return date_hrs, date_day, all_date to make data in wfdoc to be same as wfgeninfo
						// from ajax
						// Maybe return json object    <input type="hidden" value="foo" name="response" />
						var WFGenInfoID = json_return_wfgeninfo.WFGenInfoID;
						var CreateTime = json_return_wfgeninfo.CreateTime;
						var str_wfgeninfo = '<tr> <td><input type="hidden" value="'+WFGenInfoID+'" name="wfgeninfo" /></td>'+
						'<td><input type="hidden" value="'+CreateTime+'" name="all_date" /></td></tr>';
						$(str_wfgeninfo).appendTo("#upload_doc_table");
			});

			$("#Create_Form_submit_wfdoc").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfaccess").hide();
					$("#CreateFormType_wfdetail").show();
					  //evt.preventDefault();
					  var formData = new FormData($('#CreateFormType_wfdoc')[0]);
					  $.ajax({
						   url: 'createformType_doc_handle.php',
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

						//need to return WfgenInfoID from ajax
			});

			$("#Create_Form_submit_wfdetail").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfdetail").hide();
					$("#CreateFormType_wfaccess").show();
					  //evt.preventDefault();
					  // var formData = new FormData($('#CreateFormType_wfdetail')[0]);
					  // $.ajax({
						//    url: 'createFormType_wfdetail_handle.php',
						//    type: 'POST',
						//    data: formData,
						//    async: false,
						//    cache: false,
						//    contentType: false,
						//    enctype: 'multipart/form-data',
						//    processData: false,
						//    success: function (response) {
						// 	 alert(response);
						//    }
					  // });
					  // return false;

						// when it click ajax and insert state to db and query how state work and append it in to table
						// to let user set who can access in next step
						var str_2 = '';
						$(str_2).appendTo("#state_table_for_access");
			});

			$("#Create_Form_submit_wfaccess").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfdetail").hide();
					$("#CreateFormType_wfaccess").hide();
					  //evt.preventDefault();
					  // var formData = new FormData($('#CreateFormType_wfaccess')[0]);
					  // $.ajax({
						//    url: 'CreateFormType_access_handle.php',
						//    type: 'POST',
						//    data: formData,
						//    async: false,
						//    cache: false,
						//    contentType: false,
						//    enctype: 'multipart/form-data',
						//    processData: false,
						//    success: function (response) {
						// 	 alert(response);
						//    }
					  // });
					  // return false;
			});

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
				<p class="menu-color" id="CreateAccount">CreateAccount</p>
				<p class="menu-color" id="AdminSystem_Create">CreateForm(SystemAdmin)</p>

		</div>

		<div id="div_content" class="form">


			<div id="CreateFormScreen">

				<form action="createformType_wfgeninfo_handler.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfgeninfo" >
					<div id="wfgeninfo">
					<h2>Create Form</h2>
						<div>
							<Text class="makeinline">Form Name:</Text>
							<input type="text" id="form_name" name="form_name" class="makeinline">
						</div>
						<div>
							<Text class="makeinline">Description:</Text>
							<input type="text" id="form_description" name="form_description" class="makeinline">
						</div>
						<div>
							<Text class="makeinline">Admin:</Text>
							<select name="form_admin" form="form_admin" class="makeinline">
							  <option value="1">admin name...</option>  <!-- will make it query admin that exist in system -->
							</select>
						</div>
					</div>

					<div class="right">
						<input type="button" value="Next" id="Create_Form_submit_wfgeninfo" style="width: 90px;">
						<input type="reset" value="Reset" style="width: 90px;">
					</div>
				</form>

				<form action="createformType_doc_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfdoc" >

					<div id="wfdoc">
					<h2>Document</h2>
						<table id="upload_doc_table"></table>
						<div class="right" id="doc_box">
							<input type="button" value="attach file" id="add_more_doc_btn">
						</div>
					</div>

					<div class="right">
						<input type="button" value="Next" id="Create_Form_submit_wfdoc" style="width: 90px;">
					</div>
				</form>

				<form action="createFormType_wfdetail_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfdetail" >

					<div id="wfdetail">
					<h2>State</h2>
						<table id="upload_state_table"></table>
						<div class="right" id="state_box">
							<input type="button" value="add state" id="add_more_state_btn">
						</div>
					</div>

					<div class="center">
						<input type="button" value="Next" id="Create_Form_submit_wfdetail" style="width: 90px;">
						<input type="reset" value="Reset"  style="width: 90px;">
					</div>
				</form>

				<form action="createformType_access_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfaccess" >

					<div id="wfaccess">
					<h2>State</h2>
						<table id="state_table_for_access"></table>
						<!-- need to query when show -->
						<div>
							<text> some state</text>
							<input type="text">
						</div>
					</div>

					<div class="center">
						<input type="button" value="Next" id="Create_Form_submit_wfaccess" style="width: 90px;">
						<input type="reset" value="Reset"  style="width: 90px;">
					</div>
				</form>

			</div>
		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
