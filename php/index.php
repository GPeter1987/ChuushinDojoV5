<?php
  session_start();
  include_once("includes/config/initial.php");
  $user = new User();
  $permissions=$user->getPermissions();
  $page=new Page($permissions);
  include_once("container.php");
?>