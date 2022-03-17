<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Gluten:wght@600&display=swap" rel="stylesheet">


    <style>
        #settingscontent {
            /* border: 1px solid black; */
            float: left;
            text-align: center;
            width: fit-content;
            margin-left: 2em;
        }

        #updateform {
            padding: 10px;
            margin: 10px;
            border: 1px solid gray;
            margin-left: 12em;
            margin-right: 12em;
        }

        /* div  */
        #settingsform {
            text-align: center;
            float: right;
            width: 50%;
            margin-right: 21em;
        }

        #welcomelineinsettings {
            /* border: 1px solid chartreuse; */
            text-align: center;
            margin-left: 30em;
            margin-right: 30em;
            margin-bottom: 1em;
            margin-top: 1em;
            padding: 10px;
            font-family: 'Comfortaa', cursive;

        }
        #gotochat{
            padding: 10px;
            margin-top: 5em;
        }
        
    </style>
</head>

<body>
    

    <?php
    session_start();

    echo "<div id='welcomelineinsettings'>";
    echo "WELCOME BACK ";
    echo $_SESSION['currentusername'];
    echo "!!";
    echo "</div>";
    ?>
    <div id="settingscontent">
        <?php
        include 'dbconnect.php';
        $name = $_SESSION['currentusername'];

        $emailfromSQL = "SELECT Email FROM `users` WHERE Name='$name'";
        $passwordfromSQL = "SELECT Password FROM `users` WHERE Name='$name'";
        $tokenfromSQL = "SELECT token FROM `users` WHERE Name='$name'";
        $r = mysqli_query($conn, $emailfromSQL);
        $r2 = mysqli_query($conn, $passwordfromSQL);
        $r3 = mysqli_query($conn, $tokenfromSQL);

        $n = mysqli_num_rows($r);
        $n2 = mysqli_num_rows($r2);
        $n3 = mysqli_num_rows($r3);


        if ($n > 0) {
            $ro = mysqli_fetch_assoc($r);
            // echo "email ran";
            $email = $ro['Email'];
        }
        if ($n2 > 0) {
            $ro = mysqli_fetch_assoc($r2);
            // echo "password ran";
            $password = $ro['Password'];
        }
        if ($n3 > 0) {
            $ro = mysqli_fetch_assoc($r3);
            // echo "token ran";
            $token = $ro['token'];
        }

        echo "<b>Your information is:</b>";
        echo "<br>";
        echo "<br>";
        echo "Token no. = $token";
        echo "<br>";
        echo "<br>";
        echo "Name = $name";
        echo "<br>";
        echo "<br>";
        echo "Email = $email";
        echo "<br>";
        echo "<br>";
        echo "Password = $password";
        ?>
    </div>

    <div id="settingsform">
        <p style="font-family: 'Comfortaa', cursive;" >Fill the form in the way you want your updation.</p>
        <form id="updateform" action="#" method="POST">
            <div>
                <input style="padding: 10px; margin: 10px" type="text" name="name" placeholder="Enter your new name">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="email" name="email" placeholder="Enter your new Email">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="password" name="password" placeholder="Enter your new password">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="password" name="cpassword" placeholder="Confirm your new password">
            </div>
            <div>
                <button style="padding: 5px; margin-top: 5px; margin-bottom: 15px; border-radius: 5px; cursor: pointer" type="submit" id="updatebutton">UPDATE</button>
            </div>
            
        </form>
        <div id="gotochat">
            <button style="padding: 10px; font-family: 'Comfortaa', cursive; cursor:pointer; " type="submit" onclick="func()">Go to Chat</button>
        </div>

        <script>
            function func() {
            location.replace("http://localhost/ProjectBYme/chat.php");
        }
        </script>
        <?php
        $showAlert = false;
        $showError = false;
        $exists = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $updatename = $_POST["name"];
            $updateemail = $_POST["email"];
            $updatepassword = $_POST["password"];
            $updatecpassword = $_POST["cpassword"];

            $sql = "Select * from users where Name='$updatename'";

            $result = mysqli_query($conn, $sql);

            // $num = mysqli_num_rows($result);
            // This sql query is use to check ifthe username is already present or not in our Database
            // if ($num == 0) {
            if (($updatepassword == $updatecpassword) && $exists == false) {

                $hash = password_hash(
                    $updatepassword,
                    PASSWORD_DEFAULT
                );

                // Password Hashing is used here. 
                $sql = "UPDATE users SET Name='$updatename' , Email='$updateemail' , Password='$updatepassword' WHERE token='$token'  ";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $showAlert = true;
                }
            } else {
                $showError = "Passwords do not match";
            }
        }

        // if ($num > 0) {
        //     $exists = "Username not available";
        // }
        // } //end if
        ?>
    </div>
</body>

</html>