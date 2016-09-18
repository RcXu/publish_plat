<?php
require_once 'sso.inc.php';
$authList = $_POST['auth'];
$authinfo = var_export($authList, true);
$fileContent = '<?php $cdkey=' . $authinfo . ';';
file_put_contents('auth.config.inc.php', $fileContent);
echo '<script language="javascript">alert("权限更新成功");window.location.href=\'' . $webroot . '/auth.php\';</script>';
exit;