<?php
require_once dirname(dirname(dirname(__FILE__))) . '/sso.inc.php';
require_once 'config.inc.php';
$projectSvnVersion = trim($_POST['projectSvnVersion']);
if (empty($projectSvnVersion))
{
	echo json_encode(array('flag' => false, 'info' => "请输入svn版本号"));
    exit;
}
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, $_SESSION['username']);
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, $_SESSION['password']);
//$version = svn_update($projectPath);
$co = svn_checkout ( $projectSvnPath, $projectPath, $projectSvnVersion);
if ($co) 
{
	if ( is_file($projectPath . '/version.config.inc.php') )
	{
		require_once $projectPath . '/version.config.inc.php';
		!empty($version) && $version >= $projectSvnVersion && $version = 0;
	}
	$log = !empty($version) ? svn_log($projectPath, $version, $projectSvnVersion) : svn_log($projectPath, $projectSvnVersion);
	if (!empty($version))
	{
		//删除第一条日志
		array_shift($log);
	}
	$last = count($log) - 1;
	!empty($log[$last]) && $_SESSION['longmsg']  = $log[$last]['msg'];
	!empty($log[$last]) && $_SESSION['filepath'] = $log[$last]['paths'];
	echo json_encode(array('flag' => true, 'info' => $projectSvnVersion, 'logs' => $log));
} else {
	echo json_encode(array('flag' => false, 'info' => "SVN更新失败"));
}
exit;