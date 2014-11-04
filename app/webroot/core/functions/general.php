<?php 

//FUNCTION to simplify error handling
function output_errors($errors){
	return '<ul><li>'.implode('</li><li>',$errors).'</li></ul>';
}
function array_sanitize(&$item){
	//$item = mysql_real_escape_string($item);
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}


//FUNCTION sanitize to prevent sql injection
function sanitize($data){
	//return mysql_real_escape_string($data);
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

//--------------------------------------------
function email($to, $subject, $body){
	mail($to, $subject, $body, 'From: noreply@lover4life.com');
	
}	


// if user log in, redirect to this page
function logged_in_redirect(){
	//echo 'login redirect';
	if(logged_in()===true){
		header('Location: del.php?album=images');
		//header('Location: home.php?album=images');
		//echo 'go home';
		exit();
	}
}

//if user not log in go to this page
function protect_page(){
	if(logged_in()===false){
		header('Location: index.php');
		exit();
	}
}
function pending_redirect(){
  
	global $user_data;

	if(has_access($user_data['user_id'],0)=== true){
		 header('Location: home.php');
		 exit();	
	}
}
function admin_redirect(){
	global $user_data;

	if(has_access($user_data['user_id'],1)=== true){
		header('Location: admin.php');
		exit();		
	}

}
function admin_protect(){
  
	global $user_data;

	if(has_access($user_data['user_id'],1)=== false){
		header('Location: home.php');
		exit();		
	}
}


function prof_protect(){
  
	global $user_data;

	if(has_access($user_data['user_id'],2)=== false){
		header('Location: _all_post.php');
		exit();		
	}
}


function approve_redirect(){
  
	global $user_data;

	if(has_access($user_data['user_id'],0)=== false){
		header('Location: _all_post.php');
		exit();		
	}
}




function this_current_url_QR($size){	
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	//echo $actual_link;
	echo '<iframe src="http://chart.googleapis.com/chart?cht=qr&chs='.$size.'x'.$size.'&choe=UTF-8&chld=H&chl='.$actual_link.'" width="'.$size.'" height="'.$size.'" frameBorder="0">Browser not compatible.</iframe>
';

}

function this_current_url(){	
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	echo $actual_link;
}

/*
function output_errors2($errors){
	$output=array();
	foreach($errors as $error){
		//echo $error, ', ';
		$output[]='<li>'.$error.'</li>';
	}
	return '<ul>'.implode('',$output).'</ul>';
}
*/


?>
