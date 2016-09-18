<?php
session_start();
require_once 'function.inc.php';
$hasLogin = checkLogin();
$webroot = getWebtoot();
if (!$hasLogin) {
	echo '<script language="javascript">alert("还没有登陆，请先去登陆！");window.location.href=\'' . $webroot . '/login.php\';</script>';
}
13;
?>