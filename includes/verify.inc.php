<?php

require_once "dbc.inc.php";

class Verification
{
    private $vt;
    private $connection;

    public function __construct($vt, $connection)
    {
        $this->vt = $vt;
        $this->connection = $connection;
        $this->setVerification();
    }

    public function setVerification()
    {
        $sql = "UPDATE userinfo SET verified = 1 WHERE verification_token = ?";
        $stmt = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $this->vt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}



if(isset($_GET["token"]))
{
    $vt = $_GET["token"];
    $verification = new Verification($vt, $connection);
    header("location:../login.php");
}
else
{
    header("location:../register.php");
}