<?php
require_once('connect.php');
session_start();

if(isset($_POST['login']) && isset($_POST['pass'])){
	$q = 'SELECT * FROM user, userpriority, priority WHERE UserName = "'.$_POST['login'].'" AND Password = "'.$_POST['pass'].'" AND user.UserID = userpriority.UserID AND userpriority.PriorityID = priority.PriorityID;';
	$res = $mysqli -> query($q);
	if ($res && $res->num_rows == 1 ){
		while($row = $res -> fetch_array()){
				$_SESSION['user_id'] = $row['UserID'];
				$_SESSION['user_name'] = $row['UserName'];
				$_SESSION['password'] = $row['Password'];
				$_SESSION['gName'] = $row['Priority'];
		}
	}else{
?>
		<script type='text/javascript'>
			alert('Login Failed, Your username or password is invalid!');
		</script>
		<script type='text/javascript'>
			window.location = '05_log_in.php';
		</script>
<?php
	}
	if($_SESSION['gName'] == 'Requester'){
		echo "<script type='text/javascript'>
						alert('Login Success!');
					</script>";
		echo "<script type='text/javascript'>
						window.location = '02_request_list.php';
					</script>";
	}else if($_SESSION['gName'] == 'Approver'){
		echo "<script type='text/javascript'>
						alert('Login Success!');
					</script>";
		echo "<script type='text/javascript'>
						window.location = '03_approver.php';
					</script>";
	}else if($_SESSION['gName'] == 'Flow_Admin'){
		echo "<script type='text/javascript'>
						alert('Login Success!');
					</script>";
		echo "<script type='text/javascript'>
						window.location = '04_formmodify.php';
					</script>";
	}else if($_SESSION['gName'] == 'Sys_Admin'){
		echo "<script type='text/javascript'>
						alert('Login Success!');
					</script>";
		echo "<script type='text/javascript'>
						window.location = '01_createformType.php';
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
	<script src="scripts/jquery-2.0.0.min.js"></script>

	<script type="text/javascript">
	// $(document).ready(function() {
	// 	$("#Register").click(function(){
	// 			window.location = '07_register.php';
	// 	});
	// });
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
				<p class="menu-color" id="Register">Register</p>

		</div>

		<div id="div_content" class="form">
      <div id="current_work_list_page">
        <h2>Please input username & password</h2>
      </div>
			<form action="05_log_in.php" method="POST" id="logging">
	      <div style="padding-left:2%">
						<div style="width:100px;display:inline-block;">Username : </div>
						<input type="text" name="login" placeholder="Please Enter your username" id="upload_btn">
	      </div>
				<div style="padding-left:2%">
					<div style="width:100px;display:inline-block;">Password : </div>
	        <input type="password" name="pass" placeholder="Please Enter your password" id="upload_btn">
				</div>
			</form>
			<button type="submit" form="logging" style="margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;">
				Log-in
			</button>
		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
