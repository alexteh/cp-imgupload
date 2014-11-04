<?php 
$connect_error='Sorry, we\'re experiencing connection problems.';


/*localhost*/
mysql_connect('localhost','root','abc123');
mysql_select_db('cakeupload') or die($connect_error);

/*Public Server*/
//mysql_connect("localhost", "loverlif_android", "android_test_01168!");
//mysql_select_db("loverlif_android_test_01") or die($connect_error);

?>