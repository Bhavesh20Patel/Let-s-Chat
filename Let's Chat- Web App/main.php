<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Gluten:wght@600&display=swap" rel="stylesheet">

    <style>
        .maincontent{
            text-align: center;
            border: 1px solid gray;
            margin-left: 18em;
            margin-right: 18em;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="welcomeline">
        <?php
        include 'dbconnect.php';
        session_start();

        echo "WELCOME BACK ";
        echo $_SESSION['currentusername'];
        echo "!!";
        ?>
    </div>
    <div>
        <?php
        include 'dbconnect.php';
        include 'navbar.php';
        ?>
    </div>

    <h3 class="maincontent">
        SELECT ONE OPTION FROM ABOVE TO PROCEED RESPECTIVELY.
    </h3>
    <div class="maincontent">
        
        <p> <b>Chat</b> : Here you can Chat with your listed Contacts</p>
        
        <p> <b>Contacts</b> : Here you can see who is in your Contacts list and manage them</p>
        
        <p> <b>Settings</b> : Here you can Manage your Profile</p>
    </div>


    </div>
</body>

</html>