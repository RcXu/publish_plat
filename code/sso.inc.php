<?php
//header('Location:index.php');
session_start();
date_default_timezone_set('Asia/Shanghai');
require_once 'function.inc.php';
$webroot = getWebtoot();
//验证用户是否登录
if (!isset($_SESSION['isLogin']) || !$_SESSION['isLogin']) 
{
	echo '<script language="javascript">alert("请先登录");window.location.href=\'' . $webroot . '/login.php\';</script>';
	exit;
}
if (isset($_SESSION['logintime']) && $_SESSION['logintime'] < time())
{
	logout();
	echo '<script language="javascript">alert("请先登录");window.location.href=\'' . $webroot . '/login.php\';</script>';
	exit;
}
require_once 'auth.config.inc.php';
$request = explode('/', $_SERVER['REQUEST_URI']);
empty($request[0]) && array_shift($request);
if ('project' == $request[0]) 
{
	$auth = checkCdkey($_SESSION['username'], $request[1], $cdkey);
	if (!$auth) {
		echo '<script language="javascript">alert("对不起你没有权限");window.location.href=\'' . $webroot . '/index.php\';</script>';
		exit;
	}
} elseif ('addProject.php' == $request[0] || 'addProjectAction.php' == $request[0] || 'auth.php' == $request[0] || 'authUpdate.php' == $request[0]) {
	$auth = checkSuper($_SESSION['username'], $cdkey);
	if (!$auth) {
		echo '<script language="javascript">alert("只有超级管理员才能添加项目");window.location.href=\'' . $webroot . '/index.php\';</script>';
		exit;
	}
}

