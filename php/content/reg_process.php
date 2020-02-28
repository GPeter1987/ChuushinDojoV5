<?php
	session_start();
	include_once("../includes/config/dbnames.inc.php");
	include_once("../includes/config/connect.inc.php");
	include_once("../includes/config/vars.php");
	include_once("../includes/classes/user.class.php");
	
	if(isset($_POST["reg_id"])){
		$user=new User();
		$user->validateRegister($_POST);
	}
	else header("location: ../index.php?pid=404");
?>