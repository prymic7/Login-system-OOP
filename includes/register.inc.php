
<?php
include "registerfunctions.inc.php";
require_once "dbc.inc.php";

class RegisterUser
{
    private $goCreate = true;
    private $userId;

    public function getUserID()
    {
        return $this->userId;
    }

    public function __construct($username, $pass1, $pass2, $email, $datebirth, $firstname, $secondname, $connection)
    {

        if(isset($_POST["submit"]))
        {


            if($this->emptyInputString($username, $pass1, $email, $datebirth, $firstname, $secondname))
            {
                header("location: ../register.php?error=emptyinput");
                $this->goCreate = false;
                exit();
            }
            if($this->invalidUsername($username))
            {
                header("location: ../register.php?error=invalidusername");
                $this->goCreate = false;
                exit();

            }
            if($this->invalidEmail($email))
            {
                header("location: ../register.php?error=invalidemail");
                $this->goCreate = false;
                exit();

            }
            if($this->passwdMatch($pass1, $pass2))
            {
                header("location: ../register.php?error=passwdMatch");
                $this->goCreate = false;
                exit();

            }
            if($this->tooLongUsername($username))
            {
                header("location: ../register.php?error=toolongusername");
                $this->goCreate = false;
                exit();

            }
            if($this->goCreate)
            {
                $this->userId = $this->createUser($connection, $username, $pass1, $email, $datebirth, $firstname, $secondname);
                header("location: ../login.php");
            }
        }
        else
        {
            header("location: ../register.php");
            exit();
        }
    }

    public function emptyInputString($username, $password, $email, $date, $firstname, $secondname)
    {
        if(empty($username) || empty($password) || empty($email) || empty($date) || empty($firstname) || empty($secondname) )
        {
            return true;
        }
        return false;
    }

    public function invalidUsername($username)
    {
        if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            return true;
        }
        return false;

    }

    public function invalidEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        return false;
    }

    public function passwdMatch($pass1, $pass2)
    {
        return $pass1 !== $pass2;
    }

    public function tooLongUsername($username)
    {
        if(strlen($username) > 17)
        {
            return true;
        }
        return false;
    }

    public function createUser($connection, $username, $password, $email, $datebirth, $firstname, $secondname)
    {
        $sql = "INSERT INTO userinfo (username, password, email, firstname, secondname) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.php?error=stmtfailed");
            exit();
        }
    
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sssss", $username, $hashedPass, $email, $firstname, $secondname);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['allowedAccess'] = true;
        $userId = mysqli_insert_id($connection);
        return $userId;
    }
}

if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $email = $_POST["email"];
    $datebirth = $_POST["datebirth"];
    $firstname = $_POST["firstname"];  
    $secondname = $_POST["secondname"]; 
    $register = new RegisterUser($username, $password1, $password2, $email, $datebirth, $firstname, $secondname, $connection);
}






?>