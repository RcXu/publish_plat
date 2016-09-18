<?php
require_once dirname(dirname(dirname(__FILE__))) . '/sso.inc.php';
require_once dirname(dirname(dirname(__FILE__))) . '/function.inc.php';
require_once 'config.inc.php';
$workSpaceDir = explode('/', dirname(__FILE__));
$projectNmae = array_pop($workSpaceDir);
if(isset($_POST))
{
	$projectOnline = trim($_POST['projectOnline']);
	$pushOnlineSummary = trim($_POST['pushOnlineSummary']);
	$svnVersion = $projectOnline;
	$fileContent = '<?php
$versionSub = ' . trim($svnVersion) . '; //线上运行副本子版本号
$workspace = 0;
$extra = array(
	//不同大版本代码库出现比例
	\'spaceRate\' => array(
		
	),
);//额外配置需求
//大版本，子版本号列表
$versionConfigList = array(
		);';
	file_put_contents($projectPath . '/version.info.inc.php' , $fileContent);
	//严重版本配置文件是否存在
	if ( !is_file($projectPath . '/version.config.inc.php'))
	{
		$versionConfig = file_get_contents('version.config.inc.php');
		file_put_contents($projectPath . '/version.config.inc.php', $versionConfig);
	}
	//生效代码
	$serviceIpList = explode(',', $ipList);
	$pushLog = '';
	$pushError = false;
	foreach ((array)$serviceIpList as $key => $ip) {
		if (empty($ip))
		{
			continue;
		}
		$fileList = array(
			'version.info.inc.php',
			'version.config.inc.php',
			'index.php',
			'shell.php',
			'robots.txt',
		);
		$expend = '';
		foreach ($fileList as $key => $file) {
			$expend .= $projectPath . '/' . $file . ' ';
		}

		$shell = '/usr/bin/rsync -vzrtopg --progress --delete-after ' . $expend . ' --exclude=".svn" rsync://' . $ip . '/' . $mod . '/';
		//$shell = '/usr/bin/rsync -vzrtopg --progress --delete-after ' . $projectPath . '/version.info.inc.php ' . $projectPath . '/version.config.inc.php ' . $projectPath . '/index.php ' . $projectPath . '/shell.php ' . $projectPath . '/robots.txt --exclude=".svn" rsync://' . $ip . '/' . $mod . '/';
		//passthru($shell);
		$rs = shell_exec($shell);
		if (empty($rs))
		{
			$pushLog .= '<li>' . ($key + 1) . ":" . $ip . "……发布失败!!!</li>";
			$pushError = true;
		} else {
			$pushLog .= '<li>' . ($key + 1) . ":" . $ip . "……发布成功</li>";
		}
	}
	
	//发布代码成功发送邮件
	$text = !empty($pushOnlineSummary) ? trim($pushOnlineSummary) : "我很懒，什么都没写哦~";
	$emailContent ="<h3>1.上线描述：</h3>上线通知：" . $text . "<h3>2.紧急程度：<h3>低<h3>3.项目负责人：<h3>李刚<h3>4.上线负责人：<h3>" . $_SESSION['username'] . "<h3>5.是否经过测试机和仿真机测试：</h3>是<h3>6.上线版本:</h3>" . $projectSvnPath . "</br>版本号: " . $svnVersion;
	$rs = sendMail( 'ucenter@letv-ucenter.sendcloud.org', '发布代码上线通知', $emailContent);
	echo json_encode(array('flag' => true, 'log' => $pushLog, 'url' => $webroot . "/project/" . trim($projectNmae) . "/pushOnline.php",'pushError' => $pushError));
	exit;
}
unset($_SESSION['longmsg']);
echo "<a href='" . $webroot . "/project/" . trim($projectNmae) . "/pushOnline.php'>返回</a>";
exit;