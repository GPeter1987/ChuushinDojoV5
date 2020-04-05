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
    
    public function __construct(){
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
        //user is trying to log in, if the credentials match, let him/her in
        if(isset($_POST["user"]) and isset($_POST["pass"])){
          $user = sanitize($_POST["user"]);
          $pass = sanitize($_POST["pass"]);
          if($user!="" && $pass!=""){
            $sql = "select * from ".USERS." where felhasznalonev='$user'";
            $res = $conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
            
            //if the user exists
            if($res->num_rows){
              $data=$res->fetch_assoc();
              $salt=$data["so"];
              $dbPass=$data["jelszo"];
              
              //if the user profile is active
              if($data["aktiv"]=="1"){
                //if the passwords match
                if(crypt($pass,$salt)==$dbPass){
                  $this->id = $data["id"];
                  $this->permissions = $permTable[$data["jog"]];
                  $_SESSION["userid"] = $this->id;
                  $_SESSION["userperm"] = $this->permissions;
                  $this->setMsg("<div class='siker'>Sikeres bejelentkezés.</div>");
                }
                else $this->setMsg("<div class='hiba'>Helytelen felhasználónév vagy jelszó!</div>");
              }
              else $this->setMsg("<div class='hiba'>A felhasználó (még) inaktív! Adminisztrátori jóváhagyás szükséges.</div>");
            }
            else $this->setMsg("<div class='hiba'>Helytelen felhasználónév vagy jelszó!</div>");
          }
          else $this->setMsg("<div class='hiba'>A bejelentkezési adatok kitöltése kötelező!</div>");
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
        $sql = "select nev from ".USERS." where id=".$this->id;
        $res = $conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
        if($res->num_rows){
          $name=$res->fetch_assoc()["nev"];
        }
        else $name="Nincs név.";
      }
      return $name;
    }
    
    public function getData(){
      global $conn;
      
      if($this->id == 0){
        return false;
      }
      else{
        $sql = "select * from ".USERS." where id=".$this->id;
        $res = $conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
        if($res->num_rows){
          $data=$res->fetch_assoc();
        }
        else return false;
      }
      return $data;
    }
    
    public function validateRegister($data){
      global $conn;
      $modData=$data;
      $success=true;
      //exclude reg_id and submit values from validation
      unset($modData["reg_id"]);
      unset($modData["submit"]);
      
      //loop through the given data
      foreach($modData as $attr_name => $val){
        $msg="";
        $val=sanitize($val);
        //defining error cases
        if($val==""){
          $success=false;
          $msg="Hiba: A mező kitöltése kötelező!";
        }
        else{
          if($attr_name=="reg_user"){
            //in case of wrong format or length
            if(!preg_match("/^[a-z]+[0-9]*(\.|_)*[a-z0-9]*(\.|_)*[a-z0-9]*$/", $val) || strlen($val)<5){
              $success=false;
              $msg="Hiba: A felhasználónév formátuma nem megfelelő!";
            }
            else{
              $res=$conn->query("select * from ".USERS." where felhasznalonev='$val'") or die($conn->error." on line <b>".__LINE__."</b>");
              //if the chosen user name is taken
              if($res->num_rows){
                $success=false;
                $msg="Ez a felhasználónév már létezik! Válassz másikat!";
              }
            }
          }
          else if($attr_name=="fullName"){
            //check if full name contains a space
            //if not, it's in wrong format
            if(strpos($val," ")===false){
              $success=false;
              $msg="Hiba: Hiányzó vezetéknév vagy keresztnév!";
            }
            else{
              $tmp=explode(" ",mb_strtolower($val));
              $tmp[0][0]=mb_strtoupper($tmp[0][0]);
              $tmp[1][0]=mb_strtoupper($tmp[1][0]);
              $modData[$attr_name]=implode(" ",$tmp);
              $val=implode(" ",$tmp);
            }
          }
          else if($attr_name=="email"){
            //check e-mail format
            if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
              $success=false;
              $msg="Hiba: Az e-mail cím formátuma nem megfelelő!";
            }
          }
          else if($attr_name=="birthYear"){
            //check birth year format and value (range between 1900 and the current year)
            if(strlen($val)!=4 || !is_numeric($val) || $val>date("Y") || $val<1900){
              $success=false;
              $msg="error";
            }
          }
          else if($attr_name=="birthMonth"){
            //check if the birth month was selected
            if($val==0){
              $success=false;
              $msg="error";
            }
          }
          else if($attr_name=="birthDay"){
            //check if the birth day was selected
            if($val==0){
              $success=false;
              $msg="error";
            }
          }
          else if($attr_name=="reg_pass"){
            //check for the password containing birth date
            $dotFormat=strpos($val, $modData["birthYear"].".".$modData["birthMonth"].".".$modData["birthDay"])!==false;
            $slashFormat=strpos($val, $modData["birthYear"]."/".$modData["birthMonth"]."/".$modData["birthDay"])!==false;
            $dashFormat=strpos($val, $modData["birthYear"]."-".$modData["birthMonth"]."-".$modData["birthDay"])!==false;
            $noFormat=strpos($val, $modData["birthYear"].$modData["birthMonth"].$modData["birthDay"])!==false;
            
            //in case of wrong format
            if(!preg_match("/^.*(?=.*\d).*(?=.*\d).{8,}$/", $val)){
              $success=false;
              $msg="Hiba: Rossz a jelszó hossza vagy formátuma!";
            }
            else if($dotFormat || $slashFormat || $dashFormat || $noFormat){
              //if password contains the birth date in any of the formats mentioned above
              $success=false;
              $msg="Hiba: A jelszó nem tartalmazhatja a születési dátumot!";
            }
            else if(strpos($val, $modData["reg_user"])!==false){
              //if password contains the user name
              $success=false;
              $msg="Hiba: A jelszó nem tartalmazhatja a felhasználónevet!";
            }
          }
          else if($attr_name=="passAgain"){
            //check if the two passwords match
            if($val!=$modData["reg_pass"]){
              $success=false;
              $msg="Hiba: A jelszavak nem egyeznek!";
            }
          }
        }
        $_SESSION[$attr_name]=array("val" => $val, "err_msg" => $msg);
      }
      
      $birthDate=strtotime($modData["birthYear"]."-".$modData["birthMonth"]."-".$modData["birthDay"]);
      $birthParts=!($_SESSION["birthYear"]["err_msg"]=="error" || $_SESSION["birthMonth"]["err_msg"]=="error" || $_SESSION["birthDay"]["err_msg"]=="error" || $birthDate>strtotime(date("Y-m-d")));
      $msg="";
      //if error happened to any of the birth date parts or the date is greater than the current date
      if(!$birthParts)
        $msg="Hiba: A születési dátum formátuma vagy értéke nem megfelelő!";
      $_SESSION["birthDate"]=array("val" => $modData["birthYear"]."-".$modData["birthMonth"]."-".$modData["birthDay"], "err_msg" => $msg);
      
      $modData["birthDate"]=$modData["birthYear"]."-".$modData["birthMonth"]."-".$modData["birthDay"];
      unset($modData["birthYear"]);
      unset($modData["birthMonth"]);
      unset($modData["birthDay"]);
    
      if($success){
        foreach($modData as $attr => $val){
          if(isset($_SESSION[$attr])) unset($_SESSION[$attr]);
        }
        return $modData;
      }
      else return false;
    }
    
    public function register($data){
      global $conn;
      $user=$data["reg_user"];
      $salt=time();
      $pass=crypt($data["reg_pass"],$salt);
      $name=$data["fullName"];
      $email=$data["email"];
      $birthDate=$data["birthDate"];
      
      $sql = "insert into ".USERS." (felhasznalonev, jelszo, so, nev, email, szuletesi_datum)
      values ('$user','$pass',$salt,'$name','$email','$birthDate')";
      $res = $conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");
      
      if($res){
        $_SESSION["reg_success"]=true;
        header("location: ../index.php?redirect=reg_state");
      }
    }
    
    public function setMsg($msg){
      $_SESSION["msg"]=$msg;
    }
    
    public function getMsg(){
      if(isset($_SESSION["msg"])) return $_SESSION["msg"];
      else return "";
    }
    
    public function clearMsg(){
      unset($_SESSION["msg"]);
    }
    
    public function hasAccess($pid){
      global $conn;
      
      if(is_null($pid))
        return false;
      
      $perm=$this->getPermissions();
      $sql = "select * from ".PAGES." where id=$pid and jogok like '".$perm."'";
      $res=$conn->query($sql) or die($conn->error." on line <b>".__LINE__."</b>");

      if($res->num_rows)
        return true;
      else
        return false;
    }
    
    public function logout(){
      unset($_SESSION["userid"]);
      unset($_SESSION["userperm"]);
      $this->id = 0;
      $this->permissions = "1___";
      $this->setMsg("<div class='siker'>Sikeres kijelentkezés.</div>");
    }
  }
?>