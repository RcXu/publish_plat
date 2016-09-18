<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代码发布平台</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="js/jquery.min.js"></script>
<script src="js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
<script src="js/login.js?<?php echo time();?>" type="text/javascript" charset="utf-8"></script>
<?php 
	require_once 'function.inc.php';
	$webroot = getWebtoot();
?>
<script type="text/javascript">
	var webroot = <?php echo '\'' .$webroot . '\'';?>;
</script>
</head>
<body>
<div id="loginpanelwrap">
  	
	<div class="loginheader">
    <div class="logintitle"><a href="#">代码发布平台</a></div>
    </div>

     
    <div class="loginform">
        
        <div class="loginform_row">
        <label>Username:</label>
        <input type="text" class="loginform_input" id="username" name="username"  />
        </div>
        <div class="loginform_row">
        <label>Password:</label>
        <input class="loginform_input" type="password" id="password" name="password" />
        </div>
        <div class="loginform_row">
        <input type="submit" class="loginform_submit" value="Login" id="login_submit"/>
        </div> 
        <div class="clear"></div>
    </div>

</div>

    	
</body>
</html>