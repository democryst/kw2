<?php
session_start();
if(isset($_SESSION['user_id'])){
	echo "<script type='text/javascript'>
					console.log(".$_SESSION['user_id'].");
				</script>";
}
echo "<script>var userid = " . $_SESSION['user_id'] . ";</script>";
if ($_SESSION['gName'] != "Sys_Admin") {
?>
<script type='text/javascript'>
	alert('you dont have permission!');
</script>
<?php
	if($_SESSION['gName'] == 'Requester'){
		echo "<script type='text/javascript'>
						window.location = '02_request_list.php';
					</script>";
	}else if($_SESSION['gName'] == 'Approver'){
		echo "<script type='text/javascript'>
						window.location = '03_approver.php';
					</script>";
	}else if($_SESSION['gName'] == 'Flow_Admin'){
		echo "<script type='text/javascript'>
						window.location = '04_formmodify.php';
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
	<!--script src="scripts/jquery-2.0.0.min.js"></script-->
	<script src="jquery-3.1.1.min.js"></script>
	<meta http-equiv="pragma" content="no-cache" />

	<script type="text/javascript">
	// var userid = 3; //for test kw1
	var localhost = "http://localhost:8080/kw2/";
var json_return_wfgeninfo;
var json_return_wfdoc;
var json_return_wfdetail;
// var json_return_wfdetail_access;
var groupid_send_to_person;
var state_doc_index = 0;
var all_add_doc_count = 0;
var doctype_id = 0;
var docnum_inx = 0;
var kw1_fn_get_array = new Array();
var WFGenInfoID;
var CreateTime;
		$(document).ready(function() {
				 $('#div_kw1').hide();
				  $('#div_kw1').load('../kw1TempServer/Senior%20Project%20KW%20Demo/kwDemo4-newFile14.html');


			//************************************************************
			$("#Logout").click(function(){
					window.location = '06_logout.php';
			});

			$("#AdminSystem_Create").click(function(){
					window.location = '01_createformType_multidoc.php';
			});
			//************************************************************
			$("#CreateFormType_wfdoc").hide();
			$("#CreateFormType_wfdetail").hide();
			$("#CreateFormType_wfaccess").hide();
			$("#form_success").hide();

			$("#doctypeid").change(function(){
				$("#upload_doc_table").empty();
				doctype_id = $("#doctypeid").val();
			});

			$("#add_more_doc_btn").click(function(){
				let cur_index = docnum_inx;
				//check if doctype
				if (doctype_id == 0) {
					var str='<tr> <td><input type="file" name="file_array[]"></td></tr>' ;
					$(str).appendTo("#upload_doc_table");
				}else if (doctype_id == 1) {
					var str='<tr> <td><input type="button" id="kw1form'+cur_index+'" value="Form Editor"></td> <td><input type="text" id="kw1formname'+cur_index+'"></td></tr>' ;
					$(str).appendTo("#upload_doc_table");

					$("#kw1form"+cur_index+"").click(function(){ //-D1-
						$("#div_kw2").hide();
						kw1passformname = $('#kw1formname'+cur_index+'').val();
						$( "#div_kw1" ).append( "<input type='image' id='backToFirst' name='backToFirst' src='myPic/previous.png' style='position:fixed;width:80px;height:80px;left:250px;top:90px'/>");
						setTimeout(function(){
							$("#div_kw1").show();
							//  console.log("Asking kw1 - "+nowHaveItemCount);
						}, 1000);
						// console.log( "**************************************");
						// console.log( $("#kw1form"+cur_index+"").attr('id') );
						// console.log( parseInt($("#kw1form"+cur_index+"").attr('id').split('kw1form')[1]) );
						kw1_id = parseInt($("#kw1form"+cur_index+"").attr('id').split('kw1form')[1]);

					});
				}
				docnum_inx++;
			});

			$("#add_more_state_btn").click(function(){
					state_doc_index++;
	        let cur_index = state_doc_index;
					if (doctype_id == 0) {
						// var str='<tr><td><form id="form_state_doc_'+cur_index+'"> <td><text> Step: </text></td> <td><input type="text" name="state_array[]" id="state_doc_statename_'+cur_index+'"></td> <td><text> Deadline: </text></td> <td><input type="number" name="deadline[]" id="state_doc_deadline_'+cur_index+'" placeholder="day" min="0" max="7"></td> <td><Text>Document display</Text></td><td><select id="docchose_'+cur_index+'"><option value="0">show templates</option><option value="1">show update documents</option></select></td> <td><text> file: </text></td> <td><img id="add_more_state_doc_btn_'+cur_index+'" src="images/Add.ico" width="20" height="20"></td> <td><table id="state_doc_table"><tr id="state_doc_table_tr_'+cur_index+'"></tr></table></td> </form></td></tr>' ;

						// var str='<tr><td><form id="form_state_doc_'+cur_index+'"><div class="makeinline"><text> Step: </text><input type="text" name="state_array[]" id="state_doc_statename_'+cur_index+'"><text> Deadline: </text><input type="number" name="deadline[]" id="state_doc_deadline_'+cur_index+'" placeholder="day" min="0" max="7"><Text>Document display</Text><select id="docchose_'+cur_index+'"><option value="0">show templates</option><option value="1">show update documents</option></select><text> file: </text><img id="01-add_more_state_doc_btn_'+cur_index+'" src="images/Add.ico" width="20" height="20"> <table id="state_doc_table"><tr id="state_doc_table_tr_'+cur_index+'"></tr></table></div></form></td></tr>' ;
						var str='<tr><td><form id="form_state_doc_'+cur_index+'"><div class="makeinline"><text> Step: </text><input type="text" name="state_array[]" id="state_doc_statename_'+cur_index+'"><text> Deadline: </text><input type="number" name="deadline[]" id="state_doc_deadline_'+cur_index+'" placeholder="day" min="0" max="7"><Text>Document display</Text><select id="docchose_'+cur_index+'"><option value="0">show templates</option><option value="1">show update documents</option></select><text> file: </text><img id="01-add_more_state_doc_btn_'+cur_index+'" src="images/Add.ico" width="20" height="20"> <div id="state_doc_table_tr_'+cur_index+'" class="makeinline"></div></div></form></td></tr>' ;
console.log(str);

						$(str).appendTo("#upload_state_table");
						let d_chk = 0;
						$("#01-add_more_state_doc_btn_"+cur_index+"").click(function(){
							if ( d_chk < docnum_inx) {
								// all_add_doc_count++;
								// var str_s_doc = '<td><select name="doc_id[]" class="makeinline" id="select_state_doc_'+cur_index+'">';

			          // var str_s_doc = '<td><select name="select_state_doc_'+cur_index+'[]" class="makeinline" >';
								 var str_s_doc = '<select name="select_state_doc_'+cur_index+'[]" class="makeinline" >';
								for(i = 0; i < json_return_wfdoc.length; i++){
									let docid = json_return_wfdoc[i].WFDocID;
									let docname = json_return_wfdoc[i].DocName;
									str_s_doc = str_s_doc+'<option value="'+docid+'">'+docname+'</option>'
								}
								// str_s_doc = str_s_doc+'</select></td>'
								str_s_doc = str_s_doc+'</select>'
								$(str_s_doc).appendTo("#state_doc_table_tr_"+cur_index+"");
			          console.log(str_s_doc);
							}
							d_chk++;
						});

					}else if (doctype_id == 1) { //this pull each state and (formname of kw1)
						// var str='<tr><td><form id="form_state_doc_'+cur_index+'"> <td><text> Step: </text></td> <td><input type="text" name="state_array[]" id="state_doc_statename_'+cur_index+'"></td>'
						// +'<td><text> Deadline: </text></td> <td><input type="number" name="deadline[]" id="state_doc_deadline_'+cur_index+'" placeholder="day" min="0" max="7"></td> <td><Text>Document display</Text></td><td><select id="docchose_'+cur_index+'"><option value="0">show templates</option><option value="1">show update documents</option></select></td>'
						// +'<td><text> file: </text></td> <td><img id="add_more_state_doc_btn_'+cur_index+'" src="images/Add.ico" width="20" height="20"></td> <td><table id="state_doc_table"><tr id="state_doc_table_tr_'+cur_index+'"></tr></table></td> </form></td></tr>' ;

						// var str='<tr><td><form id="form_state_doc_'+cur_index+'"> <td><text> Step: </text></td> <td><input type="text" name="state_array[]" id="state_doc_statename_'+cur_index+'"></td> <td><text> Deadline: </text></td> <td><input type="number" name="deadline[]" id="state_doc_deadline_'+cur_index+'" placeholder="day" min="0" max="7">  <input type="hidden" id="docchose_'+cur_index+'" value="0">  </td> <td><text> file: </text></td> <td><img id="02-add_more_state_doc_btn_'+cur_index+'" src="images/Add.ico" width="20" height="20"></td> <td><table id="state_doc_table"><tr id="state_doc_table_tr_'+cur_index+'"></tr></table></td> </form></td></tr>' ;
						var str='<tr><td><form id="form_state_doc_'+cur_index+'"> <td><text> Step: </text></td> <td><input type="text" name="state_array[]" id="state_doc_statename_'+cur_index+'"></td> <td><text> Deadline: </text></td> <td><input type="number" name="deadline[]" id="state_doc_deadline_'+cur_index+'" placeholder="day" min="0" max="7">  <input type="hidden" id="docchose_'+cur_index+'" value="0">  </td> <td><text> file: </text></td> <td><img id="02-add_more_state_doc_btn_'+cur_index+'" src="images/Add.ico" width="20" height="20"></td> <td><div id="state_doc_table_tr_'+cur_index+'"></div></td> </form></td></tr>' ;

						$(str).appendTo("#upload_state_table");
						let d_chk_2 = 0;
						$("#02-add_more_state_doc_btn_"+cur_index+"").click(function(){
							if (d_chk_2 < docnum_inx) {
								// all_add_doc_count++;
								// var str_s_doc = '<td><select name="doc_id[]" class="makeinline" id="select_state_doc_'+cur_index+'">';
								var str_s_doc = '<td><select name="select_state_doc_'+cur_index+'[]" class="makeinline" >';
								for(i = 0; i < json_return_wfdoc.length; i++){
									let docid = json_return_wfdoc[i].WFDocID;
									let docname = json_return_wfdoc[i].DocName;
									str_s_doc = str_s_doc+'<option value="'+docid+'">'+docname+'</option>'
								}
								str_s_doc = str_s_doc+'</select></td>'
								$(str_s_doc).appendTo("#state_doc_table_tr_"+cur_index+"");
								console.log(str_s_doc);
							}
							d_chk_2++;
						});
					}


			});

			$.getJSON("createformtype_handle/select_formadmin.php", function(data){
				console.log(data);
				// select_formadmin = JSON.parse(data);
				select_formadmin = data;
				str_s_formadmin = '<tr><td><Text>Admin: </Text></td> <td> <select id="form_admin_select" name="form_admin" form="form_admin" class="makeinline">';
				str_s_formadmin = str_s_formadmin + '<option value="0">admin name...</option>';
				for (var i = 0; i < select_formadmin.length; i++) {
					str_s_formadmin = str_s_formadmin + '<option value="'+select_formadmin[i].UserID+'">'+select_formadmin[i].Name+' '+select_formadmin[i].Surname+'</option>';
				}
				str_s_formadmin = str_s_formadmin + '</select> </td></tr>';
				$(str_s_formadmin).appendTo("#form_admin_table");
			});

			$("#Create_Form_submit_wfgeninfo").click(function(evt){
					if (  ( $("#form_admin_select").val() != 0 ) && ( $("#form_name").val().length != 0 ) ){
						$("#CreateFormType_wfgeninfo").hide();
						$("#CreateFormType_wfdetail").hide();
						$("#CreateFormType_wfaccess").hide();
						$("#form_success").hide();
						$("#CreateFormType_wfdoc").show();

							let gen_formname = $("#form_name").val();
							let gen_form_description = $("#form_description").val();
							let gen_form_admin_select = $("#form_admin_select").val();
							$.post("createformtype_handle/createformType_geninfo_handle.php", {data: {form_name: gen_formname, form_description: gen_form_description, form_admin_select: gen_form_admin_select}},function(response){
								console.log(response);
								json_return_wfgeninfo = JSON.parse(response);
								WFGenInfoID = json_return_wfgeninfo.WFGenInfoID;
								CreateTime = json_return_wfgeninfo.CreateTime;
								var str_wfgeninfo = '<tr> <td><input type="hidden" value="'+WFGenInfoID+'" name="wfgeninfo" /></td>'+
								'<td><input type="hidden" value="'+CreateTime+'" name="all_date" /></td></tr>';
								$(str_wfgeninfo).appendTo("#upload_doc_table");
								$(str_wfgeninfo).appendTo("#wfdetail");
								$(str_wfgeninfo).appendTo("#wfaccess");
							});

					}
			});

			$("#Create_Form_submit_wfdoc").click(function(evt){

					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfaccess").hide();
					$("#form_success").hide();
					$("#CreateFormType_wfdetail").show();
					  //evt.preventDefault();
					  if (doctype_id == 0) {
							if ($("[name = 'file_array[]']").val().length != 0) {
								var formData = new FormData($('#CreateFormType_wfdoc')[0]);
							  $.ajax({
								   url: 'createformtype_handle/createformType_doc_handle.php',
								   type: 'POST',
								   data: formData,
								   async: false,
								   cache: false,
								   contentType: false,
								   enctype: 'multipart/form-data',
								   processData: false,
								   success: function (response) {
									 console.log(response);
									 json_return_wfdoc = JSON.parse(response);

								   }
							  });
							  return false;
							}

					  }else if (doctype_id == 1) {
							if (kw1_fn_get_array.length != 0) {
								//need to pass formname formurl of each   and wfgeninfoID, etc...
								console.log(kw1_fn_get_array);
								// wfgeninfo_f_kw1 = $("#wfgeninfo_f_kw1").val();
								console.log("WFGenInfoID :");
								console.log(WFGenInfoID);
								// all_date_f_kw1 = $("all_date_f_kw1").val();
								console.log("CreateTime :");
								console.log(CreateTime);

						  	$.post("createformtype_handle/createformType_doc_handle_kw1.php",{data:{doc: kw1_fn_get_array, wfgeninfo:WFGenInfoID, all_date:CreateTime, adminid:userid}},function(response){
									console.log(response);
									json_return_wfdoc = JSON.parse(response);
								});
							}

					  }


			});

			$("#Create_Form_submit_wfdetail").click(function(evt){
				if ( $("[name = 'state_array[]']").val().length != 0 ) {
					$("#CreateFormType_wfgeninfo").hide();
					$("#CreateFormType_wfdoc").hide();
					$("#CreateFormType_wfdetail").hide();
					$("#form_success").hide();
					$("#CreateFormType_wfaccess").show();
						//evt.preventDefault();
						// var formData = new FormData($('#CreateFormType_wfdetail')[0]);
						var state_doc_array = new Array();
						for (var i = 1; i <= state_doc_index; i++) {
              let statedocstatename = $('#state_doc_statename_'+i+'').val();
              let statedocdeadline = $('#state_doc_deadline_'+i+'').val();
							let docchose = $('#docchose_'+i+'').val();
              //     http://stackoverflow.com/questions/2627813/how-to-get-an-array-with-jquery-multiple-input-with-the-same-name
              let statedocarray = new Array();
              $('[name^="select_state_doc_'+i+'[]"]').each(function(){
                  statedocarray.push($(this).val());
              });
              let statedocdata = {statename: statedocstatename, deadline: statedocdeadline, docarr: statedocarray, docchose: docchose};
              state_doc_array.push(statedocdata);
              console.log(statedocdata);
						}
            let wfgeninfo = $('[name="wfgeninfo"]').val();
            let all_date = $('[name="all_date"]').val();
            state_doc_array_l = {wfgeninfo: wfgeninfo, all_date: all_date, state_doc_array: state_doc_array}
						var myJsonString = JSON.stringify(state_doc_array_l);
            console.log(myJsonString);
            $.post("createformtype_handle/createFormType_wfdetail_handle_2.php", {data: myJsonString}, function(res){
              console.log(res);
              json_return_wfdetail = JSON.parse(res);
              var str_access_select;
  						var	StateName;
  						var wf_detailID; //need to pass wfdetailID to wfaccess
  						for(i = 0; i < json_return_wfdetail.length; i++){
  							StateName = json_return_wfdetail[i].StateName;
  							console.log("StateName : "+StateName);
  							wf_detailID = json_return_wfdetail[i].WFDetailID; //need to pass wfdetailID to wfaccess
  							str_access_select = '<tr> <td><Text>StateName : '+StateName+'</Text></td>'
  							+'<td><input type="hidden" value="'+wf_detailID+'" name="wfdetailID[]" /></td>'; /*need to pass wfdetailID to wfaccess*/
  								str_access_select = str_access_select+'<td><table id="gtab_'+i+'"></table></td>';
  								str_access_select = str_access_select+'</tr>';
  							$(str_access_select).appendTo("#state_table_for_access");
  						}
              fn1();
            });


						// var str_access_select;
						// var	StateName;
						// var wf_detailID; //need to pass wfdetailID to wfaccess
						// for(i = 0; i < json_return_wfdetail.length; i++){
						// 	StateName = json_return_wfdetail[i].StateName;
						// 	console.log("StateName : "+StateName);
						// 	wf_detailID = json_return_wfdetail[i].WFDetailID; //need to pass wfdetailID to wfaccess
						// 	str_access_select = '<tr> <td><Text>StateName : '+StateName+'</Text></td>'
						// 	+'<td><input type="hidden" value="'+wf_detailID+'" name="wfdetailID[]" /></td>'; /*need to pass wfdetailID to wfaccess*/
						// 		str_access_select = str_access_select+'<td><table id="gtab_'+i+'"></table></td>';
						// 		str_access_select = str_access_select+'</tr>';
						// 	$(str_access_select).appendTo("#state_table_for_access");
						// }
						// return false;
				}

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
							 url: 'createformtype_handle/CreateFormType_access_handle.php',
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

    function fn1(){
      $.getJSON("createformtype_handle/createformType_wfdetail_accessSELECTOR_group.php", function(data){
        console.log(data);
        var json_wf_det_access_group = data;
        console.log(json_wf_det_access_group);
      }).then(function(json_wf_det_access_group){
        console.log(json_wf_det_access_group);
        for(i = 0; i < json_return_wfdetail.length; i++){
          var str_accessgroup_select = '<tr><td><text>   By Group: </text></td> <td><select id="gselect_'+i+'" name="group_id[]" class="makeinline">';
          str_accessgroup_select = str_accessgroup_select + '<option value="">--SELECT GROUP--</option>';
          for(j = 0; j < json_wf_det_access_group.length; j++){
            let groupid = json_wf_det_access_group[j].GroupID;
            let groupname = json_wf_det_access_group[j].GroupName;
            str_accessgroup_select = str_accessgroup_select + '<option value="'+groupid+'">'+groupname+'</option>';
          }
          str_accessgroup_select = str_accessgroup_select+'</select></td><td><input id="chb_'+i+'" type="checkbox" name="chb_'+i+'" value=1 ></td><td><table id="person_tab_'+i+'"></table></td></tr>';
          // $(str_accessgroup_select).appendTo("#state_table_for_accessgroup");
            $(str_accessgroup_select).appendTo('#gtab_'+i+'');

						$('#chb_'+i+'').change(function(){
							var group_sel_tab_index = this.id;
              var person_tab_index = group_sel_tab_index.match(/\d/g);

							$('#person_tab_'+person_tab_index+'').empty();
							groupid_send_to_person = $('#gselect_'+person_tab_index+'').find("option:selected").attr('value');
							$.post("createformtype_handle/createformType_wfdetail_accessSELECTOR_PERSON.php", {data: groupid_send_to_person}, function(data){
								 var json_return_wfdetail_access = JSON.parse(data);

								 str_access_select_person = '<td> <select name="user_id[]" class="makeinline">';
								 str_access_select_person = str_access_select_person + '<option value="">--SELECT USER--</option>';
								 for(j = 0; j < json_return_wfdetail_access.length; j++){
										 let userid = json_return_wfdetail_access[j].UserID;
										 let name_surname = json_return_wfdetail_access[j].Name + "  "+json_return_wfdetail_access[j].Surname;
										 str_access_select_person = str_access_select_person + '<option value="'+userid+'">'+name_surname+'</option>';
								 }
								 str_access_select_person = str_access_select_person+'</select></td>';
								 $('#person_tab_'+person_tab_index+'').empty();

								 if ( (json_return_wfdetail_access.length != 0)&&($('#chb_'+person_tab_index+'').is(":checked") ) ) {
	 								$(str_access_select_person).appendTo('#person_tab_'+person_tab_index+'');
	 							}else{
	 								str_access_select_person_usernull = "<td><input type='hidden' name='user_id[]' value='0'></td>";
	 								$(str_access_select_person_usernull).appendTo('#person_tab_'+person_tab_index+'');
	 							}
							});
						});

            $('#gselect_'+i+'').change(function(person_tab_index){
              var group_sel_tab_index = this.id;
              var person_tab_index = group_sel_tab_index.match(/\d/g);
              person_tab_index = person_tab_index.join("");
                // alert( $(this).find("option:selected").attr('value') );
                groupid_send_to_person = $(this).find("option:selected").attr('value');
                if(groupid_send_to_person!=""){
                  $.post("createformtype_handle/createformType_wfdetail_accessSELECTOR_PERSON.php", {data: groupid_send_to_person}, function(data){
                    //  console.log(data);
                     var json_return_wfdetail_access = JSON.parse(data);
                    //  console.log(json_return_wfdetail_access);

                  }).then(function(json_return_wfdetail_access){
                    json_return_wfdetail_access = JSON.parse(json_return_wfdetail_access);
                    console.log(json_return_wfdetail_access);
                        console.log(person_tab_index);

                        // str_access_select_person = '<td><text>   By Person : </text></td> <td> <select name="user_id[]" class="makeinline">';
                        str_access_select_person = '<td> <select name="user_id[]" class="makeinline">';
                        str_access_select_person = str_access_select_person + '<option value="">--SELECT USER--</option>';
                        for(j = 0; j < json_return_wfdetail_access.length; j++){
                            let userid = json_return_wfdetail_access[j].UserID;
                            let name_surname = json_return_wfdetail_access[j].Name + "  "+json_return_wfdetail_access[j].Surname;
                            str_access_select_person = str_access_select_person + '<option value="'+userid+'">'+name_surname+'</option>';
                        }
                        str_access_select_person = str_access_select_person+'</select></td>';
                        $('#person_tab_'+person_tab_index+'').empty();
                        if ( (json_return_wfdetail_access.length != 0)&&($('#chb_'+person_tab_index+'').is(":checked") ) ) {
                          $(str_access_select_person).appendTo('#person_tab_'+person_tab_index+'');
                        }else{
                          str_access_select_person_usernull = "<td><input type='hidden' name='user_id[]' value='0'></td>";
                          $(str_access_select_person_usernull).appendTo('#person_tab_'+person_tab_index+'');
                        }
                          // console.log(person_tab_index);
                          // 	console.log( $('#chb_'+person_tab_index+'').is(":checked") );

											  // $('#chb_'+person_tab_index+'').on('change',function(){
                        //   $('#person_tab_'+person_tab_index+'').empty();
                        //   if ( (json_return_wfdetail_access.length != 0)&&($('#chb_'+person_tab_index+'').is(":checked") ) ) {
                        //     $(str_access_select_person).appendTo('#person_tab_'+person_tab_index+'');
                        //   }else{
                        //     str_access_select_person_usernull = "<td><input type='hidden' name='user_id[]' value='0'></td>";
                        //     $(str_access_select_person_usernull).appendTo('#person_tab_'+person_tab_index+'');
                        //   }
                        // });

                  });
                }
            });


          }


      });
    }


	</script>
</head>
<body>

<div id="wrapper" >
<div id="div_kw1" style='z-index:10;'></div>
<div id="div_kw2">
	<div id="div_header">
		SIIT Form Workflow System
	</div>
	<div id="div_subhead">

	</div>
	<div id="div_main">
		<div id="div_left">

				<!-- <p class="menu-color" id="Login">Login</p> -->
				<!-- <p class="menu-color" id="CreateAccount">CreateAccount</p> -->
				<p class="menu-color" id="AdminSystem_Create">Create Form Type</p>
				<p class="menu-color" id="Logout">Log out</p>

		</div>

		<div id="div_content" class="form">


			<div id="CreateFormScreen">

				<form action="createformtype_handle/createformType_geninfo_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfgeninfo" >
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
							<!-- <Text class="makeinline">Admin:</Text> -->
							<Table id="form_admin_table"></Table>
							<!-- <select name="form_admin" form="form_admin" class="makeinline"> -->
							  <!-- <option value="1">admin name...</option>   -->
								<!-- will make it query admin that exist in system -->
							<!-- </select> -->
						</div>
					</div>

					<div class="right">
						<input type="button" value="Next" id="Create_Form_submit_wfgeninfo" style="width: 90px;">
						<input type="reset" value="Reset" style="width: 90px;">
					</div>
				</form>

				<form action="createformtype_handle/createformType_doc_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfdoc" >
					<div id="wfdoc">
					<input type="hidden" id="adminid" value="<?php echo $_SESSION['user_id']; ?>">
					<h2>Document</h2>
						<div>
							<select id="doctypeid">
								<option value="0" selected="selected">default</option>
								<option value="1">kw1form</option>
							</select>
						</div>
						<table id="upload_doc_table"></table>
						<div class="right" id="doc_box">
							<input type="button" value="attach file" id="add_more_doc_btn">
						</div>
					</div>

					<div class="right">
						<input type="button" value="Next" id="Create_Form_submit_wfdoc" style="width: 90px;">
					</div>
				</form>

				<form action="createformtype_handle/createFormType_wfdetail_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfdetail" >

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

				<form action="createformtype_handle/createformType_access_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType_wfaccess" >

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
</div>


</body>
</html>
