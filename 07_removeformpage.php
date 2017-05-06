<?php
session_start();
if(isset($_SESSION['user_id'])){
	echo "<script type='text/javascript'>
					console.log(".$_SESSION['user_id'].");
				</script>";
}
echo "<script>var user_id = " . $_SESSION['user_id'] . ";</script>";
if ($_SESSION['gName'] != "Sys_Admin"){
?>
<script type='text/javascript'>
	alert('You dont have permission!');
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
	}
  // else if($_SESSION['gName'] == 'Sys_Admin'){
	// 	echo "<script type='text/javascript'>
	// 					window.location = '01_createformType_multidoc.php';
	// 				</script>";
	// }
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

  // user_id = 0;


	$(document).ready(function() {
		//************************************************************
		$("#Logout").click(function(){
				window.location = '06_logout.php';
		});
		// $("#Request").click(function(){
		// 		alert('Move to request!');
		// 		window.location = '02_request.php';
		// });
		$("#CreateFormType").click(function(){
				// alert('Move to current request form list!');
				window.location = '07_removeformpage.php';
		});
    $("#FormTemplate").click(function(){
				// alert('Move to current request form list!');
				window.location = '01_createformType_multidoc.php';
		});
		//************************************************************
		$.getJSON("07_removeformtemplate/showformtemplatelist.php", function(res){
			console.log(res);
			json_ret_wfgeninfo = JSON.parse(res);
			for (var i = 0; i < json_ret_wfgeninfo.length; i++) {
				showselectformtype(json_ret_wfgeninfo[i], i);
			}

		});


  });
	function showselectformtype(data, index){
		// data.WFGenInfoID;
		// data.CreatorID
		// data.CreateTime
		// data.WFInfoModifyID
		// var show_FormName = data.FormName;
		// var show_Description = data.Description;
		// data.AdminID
		let str_wfgeninfo = "<div> <div class='makeinline'><input type='hidden' value='"+data.WFGenInfoID+"' id='s_wfgeninfo_id_"+index+"'> <text>Form name : "+data.FormName+"</text> <text>Description : "+data.Description+"</text> <input type='button' value='select' id='s_wfgeninfo_"+index+"'></div>   </div>";
		$(str_wfgeninfo).appendTo("#all-formtemplate-table");

		$("#s_wfgeninfo_"+index+"").click(function(){
			let c_wfgeninfo = $("#s_wfgeninfo_id_"+index+"").val();
			showselectformtype2(c_wfgeninfo);
		});
	}

	function showselectformtype2(wfgeninfo_id){
		$.post("07_removeformtemplate/showtemplatedetail.php", {data: {wfgeninfo_id: wfgeninfo_id, userid: user_id}} function(res){
			console.log(res);
			let json_ret_wf_detail_doc = JSON.parse(res);
			wfdetail = json_ret_wf_detail_doc['wfdetail'];
			wfdoc = json_ret_wf_detail_doc['wfdoc'];

			for (var j = 0; j < wfdetail.length; j++) {
				// WFDetailID
				// ParentID
				// StateName
				// CreateTime
				// ModifyTime
				// Deadline
				// WFDocID
				// WFGenInfoID
				cwfdetail = wfdetail[j];

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

				<!-- <p class="menu-color" id="Login">Login</p> -->
				<p class="menu-color" id="CreateFormType">CreateFormType</p>
				<p class="menu-color" id="FormTemplate">Form template list</p>
				<p class="menu-color" id="Logout">Logout</p>

		</div>

		<div id="div_content" class="form">

      <div id="form_template_list_page">
        <h2>Request list</h2>
				<div id="all-formtemplate-table" style='margin-left:5%;'></div>
      </div>

      <div id="form_template_page">
        <h2>Request list</h2>
				<!-- <div id="formtemplate-table" style='margin-left:5%;'></div> -->
				<div id="template-detail-table" style='margin-left:5%;'></div>
				<div id="template-doc-table" style='margin-left:5%;'></div>
      </div>

		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
