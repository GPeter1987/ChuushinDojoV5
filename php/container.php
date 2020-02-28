<?php
  if(isset($_GET["pid"])){
    if(!$page->pageExists($_GET["pid"]))
      header("location: ?pid=404");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $page->getTitle()." | "; ?>Chuushin Dojo</title> 
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
    <link rel="stylesheet" type="text/css" href="css/header.css">
      <!-- Body CSS -->
    <link rel="stylesheet" type="text/css" href="css/bodyBg.css">
      <!-- Slideshow CSS -->
    <link rel="stylesheet" type="text/css" href="css/slideshow.css">
      <!-- Content CSS -->
    <link rel="stylesheet" type="text/css" href="css/content.css">
      <!-- Footer CSS -->
    <link rel="stylesheet" type="text/css" href="">
    <!-- Used colors ==> Grey: #E9EBEE, White: #FFFFFF, Blue: #36374B  -->
    
    <!-- FontAwesome link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    
    
  </head>
  
  <body>
    
    <?php
      include_once("content/header.php");
    ?>
    
    <div id="slideShow">
      
      <!--<img name="slide" width="400" height="400"/>-->
      
    </div>
    
    <article>
    <?php
      echo "<h1>".$page->getTitle()."</h1>";
      include_once(CONTENT_DIR."/".$page->getFileName());
    ?>
    </article>
    
    <!--<img id="backgroundImg" src="img/nishioTransparentPng.png" alt="Nishio sensei is performing a technique with a partner"/>-->
    
    <?php
      include_once("content/footer.php");
    ?>
    
    <script src = "includes/js/slideShow.js"> </script>
  
    <script>
    
      //window.onload = changePic;
      
    </script>
    
  </body>
</html>