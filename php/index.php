<?php
  session_start();
  include_once("includes/config/initial.php");
  $user = new User();
  if(isset($_GET["logout"]) && $_GET["logout"]==1){
    $user->logout();
  }
  $permissions=$user->getPermissions();
  $page=new Page($permissions);
  include_once("container.php");
?>