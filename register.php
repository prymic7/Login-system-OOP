
<?php
    include 'header.php';

    if($user_logged)
    {
        header("location: home.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="main-div">
        <div class="register-div-outter">
            <div class="register-div-inner">
                <form action="includes/register.inc.php" method="POST" name="registerform">
                    <input type="text" name="username" placeholder="Username"><br>
                    <input type="password" name="password1" placeholder="Password"><br>
                    <input type="password" name="password2" placeholder="Password again"><br>
                    <input type="email" name="email" placeholder="Email"><br>
                    <input type="date" name="datebirth" placeholder="Date"><br>
                    <input type="text" name="firstname" placeholder="First name"><br>
                    <input type="text" name="secondname" placeholder="Second name"><br>
                    <input type="submit" name="submit" placeholder="Submit">
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_GET["error"]))
    {
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"){
                echo "<p class='error_message'>Vyplňte všechny pole.</p>";
            }
            else if($_GET["error"] == "invalidusername"){
                echo "<p class='error_message'>Vaše uživatelské jméno obsahuje neplatný znak.</p>";
            }
            else if($_GET["error"] == "invalidemail"){
                echo "<p class='error_message'>Zadejte prosím správný email.</p>";
            }
            else if($_GET["error"] == "passwdMatch"){
                echo "<p class='error_message'>Vaše hesla se neshodují.</p>";
            }
            else if($_GET["error"] == "usernameexists"){
                echo "<p class='error_message'>Email nebo uživatelské jméno je již obsazeno.</p>";
            }
            else if($_GET["error"] == "toolongusername"){
                echo "<p class='error_message'>Zvolte kratší jméno. Jméno je příliš dlouhé.</p>";
            }
            else if($_GET["error"] == "stmtfailed"){
                echo "<p class='error_message'>Jejda! Něco se pokazilo.</p>";
            }
        }
    }
?>

<style>

    .main-div
    {
        /* background-color: purple; */
        width:100%;
        height:100%;
    }

    .register-div-outter
    {
        margin:auto;
        /* background-color: red; */
        width:50%;
        height:300px;

    }

    .register-div-inner
    {
        margin-left:260px;
        width:50%;
        height:300px;
        justify-content: center;
        align-items: center;
    }

    html, body 
    {
        height: 100%;
    }
</style>