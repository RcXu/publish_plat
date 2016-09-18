<?php
session_start();
require_once '../../function.inc.php';
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
    <?php
    $workSpaceDir = explode('/', dirname(__FILE__));
    $projectNmae = array_pop($workSpaceDir);
    ?>
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
        <li class="active"><a href="#tab1">修改配置</a></li>
    </ul>
<?php 
if (!empty($_POST)) {
	$projectPath = $_POST['projectPath'];
	$IpList = $_POST['IpList'];
	$projectSvnPath = $_POST['projectSvnPath'];
	$mod = $_POST['mod'];
	//写项目目录的配置文件
	$projectConfig = '<?php
$projectPath = \'' . trim($projectPath) . '\';
$ipList = \'' . trim($IpList) . '\';
$projectSvnPath = \'' . trim($projectSvnPath) . '\';
$mod = \'' . trim($mod) . '\';';
	file_put_contents('config.inc.php', $projectConfig);
}
require_once 'config.inc.php';
?>
    <div id="tab1" class="tabcontent">
        <h3>配置信息</h3>
        <form action="#" method="post">
        <div class="form">
             
            <div class="form_row">
            <label>项目路径:</label>
            <input type="text" class="form_input" id="projectPath" name="projectPath" value="<?php echo $projectPath;?>"/>
            </div>

            <div class="form_row">
            <label>项目SVN路径:</label>
            <input type="text" class="form_input" id="projectSvnPath" name="projectSvnPath" value="<?php echo $projectSvnPath;?>"/>
            </div>
            
            <div class="form_row">
            <label>MOD:</label>
            <input type="text" class="form_input" id="mod" name="mod" value="<?php echo $mod;?>" />
            </div>

            <div class="form_row">
            <label>服务器IP列表:</label>
            <input type="text" class="form_input" id="IpList" name="IpList" value="<?php echo $ipList;?>" />
            </div>
            <div class="form_row">
            <input type="submit" class="form_submit" value="确认修改"/>
            </div> 
            <div class="clear"></div>
        </div>
    	</form>
    </div>

    </div>
    </div><!-- end of right content-->
                     
                    
    <div class="sidebar" id="sidebar">
    <h2>项目列表</h2>
    
        <ul>
            <li ><a href="<?php echo $webroot . '/project/' . $projectNmae;?>/">返回</a></li>
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