<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PicUr</title>
	<style type="text/css">
	body {
		background:#eee;
		margin:0;
		padding:0;
		font:12px arial, Helvetica, sans-serif;
		color:#222;
	}
	</style>
	<link type="text/css" rel="stylesheet" href="plugin/album.css" />
	<link type="text/css" rel="stylesheet" href="plugin/colorbox/colorbox.css" />
	<script type="text/javascript" src="plugin/jquery.1.11.js"></script>
	<script type="text/javascript" src="plugin/colorbox/jquery.colorbox-min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
    // initiate colorbox
    $(".albumpix").colorbox({rel:'albumpix', maxWidth:'98%', maxHeight:'98%', slideshow:true, slideshowSpeed:3500, slideshowAuto:false});
});	
	</script>
</head>
<body><br><br>
<center>
	<a href="addpic"> add image</a></center>
	<?php $_REQUEST['fullalbum']=1; include 'g.php'; ?>
</body>
</html>