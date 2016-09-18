var $ = jQuery.noConflict();
$(function() {
	$("#login_submit").click(function(){
		var username = $("#username").val();
		var password = $("#password").val();
		if (username && password) {
			$.post(
				'loginsubmit.php',
				{'username':username,'password':password},
				function(data){
					if (data.flag) {
						window.location.href = webroot + '/index.php';
					} else {
						alert("用户名或者密码错误");
					}
				},
				'json'
				);
		} else {
			alert('请正确输入用户名和密码');
		}
	});

	$("#addprojectsubmit").click(function(){
		var project = $("#project").val();
		var projectPath = $("#projectPath").val();
		var mod = $("#mod").val();
		var IpList = $("#IpList").val();
		var projectSvnPath = $("#projectSvnPath").val();
		if (project && projectPath && mod && IpList && projectSvnPath) {
			$.post(
				'addProjectAction.php',
				{'project':project,'projectPath':projectPath,'mod':mod,'IpList':IpList,'projectSvnPath':projectSvnPath},
				function(data){
					if (data.flag) {
						window.location.href = data.url;
					} else {
						alert(data.msg);
					}
				},
				'json'
				);
		} else {
			alert('请正确填写项目信息');
		}
	});

	$("#svnUpdate").click(function(){
		 var projectSvnVersion = $("#projectSvnVersion").val();
		 $.post("svnUpdate.php", {"projectSvnVersion":projectSvnVersion}, function(data){
			 if (data.flag)
		     {
			     if (data.logs && data.logs.length > 0) 
				 {
				 	$("#projectSvnUpdateForm").hide();
					var logInfo = '<h3>svn更新完成，LOG信息：</h3><ul class="lists">';
				     $.each(data.logs, function(key, log){
				    	 logInfo += '<li>' + (key + 1) + '、版本号:'+ log.rev +'</li>';
				    	 logInfo += '<li>author:'+ log.author +'</li><li>msg:'+ log.msg +'</li><li>date:'+ log.date +'</li>';
				    	 logInfo += '<li>修改文件：</li>';
					     $.each(log.paths, function(key, path){
						     switch(path.action){
						     case 'M':
							     var action = 'Modified';
							     break;
						     case 'A':
							     var action = 'Added';
							     break;
						     case 'D':
							     var action = 'Deleted';
							     break;
							 default:
								 var action = path.action;
							     break;
						     }
					    	 logInfo += '<li>' + (key + 1) + ' ）、' + action +'：'+ path.path +'</li>';
						 });
						 logInfo += "</ul>";
						 $("#svnUplogPoss").html(logInfo);
					     $("#publishSvnVersion").val(data.info);
					     $("#submitVersionInfo").html('上线版本:' + data.info);
					     $("#svnUplogPoss").show();
					     $("#svnSubmitForm").show();
					  });
			     } else {
			     	$("#projectSvnUpdateForm").hide();
			     	var logInfo = '<h3>svn更新完成，LOG信息：</h3><ul class="lists">';
			     	logInfo += '<li>此版本没有修改的文件！请确认版本信息</li>';
			     	logInfo += "</ul>";
			     	$("#svnUplogPoss").html(logInfo);
			     	$("#svnUplogPoss").show();
			     }
			 }else{
			 	$("#projectSvnUpdateForm").hide();
				 $("#svnUplogPoss").html('<h3>' + data.info + '<h3>');
				 $("#svnUplogPoss").show();
			 }
			 
			 }, 'json');
	 });
	
	$("#svnSubmitFormSubmit").click(function(){
		$("#svnUplogPoss").html('<ul class="lists"><li>由于我不会写js，不会写loading，所以请你耐心等待！不要重复点击！</li></ul>');
		$("#svnSubmitFormSubmit").attr('disabled',true); 
		var svnVersion = $("#publishSvnVersion").val();
		$.post('publish.php',
			{'svnVersion':svnVersion},
			function(data){
				if (data.flag) {
					$("#projectSvnUpdateForm").hide();
					$("#svnSubmitForm").hide();
					$("#svnUplogPoss").html('<ul class="lists">' + data.publishlog + '</ul>');
					if (!data.publisherror) {
						$("#svnUplogPoss").append('<div class="form"><div class="form_row"><a href="pushOnline.php">去发布生效</a></div></div><div class="clear"></div>');
					}
				} else {
					alert(data.msg);
				}
			},
			'json'
			);
	});

	$("#publishEnsureBtn").click(function(){
		$("#publishEnsureBtn").attr('disabled', true);
		var projectOnline = $('input[name="projectOnline"]:checked').val();
		var pushOnlineSummary = $("#pushOnlineSummary").val();
		$.post(
			'pushOnlineAction.php',
			{'projectOnline':projectOnline,'pushOnlineSummary':pushOnlineSummary},
			function(data){
				alert(data.log);
				if (data.flag) {
					if (!data.pushError) {
						window.location.href = data.url;
					} else {
						$("#publishEnsureBtn").attr('disabled', false);
					}
				}
			},
			'json'
			);		


	});

	$("#add_project_auth").click(function(){
		$("#add_project_auth_project").html('<label>项目名称:</label><input type="text" class="form_input" name="add_project_auth_input" value="" id="add_project_input" /><label id="add_new_project_auth">添加权限</label>');
		$("#add_project_input").bind('change',function(){
			$("#add_project_auth_list").html('');
			var project = $(this).val();
			$("#add_project_auth_list_div").show();
			$("#add_project_auth_list").append('<li><input type="checkbox" name="auth[' + project + '][]" value="" checked="true" />&nbsp;&nbsp;<input type="text" name="auth_input" value=""/></li>');
			$("input[name='auth_input']").bind('keyup' , function(){
				var input = $(this).val();
				$(this).prev().val(input);
			});
			$("input[name='auth_input']").bind('change' , function(){
				var input = $(this).val();
				$(this).prev().val(input);
			});
			$("#add_new_project_auth").bind('click',function(){
				$("#add_project_auth_list").append('<li><input type="checkbox" name="auth[' + project + '][]" value="" checked="true" />&nbsp;&nbsp;<input type="text" name="auth_input" value=""/></li>');
				$("input[name='auth_input']").bind('keyup' , function(){
					var input = $(this).val();
					$(this).prev().val(input);
				});
				$("input[name='auth_input']").bind('change' , function(){
					var input = $(this).val();
					$(this).prev().val(input);
				});
			});
		});
		
		
	});

	$("label[name='addauth']").click(function(){
		var authname = $(this).attr('data-id');
		$("#" + authname + '_poss').append('<li><input type="checkbox" name="auth[' + authname + '][]" value="" checked="true"/>&nbsp;&nbsp;<input type="text" name="auth_input" value=""/></li>');
		$("input[name='auth_input']").bind('keyup' , function(){
			var input = $(this).val();
			$(this).prev().val(input);
		});
		$("input[name='auth_input']").bind('change' , function(){
			var input = $(this).val();
			$(this).prev().val(input);
		});
	});
	
});
