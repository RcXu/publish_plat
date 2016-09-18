<?php
session_start();
require_once 'function.inc.php';
$hasLogin = checkLogin();
$webroot = getWebtoot();
if (!$hasLogin) {
	echo '<script language="javascript">alert("还没有登陆，请先去登陆！");window.location.href=\'' . $webroot . '/login.php\';</script>';
	exit;
}
require_once 'sso.inc.php';
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
 <form method="post" action="authUpdate.php" >
    <div id="right_wrap">
    <div id="right_content">  
    
    <ul id="tabsmenu" class="tabsmenu">
        <li class="active"><a href="#tab1">修改权限</a></li>
    </ul>
    <div id="tab1" class="tabcontent">
        <h3>添加新项目权限:</h3>
        <div class="form">
            <div class="form_row">
            <input type="button" class="form_submit" value="添加新项目权限" id="add_project_auth"/>
            </div>
            <div class="form_row" id="add_project_auth_project">
			</div>
			<div class="tabcontent" id="add_project_auth_list_div" style="display:none;">
				<ul id="add_project_auth_list" >
				</ul>
			</div>
            <div class="clear"></div>
        </div>
        <br />
        <div class="form">
            <div id="tab2" class="tabcontent">
                <?php 
                foreach((array)$cdkey as $key => $authlist){
                ?>
                <h3><?php echo $key;?>&nbsp;&nbsp;<label name='addauth' data-id='<?php echo $key;?>'>添加权限</label></h3>
                <ul class="lists" id='<?php echo $key;?>_poss'>
                <?php foreach ((array)$authlist as $ak => $auth) {?>
                <li><input type="checkbox" name="auth[<?php echo  $key;?>][]" value="<?php echo $auth;?>" checked="true"/><?php echo $auth;?></li>
                <?php 
                    }
                ?>
                </ul>
                <?php } ?>
            </div>
            <div class="form_row">
            <input type="submit" class="form_submit" value="Submit"/>
            </div> 
            <div class="clear"></div>
	    </div>
	    </div>
	</div>
</form>  
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
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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