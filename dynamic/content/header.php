<?php
  global $rootDir;
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $page->getTitle()." | "; ?>Dojo kezelő</title> 
    <meta name="TITLE" content="Chuushin Dojo"/>
    <meta name="DESCRIPTION" content="Ceglédi aikido dojo honlapja."/>
    <meta name="KEYWORDS" content="aikido, sport, cegléd, cegled, testmozgás, kard, bot, harcművészet, harcmuveszet, edzes, edzés"/>
    <meta name="CONTENT-TYPE" charset="utf-8"/>
    <meta name="ROBOTS" content="index"/>
    <meta name="AUTHOR" content="Chuushin Dojo"/>
    <meta name="COPYRIGHT" content="Chuushin Dojo"/>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
      <!-- CSS ==> font-family: 'Roboto', sans-serif; -->
      <!-- Header CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $rootDir; ?>css/header.css">
      <!-- Body CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $rootDir; ?>css/bodyBg.css">
      <!-- Slideshow CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $rootDir; ?>css/slideshow.css">
      <!-- Content CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $rootDir; ?>css/content.css">
      <!-- Footer CSS -->
    <link rel="stylesheet" type="text/css" href="">
    <!-- Used colors ==> Grey: #E9EBEE, White: #FFFFFF, Blue: #36374B  -->
    
    <!-- FontAwesome link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    
    
  </head>
  
  <body>
  <header>
    <nav>
      <!--<img id="bannerLogo" src="img/logoTransparentBgPng.png" alt="The logo of the dojo"/>-->
      <ul id="menu">
        <?php
          echo $page->getPageMenu();
        ?>
      </ul>
      <?php
        if($user->isLoggedIn()){
      ?>
        <a href="?pid=1&logout=1"><img src="<?php echo $rootDir."img/logout.png"; ?>" title="Kilépés" alt="Kilépés" /></a>
      <?php
        }
      ?>
    </nav>
  </header>
  <?php
    if($page->getTitle()!="Bejelentkezés"){
      $user->getMsg();
      $user->clearMsg();
    }
  ?>