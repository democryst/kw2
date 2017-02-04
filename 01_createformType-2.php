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
// var json_return_wfdetail_access;

		$(document).ready(function() {

			$("#CreateFormType_wfdoc").hide();
			$("#CreateFormType_wfdetail").hide();
			$("#CreateFormType_wfaccess").hide();
			$("#form_success").hide();

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
					$("#form_success").hide();
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
						$(str_wfgeninfo).appendTo("#wfaccess");

						return false; //need it here
			});

			$("#Create_Form_submit_wfdoc").click(function(evt){
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfaccess").hide();
					$("#form_success").hide();
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
					$("#form_success").hide();
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
							$.getJSON("createformType_wfdetail_accessSELECTOR_group.php", function(data){
								var json_wf_det_access_group = data;
								// console.log(json_wf_det_access_group);
			        }).then(function(json_wf_det_access_group){
								// console.log(json_wf_det_access_group);
								for(i = 0; i < json_return_wfdetail.length; i++){
									var str_accessgroup_select = '<tr><td><text>   By Group: </text></td> <td><select id="gselect_'+i+'" name="group_id[]" class="makeinline">';
									for(j = 0; j < json_wf_det_access_group.length; j++){
										let groupid = json_wf_det_access_group[j].GroupID;
										let groupname = json_wf_det_access_group[j].GroupName;
										str_accessgroup_select = str_accessgroup_select + '<option value="'+groupid+'">'+groupname+'</option>';
									}
									str_accessgroup_select = str_accessgroup_select+'</select></td><td><input id="chb_'+i+'" type="checkbox" name="chb_'+i+'" value=1 ></td><td><table id="person_tab_'+i+'"></table></td></tr>';
									// $(str_accessgroup_select).appendTo("#state_table_for_accessgroup");
										$(str_accessgroup_select).appendTo('#gtab_'+i+'');
										$('#gselect_'+i+'').change(function(person_tab_index){
											var group_sel_tab_index = this.id;
											var person_tab_index = group_sel_tab_index.match(/\d/g);
											person_tab_index = person_tab_index.join("");
								        // alert( $(this).find("option:selected").attr('value') );
												var groupid_send_to_person = $(this).find("option:selected").attr('value');
												if(groupid_send_to_person){
													$.post("createformType_wfdetail_accessSELECTOR_PERSON.php", {data: groupid_send_to_person}, function(data){
														//  console.log(data);
														 var json_return_wfdetail_access = JSON.parse(data);
														//  console.log(json_return_wfdetail_access);

												  }).then(function(json_return_wfdetail_access){
														json_return_wfdetail_access = JSON.parse(json_return_wfdetail_access);
														console.log(json_return_wfdetail_access);
																console.log(person_tab_index);

																// str_access_select_person = '<td><text>   By Person : </text></td> <td> <select name="user_id[]" class="makeinline">';
																str_access_select_person = '<td> <select name="user_id[]" class="makeinline">';
																for(j = 0; j < json_return_wfdetail_access.length; j++){
																		let userid = json_return_wfdetail_access[j].UserID;
																		let name_surname = json_return_wfdetail_access[j].Name + "  "+json_return_wfdetail_access[j].Surname;
																		str_access_select_person = str_access_select_person + '<option value="'+userid+'">'+name_surname+'</option>';
																}
																str_access_select_person = str_access_select_person+'</select></td>';
																$('#person_tab_'+person_tab_index+'').empty();

																	// console.log(person_tab_index);
																	// 	console.log( $('#chb_'+person_tab_index+'').is(":checked") );

																if( (json_return_wfdetail_access.length != 0)&&($('#chb_'+person_tab_index+'').is(":checked") ) ){
																	$(str_access_select_person).appendTo('#person_tab_'+person_tab_index+'');
																}
																// $(str_access_select_person).appendTo('#person_tab_'+person_tab_index+'');
													});
												}
								    });
									}


							});
							// .then(function() {
							// 	$.ajax({
							// 	   url: 'createformType_wfdetail_accessSELECTOR_group.php',
							// 	   type: 'POST',
							// 	   data: {data:'data'},
							// 	   async: false,
							// 	   cache: false,
							// 	   contentType: false,
							// 	   enctype: 'multipart/form-data',
							// 	   processData: false,
							// 	   success: function (response) {
							// 		 console.log(response);
							// 		 json_return_wfdetail_access_group = JSON.parse(response);
							// 	   }
							//   });
							// 	return false;
						  // })
							// ;
							// return false;
					  });

						// $.ajax({
						//    url: 'createformType_wfdetail_accessSELECTOR_PERSON.php.php',
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
						var	StateName;
						var wf_detailID; //need to pass wfdetailID to wfaccess
						for(i = 0; i < json_return_wfdetail.length; i++){
							StateName = json_return_wfdetail[i].StateName;
							console.log("StateName : "+StateName);
							wf_detailID = json_return_wfdetail[i].WFDetailID; //need to pass wfdetailID to wfaccess
							str_access_select = '<tr> <td><Text>StateName : '+StateName+'</Text></td>'
							+'<td><input type="hidden" value="'+wf_detailID+'" name="wfdetailID[]" /></td>'; /*need to pass wfdetailID to wfaccess*/

							// str_access_select = str_access_select +'<td><text>   By Group: </text></td> <td>'
							// +'<select name="group_id[]" class="makeinline">';
							// for(j = 0; j < json_wf_det_access_group.length; j++){
							// 	let groupid = json_wf_det_access_group[j].GroupID;
							// 	let groupname = json_wf_det_access_group[j].GroupName;
							// 	str_access_select = str_access_select + '<option value="'+groupid+'">'+groupname+'</option>';
							// }
							// str_access_select = str_access_select+'</select></td>';
    // str_access_select = str_access_select
		// 					+'<td><text>   By Person : </text></td> <td>'
		// 					+'<select name="user_id[]" class="makeinline">';
		// 					for(j = 0; j < json_return_wfdetail_access.length; j++){
		// 						let userid = json_return_wfdetail_access[j].UserID;
		// 						let name_surname = json_return_wfdetail_access[j].Name + "  "+json_return_wfdetail_access[j].Surname;
		// 						str_access_select = str_access_select + '<option value="'+userid+'">'+name_surname+'</option>';
		// 					}
		// 					str_access_select = str_access_select+'</select></td>';
		str_access_select = str_access_select+'<td><table id="gtab_'+i+'"></table></td>';
								str_access_select = str_access_select+'</tr>';
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
					$("#form_success").show();
					  //evt.preventDefault();
					  var formData = new FormData($('#CreateFormType_wfaccess')[0]);
					  $.ajax({
						   url: 'CreateFormType_access_handle.php',
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
						<table>
							<tr>
								<td><table id="state_table_for_access"></table></td>
								<td><table id="state_table_for_accessgroup"></table></td>
								<td><table id="state_table_for_accessperson"></table></td>
					  	</tr>
						</table>
					</div>

					<div class="center">
						<input type="button" value="Next" id="Create_Form_submit_wfaccess" style="width: 90px;">
						<input type="reset" value="Reset"  style="width: 90px;">
					</div>
				</form>

				<div class="center" id="form_success">
					<h2>Create Form successfully !</h2>
				</div>

			</div>
		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
