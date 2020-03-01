<?php
  if(isset($_POST["sess_torol"])){
    session_destroy();
  }
  $months=["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];
?>
<p>
  Amennyiben tagja vagy a Chuushin dojónak, kérlek, regisztrálj az alábbi űrlapon!
</p>
<p>
  Minden mezőt kötelező kitölteni!
</p>
<form action="content/reg_process.php" method="post">
  
  <label for="reg_user">Felhasználónév: </label>
  <input type="text" name="reg_user" value="<?php if(isset($_SESSION["reg_user"])) echo $_SESSION["reg_user"]["val"]; ?>" />
  <div>Legalább 5 karakter, csak ékezetmentes kisbetűt (az elején), pontot (.), alulvonást (_) és számot tartalmazhat.</div>
  <p><?php if(isset($_SESSION["reg_user"])) echo $_SESSION["reg_user"]["err_msg"]; ?></p>
  
  <label for="fullName">Teljes név: </label>
  <input type="text" name="fullName" value="<?php if(isset($_SESSION["fullName"])) echo $_SESSION["fullName"]["val"]; ?>" />
  <p><?php if(isset($_SESSION["fullName"])) echo $_SESSION["fullName"]["err_msg"]; ?></p>
  
  <label for="birthYear">Születési dátum: </label>
  <input type="number" name="birthYear" minlength="4" maxlength="4" min="1900" max="<?php echo date("Y"); ?>" placeholder="Év" value="<?php if(isset($_SESSION["birthYear"])) echo $_SESSION["birthYear"]["val"]; ?>" />
  <select name="birthMonth">
    <option value=0>Hónap</option>
    <?php
    foreach($months as $i => $val){
      echo "<option value=".($i+1);
      if(isset($_SESSION["birthMonth"])){
        if($_SESSION["birthMonth"]["val"]==($i+1)) echo " selected";
      }
      echo ">".$val."</option>";
    }
    ?>
  </select>
  <select name="birthDay">
    <option value=0>Nap</otion>
    <?php
    for($i=1; $i<=31; $i++){
      echo "<option value=".$i;
      if(isset($_SESSION["birthDay"])){
        if($_SESSION["birthDay"]["val"]==$i) echo " selected";
      }
      echo ">".$i."</option>";
    }
    ?>
  </select>
  <p><?php if(isset($_SESSION["birthDate"])) echo $_SESSION["birthDate"]["err_msg"]; ?></p>
  
  <label for="reg_pass">Jelszó: </label>
  <input type="password" name="reg_pass" />
  <div>A jelszónak legalább 8 karakter hosszúnak kell lennie, nem tartalmazhatja a születési dátumot és a felhasználónevet!</div>
  <p><?php if(isset($_SESSION["reg_pass"])) echo $_SESSION["reg_pass"]["err_msg"]; ?></p>
  
  <label for="passAgain">Jelszó újra: </label>
  <input type="password" name="passAgain" />
  <p><?php if(isset($_SESSION["passAgain"])) echo $_SESSION["passAgain"]["err_msg"]; ?></p>
  
  <input type="hidden" name="reg_id" value="<?php echo $_GET["pid"]; ?>" />
  <p>
    <input type="submit" name="submit" value="Regisztráció" />
  </p>
</form>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]."?pid=7"; ?>">
  <input type="submit" value="Session töröl" name="sess_torol" />
</form>