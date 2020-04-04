<?php
  session_start();
  global $contentDir;
  include_once($contentDir."includes/config/initial.php");
  $user = new User();
  $permissions=$user->getPermissions();
  $page=new Page($permissions);
  
?>
    <?php
      include_once($contentDir."/header.php");
    ?>
    
    <div id="slideShow">
      
      <!--<img name="slide" width="400" height="400"/>-->
      
    </div>
    
    <article>
    <?php
      if(isset($_GET["redirect"])){
        $redirect=$conn->real_escape_string($_GET["redirect"]);
        if(file_exists($contentDir."/".$redirect.".php"))
          include_once($contentDir."/".$redirect.".php");
        else header("location: ?pid=404");
		exit();
      }
    ?>
	  <h1>Elfelejtett jelszó</h1>
	  <p>Ha elfelejtetted a jelszavad, írd be az alábbi mezőbe az e-mail címed, és
	  kapni fogsz egy e-mailt a jelszó változtatáshoz szükséges teendőkkel.</p>
	  <form method="post" action="request-password-reset.php">
		E-mail cím: <input type="email" name="email" placeholder="Regisztrált e-mail cím." /><br />
		<input type="submit" name="request-pass-reset" value="Új jelszó kérése" />
	  </form>
	  <?php
		if(isset($_GET["error"])){
		  $error=$_GET["error"];
		  ?>
		  <div>
			<?php
			  if($error=="noemail")
				echo "Az e-mail cím megadása kötelező!";
			  else if($error=="wrongformat")
				echo "Az e-mail cím formátuma nem megfelelő!";
			?>
		  </div>
		  <?php
		}
	  ?>
    </article>
    
    <!--<img id="backgroundImg" src="img/nishioTransparentPng.png" alt="Nishio sensei is performing a technique with a partner"/>-->
    <a href="javascript:history.back()">Vissza</a>
    <?php
      include_once($contentDir."/footer.php");
    ?>