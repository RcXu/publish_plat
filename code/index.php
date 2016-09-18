<?php
session_start();
require_once 'function.inc.php';
$hasLogin = checkLogin();
$webroot = getWebtoot();
if (!$hasLogin) {
	echo '<script language="javascript">window.location.href=\'' . $webroot . '/login.php\';</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代码发布平台</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!-- jQuery file -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
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
    <?php require_once 'topBar.php';?>
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
    <div id="tab1" class="tabcontent">
        <h3><?php echo $_SESSION['username'];?></h3>
        <ul class="lists">
        <li>欢迎使用代码发布平台</li>
        </ul>
    </div>
      
     </div>
     </div><!-- end of right content-->
                     
                    
    <div class="sidebar" id="sidebar">
    <h2>项目列表</h2>
    
        <ul>
            <?php require_once 'leftBar.php';?>
        </ul>
    <?php if (isset($_SESSION['username']) && checkSuper($_SESSION['username'], $cdkey)) {?>   
    <h2>权限管理</h2>
    
        <ul>
            <li><a href="auth.php">权限管理</a></li>
        </ul> 
    <?php }?> 
         
    <h2>使用规则</h2> 
    <div class="sidebar_section_text">
        1）、项目目录要求：项目目录owner需要改为www，以保证脚本文件有读写权限。2）、index文件修改，在index文件中，系统常量定义之前添加版本信息。3）、修改config文件：
         config文件中定义controller和model文件的位置，需要配置为绝对路径。4）、系统中涉及到加载类方法的地方需要使用绝对路径。
    </div>         
    
    </div>             
    
    
    <div class="clear"></div>
    </div> <!--end of center_content-->
    
    <div class="footer">
Panelo - Free Admin Collect from <a href="http://www.mycodes.net/" title="网站模板" target="_blank">网站模板</a>
</div>

</div>

    	
</body>
</html>