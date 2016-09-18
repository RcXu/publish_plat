<?php
session_start();
require_once '../../function.inc.php';
$hasLogin = checkLogin();
$webroot = getWebtoot();
if (!$hasLogin) {
	echo '<script language="javascript">alert("还没有登陆，请先去登陆！");window.location.href=\'' . $webroot . '/login.php\';</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代码发布平台</title>
<link rel="stylesheet" type="text/css" href="<?php echo $webroot;?>/css/style.css" />
<!-- jQuery file -->
<script src="<?php echo $webroot;?>/js/jquery.min.js"></script>
<script src="<?php echo $webroot;?>/js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $webroot;?>/js/login.js?<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
var $ = jQuery.noConflict();
$(function() {
$('#tabsmenu').tabify();
$(".toggle_container").hide(); 
$(".trigger").click(function(){
	$(this).toggleClass("active").next().slideToggle("slow");
	return false;
});
});
</script>
</head>
<body>
<div id="panelwrap">
  	
	<div class="header">
    <div class="title"><a href="#">代码发布平台</a></div>
    
    <div class="header_right">Welcome <?php echo $_SESSION['username'];?>, <a href="#" class="settings">Settings</a> <a href="#" class="logout">Logout</a> </div>
    
    <div class="menu">
    <ul>
    <?php require_once '../../topBar.php';?>
    </ul>
    </div>
    
    </div>
    
    <div class="submenu">
    <ul>
    <li><a href="#" class="selected">project</a></li>
    </ul>
    </div>          
                    
    <div class="center_content">  
 
    <div id="right_wrap">
    <div id="right_content">  
    
    <ul id="tabsmenu" class="tabsmenu">
        <li class="active"><a href="#tab1">代码发布平台</a></li>
    </ul>
    <div class="tabcontent" style="display:block;" id="projectSvnUpdateForm">
        <h3>发布版本</h3>
        <div class="form">
            <div class="form_row">
            <label>上线版本号:</label>
            <input type="text" class="form_input" id="projectSvnVersion" name="projectSvnVersion" value="" />
            </div>

            <div class="form_row">
            <input type="submit" class="form_submit" value="发布" id="svnUpdate" name="svnUpdate"/>
            </div> 
            <div class="clear"></div>

        </div>
    </div>

    <div id="svnUplogPoss" class="tabcontent" style="display:none;">
        
    </div>
    <div id="svnSubmitForm" class="tabcontent" style="display:none;">
        <h3>请确认log信息：</h3>
        <div class="form">
            <div class="form_row">
                <label id="submitVersionInfo">上线版本:</label>
                <input type="hidden" class="form_input" id="publishSvnVersion" name="svnVersion" />
            </div>
            <div class="form_row">
                <input type="submit" id="svnSubmitFormSubmit" class="form_submit" value="确定发布以上代码" />
            </div> 
        <div class="clear"></div>
        </div>
    </div>
      
     </div>
     </div><!-- end of right content-->
                     
                    
    <div class="sidebar" id="sidebar">
    <h2>项目列表</h2>
    
        <ul>
            <li ><a href="index.php">项目首页</a></li>
            <li ><a href="pushOnline.php">发布上线</a></li>
            <li ><a href="pushOnlineLog.php">发布日志</a></li>
            <li ><a href="modifyConfig.php">修改配置</a></li>
        </ul>        
    
    </div>             
    
    
    <div class="clear"></div>
    </div> <!--end of center_content-->
    
    <div class="footer">
Panelo - Free Admin Collect from <a href="http://www.mycodes.net/" title="网站模板" target="_blank">网站模板</a>
</div>

</div>

    	
</body>
</html>