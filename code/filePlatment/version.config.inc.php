<?php
/**
 * 代码库版本控制配置文件
 * @var array
 */
/**
 * 文件版本信息
 * 1、$workspace 与 $versiono不同时为空时，依据此版本执行代码库
 * 2、$workspace 不为空，$versiono为空时，执行$workspace版本下flag=1的代码库
 * 3、$workspace 与 $versiono同时为空，依据$extra列举条件执行代码
 */
require_once 'version.info.inc.php';
!isset($workspace) && $workspace = 0;
$version = $workspace;
//不同版本库适配
if (isset($_COOKIE[md5('versioncontrol')]) && !empty($_COOKIE[md5('versioncontrol')]) )
{
	$version = $_COOKIE[md5('versioncontrol')];
} elseif (!empty($workspace) && !empty($versionSub)) {
	//执行$workspace 和 $versionSub共同指定的版本库
	$version = $workspace . '_' . $versionSub;
} elseif (!empty($workspace) && empty($versionSub) && isset($versionConfigList[$workspace])) {
	//执行$workspace大版本下 开启允许执行的版本
	foreach ( (array) $versionConfigList[$workspace] as $key => $versionInfo)
	{
		if (1 == $versionInfo['flag'])
		{
			$version = $workspace . '_' . $versionInfo['version'];
			break;
		}
	}
} elseif(empty($workspace) && !empty($versionSub)) {
	$version = $versionSub;
} else {
	//依据$extra指定的条件，定制化执行代码库
	if (isset($extra['spaceRate']) && !empty($extra['spaceRate'])) 
	{
		//floatval(3/10)
		$seed = floatval(rand(1, 10)/10);
		switch ($seed) 
		{
			case $seed <= $extra['spaceRate'][1]:
				$workspace = 1;
				break;
			case $seed > $extra['spaceRate'][1]:
				$workspace = 2;
				break;
			default:
				break;
		}
		foreach ( (array) $versionConfigList[$workspace] as $key => $versionInfo)
		{
			if (1 == $versionInfo['flag'])
			{
				$version = $workspace . '_' . $versionInfo['version'];
				header('P3P: CP="CAO DSP COR CUR ADM DEV TAI PSA PSD IVAi IVDi CONi TELo OTPi OUR DELi SAMi OTRi UNRi PUBi IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE GOV"');
				setcookie(md5('versioncontrol'), $version, 0, '/', 'letv.com');
				break;
			}
		}
	}
}
