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



    var str = "<tr> <td><Text>State Name: "+obj.StateName+"</Text></td>  <td><table> <tr><td><Text id='up_"+index+"'>up</Text></td></tr> <tr><td><Text id='down_"+index+"'>down</Text></td></tr> </table></td> <td><Text id='moda_"+index+"'>ModifyAccess</Text></td> </tr>";
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
      console.log("modifyaccess");
			$.post("formadmin_handle/moda_wfrqdetail_handle.php", {data_obj : {WFrqDetail_ID: obj.WFRequestDetailID, Parent_ID: obj.ParentID, WFrqDoc_ID: obj.WFRequestDocID}}, function(response){
				console.log(response);
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
