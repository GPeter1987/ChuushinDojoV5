<?php
  $months=["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"];
?>
<p>
  Amennyiben tagja egy - a rendszer által kezelt - dojónak, kérlek, regisztrálj az alábbi űrlapon!
</p>
<p>
  Minden mezőt kötelező kitölteni!
</p>
<form action="content/reg_process.php" method="post">
  <table>
    <tr>
      <td><label for="reg_user">Felhasználónév: </label></td>
      <td><input type="text" name="reg_user" value="<?php if(isset($_SESSION["reg_user"])) echo $_SESSION["reg_user"]["val"]; ?>" /></td>
    </tr>
    <tr><td colspan="2"><div>Legalább 5 karakter, csak ékezetmentes kisbetűt (az elején), pontot (.), alulvonást (_) és számot tartalmazhat.</div></td></tr>
    <tr><td colspan="2"><?php if(isset($_SESSION["reg_user"])) echo $_SESSION["reg_user"]["err_msg"]; ?></td></tr>
    
    <tr>
      <td><label for="fullName">Teljes név: </label></td>
      <td><input type="text" name="fullName" value="<?php if(isset($_SESSION["fullName"])) echo $_SESSION["fullName"]["val"]; ?>" /></td>
    </tr>
    <tr><td colspan="2"><?php if(isset($_SESSION["fullName"])) echo $_SESSION["fullName"]["err_msg"]; ?></td></tr>
    
    <tr>
      <td><label for="email">E-mail cím: </label></td>
      <td><input type="email" name="email" value="<?php if(isset($_SESSION["email"])) echo $_SESSION["email"]["val"]; ?>" /></td>
    </tr>
    <tr><td colspan="2"><div>Valódi e-mail címnek kell lennie, amit használsz.</div></td></tr>
    <tr><td colspan="2"><?php if(isset($_SESSION["email"])) echo $_SESSION["email"]["err_msg"]; ?></td></tr>
    
    <tr>
      <td><label for="birthYear">Születési dátum: </label></td>
      <td><input type="number" name="birthYear" minlength="4" maxlength="4" min="1900" max="<?php echo date("Y"); ?>" placeholder="Év" value="<?php if(isset($_SESSION["birthYear"])) echo $_SESSION["birthYear"]["val"]; ?>" />
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
      </select></td>
    </tr>
    <tr><td colspan="2"><?php if(isset($_SESSION["birthDate"])) echo $_SESSION["birthDate"]["err_msg"]; ?></td></tr>
    
    <tr>
      <td><label for="reg_pass">Jelszó: </label></td>
      <td><input type="password" name="reg_pass" /></td>
    </tr>
    <tr><td colspan="2"><div>A jelszónak legalább 8 karakter hosszúnak kell lennie (ebből min. 2 számjegy), nem tartalmazhatja a születési dátumot és a felhasználónevet!</div></td></tr>
    <tr><td colspan="2"><?php if(isset($_SESSION["reg_pass"])) echo $_SESSION["reg_pass"]["err_msg"]; ?></td></tr>
    
    <tr>
      <td><label for="passAgain">Jelszó újra: </label></td>
      <td><input type="password" name="passAgain" /></td>
    </tr>
    <tr><td colspan="2"><?php if(isset($_SESSION["passAgain"])) echo $_SESSION["passAgain"]["err_msg"]; ?></td></tr>

    <tr>
      <td><a href="javascript:history.back()">Vissza</a></td>
      <td><input type="submit" name="submit" value="Regisztráció" /></td>
    </tr>
  </table>
  <input type="hidden" name="reg_id" value="<?php echo $_GET["pid"]; ?>" />
</form>
<?php
  clearErrors();
?>