<?php
require_once 'includes/CMSManager.php';
require_once "includes/my_func.php";


$pagename	=  "index";



if($pagename !="")
{

	$cms_obj 	= new CMSManager();
	$where 		= "status='YES' and pagename='$pagename'";
//	$order_by	= "pageID desc";
	
	$cms 		= $cms_obj->getData($where,$order_by);

 	$total_rcd	= $cms_obj->numrows;
	if($total_rcd !=1)
	{
		header("Location: index.php");
		exit;
	}
	$head		= $cms[0][pagetitle];

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Eglinton Flats Winter Tennis Club - <?=$pagetitle?></title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/MenuMatic.css" type="text/css" media="screen" charset="utf-8" />
    	<link rel="stylesheet" type="text/css" href="css/slideshow.css" media="screen" />
	<script src="http://www.google.com/jsapi"></script><script>google.load("mootools", "1.2.1");</script>	
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2" valign="top"><?php include_once("header.php"); ?></td>
  </tr>
  <tr class="mainimgtr">
    <td valign="top" width="200" class="mainlefttd" align="left"><?php include_once("left.php"); ?></td>
    <td valign="top" class="maintd" width="600">
  		  

          


    <?=str_replace('../images/','images/',str_replace("\\","'",$cms[0][pagecontent]))?>
          
          
          
          
  </td>
  </tr>
  <tr>
      <td colspan="2" valign="top"><?php include_once("footer.php"); ?></td>
  </tr>
</table>

<!-- Load the MenuMatic Class -->
	<script src="js/MenuMatic_0.68.3.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- Create a MenuMatic Instance -->
	<script type="text/javascript" >
		window.addEvent('domready', function() {			
			var myMenu = new MenuMatic({ orientation:'vertical' });			
		});		
	</script>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10794808-1");
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>
