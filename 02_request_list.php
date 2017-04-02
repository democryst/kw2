<?php
session_start();
if(isset($_SESSION['user_id'])){
	echo "<script type='text/javascript'>
					console.log(".$_SESSION['user_id'].");
				</script>";
}
echo "<script>var userid = " . $_SESSION['user_id'] . ";</script>";
if ( ($_SESSION['gName'] != "Requester") && ($_SESSION['gName'] != "Approver") ) {
?>
<script type='text/javascript'>
	alert('You dont have permission!');
</script>
<?php
	// if($_SESSION['gName'] == 'Requester'){
	// 	echo "<script type='text/javascript'>
	// 					window.location = '02_request_list.php';
	// 				</script>";
	// }else if($_SESSION['gName'] == 'Approver'){
	// 	echo "<script type='text/javascript'>
	// 					window.location = '03_approver.php';
	// 				</script>";
	// }else
	if($_SESSION['gName'] == 'Flow_Admin'){
		echo "<script type='text/javascript'>
						window.location = '04_formmodify.php';
					</script>";
	}else if($_SESSION['gName'] == 'Sys_Admin'){
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
	var localhost = "http://localhost:8080/kw2/";
  var State_id;
  var State_status;
		$(document).ready(function() {
			//************************************************************
			$("#Logout").click(function(){
					window.location = '06_logout.php';
			});
			$("#Request").click(function(){
					// alert('Move to request!');
					window.location = '02_request.php';
			});
			// $("#RequestList").click(function(){
			// 		alert('Move to current request form list!');
			// 		window.location = '02_request_list.php';
			// });
			<?php
				if ($_SESSION['gName'] == 'Approver') {
			?>
			$("#Approve").click(function(){
					// alert('Move to current work form list!');
					window.location = '02_request_list.php';
			});
			<?php
				}
			?>
			//************************************************************

      $.post("request_list_handle/requestlist_showlist.php",{requestor_id: userid},function(response){

        console.log(response);
        json_ret_formlist = JSON.parse(response);
        for (var i = 0; i < json_ret_formlist.length; i++) {
          fn1_formlist(json_ret_formlist[i], i);
        }
      });

      $("#current_comment_btn").click(function(){
        let text_current_comment = $("#current_comment").val();
        if (State_status != 0) {
          console.log("State already finish");
        }else {
          if (State_id) {
            console.log("State_id: "+State_id);
            fn3_add_cmt(State_id, text_current_comment);

            $("#request_comment_table").empty();
            $.post("request_list_handle/requestlist_commentlist.php", {data: {WFRequestDetailID: State_id, userid: userid}}, function(response){
              console.log(response);
              json_ret_cmt = JSON.parse(response);
              if (json_ret_cmt.length >=1) {
                var str_add_cmt_list = "<tr><td><Text>Comment</Text></td> <td><Text>Comment by</Text></td> <td><Text>Comment Time</Text></td></tr>";
                $(str_add_cmt_list).appendTo("#request_comment_table");
                // json_ret_cmt = JSON.parse(response);
                for (var k = 0; k < json_ret_cmt.length; k++) {
                  fn2_eachstate_cmt_list(json_ret_cmt[k]);
                }

              }else{
                var str_add_cmt_list = "<tr><td><Text>No comment</Text></td></tr>";
                $(str_add_cmt_list).appendTo("#request_comment_table");
              }
            });

          }else{
            console.log("State_id is empty");
          }
        }

      });
		});

    function fn1_formlist(obj, index){
      var str_formlist = "<tr><td><Text></Text></td> <td><Text>FormName: "+obj.FormName+"</Text></td> <td><Text>Description: "+obj.Description+"</Text></td> <td><Text>CreateTime: "+obj.CreateTime+"</Text></td> <td><input type='button' value='select' id='select_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
      $(str_formlist).appendTo("#requestlist_table");
      $("#select_form_btn_"+index+"").click(function(){
        console.log(obj.WFRequestID);
        fn2_formstate(obj.WFRequestID,index);
      });
    }

    function fn2_formstate(wfrequestid,index){
			$("#request_comment_table").empty();
      $.post("request_list_handle/requestlist_formstate.php",{wfrequest_id: wfrequestid},function(response){
        console.log(response);
        json_ret_formstate = JSON.parse(response);
        $("#requestflow_table").empty();
        for (var j = 0; j < json_ret_formstate.length; j++) {
          fn2_eachstate(json_ret_formstate[j], j);
        }
      });
    }

    function fn2_eachstate(obj, index){
      var str_state = "<tr> <td><Text>State :"+obj.StateName+"</Text></td> ";
      if (obj.DoneBy!=0) {
        // str_state= str_state + "<td><Text>DoneBy :"+obj.DoneBy+"</Text></td>"
        str_state= str_state + "<td></td> <td><Text>Status : </Text></td> <td><img src='images/greendot.png' width='20' height='20'></td>"
      }else{
        str_state= str_state + "<td></td> <td><Text>Status : </Text></td> <td><img src='images/reddot.png' width='20' height='20'></td>"
      }
      str_state = str_state + "<td><input type='button' value='comments' id='comment_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";

      $(str_state).appendTo("#requestflow_table");

      $("#comment_btn_"+index+"").click(function(){
        console.log(obj.WFRequestDetailID);
        State_id = obj.WFRequestDetailID;
        State_status = obj.DoneBy;
        // $("#current_comment_btn").click(function(){
        //   let text_current_comment = $("#current_comment").val();
        //   fn3_add_cmt(obj.WFRequestDetailID, text_current_comment);
        // });

        fn2_eachstate_post(obj.WFRequestDetailID);
      });
    }

		function fn2_eachstate_post(WFRQDetailID){
			$("#request_comment_table").empty();
			$.post("request_list_handle/requestlist_commentlist.php", {data: {WFRequestDetailID: WFRQDetailID, userid: userid}}, function(response){
				console.log(response);
				json_ret_cmt = JSON.parse(response);
				if (json_ret_cmt.length >=1) {
					// var str_add_cmt_list = "<tr style='background-color: azure;'><td><Text>Comment</Text></td> <td><Text>Comment by</Text></td> <td><Text>Comment Time</Text></td></tr>";
					// $(str_add_cmt_list).appendTo("#request_comment_table");
					var str_add_cmt_list;

					// json_ret_cmt = JSON.parse(response);
					for (var k = 0; k < json_ret_cmt.length; k++) {
						fn2_eachstate_cmt_list(json_ret_cmt[k]);
					}

				}
				// else{
				// 	var str_add_cmt_list = "<tr><td style='width: 100px;font-size: small;'><Text style='margin-left:5%;'>No comment</Text></td></tr>";
				// 	$(str_add_cmt_list).appendTo("#request_comment_table");
				// }



			});
		}

    function fn2_eachstate_cmt_list(obj) {
			$.post("request_list_handle/userid_name.php", {userid:obj.CommentBy}, function(res){
				console.log(res);
				json_ret_cmt_userid_name =JSON.parse(res);
				cmtbyname = json_ret_cmt_userid_name.Name + " "+json_ret_cmt_userid_name.Surname;
				if (obj.CommentBy == userid) {
					m_left = 65;
					// m_color = "#3c8dbc";
					m_color = "violet";
				}else{
					m_left = 10;
					m_color = "purple";
				}
	      var str_add_cmt_list = "<tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+cmtbyname+"</Text></td></tr> <tr><td><Text>"+obj.Comment+"</Text></td></tr> <tr><td><Text>"+obj.CommentTime+"</Text></table></td></tr>   </td></tr>";
	      $(str_add_cmt_list).appendTo("#request_comment_table");
			});
			// if (obj.CommentBy == userid) {
			// 	m_left = 65;
			// 	// m_color = "#3c8dbc";
			// 	m_color = "violet";
			// }else{
			// 	m_left = 10;
			// 	m_color = "purple";
			// }
      // var str_add_cmt_list = "<tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+cmtbyname+"</Text></td></tr> <tr><td><Text>"+obj.Comment+"</Text></td></tr> <tr><td><Text>"+obj.CommentTime+"</Text></table></td></tr>   </td></tr>";
      // $(str_add_cmt_list).appendTo("#request_comment_table");
    }

    function fn3_add_cmt(WFRequestDetailID, text_current_comment){
      if (text_current_comment != "") {
        $.post("request_list_handle/addcomment.php", {data: {WFRequestDetailID: WFRequestDetailID, comment: text_current_comment, userid: userid}}, function(response){
          console.log(response);
					jret = JSON.parse(response);
					fn2_eachstate_post(jret.WFRequestDetailID);
        });
      }else {
        console.log("no current comment");
      }
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

			<p class="menu-color" id="Request">Request</p>
			<p class="menu-color" id="RequestList">Current request form list</p>
			<?php
				if ($_SESSION['gName'] == 'Approver') {
			?>
			<p class="menu-color" id="Approve">Current work form list</p>
			<?php
				}
			?>
			<p class="menu-color" id="Logout">Logout</p>

		</div>

		<div id="div_content" class="form">
			<div id="Requestlist">
        <h2>Current Request list</h2>
        <table id="requestlist_table" style="margin-left:5%;font-size:small;"></table>
			</div>

      <div id="requestflow">
        <h2>Workflow</h2>
        <table id="requestflow_table" style="margin-left:5%;font-size:small;"></table>
			</div>

      <div id="comment">
        <h2>Comment</h2>
        <table id="request_comment_table"></table>
        <table id="commentbox" style="margin-left:5%;background-color:#8282fe;border-radius:3px;border:1px solid transparent;width:450px;height:18px;color:white;font-size:small;">
          <tr><td style="width:100px"><Text>Comment box: </Text></td> <td><input type="text" id="current_comment" style="width: 220px;"></td> <td><input type="button" id="current_comment_btn" value="comment" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;"></td></tr>
        </table>
			</div>

		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
