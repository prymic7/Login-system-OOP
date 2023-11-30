
<?php

include "registerfunctions.inc.php";
require_once "dbc.inc.php";
class LoginUser
{
    private $password;
    private $username;
    private $connection;

    public function __construct($username, $password, $connection)
    {
        $this->username = $username;
        $this->password = $password;
        $this->connection = $connection;

        $this->checkCredentials();
    }

    public function usernameExists()
    {
        $sql = "SELECT * FROM userinfo WHERE username = ? OR email = ?";
        $stmt = mysqli_stmt_init($this->connection);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=usernameExists");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $this->username, $this->username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        if($row)
        {
            return $row;
        }
        else
        {
            return false;
        }
        return false;
    }

    public function checkCredentials()
    {
        $usernameExists = $this->usernameExists();
        if(!$usernameExists)
        {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        else if(!$this->checkVerification())
        {
            header("location:../login.php?error=accountnotverified");
            exit();
        }
        else
        {
            $hashed_pass = $usernameExists["password"];
            $passMatch = password_verify($this->password, $hashed_pass);
            if($hashed_pass == $this->password)
            {
                $passMatch = true;
            }
            if(!$passMatch)
            {
                header("location: ../login.php?error=passdontmatch");
            }
            else
            {
                session_start();
                $_SESSION["id"] = $usernameExists["id"];
                $_SESSION["username"] = $usernameExists["username"];
                header("location: ../home.php");
            }
        }
    }

    public function checkVerification()
    {
        $sql = "SELECT verified FROM userinfo WHERE username = ?";
        $stmt = mysqli_stmt_init($this->connection);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location: ../register.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $this->username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);

        mysqli_stmt_close($stmt);

        if($row["verified"] == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if(isset($_POST["submit"]))
{
    $username = $_POST["username"]; 
    $password = $_POST["password"];

    $loginUser = new LoginUser($username, $password, $connection);
}

?>