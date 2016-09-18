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
    <?php
    if (!empty($versionSub)) 
    {
        $key = array_search($versionSub, (array)$projectVersionList);
        unset($projectVersionList[$key]);
    ?>
    <h2>线上工作版本</h2> 
    <table id="rounded-corner">
    <tfoot>
        <tr>
            <td colspan="12">请选择需要发布的版本号，推送版本</td>
        </tr>
    </tfoot>
    <tbody>
        <tr class="odd">
            <td><input type="radio" name="projectOnline" checked="true" value="<?php echo $versionSub;?>"/></td>
            <td><?php echo $versionSub; ?></td>
        </tr>
        
        </tbody>
    </table>
    <?php 
    }
    ?>
    <br />
    <h2>已发布版本</h2>
    <table id="rounded-corner">
    <tfoot>
        <tr>
            <td colspan="12">请选择需要发布的版本号，推送版本</td>
        </tr>
    </tfoot>
    <tbody>
        <?php 
        foreach ((array)$projectVersionList as $key => $line) {
            if (empty($line)) continue;
        ?>
        <tr class="odd">
            <td><input type="radio" name="projectOnline" value="<?php echo trim($line);?>"/></td>
            <td><?php echo trim($line); ?></td>
        </tr>
        <?php 
        }
        ?>
    </tbody>
    </table>
    <br />
    <div id="svnSubmitForm" class="tabcontent">
        <h3>请确认信息：</h3>
        <div class="form">
            <div class="form_row">
            <label>上线说明:</label>
            <input type="text" class="form_input" id="pushOnlineSummary" name="pushOnlineSummary" value="<?php if (isset($_SESSION['longmsg'])) echo $_SESSION['longmsg'];?>"/>
            </div>
            <div class="form_row">
                <input type="submit" id="publishEnsureBtn" class="form_submit" value="确定发布以上版本" />
            </div> 
             <div class="clear"></div>
        </div>
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