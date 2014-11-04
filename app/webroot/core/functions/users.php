<?php



function mail_users($subject, $body){
	$query = mysql_query("SELECT `email`, `username` FROM `users` WHERE `email_updates` = 1");
	while(($row=mysql_fetch_assoc($query)) !== false){
		email($row['email'], $subject,  "Hello " . $row ['username'] . ",\n\n" . $body);
	}
}

function has_access($user_id, $type){
	$user_id = (int)$user_id;	
	$type = (int)$type;

	return(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id`=$user_id AND `type`=$type"), 0) ==1)?true:false;
	
}

function recover($mode, $email){
	$mode = sanitize($mode);
	$email = sanitize($email);

	$user_data = user_data(user_id_from_email($email),'user_id','username');

	if($mode=='username'){
		//recover username
		email($email, 'Your username', "Hello ".$user_data['username'].", \n\nYour username is:".$user_data['username']."\n\n-University of Greenwich");
	}else if($mode=='password'){
		//recover password
		$generated_password=substr(md5(rand(999,999999)), 0, 8);

		//die($generated_password);
		change_password($user_data['user_id'], $generated_password);



		update_user($user_data['user_id'], array('password_recover' => '1'));

		email($email, 'Your Password Recovery', "Hello ".$user_data['username'].", \n\nYour new password is:".$generated_password."\n\nNOTE: You NEED to change your password immediately, else you will not have proper access.\n\n-University of Greenwich");
	
	}
}


function update_user($user_id, $update_data){
	global $session_user_id;
	$update =array();

	array_walk($update_data, 'array_sanitize');
	foreach($update_data as $field=>$data){
		$update[]= '`' . $field . '`=\'' . $data . '\'';

	}
	//print_r($update);
	//echo implode(', ',$update);
	//die();
	

	mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id");
	//mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $session_user_id")or die(mysql_error());	
}

function activate($email, $email_code){
	$email 			= mysql_real_escape_string($email);
	$email_code 	= mysql_real_escape_string($email_code);

	if(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email`= '$email' AND `email_code` = '$email_code' AND `active` = 0"),0)==1)
	{
		//query to update user active status from 0 to 1
		mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
		return true;
	}
	else
	{
		return false;
	}
}

//FUNCTION Upon Activate, log user in
function activation_login($email,$email_code){
	$user_id = user_id_from_email($email);
	$email = sanitize($email);

	//$email_code = md5($email_code);

	return(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code'"), 0)==1)?$user_id:false;

}
/* FUNCTION CHANGE PSW */
function change_password($user_id, $password){
	$user_id = (int)$user_id;
	$password = md5($password);

	mysql_query("UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id");
}

function email_exists($email){

	//preventive SQL injection's function
	$username = sanitize($email);

	$query=mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");

	return (mysql_result($query, 0)==1) ? true:  false;
}


//FUNCTION unused == > check redirect problem
function activation_login_redirect($email,$email_code){
	$user_id = user_id_from_email($email);
	$email = sanitize($email);

	//$email_code = md5($email_code);

	return(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code'"), 0)==1)?$user_id:false;

}




function register_user_to_users_db($register_data){

	array_walk($register_data, 'array_sanitize');

	$register_data['password']=md5($register_data['password']);
	
	//print_r($register_data);

	//make it readable to database
	$fields = '`' . implode('`, `', array_keys($register_data)). '`';
	//echo $fields;

	$data='\'' . implode('\', \'', $register_data). '\'';

	//echo $data;

	//try check for sql syntax error from	
	//echo "INSERT INTO `users` ($fields) VALUES ($data)";
	//die();
	
	//start inserting data in mysql
	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");	
	//modify md5 to front 5 digit
	//email($register_data['email'], 'Activate your account', "Hello ".$register_data['username'].",\n\nYou need to activate your account, so use the link below:\n\nhttp://stuweb.cms.gre.ac.uk/~tk133/comp1687/activate.php?email=".$register_data['email']."&email_code=\n\nthe activation code is 1st 5 letter:".$register_data['email_code']. "- royalgreenwich"); 
	
	//original to web host
	//email($register_data['email'], 'Activate your account', "Hello ".ucfirst($register_data['username']).",\n\nYou need to activate your account, so use the link below:\n\nhttp://lover4life.com/site/owner/proj/02_1_php/a.php?email=".$register_data['email']."&email_code=".$register_data['email_code']. "\n\nRegards,\nAndroid Upload"); 
	
	//to localhost
	email($register_data['email'], 'Activate your account', "Hello ".ucfirst($register_data['username']).",\n\nYou need to activate your account, so use the link below:\n\nhttp://lover4life.com/site/owner/proj/02_1_php/a.php?email=".$register_data['email']."&email_code=".$register_data['email_code']. "\n\nRegards,\nAndroid Upload"); 
}


// FUNCTION QUERY USER NUMBERS 
function total_users(){
	return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` =1"), 0);
}

// FUNCTION RETRIEVE USER DATA from `users` table etc ==> profile information
function user_data($user_id){
	$data= array();
	$user_id = (int)$user_id;

	$func_num_args = func_num_args(); // check the amount of parameter i pass into this funtion
	$func_get_args = func_get_args();

	//test can receive data from database
	//echo $func_num_args;
	//print_r($func_get_args);
	if ($func_num_args >1){
		unset($func_get_args[0]);
 
		$fields = '`' . implode('`, `', $func_get_args). '`';
		 //echo $fields;

		//echo "SELECT $fields FROM `users` WHERE `user_id` = $user_id";
		//die();

		//$data = mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id");
		
		//the $field is where init.php controls the amount

		$query = mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id");
		if($query === FALSE) {
		    die(mysql_error()); // TODO: better error handling
		}


		$data = mysql_fetch_assoc($query);
		
		//print_r($data);
		//die();

		return $data; 
	}
}

//to check whether session is set
function logged_in(){
	return(isset($_SESSION['user_id']))? true : false;
}
//self explainatory
function get_username_from_user_id($user_id){
	//preventive SQL injection's function
	$username = sanitize($user_id);
	$query = mysql_query("SELECT `username` FROM `users` WHERE `user_id` = '$user_id'");
	return mysql_result($query, 0, 'username');
}
//self explainatory
function get_user_id_from_username($username){
	//preventive SQL injection's function
	$username = sanitize($username);
	$query = mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'");
	return mysql_result($query, 0, 'user_id');
}

//FUNCTION login, return 0 if false or user_id if true
function login($username, $password){
	//preventive SQL injection's function
	$user_id = get_user_id_from_username($username);
	$username = sanitize($username);	
	$password = md5($password);//encrypt password
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
	return (mysql_result($query, 0)==1) ? $user_id : false;
}

//FUNCTION to check user is active, return 0 for false or 1 for true
function user_active($username){
	//preventive SQL injection's function
	$username = sanitize($username);
	$query =mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1");
	return (mysql_result($query, 0)==1) ? true:  false;
}

//FUNCTION check whether user exist, return 0 for false or 1 for true
function user_exists($username){
	//preventive SQL injection's function
	$username = sanitize($username);
	$query=mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query, 0)==1) ? true:  false;
}

function user_id_exists($user_id){
	//preventive SQL injection's function
	$user_id = sanitize($user_id);
	$query=mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = '$user_id'");
	return (mysql_result($query, 0)==1) ? true:  false;
}


//---------------------------------------------------------------

function post_delete_skydrive_data($doc_id){	


	mysql_query("DELETE FROM `cp1108_doc` WHERE `doc_id`=$doc_id");
	//mysql_query("DELETE FROM `cp1108_doc` WHERE `url`=$doc_id");


	header('Location: '.this_current_url());
}	

function upload_post_notes_link($user_id, $post_id, $doc_title, $url){
	
		mysql_query("INSERT INTO `cp1108_doc` SET
		`user_id`			={$user_id},
		`post_id`			='{$post_id}',
		`doc_title`			='{$doc_title}',
		`iframe`			= 0,
		`url`				='{$url}'
		");
}


function upload_post_notes_iframe($user_id, $post_id, $doc_title, $url){
	

		mysql_query("INSERT INTO `cp1108_doc` SET
		`user_id`			={$user_id},
		`post_id`			='{$post_id}',
		`doc_title`			='{$doc_title}',
		`iframe`			= 1,
		`url`				='{$url}'
		");

}





function upload_post_image($user_id, $file_temp, $file_extn,$post_id){
	

	//if(){


	//upload this file
		$file_path ='images/post/' .  substr(md5(time()), 0,10) . '.' . $file_extn;
		//echo $file_path;
		move_uploaded_file($file_temp, $file_path);

	//update comp1687_user's data
		//mysql_query("UPDATE `users` SET `profile` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` =".(int)$user_id);
		
		//find the greatest $post_id for this user where tmp_post is 1
		//$post_id = mysql_result(mysql_query("SELECT  `post_id` FROM  `cp1687_posts` WHERE  `user_id` ={$user_id} AND  `tmp_post` =1 ORDER BY  `post_id` DESC LIMIT 1"),0);
		//echo '$post_id = '.$post_id;

		//store data in cp1687_img
		mysql_query("INSERT INTO `cp1687_img` SET
		`user_id`			={$user_id},
		`post_id`			='{$post_id}',
		`url`				='{$file_path}'
		");

		/* temp post idea */
		//tmp_post default is 1
	//}

		//mysql_query("INSERT INTO `cp1687_img` VALUES('','".$_SESSION['user_id']."','".$_SESSION['user_id']."','0','{$file_path2}')");

}




function change_profile_image($user_id, $file_temp, $file_extn){
	//retrieve data from 'profile' if it is not empty, go and delete the image
	//if img not found, or database 'profile is empty = ignore this line

	//upload this file
		$file_path ='images/profile/' .  substr(md5(time()), 0,10) . '.' . $file_extn;
		//echo $file_path;
				//folder creation
		//$uploaddir ='images/profile/';
		//look up 0744
		//mkdir('uploads/thumbs/'.mysql_insert_id(), 0777);//look up 0744

		//if (!is_dir($uploaddir) && !mkdir($uploaddir, 0777)){
		// die("Error creating folder $uploaddir");
	//	}

		//mkdir($uploaddir, 0777);

		move_uploaded_file($file_temp, $file_path);

	//update comp1687_user's data
		mysql_query("UPDATE `users` SET `profile` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` =".(int)$user_id);


}
function register_user2($register_data){
	array_walk($register_data, 'array_sanitize');

	//convert data provided into md5
	$register_data['password']=md5($register_data['password']);
	
	//make it readable to database
	$fields = '`' . implode('`, `', array_keys($register_data)). '`';

	//echo $fields;	//make it readable to database
	$data='\'' . implode('\', \'', $register_data). '\'';

	//start inserting data in mysql
	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");	

	//modify md5 to front 5 digit
	email($register_data['email'], 'Activate your account', "Hello ".$register_data['username'].",\n\nYou need to activate your account, so use the link below:\n\nhttp://stuweb.cms.gre.ac.uk/~tk133/comp1108_v2/verified.php?email=".$register_data['email']."\n\nthe activation code is:".$register_data['email_code']."\n\n- University of Greenwich"); 
}

function activate2($email, $email_code){
	$email 			= mysql_real_escape_string($email);
	$email_code 	= mysql_real_escape_string($email_code);

	if(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email`= '$email' AND `email_code` = '$email_code' AND `active` = 0"),0)==1){
		

		//query to update user active status from 0 to 1
		mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");


		return true;
	}else{
		return false;
	}
}



/* UPDATE DATABASE */








function register_user($register_data){

	array_walk($register_data, 'array_sanitize');

	$register_data['password']=md5($register_data['password']);
	
	//print_r($register_data);

	//make it readable to database
	$fields = '`' . implode('`, `', array_keys($register_data)). '`';
	//echo $fields;

	$data='\'' . implode('\', \'', $register_data). '\'';

	//echo $data;

	//try check for sql syntax error from
	/*
	echo "INSERT INTO `users` ($fields) VALUES ($data)";
	die();
	*/


	//start inserting data in mysql
	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");	
	//modify md5 to front 5 digit
	//email($register_data['email'], 'Activate your account', "Hello ".$register_data['username'].",\n\nYou need to activate your account, so use the link below:\n\nhttp://stuweb.cms.gre.ac.uk/~tk133/comp1687/activate.php?email=".$register_data['email']."&email_code=\n\nthe activation code is 1st 5 letter:".$register_data['email_code']. "- royalgreenwich"); 
	
	//original
	email($register_data['email'], 'Activate your account', "Hello ".$register_data['username'].",\n\nYou need to activate your account, so use the link below:\n\nhttp://stuweb.cms.gre.ac.uk/~tk133/comp1687/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code']. "\n\n- royalgreenwich"); 
}









			//auto login script




function user_id_from_email($email){
	$username = sanitize($email);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `email` = '$email'"), 0, 'user_id');
}
?>