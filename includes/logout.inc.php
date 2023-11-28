<?php

session_start();

class LogoutUser
{
    public function __construct()
    {
        $this->logoutUser();
    }

    private function logoutUser()
    {
        $_SESSION = array();
        session_destroy();

        header("location: ../login.php");
        exit(); 
    }
}


$logoutUser = new LogoutUser();