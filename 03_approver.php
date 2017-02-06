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
      <div id="current_work_list">
        <h2>Approve list</h2>
        <table id="current-work-table"></table>
      </div>

      <div id="currentwork-select">
        <h2>Student graduation form</h2><!--need to change name according to one that select-->
        <table id="file-download"></table>
      </div>

      <div id="file upload">
        <h2>File upload</h2>
        <table id="file-upload"></table>
        <div class="right">
          <input type="button" value="Approve" id="approve_form" style="width: 90px;">
          <input type="button" value="Reject" id="reject_form" style="width: 90px;">
        </div>
      </div>

      <div id=comment>
        <h2>Comment</h2>
        <table id="approver_comment"></table>
      </div>

		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
