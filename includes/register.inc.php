
<?php
require_once "dbc.inc.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/SMTP.php';


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
        $sql = "INSERT INTO userinfo (username, password, email, firstname, secondname, verification_token,
         vt_expires_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.php?error=stmtfailed");
            exit();
        }
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        $verifyID = md5(uniqid(rand(), true));
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sssssss", $username, $hashedPass, $email, $firstname, $secondname, $verifyID, $expiresAt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['allowedAccess'] = true;
        $userId = mysqli_insert_id($connection);

        $verifyLink = "https://localhost/WebForApp/includes/verify.inc.php?token=$verifyID";
        $subject = "AeroGuide verification";
        $message = "Click the following link to verify your account: <a href=$verifyLink>THIS</a>";
        // $message = "Click the following link to verify your account: <a href=\"$verifyLink\">THIS</a>";
            

        $phpmailer = new PHPMailer(true);
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = "";
        $phpmailer->Password = "";
        $phpmailer->SMTPSecure = "ssl";
        $phpmailer->Port = 465;
        $phpmailer->setFrom("");
        $phpmailer->addAddress($email);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = $subject;
        $phpmailer->Body = $message;
        $phpmailer->send();

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