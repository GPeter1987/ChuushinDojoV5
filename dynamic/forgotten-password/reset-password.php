<?php
	session_start();
	include_once("includes/config/initial.php");
	global $rootDir;
	global $contentDir;
	$user = new User();
	$permissions=$user->getPermissions();
	$page=new Page($permissions);
  
	include_once($contentDir."/header.php");
	
	if(isset($_POST["send-reset-submit"])){
		$selector=$_POST["selector"]; //already sanitized
		$validator=$_POST["validator"]; //already sanitized
		$pass=sanitize($_POST["newPass"]);
		$passAgain=sanitize($_POST["newPassAgain"]);
		
		if(empty($pass) || empty($passAgain)){
			header("location: create-new-password.php?err=emptypass&selector=".$selector."&validator=".$validator);
			exit();
		}
		else if($pass!=$passAgain){
			header("location: create-new-password.php?err=notsamepass&selector=".$selector."&validator=".$validator);
			exit();
		}
		else if(!$user->validate("password", $pass)){
			header("location: create-new-password.php?err=wrongpassformat&selector=".$selector."&validator=".$validator);
			exit();
		}
		
		$currentDate=date("U");
		
		$sql="select * from ".PASSRESET." where reset_selector=? and reset_expires>=".$currentDate;
		$stmt=$conn->stmt_init();
		
		if(!$stmt->prepare($sql)){
			header("location: index.php?err=unknown");
			exit();
		}
		else{
			$stmt->bind_param("s", $selector);
			$stmt->execute();
			
			$result=$stmt->get_result();
			if(!$row=$result->fetch_assoc()){
				header("location: index.php?err=expiredOrWrongSelector");
				exit();
			}
			else{
				$tokenBin=hex2bin($validator);
				$tokenCheck=password_verify($tokenBin, $row["reset_token"]);
				
				if($tokenCheck===false){
					header("location: index.php?err=expiredOrWrongSelector");
					exit();
				}
				else if($tokenCheck===true){
					$tokenEmail=$row["reset_email"];
					
					$sql="select * from ".USERS." where email=?";
					
					$stmt=$conn->stmt_init();
					if(!$stmt->prepare($sql)){
						header("location: index.php?err=unknown");
						exit();
					}
					else{
						$stmt->bind_param("s", $tokenEmail);
						$stmt->execute();
						
						$result=$stmt->get_result();
						if(!$row=$result->fetch_assoc()){
							header("location: index.php?err=invalidEmail");
							exit();
						}
						else{
							$sql="update ".USERS." set jelszo=?, so=? where email=?";
							$stmt=$conn->stmt_init();
							if(!$stmt->prepare($sql)){
								header("location: index.php?err=unknown");
								exit();
							}
							else{
								$salt=time();
								$saltedPass=crypt($pass,$salt);
								$stmt->bind_param("sis", $saltedPass, $salt, $tokenEmail);
								$stmt->execute();
								
								$sql="delete from ".PASSRESET." where reset_email=?";
								$stmt=$conn->stmt_init();
								
								if(!$stmt->prepare($sql)){
									header("location: index.php?err=failedDelete");
									exit();
								}
								else{
									$stmt->bind_param("s", $tokenEmail);
									$stmt->execute();
									$user->setMsg("<div class='success'>Az új jelszó sikeresen beállítva.</div>");
									echo "<div class='success'>Az új jelszó sikeresen beállítva.</div>";
									header("location: ../index.php?pid=3");
									exit();
								}
							}
						}
					}
				}
			}
		}
	}
	else header("location: index.php");
?>