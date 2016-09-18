<?php 
require_once 'sso.inc.php';
if (!empty($_POST))
{
	$projectName = $_POST['project'];
	$projectPath = $_POST['projectPath'];
	$IpList = $_POST['IpList'];
	$projectSvnPath = $_POST['projectSvnPath'];
	$mod = $_POST['mod'];
	if (empty($projectName) || empty($projectPath) || empty($projectSvnPath) || empty($mod)) {
		echo json_encode(array('flag' => false,'msg' => "请正确输入项目信息"));
		exit;
	}
	//发布脚本所在路径
	$projectUrl = 'project/' . trim($projectName);
	if (is_dir($projectUrl)) 
	{
		echo json_encode(array('flag' => false,'msg' => "该项目已经存在"));
		exit;
	} else {
		@mkdir($projectUrl);
		chmod($projectUrl, 0755);
		//写项目目录的配置文件
		$projectConfig = '<?php 
$projectPath = \'' . trim($projectPath) . '\';
$ipList = \'' . trim($IpList) . '\';
$projectSvnPath = \'' . trim($projectSvnPath) . '\';
$mod = \'' . trim($mod) . '\';';
		file_put_contents($projectUrl . '/config.inc.php', $projectConfig);
		//写项目发布展示界面
		$indexContent = file_get_contents('filePlatment/index.php');
		file_put_contents($projectUrl . '/index.php', $indexContent);
		//写发布脚本
		$publish = file_get_contents('filePlatment/publish.php');
		file_put_contents($projectUrl . '/publish.php', $publish);
		//生效脚本
		$pushOnline = file_get_contents('filePlatment/pushOnline.php');
		file_put_contents($projectUrl . '/pushOnline.php', $pushOnline);
		$pushOnlineAction = file_get_contents('filePlatment/pushOnlineAction.php');
		file_put_contents($projectUrl . '/pushOnlineAction.php', $pushOnlineAction);
		//svn更新脚本
		$svnUpdate = file_get_contents('filePlatment/svnUpdate.php');
		file_put_contents($projectUrl . '/svnUpdate.php', $svnUpdate);
		//上线日志
		$pushOnlineLog = file_get_contents('filePlatment/pushOnlineLog.php');
		file_put_contents($projectUrl . '/pushOnlineLog.php', $pushOnlineLog);
		//文件生效版本控制
		$versionConfig = file_get_contents('filePlatment/version.config.inc.php');
		file_put_contents($projectUrl . '/version.config.inc.php', $versionConfig);
		$modifyConfig = file_get_contents('filePlatment/modifyConfig.php');
		file_put_contents($projectUrl . '/modifyConfig.php', $modifyConfig);
		//echo '<script language="javascript">alert("项目添加成功");window.location.href=\'' . $webroot . '/project/' . trim($projectName) .  '/\';</script>';
		echo json_encode(array('flag' => true,'url' => $webroot . '/project/' . trim($projectName) . '/'));
		exit;
	}
}