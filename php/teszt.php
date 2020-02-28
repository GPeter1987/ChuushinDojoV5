<?php
  if(isset($_POST["pass"])){
    $jelszo=$_POST["pass"];
    
    if(!preg_match("/^[a-z]+[0-9]*(\.|_)*[a-z0-9]*(\.|_)*[a-z0-9]*$/", $jelszo))
      echo "Nem felel meg!";
    else echo "Megfelel.";
  }

?>
  <form method="post" action="teszt.php">
    <input type="text" name="pass" placeholder="Jelszó" value="<?php if(isset($_POST["pass"])) echo $_POST["pass"]; ?>" />
    <input type="submit" value="Próba" name="submit" />
  </form>
<?php
  exit();
  
  $beiratkozas=strtotime("2019-05-04");
  $szuletes=strtotime(date("Y-m-d"));//strtotime("2019-05-3");
  $mp=$beiratkozas-$szuletes;
  if($beiratkozas<=$szuletes) echo "Hiba, a beiratkozás dátuma<=születési dátum!";
  else echo "Minden oké";
  
  $adatok=array(
    array("szoveg" => ".betuk", "celertek" => 0),
    array("szoveg" => "_betuk", "celertek" => 0),
    array("szoveg" => "3betuk", "celertek" => 0),
    array("szoveg" => "34betuk", "celertek" => 0),
    array("szoveg" => ".betuk_", "celertek" => 0),
    array("szoveg" => "_betuk.", "celertek" => 0),
    array("szoveg" => "3betuk_", "celertek" => 0),
    array("szoveg" => "3betuk.", "celertek" => 0),
    array("szoveg" => ".betuk_3", "celertek" => 0),
    array("szoveg" => "_betuk3.", "celertek" => 0),
    array("szoveg" => "3betuk_.", "celertek" => 0),
    array("szoveg" => "abcF3._", "celertek" => 0),
    array("szoveg" => "abc3@._", "celertek" => 0),
    array("szoveg" => "ab c3._", "celertek" => 0),
    array("szoveg" => "afjűso", "celertek" => 0),
    array("szoveg" => "afjso", "celertek" => 1),
    array("szoveg" => "as.dof", "celertek" => 1),
    array("szoveg" => "jof_osa", "celertek" => 1),
    array("szoveg" => "sof._sof", "celertek" => 1),
    array("szoveg" => "a.dof", "celertek" => 1),
    array("szoveg" => "j_osa", "celertek" => 1),
    array("szoveg" => "s._sof", "celertek" => 1),
    array("szoveg" => "abc123", "celertek" => 1),
    array("szoveg" => "a123", "celertek" => 1),
    array("szoveg" => "abc__", "celertek" => 1),
    array("szoveg" => "abc..", "celertek" => 1),
    array("szoveg" => "abc_.", "celertek" => 1),
    array("szoveg" => "abc_3", "celertek" => 1),
    array("szoveg" => "abc.3", "celertek" => 1),
    array("szoveg" => "abc_.3", "celertek" => 1),
    array("szoveg" => "abc_3.", "celertek" => 1),
    array("szoveg" => "abc._3", "celertek" => 1),
    array("szoveg" => "abc.3_", "celertek" => 1),
    array("szoveg" => "abc3_.", "celertek" => 1),
    array("szoveg" => "abc3._", "celertek" => 1)
  );
?>
<p>Kritériumok:</p>
<ul>
  <li>csak kisbetűt, pontot, alulvonást, számot tartalmazhat</li>
  <li>csak betű lehet az elején</li>
</ul>

<table>
  <tr><th>Teszt adat</th><th>Célérték</th><th>Megfelel?</th></tr>
<?php
  foreach($adatok as $sor){
    echo "<tr>";
    echo "<td>".$sor["szoveg"]."</td><td>".$sor["celertek"]."</td><td>";
    if(preg_match("/^[a-z]+(\.|_)*[a-z]*[0-9]*[a-z]*(\.|_)*[a-z]*$/", $sor["szoveg"])==false)
      echo 0;
    else echo 1;
    //var_dump($eredmeny);
    echo "</td></tr>";
  }
?>
<table>