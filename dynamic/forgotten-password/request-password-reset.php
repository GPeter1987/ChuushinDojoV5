<?php
	if(isset($_POST["request-pass-reset"])){
		include_once("includes/config/initial.php");
		global $contentDir;
		
		$email=sanitize($_POST["email"]);
		//check e-mail format
		if($email==""){
			header("location: index.php?err=noemail");
			exit();
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("location: index.php?err=wrongformat");
			exit();
		}
		else{
			$sql="select email from ".USERS." where email=?";
			$stmt=$conn->stmt_init();
			
			if(!$stmt->prepare($sql)){
				header("location: index.php?err=failedCheckEmail");
				exit();
			}
			else{
				$stmt->bind_param("s", $email);
				$stmt->execute();
				
				$result=$stmt->get_result();
				if(!$row=$result->fetch_assoc()){
					header("location: index.php?err=invalidEmail");
					exit();
				}
			}
		}
		session_start();
		$user = new User();
		
		$selector=bin2hex(random_bytes(8));
		$token=random_bytes(32);
		
		$url="http://localhost/chuushindojov5/dynamic/forgotten-password/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);
		$expires=date("U")+1800; //30 minutes from now
		$sql="delete from ".PASSRESET." where reset_email=?";
		$stmt=$conn->stmt_init();
		
		if(!$stmt->prepare($sql)){
			header("location: index.php?err=failedDelete");
			exit();
		}
		else{
			$stmt->bind_param("s", $email);
			$stmt->execute();
		}
		
		$sql="insert into ".PASSRESET." (reset_email, reset_selector, reset_token, reset_expires) values (?,?,?,?)";
		
		$stmt=$conn->stmt_init();
		if(!$stmt->prepare($sql)){
			header("location: index.php?err=failedCreateToken");
			exit();
		}
		else{
			$hashedToken=password_hash($token, PASSWORD_DEFAULT);
			$stmt->bind_param("ssss", $email, $selector, $hashedToken, $expires);
			$stmt->execute();
		}
		
		$stmt->close();
		$conn->close();
		
		$to=$email;
		$subject="Jelszó alaphelyzetbe állítása a Dojo kezelőhöz";
		$msg="<p>Kedves felhasználó!</p>";
		$msg.="<p>Kaptunk egy kérést a jelszó alaphelyzetbe állítására. Az alábbi link segítségével felülírhatod az elfelejtett jelszót.
		Ha nem te kérted az új jelszót, hagyd figyelmen kívül ezt az e-mailt.</p>";
		$msg.="<p>A jelszó újra beállításához használd a következő linket: <br />
		<a href=".$url.">".$url."</a></p>";
		$msg.="<p>Üdvözlettel:<br />Dojo kezelő</p>";
		$headers="From: dojokezelo <sample@dojokezelo.hu>\r\n";
		$headers.="Reply-To: sample@dojokezelo.hu\r\n";
		$headers.="Content-type: text/html; charset=utf-8\r\n";
		
		$result="fail";
		if(mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $msg, $headers))
			$result="success";
			
		header("Location: index.php?reset=".$result);
	}
	else header("location: index.php");
?>