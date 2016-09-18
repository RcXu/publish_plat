<?php
session_start();
require_once 'function.inc.php';
require_once 'sso.inc.php';
$hasLogin = checkLogin();
$webroot = getWebtoot();
if (!$hasLogin) {
	echo '<script language="javascript">alert("还没有登陆，请先去登陆！");window.location.href=\'' . $webroot . '/login.php\';</script>';
    exit;
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
<script src="js/login.js?<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
var webroot = <?php echo '\'' .$webroot . '\'';?>;
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
        <li class="active"><a href="#tab1">添加新项目</a></li>
    </ul>
    <div id="tab1" class="tabcontent">
        <h3>项目信息</h3>
        <div class="form">
            
            <div class="form_row">
            <label>项目名称:</label>
            <input type="text" class="form_input" id="project" name="project" value="全英文，不要出现中文以及空格和特殊符号"/>
            </div>
             
            <div class="form_row">
            <label>项目路径:</label>
            <input type="text" class="form_input" id="projectPath" name="projectPath" value="发布代码的绝对路径"/>
            </div>

            <div class="form_row">
            <label>项目SVN路径:</label>
            <input type="text" class="form_input" id="projectSvnPath" name="projectSvnPath" value="SVN路径"/>
            </div>
            
            <div class="form_row">
            <label>MOD:</label>
            <input type="text" class="form_input" id="mod" name="mod" value="发布代码mod" />
            </div>

            <div class="form_row">
            <label>服务器IP列表:</label>
            <input type="text" class="form_input" id="IpList" name="IpList" value="纯字符串添加，多ip以,分隔" />
            </div>
            <div class="form_row">
            <input type="submit" class="form_submit" value="Submit" id="addprojectsubmit"/>
            </div> 
            <div class="clear"></div>
        </div>
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