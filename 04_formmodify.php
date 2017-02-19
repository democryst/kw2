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
  user_id = 2;


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
    var str = "<tr> <td><Text>FormName: "+FormName+"</Text><td> <td><Text>Description: "+Description+"</Text><td> <td><input type='button' value='select' id='"+index+"' ></td></tr>";
    $(str).appendTo("#all-form-table");
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


		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
