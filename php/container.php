<?php
  if(isset($_GET["pid"])){
    if(!$page->pageExists($_GET["pid"]))
      header("location: ?pid=404");
  }
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
        $redirect=sanitize($_GET["redirect"]);
        if(file_exists($contentDir."/".$redirect.".php"))
          include_once($contentDir."/".$redirect.".php");
        else header("location: ?pid=404");
      }
      else{
        if($user->hasAccess($page->getPid()) || $page->getTitle()=="404" || $page->getTitle()=="Tagoknak"){
          echo "<h1>".$page->getTitle()."</h1>";
          include_once($contentDir."/".$page->getFileName());
        }
        else echo "<div>A kért tartalom eléréséhez nincs engedély.</div>";
      }
    ?>
    </article>
    
    <!--<img id="backgroundImg" src="img/nishioTransparentPng.png" alt="Nishio sensei is performing a technique with a partner"/>-->
    
    <?php
      include_once($contentDir."/footer.php");
    ?>