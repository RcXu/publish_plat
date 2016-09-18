<?php
require_once 'function.inc.php';
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$isLogin  = ldap($username, $password);
if ($isLogin) 
{
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	$_SESSION['logintime'] = time() + 1800;
	$_SESSION['isLogin'] = true;
	echo json_encode(array('flag' => true));
	exit;
} else {
	$webroot = getWebtoot();
	//echo '<script language="javascript">alert("用户名或者密码错误");window.location.href=\'' . $webroot . '/index.php\';</script>';
	echo json_encode(array('flag' => false));
	exit;
}