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
var json_return_wfgeninfo;
var json_return_wfdoc;
var json_return_wfdetail;
var json_return_wfdetail_access;
		$(document).ready(function() {

			$("#CreateFormType_wfdoc").hide();
			$("#CreateFormType_wfdetail").hide();
			$("#CreateFormType_wfaccess").hide();

			$("#add_more_doc_btn").click(function(){
				var str='<tr> <td><input type="file" name="file_array[]"></td></tr>' ;
				$(str).appendTo("#upload_doc_table");
			});
			$("#add_more_state_btn").click(function(){
				var str='<tr> <td><text> Step: </text></td> <td><input type="text" name="state_array[]"></td>'
				+'<td><text> Deadline: </text></td> <td><input type="text" name="deadline[]"></td>'
				+'<td><text> file: </text></td> <td>'
				+'<select name="doc_id[]" class="makeinline">';
				for(i = 0; i < json_return_wfdoc.length; i++){
					let docid = json_return_wfdoc[i].WFDocID;
					let docname = json_return_wfdoc[i].DocName;
					str = str+'<option value="'+docid+'">'+docname+'</option>'
				}
				str = str+'</select></td></tr>' ;
				$(str).appendTo("#upload_state_table");
			});

			$("#Create_Form_submit_wfgeninfo").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdetail").hide();
					$("#CreateFormType_wfaccess").hide();
					$("#CreateFormType_wfdoc").show();
					  // //evt.preventDefault();
					  var formData = new FormData($('#CreateFormType_wfgeninfo')[0]);
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
					  // return false;

						//need to return WfgenInfoID
						// and return date_hrs, date_day, all_date to make data in wfdoc to be same as wfgeninfo
						// from ajax
						// Maybe return json object    <input type="hidden" value="foo" name="response" />
						var WFGenInfoID = json_return_wfgeninfo.WFGenInfoID;
						var CreateTime = json_return_wfgeninfo.CreateTime;
						var str_wfgeninfo = '<tr> <td><input type="hidden" value="'+WFGenInfoID+'" name="wfgeninfo" /></td>'+
						'<td><input type="hidden" value="'+CreateTime+'" name="all_date" /></td></tr>';
						$(str_wfgeninfo).appendTo("#upload_doc_table");
						$(str_wfgeninfo).appendTo("#wfdetail");

						return false; //need it here
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
							// 	 console.log("----------");
							// 	 console.log("----------");
							// 	 console.log("----------");
							 console.log(response);
							//  console.log("----------");
							//  console.log("----------");
							//  console.log("----------");
							 json_return_wfdoc = JSON.parse(response);

						   }
					  });
					  return false;

						//need to return WfdocID from ajax and give it to selector
			});

			$("#Create_Form_submit_wfdetail").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfdetail").hide();
					$("#CreateFormType_wfaccess").show();
					  //evt.preventDefault();
					  var formData = new FormData($('#CreateFormType_wfdetail')[0]);
					  $.ajax({
						   url: 'createFormType_wfdetail_handle.php',
						   type: 'POST',
						   data: formData,
						   async: false,
						   cache: false,
						   contentType: false,
						   enctype: 'multipart/form-data',
						   processData: false,
						   success: function (response) {
							 console.log(response);
							 json_return_wfdetail = JSON.parse(response);
						   }
					  }).then(function() {
							$.ajax({
							   url: 'createformType_wfdetail_accessSELECTOR.php',
							   type: 'POST',
							   data: {data:'data'},
							   async: false,
							   cache: false,
							   contentType: false,
							   enctype: 'multipart/form-data',
							   processData: false,
							   success: function (response) {
								 console.log(response);
								 json_return_wfdetail_access = JSON.parse(response);
							   }
						  });
							return false;
					  });

						// $.ajax({
						//    url: 'createformType_wfdetail_accessSELECTOR.php',
						//    type: 'POST',
						//    data: {},
						//    async: false,
						//    cache: false,
						//    contentType: false,
						//    enctype: 'multipart/form-data',
						//    processData: false,
						//    success: function (response) {
						// 	 console.log(response);
						// 	 json_return_wfdetail_access = JSON.parse(response);
						//    }
					  // });
						var str_access_select;
						var	StateName
						for(i = 0; i < json_return_wfdetail.length; i++){
							StateName = json_return_wfdetail[i].StateName;
							console.log("StateName : "+StateName);
							str_access_select = '<tr> <td><Text>StateName : '+StateName+'</Text></td>'
							+'<td><text>   By: </text></td> <td>'
							+'<select name="doc_id[]" class="makeinline">';
							for(j = 0; j < json_return_wfdetail_access.length; j++){
								let userid = json_return_wfdetail_access[j].UserID;
								let name_surname = json_return_wfdetail_access[j].Name + "  "+json_return_wfdetail_access[j].Surname;
								str_access_select = str_access_select + '<option value="'+userid+'">'+name_surname+'</option>';
							}
							str_access_select = str_access_select+'</select></td></tr>';
							$(str_access_select).appendTo("#state_table_for_access");
						}



						// var str_access_select = '<tr> <td><Text>StateName'+StateName+'" </Text></td>'
						// +'<td><text> By: </text></td> <td>'
						// +'<select name="doc_id[]" class="makeinline">';
						// for(i = 0; i < json_return_wfdetail_access.length; i++){
						// 	let userid = json_return_wfdetail_access[i].UserID;
						// 	let name_surname = json_return_wfdetail_access[i].Name + "  "+json_return_wfdetail_access[i].Surname;
						// 	str_access_select = str_access_select + '<option value="'+userid+'">'+name_surname+'</option>';
						// }
						// str_access_select = str_access_select+'</select></td></tr>';
						// $(str_access_select).appendTo("#state_table_for_access");

						// when it click ajax and insert state to db and query how state work and append it in to table
						// to let user set who can access in next step

						return false;
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
