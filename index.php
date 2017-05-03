<?php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
<title>اختصار الروابط </title>
<style type="text/css">
<!--
	body {
	font-family:Geneva, Arial, Helvetica, sans-serif;
	font-size:0.9em;
	text-align: center;
	}
	a, a:hover, a:visited {
		color:#d20000;
	}
	form {
		padding:15px;
		margin:0;
		border:0px solid #dddddd;
		width:80%;
	}
	form label {
		font-weight:bold;
		padding-right:10px;
	}
	form input {
		border:1px solid #dddddd;
		border-right:2px solid #cccccc;
		border-bottom:2px solid #cccccc;
		padding:4px;
	}
	form input.button {
		background-color:#D20000;
		font-weight:bold;
		font-size:0.8em;
		color:#ffffff;
		border:1px solid #FF0505;
		border-right-color:#9E0000;
		border-bottom-color:#9E0000;
		font-family:Verdana, Arial, Helvetica, sans-serif;
	}
//-->
</style>
</head>
<body>
  <h2 align="center">اختصار الروابط </h2>
  <div>
<?php

/*
location of file to store URLS
*/
$file = 'https://dzapps.github.io/cut/urls.txt';

/* 
use mod_rewrite: 0 - no or 1 - yes
*/
$use_rewrite = 1;

/*
language/style/output variables
*/

$l_url			= 'URL';
$l_nourl		= '<strong>No URL supplied</strong>';
$l_yoururl		= '<strong>الرابط المختصر: </strong>';
$l_invalidurl	= '<strong>الرابط غير صالح.</strong>';
$l_createurl	= 'اختصر الرابط';

//////////////////// NO NEED TO EDIT BELOW ////////////////////

if(!is_writable($file) || !is_readable($file))
{
	die('Cannot write or read from file. Please CHMOD the url file (urls.txt) by default to 777 and make sure it is uploaded.');
}

$action = trim($_GET['id']);
$action = (empty($action) || $action == '') ? 'create' : 'redirect';

$valid = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

$output = '';

if($action == 'create')
{
	if(isset($_POST['create']))
	{
		$url = trim($_POST['url']);
		
		if($url == '')
		{
			$output = $l_nourl;
		}
		else
		{
			if(eregi($valid, $url))
			{
				$fp = fopen($file, 'a');
				fwrite($fp, "{$url}\r\n");
				fclose($fp);
				
				$id			= count(file($file));
				$dir		= dirname($_SERVER['PHP_SELF']);
				$filename	= explode('/', $_SERVER['PHP_SELF']);
				$filename   = $filename[(count($filename) - 1)];
				
				$shorturl = ($use_rewrite == 1) ? "http://{$_SERVER['HTTP_HOST']}{$dir}/{$id}" : "http://{$_SERVER['HTTP_HOST']}{$dir}/{$filename}?id={$id}";
				
				$output = "{$l_yoururl} <a href='{$shorturl}'>{$shorturl}</a>";
			}
			else
			{
				$output = $l_invalidurl;
			}
		}
	}
}

if($action == 'redirect')
{
	$urls = file($file);
	$id   = trim($_GET['id']) - 1;
	if(isset($urls[$id]))
	{
		header("Location: {$urls[$id]}");
		exit;
	}
	else
	{
		die('Script error');
	}
}

//////////////////// FEEL FREE TO EDIT BELOW ////////////////////
?>


<!-- start html output -->
<form action="<?=$_SERVER['../PHP_SELF']?>" method="post">
<p class="response"><?=$output?></p>
<p>
	<label for="s-url">ادخل الرابط :</label>
	<input name="url" type="text" id="s-url" value="http://" size="45" />
</p>
<p>
	<input type="submit" class="button" name="create" value="<?=$l_createurl?>" />
</p>
</form> </div>
<div><a href="http://www.elrafik.com/url" title="Short URL Service">Shorturl</a> &nbsp;| <a href="http://www.elrafik.com/forum" title="Generate Free Sitemap">ÏÚã Ýäí </a>&nbsp;| <a href="http://www.elrafik.com/favi" title="Generate Free Favicon">Free Favicon</a>&nbsp;| <a href="http://www.elrafik.com/forum" title="Download Free PHP Scripts">ãäÊÏíÇÊ</a>&nbsp;| <a href="http://www.elrafik.com/url" title="Free PHP Linker Script">ÇáÑÆíÓíÉ</a> </div>
<!-- Free short url script from scriptomart.com -->
<!-- Ads -->
<br />
<center><!-- Start Easy Banner Manager Code -->
<div align="center"><script type="text/javascript"><!--
google_ad_client = "ca-pub-9935930967042478";
/* 728x90, Êã ÅäÔÇÄåÇ 11/05/10 */
google_ad_slot = "4766287949";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">

</script></div>
<!-- End Easy Banner Manager Code -->
</center>
<!-- End Ads -->
</body>
</html>
<?php
ob_end_flush();
?>
