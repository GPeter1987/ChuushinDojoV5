<p>
  A bejelentkezett felhasználó adatai:
</p>
<?php
  $userData=$user->getData();
?>
<table>
  <tr><td>Felhasználónév: </td>
	<td><?php echo $userData["felhasznalonev"]; ?></td>
  </tr>
  <tr><td>Név: </td>
	<td><?php echo $userData["nev"]; ?></td>
  </tr>
  <tr><td>E-mail cím: </td>
	<td><?php echo $userData["email"]; ?></td>
  </tr>
  <tr><td>Születési dátum: </td>
	<td><?php echo $userData["szuletesi_datum"]; ?></td>
  </tr>
  <tr><td>Beiratkozási dátum: </td>
	<td><?php echo ($userData["beiratkozas_datum"]!="") ? $userData["beiratkozas_datum"] : "nincs adat"; ?></td>
  </tr>
  <tr><td>Övfokozat: </td>
	<td><?php echo ($userData["ovfokozat"]!="") ? $userData["ovfokozat"] : "nincs adat"; ?></td>
  </tr>
  <tr><td>Rang: </td>
	<td><?php echo $userData["jog"]; ?></td>
  </tr>
</table>