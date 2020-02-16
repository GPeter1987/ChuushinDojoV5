<?php
  class User{
    private $id;
    private $permissions;
    /* Defining permissions:
     * first char: Is visible to guests? (0/1)
     * second char: Is visible to members? (0/1)
     * third char: Is visible to trainers? (0/1)
     * last char: Is visible to admins? (0/1)
     * Example of guest user permission mask: 1___
     */
    
    public function __construct() {
      //set default values
      global $conn;
      $this->id = 0;
      $this->permissions = "1___";
      $permTable=array("tag" => "_1__", "edző" => "__1_", "admin" => "___1");
      
      if(isset($_SESSION["userid"], $_SESSION["userperm"])){
        //user already logged in
        $this->id = $_SESSION["userid"];
        $this->permissions = $_SESSION["userperm"];
      }
      else{
        if(isset($_POST["user"]) and isset($_POST["pass"])){
          //user is trying to log in, if the credentials match, let them in
          $user = $conn->real_escape_string($_POST["user"]);
          $pass = $conn->real_escape_string($_POST["pass"]);
          $sql = "select * from ".USERS." where felhasznalonev='$user' and jelszo=password('$pass')";
          $res = $conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
          if($res->num_rows){
            $data=$res->fetch_assoc();
            $this->id = $data["id"];
            $this->permissions = $permTable[$data["jog"]];
            $_SESSION["userid"] = $this->id;
            $_SESSION["userperm"] = $this->permissions;
          }
        }
      }
    }
  
    public function isLoggedIn(){
      if ($this->id == 0)
        return false;
      else
        return true;
    }
    
    public function getUserId(){
      return $this->id;
    }
    
    public function getPermissions(){
      return $this->permissions;
    }
    
    public function getName(){
      global $conn;
      
      if($this->id == 0){
        $name = "";
      }
      else{
        $sql = "select * from ".USERS." where id=".$this->id;
        $res = $conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
        if($res->num_rows){
          $name=$res->fetch_assoc()["nev"];
        }
        else $name="Nincs név.";
      }
      return $name;
    }
    
    public function logout(){
      unset($_SESSION["userid"]);
      unset($_SESSION["userperm"]);
      $this->id = 0;
      $this->permissions = "1___";
    }
  }
?>