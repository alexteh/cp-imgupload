<?php
function check_image_file_exist($root,$filepath){	
	
	$exist=0;
	if ($filepath!=$root){
		if(file_exists($filepath)) 
		{
			$exist=1;
		}
	}
	else
	{
		$exist=0;
	}
	return $exist;
}


function delete_image($img_filename)
{
	//$$img_filename=(int)$$img_filename;
	
	//provide file path
	$root = 'albums/images/';
	$tmbroot='albums/images/thumbs/';

	$filepath=$root.$img_filename;
	$filetmbpath=$tmbroot.$img_filename;



	echo '<br>check_image_file_exist($filepath) = '.check_image_file_exist($root,$filepath);
	echo '<br>check_image_file_exist($filetmbpath) = '.check_image_file_exist($tmbroot,$filetmbpath);


	if(check_image_file_exist($root,$filepath)==1){
		 unlink($filepath);
	}

	if(check_image_file_exist($tmbroot,$filetmbpath)==1){
		 unlink($filetmbpath);
	}
	 echo '<br>file deleted...';	

	echo '<br>check_image_file_exist($filepath) = '.check_image_file_exist($root,$filepath);
	echo '<br>check_image_file_exist($filetmbpath) = '.check_image_file_exist($tmbroot,$filetmbpath);

	echo '<br>redirect...';	
	header('Location: index.php');
}	
?>