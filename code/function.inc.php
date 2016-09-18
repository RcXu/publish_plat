<?php
// /usr/bin/rsync -vzrtopg --progress --delete-after /letv/www/sso --exclude=".svn" rsync://10.200.89.66/sso/sso_1124
//检查用户的访问权限
function checkCdkey($username, $project, $cdkey)
{
    //是否是超级管理员
    if ( array_search($username, $cdkey['super']) || array_search($username, $cdkey['super']) === 0)
    {
        return true;
    }
    //是否有该项目的管理权限
    if (!isset($cdkey[$project]))
    {
        return false;
    }
    if (array_search($username, $cdkey[$project]) || array_search($username, $cdkey[$project]) === 0)
    {
        return true;
    }
    return false;
}

//检查用户是否是超级用户
function checkSuper($username, $cdkey)
{
    //是否是超级管理员
    if ( array_search($username, $cdkey['super']) || array_search($username, $cdkey['super']) === 0)
    {
        return true;
    }
}

//用户登录
function ldap($username, $password)
{
    $ldap_server = "10.205.91.25";
    $ldap_port = "389";
    $conn = ldap_connect("ldap://$ldap_server:$ldap_port");
    if(!$conn)
    {
        return false;
    }
    ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
    $bind = @ldap_bind($conn, "letv\\" . $username, $password);
    if(!$bind)
    {
        return false;
    }else{
        return true;
    }
}

function logout()
{
	foreach ((array)$_SESSION as $key => $value)
	{
		unset($_SESSION[$key]);
	}
}

function sendMail( $email='ucenter@letv-ucenter.sendcloud.org', $mailTitle='测试标题', $mailContent='测试内容', $from = 'no-reply@letvw.com', $fromName = '乐视网用户中心' )
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, 'https://sendcloud.sohu.com/webapi/mail.send.json');
    curl_setopt($ch, CURLOPT_POSTFIELDS,
            array('api_user'  => 'postmaster@inner-publish.mail.letvw.com',
            	  'api_key'   => '1VKmSMVhbwV8XWAY',
                  'from'      => $from,
                  'fromname'  => $fromName,
                  'to'        => $email,
                  'subject'   => $mailTitle,
                  'html'      => $mailContent,
            	  'use_maillist' => 'true'
            	)
    		);        
    $result = curl_exec($ch);
    if($result === false) //请求失败
    {
        echo 'last error : ' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}

function getWebtoot()
{
	return 'http://test.publish.letv.com';
}

function checkLogin(){
    if (isset($_SESSION['logintime']) && $_SESSION['logintime'] < time())
    {
        logout();
    }
    if (!isset($_SESSION['isLogin']) || !$_SESSION['isLogin']) {
        return false;
    } else {
        return true;
    }
}

