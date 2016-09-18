<?php
require_once dirname(dirname(dirname(__FILE__))) . '/sso.inc.php';
require_once 'config.inc.php';
$workSpaceDir = explode('/', dirname(__FILE__));
$projectNmae = array_pop($workSpaceDir);
if (isset($_POST))
{
	
	$projectDir = $projectPath . '/';
	$svnVersion = trim($_POST['svnVersion']);


    if (empty($svnVersion) || !is_dir($projectDir) || !is_numeric($svnVersion))
    {
        echo json_encode(array('flag' => false,'msg' => '发布参数错误'));
        exit;
    }
    if (!isset($_SESSION['filepath']) || empty($_SESSION['filepath']))
    {
        echo json_encode(array('flag' => false,'msg' => '请先更新svn！每次上线都要走svn哦！'));
    	exit;
    }
    //检查代码是否有语法错误
    $paths =  $_SESSION['filepath'];
    $errorInfo = '';
    foreach ((array)$paths as $path) 
    {
    	$tmp = explode('/', $path['path']);
    	$fileName = array_pop($tmp);
    	$filePath = array_pop($tmp);
    	$file = $projectDir . trim($filePath) . '/' . trim($fileName);
    	if (!is_file($file)) {
    		continue;
    	}
    	$pathinfo = pathinfo($file);
    	if (!isset($pathinfo['extension']) || $pathinfo['extension'] != 'php')
    	{
    		continue;
    	}
    	$cmd = 'php -l ' . $file;
    	$rs = shell_exec($cmd);
    	$rs = trim($rs);
    	$start = substr($rs, 0, 2);
    	if ($start !== 'No') {
    		$errorFlag = true;
    		$errorInfo .=  $rs . "<br />";
    	}
    }
    $workSpaceDir = explode('/', dirname(__FILE__));
    $projectName = array_pop($workSpaceDir);
    unset($_SESSION['filepath']);
    //如果代码有语法错误
    if (isset($errorFlag) && $errorFlag)
    {
        echo json_encode(array('flag' => false,'msg' => '本次更新有语法错误！不能上线代码，请修复后再上线！！' . $errorInfo));
    	exit;
    }
    ///////发布代码
    $serviceIpList = explode(',', $ipList);
    $publishlog = '';
    foreach ((array)$serviceIpList as $key => $ip) 
    {
        if (empty($ip))
        {
            continue;
        }
        $shell = '/usr/bin/rsync -vzrtopg --progress --delete-after ' . $projectDir . ' --exclude=".svn" --exclude="version.info.inc.php" --exclude="robots.txt" --exclude="version.config.inc.php" rsync://' . $ip . '/' . $mod . '/' . $svnVersion . '/';
        $rs = shell_exec($shell);
        $publisherror = false;
        if (empty($rs))
        {
            $publishlog .= "<li>" . ($key + 1) . "：" . $ip . "……发布失败!!!</li>";
            $publisherror = true;
        } else {
            $publishlog .=  "<li>" . ($key + 1) . "：" . $ip . "……发布成功</li>";
        }
    }
    $versionLog = file_put_contents('publishLog', $svnVersion . '|' . $_SERVER['REMOTE_ADDR'] . '|' . $_SESSION['username'] . '|' . date('Y-m-d H:i:s', time()) ."\n", FILE_APPEND);
    
    echo json_encode(array('flag' => true, 'publishlog' => $publishlog, 'publisherror' => $publisherror));
    exit;
}