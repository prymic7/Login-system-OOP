
<?php
    include 'header.php';
    include 'includes/checkerror.inc.php';

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
                <form action="includes/login.inc.php" method="POST" name="loginform">
                    <input type="text" name="username" placeholder="Username"><br>
                    <input type="password" name="password" placeholder="Password"><br>
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
  
        $error = new CheckError($_GET["error"]);
        $errorStr = $error->getError();
        echo "<p class='error_message'>$errorStr</p>";
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