<?php

include 'core/init.php'; 
protect_page();

//echo 'ur admin';
if(isset($_GET['i'])===true && empty($_GET['i'])===false){

delete_image($_GET['i']);

}else{
 header('Location: index.php');
}

?>