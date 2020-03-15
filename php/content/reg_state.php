<?php
	if(!isset($_SESSION["reg_success"])){
		header("location: index.php");
		exit;
	}
?>
<h3>Sikeres regisztráció!</h3>
<p>Addig nem tudsz bejelentkezni, amíg egy admin nem aktiválja a fiókod.</p>