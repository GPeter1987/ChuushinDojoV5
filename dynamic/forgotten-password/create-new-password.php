<?php
	session_start();
	include_once("includes/config/initial.php");
	global $rootDir;
	global $contentDir;
	$user = new User();
	$permissions=$user->getPermissions();
	$page=new Page($permissions);
  
	include_once($contentDir."/header.php");
?>
    
    <article>
    <?php
      if(isset($_GET["redirect"])){
        $redirect=sanitize($_GET["redirect"]);
        if(file_exists($contentDir."/".$redirect.".php"))
          include_once($contentDir."/".$redirect.".php");
        else header("location: ?pid=404");
		exit();
      }
	  
	  if(!isset($_GET["selector"]) || !isset($_GET["validator"])){
		if(empty($selector) || empty($validator)){
		  echo "<div class='error'>Nem sikerült a kérés érvényesítése!</div>";
		}
	  }
	  else{
		$selector=sanitize($_GET["selector"]);
		$validator=sanitize($_GET["validator"]);
		if(ctype_xdigit($selector)!==false && ctype_xdigit($validator)!==false){
			?>
			<h1>Elfelejtett jelszó helyreállítása</h1>
			<form action="reset-password.php" method="post">
				<input type="hidden" name="selector" value="<?php echo $selector; ?>" />
				<input type="hidden" name="validator" value="<?php echo $validator; ?>" />
				Új jelszó: <input type="password" name="newPass" /><br />
				Új jelszó újra: <input type="password" name="newPassAgain" />
				<div>A jelszónak legalább 8 karakter hosszúnak kell lennie (ebből min. 2 számjegy)!</div>
				<p>
					<input type="submit" name="send-reset-submit" value="Helyreállítás" />
				</p>
			</form>
			<?php
			if(isset($_GET["err"])){
				$error=$_GET["err"];
				$content="<div class='error'>";
				switch($error){
					case "emptypass": $content.="Hiba: Az új jelszó megadása (kétszer) kötelező!"; break;
					case "notsamepass": $content.="Hiba: A beírt jelszavak nem egyeznek meg!"; break;
					case "wrongpassformat": $content.="Hiba: Rossz a jelszó hossza vagy formátuma!"; break;
					default: $content.="Ismeretlen hiba történt! Próbáld újra!";
				}
				$content.="</div>";
				echo $content;
			}
		}
		else echo "<div class='error'>Helytelen azonosító formátum!</div>";
	  }
    ?>
    </article>
    
    <!--<img id="backgroundImg" src="img/nishioTransparentPng.png" alt="Nishio sensei is performing a technique with a partner"/>-->
    <a href="javascript:history.back()">Vissza</a>
    <?php
      include_once($contentDir."/footer.php");
    ?>