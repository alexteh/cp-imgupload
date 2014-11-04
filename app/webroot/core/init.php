<?php 
session_start();
ob_start();
//error_reporting(0);

require 'database/connect.php';
require 'functions/users.php';
require 'functions/general.php';
require 'functions/images.php';
//require 'functions/posts.php';
//require 'functions/blog.php';

//IF(empty(var))
	// Include func files
	//include "core/func/album.func.php";
	//include "core/func/image.func.php";
	//include "core/func/user.func.php";
	//include "core/func/thumb.func.php";


	
//$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
//$current_file = end($current_file);

//echo $current_file = basename(__FILE__);

// if(logged_in()===true)
// {
// 		$session_user_id = $_SESSION['user_id'];
// 		//$user_data = user_data($session_user_id,'user_id','username','password','postcode','address','email','email_code','profile','password_recover','type','allow_email');
// 		$user_data = user_data($session_user_id,'user_id','active','username','password','first_name','last_name','email','password_recover','type','email_updates');

// 		//retrieve data from database
// 		//echo $user_data['email'];

// 		//log user out when deactivate their account
// 		if(user_active($user_data['username'])===1){
// 		 	session_destroy();
// 			header('Location: index.php'); 
// 			exit();
// 		}

// 		 if($current_file !== 'c.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1){
// 		 	header('Location: c.php?force');
// 		 	exit();
// 		 }
// }

$errors = array();
?>
 