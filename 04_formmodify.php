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
  //var user_id = $_SESSION['user_id'];
  var user_id = 2;
  // var WFRequestID;

	$(document).ready(function() {
    $.post("formadmin_handle/formadmin_show_worklist_handle.php", {cur_userid: user_id}, function(data){
      console.log(data);
      json_return_all_wf = JSON.parse(data);
      console.log(json_return_all_wf);
      for (var i = 0; i < json_return_all_wf.length; i++) {
        fn1(json_return_all_wf[i], i);
      }
	  });
	});

  function fn1(obj, index){
    FormName = obj.FormName;
    Description = obj.Description;
    WFRequestID = obj.WFRequestID;
		CreateTime = obj.CreateTime;
		requestorName = obj.Name + " " +obj.Surname;
    var str = "<tr> <td><Text>FormName: "+FormName+"</Text><td> <td><Text>Description: "+Description+"</Text><td> <td><Text>Create by: "+requestorName+"</Text><td> <td><Text>Create time: "+CreateTime+"</Text><td> <td><input type='button' value='select' id='wfrq_"+index+"' ></td></tr>";
    $(str).appendTo("#all-form-table");

    $("#wfrq_"+index+"").click(function(){
			$("#wfrqdetail-table").empty();
      console.log(WFRequestID);
      $.post("formadmin_handle/formadmin_show_wfrqdetail_handle.php", {wfrequest_id: obj.WFRequestID}, function(data){
        console.log(data);
        json_return_wfrqdetail = JSON.parse(data);
        console.log(json_return_wfrqdetail);
        for (var j = 0; j < json_return_wfrqdetail.length; j++) {
          fn2(json_return_wfrqdetail[j], j);
        }
  	  });
    });
  }

  function fn2(obj, index){
    // WFRequestDetailID = obj.WFRequestDetailID;
    // ParentID = obj.ParentID;
    // StateName = obj.StateName;
    // CreateTime = obj.CreateTime;
    // ModifyTime = obj.ModifyTime;
    // Deadline = obj.Deadline;
    // WFRequestDocID = obj.WFRequestDocID;
    // State = obj.State;
    // Priority = obj.Priority;
    // DoneBy = obj.DoneBy;
    // Status = obj.Status;
    // StartTime = obj.StartTime;
    // EndTime = obj.EndTime;



    var str = "<tr> <td><Text>State Name: "+obj.StateName+"</Text></td>  <td><table> <tr><td><img  id='up_"+index+"' src='images/up.ico' width='20' height='20'></td></tr> <tr><td><img id='down_"+index+"' src='images/down.ico' width='20' height='20'></td></tr> </table></td> <td><img id='moda_"+index+"' src='images/access.ico'  width='30' height='30'></td> <td><Table id='table_moda_"+index+"'></Table></td></tr>";
    $(str).appendTo("#wfrqdetail-table");
// it pull last data that was store in variable
    $("#up_"+index+"").click(function(){
      console.log("up");
      console.log(obj.WFRequestDetailID);
      console.log(obj.ParentID);
			console.log(obj.WFRequestDocID);
			$.post("formadmin_handle/up_wfrqdetail_handle.php", {data_obj : {WFrqDetail_ID: obj.WFRequestDetailID, Parent_ID: obj.ParentID, WFrqDoc_ID: obj.WFRequestDocID}}, function(response){
				console.log(response);
				if (response) {
					j_retup = JSON.parse(response);
					console.log(j_retup);
					fn_refresh(j_retup);
				}

			});
    });
    $("#down_"+index+"").click(function(){
      console.log("down");
			$.post("formadmin_handle/down_wfrqdetail_handle.php", {data_obj : {WFrqDetail_ID: obj.WFRequestDetailID, Parent_ID: obj.ParentID, WFrqDoc_ID: obj.WFRequestDocID}}, function(response){
				console.log(response);
				if (response) {
					j_retup = JSON.parse(response);
					console.log(j_retup);
					fn_refresh(j_retup);
				}
			});
    });
    $("#moda_"+index+"").click(function(){

			$("#table_moda_"+index+"").empty();
			var str_moda = "<tr><td><select id='selector_"+index+"'>";
      console.log("modifyaccess");
			$.post("formadmin_handle/moda_wfrqdetail_handle.php", {data_obj : {WFrqDetail_ID: obj.WFRequestDetailID, Parent_ID: obj.ParentID, WFrqDoc_ID: obj.WFRequestDocID}}, function(response){
				console.log(response);
				json_ret_modaccess = JSON.parse(response);
				for (var k = 0; k < json_ret_modaccess.length; k++) {
					G_Name = json_ret_modaccess[k].GroupName;
					G_id = json_ret_modaccess[k].GroupID;
					str_moda = str_moda + "<option value='"+G_id+"'>"+G_Name+"</option>";
				}
				str_moda = str_moda + "</select></td><td><table id='table_gtop_"+index+"'></table></td></tr>";
				console.log(str_moda);
				$(str_moda).appendTo("#table_moda_"+index+"");

				$("#selector_"+index+"").change(function(){
					$("#table_gtop_"+index+"").empty();

					var groupid = $(this).find("option:selected").attr('value');
					console.log(groupid);
					str_moda_ii = "<tr><td> <input type='checkbox' id='chk_"+index+"' name='chose person' value='1'></td> <td><table id='table_person_"+index+"'></table></td></tr>";
					$(str_moda_ii).appendTo("#table_gtop_"+index+"");
					$("#chk_"+index+"").change(function(){
						$("#table_person_"+index+"").empty();
						let chkval1 = $("#chk_"+index+"").is(":checked") ;
						if (chkval1) {
							console.log("chkbox checked ");
							var str_moda_iii;
							//post to db to get person name+surname list
							$.post("formadmin_handle/moda_person_wfrqdetail_handle.php", {group_id: groupid}, function(response){
								console.log(response);
								json_ret_modaccess_p = JSON.parse(response);
								if(json_ret_modaccess_p.length != 0){
									str_moda_iii = "<tr><td><select id='selector2_"+index+"'>";
									for (var i = 0; i < json_ret_modaccess_p.length; i++) {
										UserID = json_ret_modaccess_p[i].UserID;
										fullname = json_ret_modaccess_p[i].Name +" "+ json_ret_modaccess_p[i].Surname;
										console.log(UserID);
										console.log(fullname);
										str_moda_iii = str_moda_iii + "<option value='"+UserID+"'>"+fullname+"</option>";
									}
									str_moda_iii = str_moda_iii + "</select></td> <td><table id='confirm_mod_table_"+index+"'></table></td></tr>";
									console.log(str_moda_iii);
									console.log(index);
									$(str_moda_iii).appendTo("#table_person_"+index+"");
									var approverid = $(this).find("option:selected").attr('value');
									// $("#selector2_"+index+"").change(function(){
									// 	$("#confirm_mod_table").empty();
									// 	var approverid = $(this).find("option:selected").attr('value');
									// 	str_confirm_mod = "<tr><td> <input type='button' value='confirm' id='confirm_mod_btn'> </td></tr>";
									// 	$(str_confirm_mod).appendTo("#confirm_mod_table");
									// });
									str_confirm_mod = "<tr><td> <input type='button' value='confirm' id='confirm_mod_btn_"+index+"'> </td></tr>";
									$(str_confirm_mod).appendTo("#confirm_mod_table_"+index+"");
									$("#confirm_mod_btn_"+index+"").click(function(){
										console.log("confirm_mod_btn_"+index+" was clicked");
									});
								}

							});
							// add it to table table_person_'index'

						}else{
							console.log("chkbox not check ");
						}
					});

				});
			});
    });
  }


	function fn_refresh(obj_r){ //obj is object that contain wfrequestid

		$.post("formadmin_handle/formadmin_show_wfrqdetail_handle.php", {wfrequest_id: obj_r.WFRequestID}, function(data){
			console.log(data);
			json_return_wfrqdetail = JSON.parse(data);
			console.log(json_return_wfrqdetail);
			// empty table
			$("#wfrqdetail-table").empty();
			for (var j = 0; j < json_return_wfrqdetail.length; j++) {
				fn2(json_return_wfrqdetail[j], j);
			}
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

				<p class="menu-color" id="Login">Login</p>
				<p class="menu-color" id="Request">Request</p>
				<p class="menu-color" id="Approve">Current form list</p>

		</div>

		<div id="div_content" class="form">
      <div id="current_work_list_page">
        <h2>Work list</h2>
				<form id="chose_available_form">
        	<table id="all-form-table"></table>
				</form>
      </div>

      <div id="chose_work_list_page">
        <h2>Form Work Flow</h2>
				<form id="chose_wfrqdetail">
        	<table id="wfrqdetail-table"></table>
				</form>
      </div>


		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
