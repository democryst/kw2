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
  var userid = 0;
  var State_id;
  var State_status;
		$(document).ready(function() {
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
      var str_formlist = "<tr><td><Text></Text></td> <td><Text>FormName: "+obj.FormName+"</Text></td> <td><Text>Description: "+obj.Description+"</Text></td> <td><Text>CreateTime: "+obj.CreateTime+"</Text></td> <td><input type='button' value='select' id='select_form_btn_"+index+"'></td></tr>";
      $(str_formlist).appendTo("#requestlist_table");
      $("#select_form_btn_"+index+"").click(function(){
        console.log(obj.WFRequestID);
        fn2_formstate(obj.WFRequestID,index);
      });
    }

    function fn2_formstate(wfrequestid,index){
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
      str_state = str_state + "<td><input type='button' value='comments' id='comment_btn_"+index+"'></td></tr>";

      $(str_state).appendTo("#requestflow_table");

      $("#comment_btn_"+index+"").click(function(){
        console.log(obj.WFRequestDetailID);
        State_id = obj.WFRequestDetailID;
        State_status = obj.DoneBy;
        // $("#current_comment_btn").click(function(){
        //   let text_current_comment = $("#current_comment").val();
        //   fn3_add_cmt(obj.WFRequestDetailID, text_current_comment);
        // });

        $("#request_comment_table").empty();
        $.post("request_list_handle/requestlist_commentlist.php", {data: {WFRequestDetailID: obj.WFRequestDetailID, userid: userid}}, function(response){
          console.log(response);
          json_ret_cmt = JSON.parse(response);
          if (json_ret_cmt.length >=1) {
            var str_add_cmt_list = "<tr style='background-color: azure;'><td><Text>Comment</Text></td> <td><Text>Comment by</Text></td> <td><Text>Comment Time</Text></td></tr>";
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
      });
    }

    function fn2_eachstate_cmt_list(obj) {
      var str_add_cmt_list = "<tr><td><Text>"+obj.Comment+"</Text></td> <td><Text>"+obj.CommentBy+"</Text></td> <td><Text>"+obj.CommentTime+"</Text></td></tr>";
      $(str_add_cmt_list).appendTo("#request_comment_table");
    }

    function fn3_add_cmt(WFRequestDetailID, text_current_comment){
      if (text_current_comment != "") {
        $.post("request_list_handle/addcomment.php", {data: {WFRequestDetailID: WFRequestDetailID, comment: text_current_comment, userid: userid}}, function(response){
          console.log(response);
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

      <p class="menu-color" id="Login">Login</p>
      <p class="menu-color" id="Request">Request</p>
      <p class="menu-color" id="Approve">Current form list</p>

		</div>

		<div id="div_content" class="form">
			<div id="Requestlist">
        <h2>Current Request list</h2>
        <table id="requestlist_table"></table>
			</div>

      <div id="requestflow">
        <h2>Workflow</h2>
        <table id="requestflow_table"></table>
			</div>

      <div id="comment">
        <h2>Comment</h2>
        <table id="request_comment_table"></table>
        <table id="commentbox">
          <tr><td><Text>Comment box: </Text><input type="text" id="current_comment"><input type="button" id="current_comment_btn" value="comment"></td></tr>
        </table>
			</div>

		</div>
	</div>

	<div id="div_footer">
	</div>

</div>


</body>
</html>
