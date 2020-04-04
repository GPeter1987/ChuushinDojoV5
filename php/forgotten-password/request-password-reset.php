<?php
if(isset($_POST["request-pass-reset"])){
	global $contentDir;
	include_once($contentDir."includes/config/initial.php");
	$email=sanitize($_POST["email"]);
	//check e-mail format
	if($email==""){
		header("location: index.php?error=noemail");
		exit();
	}
	else{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		  header("location: index.php?error=wrongformat");
		  exit();
		}
	}
	session_start();
	$user = new User();
	
	$selector=bin2hex(random_bytes(8));
	$token=random_bytes(32);
	echo $token;
	
}
else header("location: index.php");
?>