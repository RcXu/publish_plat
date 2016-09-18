<?php
require_once 'auth.config.inc.php';
require_once 'function.inc.php';
$projectList = scandir('project');
foreach ((array)$projectList as $key => $value) {
	if ('.' == $value || '..' == $value){
		unset($projectList[$key]);
	}
}
empty($projectList) ? $havePfoject = false : $havePfoject = true;
if (!$havePfoject)
{
	echo '<li ><a href="index.php">还没有项目</a></li>';
} else {
	foreach((array)$projectList as $key => $value)
	{
		if ('.' == $value || '..' == $value 
				||!isset($_SESSION['username']) 
				|| !checkCdkey($_SESSION['username'], $value, $cdkey))
		{
			continue;
		}
		echo '<li ><a href="project/' . $value . '/">' . $value . '</a></li>';
		$havePfoject = true;
	}
}
