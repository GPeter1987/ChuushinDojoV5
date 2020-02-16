<?php
  class Page {
    private $id;
    private $title;
    private $fileName;
    private $permissions;
    
    public function __construct($permissions){
      //set default values (home page)
      global $conn;
      $this->id = 1;
      $this->title = "Főoldal";
      $this->fileName="fooldal.php";
      $this->permissions = $permissions;
      $pid = 1;
      
      //if there is a requested page, get the required information
      if(isset($_GET["pid"])) $pid=$conn->real_escape_string($_GET["pid"]);
      $sql="select * from ".PAGES." where id=$pid and jogok like '".$this->permissions."'";
      $res=$conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");

      if($res->num_rows){
        $this->id=$pid;
        $data=$res->fetch_assoc();
        $this->fileName=$data["fajlnev"];
        $this->title=$data["cim"];
      }
      else{
        $this->id=0;
        $this->title="sfsdfah";
        $this->fileName="justrandomstring0124";
      }
      if(!file_exists("content/".$this->fileName)){
        $this->id=404;
        $this->title="404";
        $this->fileName="nemtalalhato.php";
      }
    }
    
    public function getPid(){
      //get the current page id
      return $this->id;
    }
    
    public function getTitle(){
      //get the current page title
      return $this->title;
    }
    
    public function getFileName(){
      return $this->fileName;
    }
    
    public function getPageMenu(){
      //generate the page menu
      global $conn;
      $sql="select * from ".PAGES." where cim<>'' and jogok like '".$this->permissions."' order by id";
      $res=$conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
      $output="";
      
      while($row=$res->fetch_assoc()){
        $output.="<li class=\"menuBtn";
        if($row["id"]==$this->id) $output.=" current_page_item\"";
        $output.="\"><a href=\"?pid=".$row["id"]."\" title=\"".$row["leiras"]."\">".$row["cim"]."</a></li>";
      }
      return $output;
    }
    
    public function redirect($pid, $permissions){
      //redirect based on the requested page id and current permissions
      global $conn;
      $this->permissions = $permissions;
      $this->title = "";
      $sql = "select * from ".PAGES." where id=$pid and".
             " jogok like '".$permissions."'";
      $res=$conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");

      if($res->num_rows){
        $pid = 1;
      } else {
        $this->title = $res->fetch_assoc()["cim"];
      }
      $this->id = $pid;
      return $pid;
    }
  }
?>