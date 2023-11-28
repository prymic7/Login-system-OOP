<?php

session_start();
$logged_user_id = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$logged_username = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
$user_logged = isset($_SESSION["username"]) ? true : false;

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
    <nav>
        <div class="left-items">
            <li><a href="#">Home</a></li>
            <li><a href="#">Purchase</a></li>
        </div>

        <div class="right-items">
            <?php
                if($user_logged)
                {
                    echo '<li><a href="">' . $logged_username . '</a></li>
                    <li><a href="includes/logout.inc.php">Logout</a></li>';
                }
                else
                {
                    echo "<li><a href='login.php'>Login</a></li>
                    <li><a href='register.php'>Register</a></li>";
                }

            ?>

        </div>
    </nav>
</body>
</html>

<style>
    nav 
    {
        background-color: blue;
        height: 30px;
        color: white;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .left-items, .right-items 
    {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .left-items li, .right-items li 
    {
        margin: 0 10px;
    }

    a 
    {
        text-decoration: none;
        color: white;
    }

    nav li:hover a
    {
        color: yellow;
    }
</style>