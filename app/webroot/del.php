<?php
include 'core/init.php'; 
protect_page();
if(isset($_GET['album'])===false)
{
	header('Location: del.php?album=images');
}
function build_external_file_include($_dir){
    $_files = scandir($_dir);
    $_stack_of_file_includes = "";//will store the includes for the specified file.
foreach ($_files as $ext){
    //split the file name into two;
    $fileName = explode('.',$ext);//this is where the issue is.

    switch ($fileName[1]){
       
        case "jpg";//if file is jpg
             $_stack_of_file_includes =  $_stack_of_file_includes."<p><a href='d.php?i=".$ext."'> [ DELETE ]</a> ". $ext."</p>";
            break;
        case "jpeg";//if file is jpg
             $_stack_of_file_includes =  $_stack_of_file_includes."<p><a href='d.php?i=".$ext."'> [ DELETE ]</a> ". $ext."</p>";
            break;
        case "gif";//if file is gif
             $_stack_of_file_includes =  $_stack_of_file_includes."<p><a href='d.php?i=".$ext."'> [ DELETE ]</a> ". $ext."</p>";
            break;
        case "png";//if file is png
             $_stack_of_file_includes =  $_stack_of_file_includes."<p><a href='d.php?i=".$ext."'> [ DELETE ]</a> ". $ext."</p>";
            break;
        default://if file type is unkown
             $_stack_of_file_includes =  $_stack_of_file_includes."<!-- File: ".  $ext." was not included-->";
    }


}
return $_stack_of_file_includes;
}
?>

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
	<h1>Admin Page <a href="logout.php"> [ logout ]</a></h1>
	<p>(ROLE: delete upload images)</p>
	
</center>

<div width="800px" style="width: 50%;margin: 0 auto;">
<p =>
<?php
$dir = "albums/images/thumbs";

// Sort in descending order
// $b = scandir($dir,1);

// print_r($b);

print_r(build_external_file_include($dir));
?>
</p>

</div>
<center>
	<?php $_REQUEST['fullalbum']=1; include 'g.php'; ?>
</center>
</body>

</html>
