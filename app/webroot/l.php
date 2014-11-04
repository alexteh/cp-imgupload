<?php 
include 'core/init.php'; 
logged_in_redirect();

if(empty($_POST)===false)
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	//testing: //echo $username, ' ',  $password;

	if(empty($username)===true||empty($password)===true)
	{
		$errors[]='You need to enter a username and password';
	}

	else if(user_exists($username)===false)
	{
		$errors[]='We can\'t find that username. Have you registered?';
	}

	else if (user_active($username)===false)
	{
		$errors[]='You haven\'t activated your account!';
		$errors[]='Please Check your email to verify your registration';			
	}

	else
	{
		/*test errors*/
		if(strlen($password)> 32){
			$errors[] ='Password too long';
		}		

		if(login($username, $password) === false)
		{
		 	$errors[]='That username/password combination is incorrect';
		}

		else
		{			
		 	$_SESSION['user_id']=login($username, $password);//set user session	

			echo'session'.$_SESSION['user_id'];
			//include '_testing_1.php';


		// echo $host  = $_SERVER['HTTP_HOST'];
		// echo $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		// echo $extra = '__home.php';
		// header('Location: http://'.$host.$uri.'/'.$extra);	
		 	header('Location: del.php?album=images'); //redirect user to home				
		 	exit();			
		}
	}
	//print_r($errors);
}
?>

<?php	
if(empty($errors)===false)
{?>
	<div class="alert alert-danger" role="alert">
	    <strong>Oh snap!</strong> We tried to log you in, but...  
			<?php echo output_errors($errors); ?>
	</div>
<?php
}?>
<center>

<form action="l.php" method="post" class="form-signin" role="form"> 
  <h2 class="form-signin-heading"><center>Image Upload</center></h2>
		<input type="text" name="username" class="form-control" placeholder="Username" required autofocus><br>
    <input type="password" name="password" class="form-control" placeholder="Password" required><br>
    <input type="submit" value="Log In" class="btn btn-lg btn-primary btn-block"> 
    <?php
      /*
        <a href="register.php"  class="btn btn-lg btn-success btn-block">Register</a>                
        Forgotten Your 
        <a href="recover.php?mode=username"><strong>Username</strong></a>  or  
        <a href="recover.php?mode=password"><strong>Password</strong></a> ?
    <a href="http://lover4life.com/site/owner/" target="_blank" class="container-fluid">&copy; Alex Teh 2014. All rights reserved.</a>   
      */
    ?>
</form>
</center>