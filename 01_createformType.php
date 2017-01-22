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
			$("#add_state_btn").click(function(){
				var str='<tr> <td>State Name: </td><td><input type="text" name="state_array[]"></td>'+
				'<td><input type="file" name="file_array[]"></td></tr>' ;
				$(str).appendTo("#state_table");
			});
			$("#Create_Form_submit").click(function(evt){	 
					  //evt.preventDefault();
					  var formData = new FormData($('#CreateFormType')[0]);
					  $.ajax({
						   url: 'createformType_handle.php',
						   type: 'POST',
						   data: formData,
						   async: false,
						   cache: false,
						   contentType: false,
						   enctype: 'multipart/form-data',
						   processData: false,
						   success: function (response) {
							 alert(response);
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
			<h2>Create Form</h2>
				<form action="createformType_handle.php" method="post" enctype="multipart/form-data" id="CreateFormType" >					
					<div >
						<Text>Form Name:</Text>
						<input type="text" id="form_name" name="form_name">
					</div>
					<div class="right" id="state_box">
						
						
						<table id="state_table"></table>
						<input type="button" value="add state" id="add_state_btn">
					</div>

					<div class="center">
						<input type="button" value="CreateForm" id="Create_Form_submit" style="width: 90px;">
						<!--input type="submit" value="Upload all files" id="Create_Form_submit"-->
						<input type="reset" style="width: 90px;">							
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