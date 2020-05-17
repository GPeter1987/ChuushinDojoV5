<?php
  session_start();
  include_once("includes/config/initial.php");
  global $rootDir;
  global $contentDir;
  $user = new User();
  $permissions=$user->getPermissions();
  $page=new Page($permissions);
  
?>
    <?php
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
    ?>
	  <h1>Elfelejtett jelszó</h1>
	  <p>Ha elfelejtetted a jelszavad, írd be az alábbi mezőbe az e-mail címed, kattints
	  az "Új jelszó kérése" gombra és kapni fogsz egy e-mailt az új jelszó igényléshez szükséges információkkal.</p>
	  <form method="post" action="request-password-reset.php">
		E-mail cím: <input type="email" name="email" placeholder="Regisztrált e-mail cím." /><br />
		<input type="submit" name="request-pass-reset" value="Új jelszó kérése" />
	  </form>
	  <?php
		if(isset($_GET["err"])){
		  $error=$_GET["err"];
		  $content="<div class='error'>";
		  
		  switch($error){
			case "noemail": $content.="Az e-mail cím megadása kötelező!"; break;
			case "wrongformat": $content.="Az e-mail cím formátuma nem megfelelő!"; break;
			case "failedDelete": $content.="A korábbi jelszó visszaállítás paramétereit nem sikerült törölni, próbáld újra!"; break;
			case "failedCreateToken": $content.="Az új jelszó igénylése sikertelen!"; break;
			case "expiredOrWrongSelector": $content.="Az új jelszó igényléshez szükséges adat lejárt vagy érvénytelen!<br />Kérlek, kezdd újra!"; break;
			case "failedCheckEmail": $content.="Az e-mail cím ellenőrzése sikertelen! Próbáld újra!"; break;
			case "invalidEmail": $content.="Nem regisztrált e-mail cím!"; break;
			default: $content.="Ismeretlen hiba történt! Próbáld újra!";
		  }
		  $content.="</div>";
		  echo $content;
		}
		if(isset($_GET["reset"])){
		  if($_GET["reset"]=="success")
			echo "<div class='success'>Nézd meg a levelezőrendszered, az e-mail hamarosan megérkezik.</div>";
		}
	  ?>
    </article>
    
    <!--<img id="backgroundImg" src="img/nishioTransparentPng.png" alt="Nishio sensei is performing a technique with a partner"/>-->
    <a href="javascript:history.back()">Vissza</a>
    <?php
      include_once($contentDir."/footer.php");
    ?>