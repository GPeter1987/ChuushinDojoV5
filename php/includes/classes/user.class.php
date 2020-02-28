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
    
    public function validateRegister($data){
      global $conn;
      $modData=$data;
      $success=true;
      //loop through the given data
      foreach($modData as $attr_name => $val){
        //exclude reg_id and submit values from validation
        if($attr_name!="reg_id" && $attr_name!="submit"){
          $val=$conn->real_escape_string(htmlspecialchars(stripslashes(trim($val))));
          //defining error cases
          if($val==""){
            $success=false;
            $msg="Hiba: a mező kitöltése kötelező!";
            $_SESSION[$attr_name]=array("val" => $val, "err_msg" => $msg);
          }
          else{
            if($attr_name=="reg_user"){
              if(!preg_match("/^[a-z]+[0-9]*(\.|_)*[a-z0-9]*(\.|_)*[a-z0-9]*$/", $val) || strlen($val)<5){
                $success=false;
                $msg="Hiba: a felhasználónév formátuma nem megfelelő!";
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => $msg);
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            else if($attr_name=="fullName"){
              //check if full name contains a space
              //if not, it's in wrong format
              if(strpos($val," ")===false){
                $success=false;
                $msg="Hiba: hiányzó vezetéknév vagy keresztnév!";
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => $msg);
              }
              else{
                $tmp=explode(" ",mb_strtolower($val));
                $tmp[0][0]=mb_strtoupper($tmp[0][0]);
                $tmp[1][0]=mb_strtoupper($tmp[1][0]);
                $modData[$attr_name]=implode(" ",$tmp);
                $val=implode(" ",$tmp);
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            else if($attr_name=="birthYear"){
              if(strlen($val)!=4 || !is_numeric($val) || $val>date("Y") || $val<1900){
                $success=false;
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "error");
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            else if($attr_name=="birthMonth"){
              if($val==0){
                $success=false;
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "error");
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            else if($attr_name=="birthDay"){
              if($val==0){
                $success=false;
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "error");
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            /*else if($attr_name=="signInYear"){
              if(strlen($val)!=4 || !is_numeric($val) || $val>date("Y") || $val<1900){
                $success=false;
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "error");
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            else if($attr_name=="signInMonth"){
              if($val==0){
                $success=false;
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "error");
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }
            else if($attr_name=="signInDay"){
              if($val==0){
                $success=false;
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "error");
              }
              else{
                $_SESSION[$attr_name]=array("val" => $val, "err_msg" => "");
              }
            }*/
            else if($attr_name=="reg_pass"){
              
            }
            else if($attr_name=="passAgain"){
              
            }
          }
          //echo $attr_name."=".$val."<br />";
          /*if(isset($_SESSION[$attr_name])){
            $_SESSION[$attr_name]["val"].": ".
            echo $_SESSION[$attr_name]["err_msg"]."<br />";
          }*/
        }
      }
      
      $birthDate=strtotime($modData["birthYear"]."-".$modData["birthMonth"]."-".$modData["birthDay"]);
      //$signInDate=strtotime($modData["signInYear"]."-".$modData["signInMonth"]."-".$modData["signInDay"]);
      $birthParts=!($_SESSION["birthYear"]["err_msg"]=="error" || $_SESSION["birthMonth"]["err_msg"]=="error" || $_SESSION["birthDay"]["err_msg"]=="error" || $birthDate>strtotime(date("Y-m-d")));
      //$signInParts=!($_SESSION["signInYear"]["err_msg"]=="error" || $_SESSION["signInMonth"]["err_msg"]=="error" || $_SESSION["signInDay"]["err_msg"]=="error" || $signInDate>strtotime(date("Y-m-d")));
      if(!$birthParts){ //error
        $msg="Hiba: a születési dátum formátuma vagy értéke nem megfelelő!";
        $_SESSION["birthDate"]=array("val" => $modData["birthYear"]."-".$modData["birthMonth"]."-".$modData["birthDay"], "err_msg" => $msg);
      }
      else{
        $_SESSION["birthDate"]=array("val" => $val, "err_msg" => "");
      }
      /*if(!$signInParts){ //error
        $msg="Hiba: a beiratkozási dátum formátuma vagy értéke nem megfelelő!";
        $_SESSION["signInDate"]=array("val" => $modData["signInYear"]."-".$modData["signInMonth"]."-".$modData["signInDay"], "err_msg" => $msg);
      }
      else{
        $_SESSION["signInDate"]=array("val" => $val, "err_msg" => "");
      }*/
      //every parts of both dates are good on their own
      /*if($birthParts && $signInParts){
        if($birthDate>=$signInDate){
          $msg="Hiba: a születési dátum nem lehet későbbi vagy azonos a beiratkozási dátummal!";
          $_SESSION["signInDate"]=array("val" => $modData["signInYear"]."-".$modData["signInMonth"]."-".$modData["signInDay"], "err_msg" => $msg);
        }
      }*/
      
      //return;
      
      if(!$success){
        header("location: ../index.php?pid=".$data["reg_id"]);
      }
      else{
        echo json_encode($modData);
      }
    }
    
    public function register(){
      
    }
    
    public function logout(){
      unset($_SESSION["userid"]);
      unset($_SESSION["userperm"]);
      $this->id = 0;
      $this->permissions = "1___";
    }
  }
?>