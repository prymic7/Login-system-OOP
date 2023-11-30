<?php

class CheckError
{
    private $errorFoundStr;
    public function __construct($errorStr)
    {
        switch($errorStr)
        {
            case "emptyinput":
                $this->errorFoundStr = "Vyplňte všechny pole.";
                break;
            case "invalidusername":
                $this->errorFoundStr = "Vaše uživatelské jméno obsahuje neplatný znak.";
                break;
            case "invalidemail":
                $this->errorFoundStr = "Zadejte prosím správný email.";
                break;
            case "passwdMatch":
                $this->errorFoundStr = "Vaše hesla se neshodují.";
                break;
            case "usernameexists":
                $this->errorFoundStr = "Email nebo uživatelské jméno je již obsazeno.";
                break;
            case "toolongusername":
                $this->errorFoundStr = "Zvolte kratší jméno. Jméno je příliš dlouhé.";
                break;
            case "wronglogin":
                $this->errorFoundStr = "Špatné uživatelské jméno nebo heslo.</p>";
                break;
            case "passdontmatch":
                $this->errorFoundStr = "Password dont match.";
                break;
        }
    }

    public function getError()
    {
        return $this->errorFoundStr;
    }
}
?>