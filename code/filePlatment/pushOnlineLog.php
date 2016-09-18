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
    require_once 'config.inc.php';
    //读取远端服务器代码目录
    $serviceIpList = explode(',', $ipList);
    $shell = '/usr/bin/rsync -vzrtopg --progress rsync://' . $serviceIpList[0] . '/' . $mod . '/';
    $fileList = shell_exec($shell);
    $fileList = explode("\n", $fileList);
    foreach ((array)$fileList as $key => $file) {
        if (empty($file))
        {
            continue;
        }
        if ($file[0] != "d")
        {
            unset($fileList[$key]);
            continue;
        }
        $dir = explode(" ", $file);
        $projectVersion = array_pop($dir);
        if (strpos($projectVersion, '/') > 0)
        {
            unset($fileList[$key]);
            continue;
        }
        ($projectVersion != '.' && $projectVersion != '..') && $projectVersionList[] = $projectVersion;
    }
    if (empty($projectVersionList))
    {
        echo '<script language="javascript">alert("你还没有推送过代码哦~");window.location.href=\'' . $webroot . '/project/' . trim($projectNmae) .'/\';</script>';
        exit;
    }
    is_file($projectPath . '/version.info.inc.php') && require_once $projectPath . '/version.info.inc.php';
    !isset($versionSub) && $versionSub = 0;
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
    <h2>代码发布LOG</h2> 
    <div id="tab2" class="tabcontent">
        <h3>LOG信息</h3>
        <ul class="lists">
<?php 
$file = 'publishLog';
if (!is_file($file))
{
	echo "<li>还从未上过线</li>";
} else {
	$handle = fopen($file, 'r');
	while(!feof($handle))
	{
		$line = fgets($handle);
		if (empty($line))
		{
			continue;
		}
		list($project, $ip, $author, $date) = explode('|', trim($line));
		echo "<li>" . $project . "&nbsp;&nbsp;" . $ip . "&nbsp;&nbsp;" . $author . "&nbsp;&nbsp;" . $date . "</li>";
		
	}
	fclose($handle);
}
?>
        </ul>
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