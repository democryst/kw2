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
						window.location = '01_createformType_multidoc.php';
					</script>";
	}else{
		echo "<script type='text/javascript'>
						window.location = '05_log_in.php';
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
	<!-- <script src="scripts/jquery-2.0.0.min.js"></script> -->
		<script src="jquery-3.1.1.min.js"></script>

	<script type="text/javascript">
	var localhost = "http://localhost:8080/kw2/";
  var State_id;
  var State_status;
	var WFreq_ID;
	var kw1_pass_item;
		$(document).ready(function() {
			$('#div_kw1').hide();
			$('#div_kw1').load('../kw1TempServer/Senior%20Project%20KW%20Demo/kwDemo4-fillFile.html');
			//************************************************************
			$("#Logout").click(function(){
					window.location = '06_logout.php';
			});
			$("#Request").click(function(){
					// alert('Move to request!');
					window.location = '02_request.php';
			});
			$("#RequestList").click(function(){
					// alert('Move to current request form list!');
					window.location = '02_request_list.php';
			});
			<?php
				if ($_SESSION['gName'] == 'Approver') {
			?>
			$("#Approve").click(function(){
					// alert('Move to current work form list!');
					window.location = '03_approver.php';
			});
			<?php
				}
			?>
			//************************************************************
			$("#Requestlist").hide();
			$("#Requestcompletelist").hide();
			$("#Requestworklist").hide();
			$("#comment").hide();
			$("#requestflow").hide();

			$("#moveto_edit_doc_box").hide();
			$("#editdoc").hide();
			//edit doc display
			// $("#moveto_edit_doc_box").click(function(){
			// 	$("#editdoc").show();
			// 	$("#relate_doc_table").empty();
			// 	console.log(WFreq_ID);
			// 	$.post("request_list_handle/requestlist_show_all_doc.php",{wfrequest_id: WFreq_ID},function(res){
			// 		// console.log(res);
			// 		j_doc_re = JSON.parse(res);
			// 		console.log(j_doc_re);
			// 		for (var i = 0; i < j_doc_re.length; i++) {
			// 			let e_WFRequestDocID = j_doc_re[i].WFRequestDocID;
			// 			let e_WFRequestID = j_doc_re[i].WFRequestID;
			// 			let e_DocName = j_doc_re[i].DocName;
			// 			// j_doc_re[i].DocURL;
			// 			// j_doc_re[i].TimeStamp;
			// 			// j_doc_re[i].WFDocID;
			// 			str_show_doc = "<tr style='margin-left:10;'><td> <div style='display:grid'><img src='images/Document.ico' height='52' width='52'><Text style='font-size:small;'>"+e_DocName+"</Text></div>  </td> <td><form id='formupload_"+i+"'><input type='file' name='file' id='file_update_"+i+"'><input type='hidden' name='docid' value='"+e_WFRequestDocID+"' ><input type='hidden' name='userid' value='"+userid+"' ></form></td>   <td><input type='button' value='edit' id='editdoc_btn_"+i+"'></td> </tr>";
			// 			// str_show_doc = "<tr style='margin-left:10;'><td> <div style='display:grid'><img src='images/Document.ico' height='52' width='52'><Text style='font-size:small;'>"+e_DocName+"</Text></div>  </td> <td><form id='formupload_"+i+"'><input type='file' id='file_update_"+i+"'><input type='hidden' name='docid' value='"+e_WFRequestDocID+"' ><input type='hidden' name='userid' value='"+userid+"' ></form></td>   <td><input type='button' value='edit' id='editdoc_btn_"+i+"'></td> </tr>";
			// 			$(str_show_doc).appendTo("#relate_doc_table");
			// 			let index = i;
			// 			$("#editdoc_btn_"+i+"").click(function(){
			// 				// console.log(index);
			// 				e_fileupdate = $("#file_update_"+index+"").val();
			// 				fn4_doc_update(index, e_fileupdate);
			// 			});
			//
			// 		}
			// 	});
			// });
			//************************************************************
			$("#Request_tab_worklist").click(function(){
				$("#Requestlist").hide();
				$("#Requestcompletelist").hide();
				$("#Requestworklist").show();
				$("#comment").hide();
				$("#moveto_edit_doc_box").hide();
				$("#editdoc").hide();
				$("#requestflow").hide();

				$("#requestflow_table").empty();
				$("#requestcompletelist_table").empty();

				$.post("request_list_handle/requestworklist_showworklist.php",{requestor_id: userid},function(response){
	        console.log(response);
	        json_ret_formworklist = JSON.parse(response);
					$("#requestworklist_table").empty();
					for (var i = 0; i < json_ret_formworklist.length; i++) {
						let retwfrequest = json_ret_formworklist[i];
						let str_wl_wfrequest = "<div class='cardbox' style='color:black;'> <Text style='margin-left:10;'>FormName : "+retwfrequest.FormName+"</Text> <Text>Description : "+retwfrequest.Description+"</Text> <input type='hidden' value='"+retwfrequest.WFRequestID+"' id='wfrequestid_"+i+"'> <input type='button' value='select' id='select_wfrequest_"+i+"' class='select_wfrequest_f_color' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;' ></div>";
						$(str_wl_wfrequest).appendTo("#requestworklist_table");
						let cur_index = i;
						$("#select_wfrequest_"+i+"").click(function(){
							let select_wfrequest_f_color_c_obj = document.getElementsByClassName('select_wfrequest_f_color');
							for (var i = 0; i < select_wfrequest_f_color_c_obj.length; i++) {
								select_wfrequest_f_color_c_obj[i].style.backgroundColor ='#3c8dbc';
							}
							let select_wfrequest_f_color_cbtn_obj = document.getElementById("select_wfrequest_"+cur_index+"");
							select_wfrequest_f_color_cbtn_obj.style.backgroundColor ="#252726";

							let wfrequestid_s_wl = $("#wfrequestid_"+cur_index+"").val();
							$("#requestflow").show();
							console.log(cur_index);
							console.log(wfrequestid_s_wl);
							showWFworklist(wfrequestid_s_wl, i);

						});
					}
	      });
			});

      $("#Request_tab_Request").click(function(){
				$("#Requestworklist").hide();
				$("#Requestcompletelist").hide();
				$("#Requestlist").show();
				$("#moveto_edit_doc_box").hide();
				$("#editdoc").hide();
				$("#requestflow").hide();

				$("#requestlist_table").empty();
				$("#requestcompletelist_table").empty();

				$.post("request_list_handle/requestlist_showlist.php",{requestor_id: userid},function(response){

	        console.log(response);
	        json_ret_formlist = JSON.parse(response);
	        for (var i = 0; i < json_ret_formlist.length; i++) {
	          fn1_formlist(json_ret_formlist[i], i);
	        }
	      });
			});

			$("#Request_tab_Complete").click(function(){
				$("#Requestworklist").hide();
				$("#Requestlist").hide();
				$("#Requestcompletelist").show();
				$("#comment").hide();
				$("#moveto_edit_doc_box").hide();
				$("#editdoc").hide();
				$("#requestflow").hide();

				$("#requestflow_table").empty();
				$("#requestlist_table").empty();
				$("#requestcompletelist_table").empty();
				$.post("request_list_handle/requestlist_showcompletelist.php",{requestor_id: userid},function(response){
	        console.log(response);
					jres_completelist = JSON.parse(response);
					console.log(jres_completelist);
					for (var i = 0; i < jres_completelist.length; i++) {
						let FormName_comp = jres_completelist[i].FormName;
						let CreateTime_comp = jres_completelist[i].CreateTime;
						let CreateTime_comp_s = CreateTime_comp.replace("***", " ");
						let Document_comp = jres_completelist[i].Document;
						var str_completelist = "<tr><td><div class='makeinline'><Text>FormName : "+FormName_comp+"</Text> <Text>CreateTime: "+CreateTime_comp_s+"</Text></div></td> <td><div id='doccomptable_"+i+"' class='makeinline'></div></td></tr> <tr><td><text>____________________________________________</text></td></tr>";
						$(str_completelist).appendTo("#requestcompletelist_table");
						let wfdoctype_complete_check = jres_completelist[i].WfdocType;
						if (wfdoctype_complete_check == 0) {
							for (var j = 0; j < Document_comp.length; j++) {
								let DocName_comp = Document_comp[j].DocName;
								let DocURL_comp = Document_comp[j].DocURL;
								// console.log(DocName_comp);
								str_completelist_1 = "<div style='margin-left:10px;'> <div><a target='_tab' href='"+localhost+DocURL_comp+"'><img src='images/Document.ico' height='52' width='52'></a></div> <div><Text>"+DocName_comp+"</Text></div>  </div>";
								$(str_completelist_1).appendTo("#doccomptable_"+i);
							}
						}else {
							for (var j = 0; j < Document_comp.length; j++) {
								let DocName_comp = Document_comp[j].DocName;
								let DocURL_comp = Document_comp[j].DocURL;
								// console.log(DocName_comp);
								str_completelist_1 = "<div style='margin-left:10px;' class='makeinline'> <div><img src='images/Document.ico' height='52' width='52' id='kw1_doc_comp_"+i+j+"_"+DocURL_comp+"'></div> <div><Text>"+DocName_comp+"</Text></div>  </div>";
								$(str_completelist_1).appendTo("#doccomptable_"+i);
								let i_index = i;
								let j_index = j;
								$("#kw1_doc_comp_"+i+j+"_"+DocURL_comp).click(function(){
									console.log("*************************************************");
									let kw1_id = $(this).attr('id');
									console.log(kw1_id);
									let str_f_split = 'kw1_doc_comp_'+i_index+j_index+'_item';
									console.log(str_f_split);
									kw1_pass_item = kw1_id.split(str_f_split)[1];
									console.log("kw1_pass_item --" + kw1_pass_item);
									setTimeout(function(){
										$('#div_kw2').hide();
										$('#div_kw1').load('../kw1TempServer/Senior%20Project%20KW%20Demo/kwDemo4-viewDownload.html');

										$('#div_kw1').show();
									}, 100);
								});
							}
						}

						// str_completelist = str_completelist+"</tr>";console.log(str_completelist);
						// $(str_completelist).appendTo("#requestcompletelist_table");
					}
	      });

			});

      $("#current_comment_btn").click(function(){
        let text_current_comment = $("#current_comment").val();
        if (State_status != 0) {
          console.log("State already finish");
        }else {
          if (State_id) {
            console.log("State_id: "+State_id);
            fn3_add_cmt(State_id, text_current_comment);
						$("#comment").show();
            $("#request_comment_table").empty();
            $.post("request_list_handle/requestlist_commentlist.php", {data: {WFRequestDetailID: State_id, userid: userid}}, function(response){
              console.log(response);
              json_ret_cmt = JSON.parse(response);
              if (json_ret_cmt.length >=1) {
                var str_add_cmt_list = "<div><table><tr><td><Text>Comment</Text></td> <td><Text>Comment by</Text></td> <td><Text>Comment Time</Text></td></tr></table></div>";
                $(str_add_cmt_list).appendTo("#request_comment_table");
                // json_ret_cmt = JSON.parse(response);
                for (var k = 0; k < json_ret_cmt.length; k++) {
                  fn2_eachstate_cmt_list(json_ret_cmt[k]);
                }

              }else{
                var str_add_cmt_list = "<div><table><tr><td><Text>No comment</Text></td></tr></table></div>";
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
      // var str_formlist = "<tr > <td class='cardbox'><Text>FormName: "+obj.FormName+"</Text></td> <td class='cardbox'><Text>Description: "+obj.Description+"</Text></td> <td class='cardbox'><Text>CreateTime: "+CreateTime+"</Text></td> <td><input type='button' value='select' id='select_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
      // var str_formlist = "<tr > <td > <div class='cardbox' style='display:inline-block;'> <div style='display:inline-block;'><Text>FormName: "+obj.FormName+"</Text><Text>Description: "+obj.Description+"</Text><Text>CreateTime: "+CreateTime+"</Text></div> <div style='display:inline-block;'><input type='button' value='select' id='select_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></div> </div></td></tr>";
      // var str_formlist = "<tr > <td > <div class='cardbox' style='display:inline-block;'> <table ><tr><td><table style='font-size:small;color:black;'><tr><td><Text>FormName: "+obj.FormName+"</Text></td></tr><tr><td><Text>Description: "+obj.Description+"</Text></td></tr><tr><td><Text>CreateTime: "+CreateTime+"</Text></td></tr></table></td> <td><div style='display:inline-block;'><input type='button' value='select' id='select_form_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td> </tr></table></td></tr>";
			var str_formlist = "<tr > <td > <div class='cardbox' > <div style='display:inline-block;color:black;'><div><Text>FormName: "+obj.FormName+"</Text></div><div><Text>Description:"+obj.Description+"</Text></div><div><Text>CreateTime: "+CreateTime+"</Text></div> </div><div style='display:inline-block;'><input type='button' value='select' id='select_form_btn_"+index+"' class='select_form_btn_request_f_color' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></div> </div></td></tr>";

      $(str_formlist).appendTo("#requestlist_table");
      $("#select_form_btn_"+index+"").click(function(){
				let select_form_btn_request_f_color_c_obj = document.getElementsByClassName('select_form_btn_request_f_color');
				for (var i = 0; i < select_form_btn_request_f_color_c_obj.length; i++) {
					select_form_btn_request_f_color_c_obj[i].style.backgroundColor ='#3c8dbc';
				}
				let select_form_btn_request_f_color_cbtn_obj = document.getElementById("select_form_btn_"+index+"");
				select_form_btn_request_f_color_cbtn_obj.style.backgroundColor ="#252726";

				// $("#moveto_edit_doc_box").show();
				$("#editdoc").hide();
				$("#requestflow").show();
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
      // var str_state = "<tr > <td class='cardbox'><Text>State :"+obj.StateName+"</Text></td> ";
      // if (obj.DoneBy!=0) {
      //   // str_state= str_state + "<td><Text>DoneBy :"+obj.DoneBy+"</Text></td>"
      //   str_state= str_state + "<td class='cardbox' style='margin-left:10px'><Text>Status : </Text></td> <td style='margin-left:10px'><img src='images/greendot.png' width='20' height='20'></td>"
      // }else{
      //   str_state= str_state + "<td><Text class='cardbox' style='margin-left:10px'>Status : </Text></td> <td style='margin-left:10px'><img src='images/reddot.png' width='20' height='20'></td>"
      // }
      // str_state = str_state + "<td><input type='button' value='comments' id='comment_btn_"+index+"' style='margin-left:17%;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";

			var str_state = "<tr > <td ><div class='cardbox' style='display:inline-block;color:black;'><Text style='margin-left:10px;'>State :"+obj.StateName+"</Text>";
      if (obj.DoneBy!=0) {
        // str_state= str_state + "<td><Text>DoneBy :"+obj.DoneBy+"</Text></td>"
        str_state= str_state + "<Text style='margin-left:10px;'>Status : </Text> <img src='images/greendot.png' width='20' height='20' style='margin-left:10px;'>"
      }else{
        str_state= str_state + "<Text style='margin-left:10px;'>Status : </Text> <img src='images/reddot.png' width='20' height='20' style='margin-left:10px;'>"
      }
      str_state = str_state + "<input type='button' value='comments' id='comment_btn_"+index+"' class='comment_btn'> ";

			if (obj.DoneBy==userid) {
				str_state = str_state + "<input type='button' value='document' id='document_R_"+index+"' style='margin-left:10px;background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'> </div></td></tr>";
			}

			str_state = str_state + "</div></td></tr>";
      $(str_state).appendTo("#requestflow_table");

			if (obj.DoneBy==userid) {
				$("#document_R_"+index+"").click(function(){
					console.log(obj);

					documentpage_Request(obj.WFRequestDetailID, obj.TemplateFileChose);
				});
			}

      $("#comment_btn_"+index+"").click(function(){
				let cmt_c_obj = document.getElementsByClassName('comment_btn');
				console.log(cmt_c_obj);
				for (var i = 0; i < cmt_c_obj.length; i++) {
					console.log(cmt_c_obj[i].style.backgroundColor);
					// cmt_c_obj[i].style.backgroundColor ='gray';
					cmt_c_obj[i].style.backgroundColor ='#3c8dbc';
					// cmt_c_obj[i].style.color ='black';
					// cmt_c_obj[i].style.color ='white';
				}
				let cmt_cbtn_obj = document.getElementById("comment_btn_"+index+"");
				// cmt_cbtn_obj.style.backgroundColor ="#3c8dbc";
				cmt_cbtn_obj.style.backgroundColor ="#252726";
				// cmt_cbtn_obj.style.color="white";
				// cmt_cbtn_obj.style.color="black";

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
			$("#comment").show();
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
	      var str_add_cmt_list = "<div><table><tr> <td><table style='margin-left:"+m_left+"%;background-color:"+m_color+";border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:300px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><tr><td><Text>"+cmtbyname+"</Text></td></tr> <tr><td><Text>"+obj.Comment+"</Text></td></tr> <tr><td><Text>"+obj.CommentTime+"</Text></table></td></tr> </table></div>";
	      $(str_add_cmt_list).appendTo("#request_comment_table");
			});

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

		// function fn4_doc_update(index, e_fileupdate){
		// 	// console.log(e_fileupdate);
		// 	if (e_fileupdate.length != 0) {
		// 		console.log("update file");
		// 		var formData = new FormData($('#formupload_'+index+'')[0]);
		// 		console.log(formData);  //json formdata
		//  		$.ajax({
		//  			 url: 'request_list_handle/edit_doc.php',
		//  			 type: 'POST',
		//  			 data: formData,
		//  			 async: false,
		//  			 cache: false,
		//  			 contentType: false,
		//  			 enctype: 'multipart/form-data',
		//  			 processData: false,
		//  			 success: function (response) {
		//  			 console.log(response);
		//  			 }
		//  		});
		//  		return false;
		// 	}
		// }

		function showWFworklist(wfrequestid_s_wl, index){
			$.post("request_list_handle/showWFworklist.php", {wfrequestid : wfrequestid_s_wl}, function(res){
				console.log(res);
				json_ret_showWFworklist = JSON.parse(res);
        $("#requestflow_table").empty();
        for (var j = 0; j < json_ret_showWFworklist.length; j++) {
          // fn2_eachstate(json_ret_formstate[j], j);
					showWFworklist_eachstate(json_ret_showWFworklist[j], j);
        }
			});
		}

		function showWFworklist_eachstate(obj, index){
			var str_state = "<tr > <td ><div class='cardbox' style='display:inline-block;color:black;'><Text style='margin-left:10px;'>State :"+obj.StateName+"</Text>";
      if (obj.DoneBy!=0) {
        // str_state= str_state + "<td><Text>DoneBy :"+obj.DoneBy+"</Text></td>"
        str_state= str_state + "<Text style='margin-left:10px;'>Status : </Text> <img src='images/greendot.png' width='20' height='20' style='margin-left:10px;'>"
      }else{
        str_state= str_state + "<Text style='margin-left:10px;'>Status : </Text> <img src='images/reddot.png' width='20' height='20' style='margin-left:10px;'>"
      }
			if (obj.ParentID == 0) {
				str_state= str_state + "<input type='button' value='document' id='doc_wl_select' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'><input type='hidden' value='"+obj.WFRequestDetailID+"' id='doc_wl_select_id' ><input type='hidden' value='"+obj.TemplateFileChose+"' id='tempfilechose_"+index+"'>";
			}
      str_state = str_state + "</div></td></tr>";

      $(str_state).appendTo("#requestflow_table");

			if (obj.ParentID == 0) {

				$("#doc_wl_select").click(function(){
					 let wfrqdetailid = $("#doc_wl_select_id").val();
					 let tempfilechose = $("#tempfilechose_"+index+"").val();
					 $("#relate_doc_table").empty();
					 documentpage(wfrqdetailid, tempfilechose);
				});
			}
		}
		function documentpage(wfrqdetailid, tempfilechose){
			$("#editdoc").show();
			$.post("request_list_handle/showdocpage.php", {data : {wfrqdetailid: wfrqdetailid, tempfilechose: tempfilechose}}, function(res){
				console.log(res);
				let arr_wl = JSON.parse(res);
				let docarrwl = arr_wl[1];
				let wfrqdetailid_wl = arr_wl[0];
				let tempfilechose = arr_wl[2];

				console.log(wfrqdetailid_wl);
				for (var i = 0; i < docarrwl.length; i++) {
					if (docarrwl[i].WFRequestTemplateDocID) {
						e_WFRequestDocID = docarrwl[i].WFRequestTemplateDocID;
					}else {
						e_WFRequestDocID = docarrwl[i].WFRequestDocID;
					}
					let e_formtype = docarrwl[i].WfdocType;
					console.log("e_formtype:");
					console.log(e_formtype);
					console.log("/n");
					let e_WFRequestID = docarrwl[i].WFRequestID;
					let e_DocName = docarrwl[i].DocName;
					console.log(e_WFRequestDocID);
					console.log(e_WFRequestID);
					console.log(e_DocName);
					let e_DocURL = docarrwl[i].DocURL;
					if (e_formtype == 0) {//comment for test kw1
						console.log("case 0");
						str_show_doc_wl = "<tr style='margin-left:10;'><td> <div style='display:grid'><img src='images/Document.ico' height='52' width='52'><Text style='font-size:small;'>"+e_DocName+"</Text></div>  </td> <td><input type='file' name='file_array[]' id='file_update_"+i+"'><input type='hidden' name='WFDocID_arr[]' value='"+e_WFRequestDocID+"' ><input type='hidden' name='userid[]' value='"+userid+"' ><input type='hidden' name='wf_requestid[]' value='"+e_WFRequestID+"' ><input type='hidden' name='stateid_arr[]' value='"+wfrqdetailid_wl+"' ></td> </tr>";
					}else { //e_formtype == 1  kw1form
						console.log("case 1");
						str_show_doc_wl = "<tr style='margin-left:10;'><td><div style='display:grid'><img src='images/Document.ico' height='52' width='52' id='kw1_document_update_"+i+"_"+e_DocURL+"' class='kw1_doc_img'><Text style='font-size:small;'>"+e_DocName+"</Text></div> <input type='hidden' name='WFDocID_arr[]' value='"+e_WFRequestDocID+"' ><input type='hidden' name='wf_requestid[]' value='"+e_WFRequestID+"' ><input type='hidden' name='stateid_arr[]' value='"+wfrqdetailid_wl+"' ></td> </tr>";
					}
					$(str_show_doc_wl).appendTo("#relate_doc_table");
					let index = i;

					if (e_formtype != 0) {//comment for test kw1
						$("#kw1_document_update_"+i+"_"+e_DocURL).click(function(){
							console.log("*************************************************");
							let kw1_id = $(this).attr('id');
							console.log(kw1_id);
							let str_f_split = 'kw1_document_update_'+index+'_';
							console.log(str_f_split);
							kw1_pass_item = kw1_id.split(str_f_split)[1];
							console.log("kw1_pass_item --" + kw1_pass_item);
							setTimeout(function(){
								$('#div_kw2').hide();
								$('#div_kw1').load('../kw1TempServer/Senior%20Project%20KW%20Demo/kwDemo4-fillFile.html');
								$('#div_kw1').show();
							}, 100);

						});
					}


				}
				if (docarrwl[0].WfdocType == 0) {
					str_show_doc_wl2 = "<tr><td><input type='hidden' name='userid' value='"+userid+"' ><input type='button' value='edit' id='editdoc_btn' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
					$(str_show_doc_wl2).appendTo("#relate_doc_table");
					$("#editdoc_btn").click(function(){
						// console.log(index);
						//e_fileupdate = $("#file_update_"+index+"").val();
						let chk=0;
							let fileinarr = new Array();
							$('[name^="file_array[]"]').each(function(){
									if ($(this).val() != "") {
										fileinarr.push($(this).val());
									}else{
										chk=1;
									}
							});
							if (chk==0) {
								console.log("can update");
								documentinsert();
							}
					});
				}else {
					str_show_doc_wl2 = "<tr><td><input type='hidden' name='userid' value='"+userid+"' ><input type='button' value='edit' id='editdoc_btn_kw1' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
					$(str_show_doc_wl2).appendTo("#relate_doc_table");
					$("#editdoc_btn_kw1").click(function(){

						// kw1_WFDocID_arr = new Array();
						// $('[name^="WFDocID_arr[]"]').each(function(){
						// 	if ($(this).val() != "") {
						// 			kw1_WFDocID_arr.push($(this).val());
						// 		}
						// });

						kw1_wf_requestid = new Array();
						$('[name^="wf_requestid[]"]').each(function(){
							if ($(this).val() != "") {
			 					kw1_wf_requestid.push($(this).val());
			 				}
						});

						kw1_stateid_arr = new Array();
						$('[name^="stateid_arr[]"]').each(function(){
							if ($(this).val() != "") {
			 					kw1_stateid_arr .push($(this).val());
			 				}
						});

						$.post("request_list_handle/kw1_insert_doc.php", {data:{wf_requestid: kw1_wf_requestid, stateid_arr: kw1_stateid_arr, userid: userid}}, function(res){
							console.log(res);
							alert("Upload successfully!");
							window.location = '02_request_list.php';
						});
					});
				}



			});
		}

		function documentpage_Request(wfrqdetailid, tempfilechose){
			$("#editdoc").show();
			$.post("request_list_handle/showdocpage.php", {data : {wfrqdetailid: wfrqdetailid, tempfilechose: tempfilechose}}, function(res){
				console.log(res);
				let arr_wl = JSON.parse(res);
				let docarrwl = arr_wl[1];
				let wfrqdetailid_wl = arr_wl[0];
				let tempfilechose = arr_wl[2];
				console.log(wfrqdetailid_wl);
				for (var i = 0; i < docarrwl.length; i++) {
					if (docarrwl[i].WFRequestTemplateDocID) {
						e_WFRequestDocID = docarrwl[i].WFRequestTemplateDocID;
					}else {
						e_WFRequestDocID = docarrwl[i].WFRequestDocID;
					}
					let e_formtype = docarrwl[i].WfdocType;

					let e_WFRequestID = docarrwl[i].WFRequestID;
					let e_DocName = docarrwl[i].DocName;
					console.log(e_WFRequestDocID);
					console.log(e_WFRequestID);
					console.log(e_DocName);
					let e_DocURL = docarrwl[i].DocURL;
					if (e_formtype == 0) {
						str_show_doc_wl = "<tr style='margin-left:10;'><td> <div style='display:grid'><img src='images/Document.ico' height='52' width='52'><Text style='font-size:small;'>"+e_DocName+"</Text></div>  </td> <td><input type='file' name='file_array[]' id='file_update_"+i+"' class='file_array_request'><input type='hidden' name='WFDocID_arr[]' value='"+e_WFRequestDocID+"' ><input type='hidden' name='userid[]' value='"+userid+"' ><input type='hidden' name='wf_requestid[]' value='"+e_WFRequestID+"' ><input type='hidden' name='stateid_arr[]' value='"+wfrqdetailid_wl+"' ></td> </tr>";
					}else { //e_formtype == 1  kw1form
						str_show_doc_wl = "<tr style='margin-left:10;'><td><div style='display:grid'><img src='images/Document.ico' height='52' width='52' id='r_kw1_document_update_"+i+"_"+e_DocURL+"'><Text style='font-size:small;'>"+e_DocName+"</Text></div> <input type='hidden' name='WFDocID_arr[]' value='"+e_WFRequestDocID+"' ><input type='hidden' name='wf_requestid[]' value='"+e_WFRequestID+"' ><input type='hidden' name='stateid_arr[]' value='"+wfrqdetailid_wl+"' ></td> </tr>";
					}


					$(str_show_doc_wl).appendTo("#relate_doc_table");
					let index = i;

					if (e_formtype != 0) {//comment for test kw1
						$("#r_kw1_document_update_"+i+"_"+e_DocURL).click(function(){
							console.log("*************************************************");
							let kw1_id = $(this).attr('id');
							console.log(kw1_id);
							let str_f_split = 'r_kw1_document_update_'+index+'_';
							console.log(str_f_split);
							kw1_pass_item = kw1_id.split(str_f_split)[1];
							console.log("kw1_pass_item --" + kw1_pass_item);
							setTimeout(function(){
								$('#div_kw2').hide();
								$('#div_kw1').load('../kw1TempServer/Senior%20Project%20KW%20Demo/kwDemo4-fillFile.html');
								$('#div_kw1').show();
							}, 100);

						});
					}

				}
				if (docarrwl[0].WfdocType == 0) {
					str_show_doc_wl2 = "<tr><td><input type='hidden' name='userid' value='"+userid+"' ><input type='button' value='edit' id='editdoc_btn' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
					$(str_show_doc_wl2).appendTo("#relate_doc_table");
					$("#editdoc_btn").click(function(){
						// console.log(index);
						//e_fileupdate = $("#file_update_"+index+"").val();
						let chk=0;
							let fileinarr = new Array();
							$('[name^="file_array[]"]').each(function(){
									if ($(this).val() != "") {
										fileinarr.push($(this).val());
									}else{
										chk=1;
									}
							});
							if (chk==0) {
								console.log("can update");
								documentinsert_Request();
							}
					});
				}else {
					str_show_doc_wl2 = "<tr><td><input type='hidden' name='userid' value='"+userid+"' ><input type='button' value='edit' id='editdoc_btn_kw1' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
					$(str_show_doc_wl2).appendTo("#relate_doc_table");
					$("#editdoc_btn_kw1").click(function(){

						kw1_wf_requestid = new Array();
						$('[name^="wf_requestid[]"]').each(function(){
							if ($(this).val() != "") {
			 					kw1_wf_requestid.push($(this).val());
			 				}
						});

						kw1_stateid_arr = new Array();
						$('[name^="stateid_arr[]"]').each(function(){
							if ($(this).val() != "") {
			 					kw1_stateid_arr .push($(this).val());
			 				}
						});

						$.post("request_list_handle/kw1_insert_doc_Request.php", {data:{wf_requestid: kw1_wf_requestid, stateid_arr: kw1_stateid_arr, userid: userid}}, function(res){
							console.log(res);
							alert("Upload successfully!");
							window.location = '02_request_list.php';
						});
					});
				}


				// str_show_doc_wl2 = "<tr><td><input type='hidden' name='userid' value='"+userid+"' ><input type='button' value='edit' id='editdoc_btn' style='background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;'></td></tr>";
				// $(str_show_doc_wl2).appendTo("#relate_doc_table");
				// $("#editdoc_btn").click(function(){
				// 	// console.log(index);
				// 	//e_fileupdate = $("#file_update_"+index+"").val();
				// 	let chk=0;
				// 	if (docarrwl[0].WfdocType == 0) {
				// 		let fileinarr = new Array();
				// 		// $('[name^="file_array[]"]').each(function(){
				// 		// 		if ($(this).val() != "") {
				// 		// 			fileinarr.push($(this).val());
				// 		// 		}else{
				// 		// 			chk=1;
				// 		// 		}
				// 		// });
				// 		$('.file_array_request').each(function(){
				// 				if ($(this).val() != "") {
				// 					fileinarr.push($(this).val());
				// 				}else{
				// 					chk=1;
				// 				}
				// 		});
				//
				// 		if (chk==0) {
				// 			console.log("can update");
				// 			documentinsert_Request();
				// 		}
				//
				// 	}
				//
				// });

			});
		}

		function documentinsert(){

				var formData = new FormData($('#editdoc_form')[0]);
				console.log(formData);  //json formdata
				$.ajax({
					 url: 'request_list_handle/insert_doc.php',
					 type: 'POST',
					 data: formData,
					 async: false,
					 cache: false,
					 contentType: false,
					 enctype: 'multipart/form-data',
					 processData: false,
					 success: function (response) {
					 console.log(response);
					 alert('Upload successfully!');
					 window.location = '02_request_list.php';
					 }
				});
				return false;

		}

		function documentinsert_Request(){

				var formData = new FormData($('#editdoc_form')[0]);
				console.log(formData);  //json formdata
				$.ajax({
					 url: 'request_list_handle/insert_doc_Request.php',
					 type: 'POST',
					 data: formData,
					 async: false,
					 cache: false,
					 contentType: false,
					 enctype: 'multipart/form-data',
					 processData: false,
					 success: function (response) {
					 console.log(response);
					 alert('Upload successfully!');
					 window.location = '02_request_list.php';
					 }
				});
				return false;

		}


	</script>
</head>
<body>

<div id="wrapper">
	<div id="div_kw1" style='z-index:10;'></div>
	<div id="div_kw2">
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
			<div class="makeinline">
				<input type="button" value="Request" id="Request_tab_Request" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;">
				<input type="button" value="worklist" id="Request_tab_worklist" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;">
				<input type="button" value="Complete" id="Request_tab_Complete" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;">
			</div>
			<div id="Requestworklist">
        <h2>Current work list</h2>
        <table id="requestworklist_table" style="margin-left:5%;font-size:small;"></table>
			</div>

			<div id="Requestlist">
        <h2>Current Request list</h2>
        <table id="requestlist_table" style="margin-left:5%;font-size:small;"></table>
			</div>

			<div id="Requestcompletelist">
        <h2>Complete Request list</h2>
        <table id="requestcompletelist_table" style="margin-left:5%;font-size:small;"></table>
			</div>

      <div id="requestflow">
        <h2>Workflow</h2>
				<div id="moveto_edit_doc_box" class="right"><input type="button" value="Edit" id="moveto_edit_doc_btn" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;"></div>
        <table id="requestflow_table" style="margin-left:5%;font-size:small;"></table>
			</div>

			<div id="editdoc">
        <h2>Relate documents</h2>
				<form id='editdoc_form'>
        <table id="relate_doc_table" style="margin-left:5%;font-size:small;"></table>
				</form>
			</div>

      <div id="comment">
        <h2>Comment</h2>
        <div id="request_comment_table"></div>
        <table id="commentbox" style="margin-left:5%;background-color:#8282fe;border-radius:3px;border:1px solid transparent;width:450px;height:18px;color:white;font-size:small;">
          <tr><td style="width:100px"><Text>Comment box: </Text></td> <td><input type="text" id="current_comment" style="width: 220px;"></td> <td><input type="button" id="current_comment_btn" value="comment" style="background-color:#3c8dbc;border-color:#367fa9;border-radius:3px;border:1px solid transparent;width:100px;height:30px;touch-action:manipulation;color:white;cursor: pointer;"></td></tr>
        </table>
			</div>

		</div>
	</div>

	<div id="div_footer">
	</div>
</div>
</div>


</body>
</html>
