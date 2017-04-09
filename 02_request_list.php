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
	var WFreq_ID;
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
			$("#moveto_edit_doc_box").hide();
			$("#editdoc").hide();
			//edit doc display
			$("#moveto_edit_doc_box").click(function(){
				$("#editdoc").show();
				$("#relate_doc_table").empty();
				console.log(WFreq_ID);
				$.post("request_list_handle/requestlist_show_all_doc.php",{wfrequest_id: WFreq_ID},function(res){
					// console.log(res);
					j_doc_re = JSON.parse(res);
					console.log(j_doc_re);
					for (var i = 0; i < j_doc_re.length; i++) {
						let e_WFRequestDocID = j_doc_re[i].WFRequestDocID;
						let e_WFRequestID = j_doc_re[i].WFRequestID;
						let e_DocName = j_doc_re[i].DocName;
						// j_doc_re[i].DocURL;
						// j_doc_re[i].TimeStamp;
						// j_doc_re[i].WFDocID;
						console.log(e_WFRequestDocID);
						console.log(e_WFRequestID);
						console.log(e_DocName);
						console.log(i);
						str_show_doc = "<tr style='margin-left:10;'><td> <div style='display:grid'><img src='images/Document.ico' height='52' width='52'><Text style='font-size:small;'>"+e_DocName+"</Text></div>  </td> <td><form id='formupload_"+i+"'><input type='file' name='file' id='file_update_"+i+"'><input type='hidden' name='docid' value='"+e_WFRequestDocID+"' ><input type='hidden' name='userid' value='"+userid+"' ></form></td>   <td><input type='button' value='edit' id='editdoc_btn_"+i+"'></td> </tr>";
						// str_show_doc = "<tr style='margin-left:10;'><td> <div style='display:grid'><img src='images/Document.ico' height='52' width='52'><Text style='font-size:small;'>"+e_DocName+"</Text></div>  </td> <td><form id='formupload_"+i+"'><input type='file' id='file_update_"+i+"'><input type='hidden' name='docid' value='"+e_WFRequestDocID+"' ><input type='hidden' name='userid' value='"+userid+"' ></form></td>   <td><input type='button' value='edit' id='editdoc_btn_"+i+"'></td> </tr>";
						$(str_show_doc).appendTo("#relate_doc_table");
						let index = i;
						$("#editdoc_btn_"+i+"").click(function(){
							// console.log(index);
							e_fileupdate = $("#file_update_"+index+"").val();
							fn4_doc_update(index, e_fileupdate);
						});

					}
				});
			});
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
			let create_time = obj.CreateTime;
			let CreateTime = create_time.replace("***"," ");
      var str_formlist = "<tr > <td class='cardbox'><Text>FormName: "+obj.FormName+"</Text></td> <td class='cardbox'><Text>Description: "+obj.Description+"</Text></td> <td class='cardbox'><Text>CreateTime: "+CreateTime+"</Text></td> <td><input type='button' value='select' id='select_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
      $(str_formlist).appendTo("#requestlist_table");
      $("#select_form_btn_"+index+"").click(function(){
				$("#moveto_edit_doc_box").show();
				$("#editdoc").hide();
				$("#relate_doc_table").empty();
        console.log(obj.WFRequestID);
				WFreq_ID = obj.WFRequestID;
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
      var str_state = "<tr > <td class='cardbox'><Text>State :"+obj.StateName+"</Text></td> ";
      if (obj.DoneBy!=0) {
        // str_state= str_state + "<td><Text>DoneBy :"+obj.DoneBy+"</Text></td>"
        str_state= str_state + "<td class='cardbox' style='margin-left:10px'><Text>Status : </Text></td> <td style='margin-left:10px'><img src='images/greendot.png' width='20' height='20'></td>"
      }else{
        str_state= str_state + "<td><Text class='cardbox' style='margin-left:10px'>Status : </Text></td> <td style='margin-left:10px'><img src='images/reddot.png' width='20' height='20'></td>"
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

		function fn4_doc_update(index, e_fileupdate){
			// console.log(e_fileupdate);
			if (e_fileupdate.length != 0) {
				console.log("update file");
				var formData = new FormData($('#formupload_'+index+'')[0]);
				console.log(formData);  //json formdata
		 		$.ajax({
		 			 url: 'request_list_handle/edit_doc.php',
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
				<div id="moveto_edit_doc_box" class="right"><input type="button" value="Edit" id="moveto_edit_doc_btn" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;"></div>
        <table id="requestflow_table" style="margin-left:5%;font-size:small;"></table>
			</div>

			<div id="editdoc">
        <h2>Relate documents</h2>
        <table id="relate_doc_table" style="margin-left:5%;font-size:small;"></table>
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
