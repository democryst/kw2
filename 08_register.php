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

	// var userid = 1;//test approver id
	var cur_wfrqstate_id;
	var cmtbyname;
	var wfrequestdocarr_new = new Array();
	$(document).ready(function() {
		//************************************************************
		$("#Login_Tab").click(function(){
				window.location = '05_log_in.php';
		});
    $("#Register_Tab").click(function(){
				window.location = '08_register.php';
		});
		//************************************************************
    $.getJSON("08_register/get_group.php",function(res){
      console.log(res);
      // let json_group = JSON.parse(res);
      let json_group = res;
      let str_get_group = "<select id='select_group'>";
      str_get_group = str_get_group + "<option value='0'>--select group--</option>";
      for (var i = 0; i < json_group.length; i++) {
        GroupID = json_group[i].GroupID;
        GroupName = json_group[i].GroupName;
        str_get_group = str_get_group + "<option value='"+GroupID+"'>"+GroupName+"</option>";
      }
      str_get_group = str_get_group + "<select>";
      $(str_get_group).appendTo("#groupbox");

      $.getJSON("08_register/get_priority.php",function(res){
        console.log(res);
        // let json_priority = JSON.parse(res);
        let json_priority = res;
        let str_get_priority = "<select id='select_priority'>";
        str_get_priority = str_get_priority + "<option value='0'>--select priority--</option>";
        for (var i = 0; i < json_priority.length; i++) {
          PriorityID = json_priority[i].PriorityID;
          Priority = json_priority[i].Priority;
          str_get_priority = str_get_priority + "<option value='"+PriorityID+"'>"+Priority+"</option>";
        }
        str_get_priority = str_get_priority + "<select>";
        $(str_get_priority).appendTo("#prioritybox");
      });

    });

    $("#Register_btn").click(function(){
      groupid = $("#select_group").val(); console.log(groupid);
      priorityid = $("#select_priority").val(); console.log(priorityid);
      username = $("#username").val();
      password = $("#password").val();
      name = $("#name").val();
      surname = $("#surname").val();
      if (groupid!=0 && priorityid!=0) {
        $.post("08_register/post_register.php",{ data:{ groupid: groupid, priorityid: priorityid, username: username, password: password, name: name, surname: surname} }, function(res){
          console.log(res);
					register_res = JSON.parse(res);
          if (register_res == 1) {
          	alert("Register Successfully!");
						window.location = '05_log_in.php';
          }else if(register_res == -1 ){
						alert("Register Fail!");
					}else if(register_res == 0 ){
						alert("User Already Exist!");
					}

        });
      }
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

			<p class="menu-color" id="Register_Tab">Register</p>
			<p class="menu-color" id="Login_Tab">Login</p>

		</div>

		<div id="div_content" class="form">
      <div id="Register">
        <h2>Register</h2>
				<div id="Register_box" style="margin-left:10px">
          <div calss="makeinline"><Text>UserName : </Text><input type="text" id="username"></div>
          <div calss="makeinline"><Text>Password : </Text><input type="text" id="password"></div>
          <div calss="makeinline"><Text>Name : </Text><input type="text" id="name"></div>
          <div calss="makeinline"><Text>Surname : </Text><input type="text" id="surname"></div>
          <div calss="makeinline" id="groupbox"><Text>Group : </Text></div>
          <div calss="makeinline" id="prioritybox"><Text>Priority : </Text></div>
          <div calss="right"><input type="button" value="Register" id="Register_btn"></div>
        </div>
      </div>







	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
