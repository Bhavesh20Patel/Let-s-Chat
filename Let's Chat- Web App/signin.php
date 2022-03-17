<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin</title>
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        #signincontainer{
            border: 1px solid gray;
            background-color: white;
            padding-top: 30px;
            margin-top: 3em;
            margin-right: 32em;
            margin-left: 32em;
            padding-bottom: 2em;
            border-radius: 10px;
        }
        #signincontainer1{
            border: 1px solid gray;
            background-color: white;
            margin-top: 3em;
            margin-right: 32em;
            margin-left: 32em;
            height: 65px;
            border-radius: 10px;

        }
        #signinform{
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div id="signincontainer">
        <form class="signinform" action="#" method="POST">
            <h1 style="font-family: 'Great Vibes', cursive; font-size: 50px; margin-top: -1em; ">Letschat</h1>
            <div>
                <input style="padding: 10px; margin: 10px" type="email" name="email" placeholder="Enter your Email">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="password" name="password" placeholder="Enter your Password">
            </div>
            <div>
                <button style="padding: 5px; margin: 5px; border-radius: 5px ;font-family: 'Noto Sans', sans-serif; cursor: pointer; " type="submit" onclick="myFunction()">Login</button>
            </div>
        </form>
    </div>

    <div id="signincontainer1">
        <p id="signinform" class="signinform">Don't have an account, <a id="signinform1"  href="signup.php">Sign Up</a> here </p>
    </div>
    <script>
        function myFunction() {
            location.replace("http://localhost/ProjectBYme/chat.php");
        }
    </script>

    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'dbconnect.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        //to prevent from mysqli injection  
        $email = stripcslashes($email);
        $password = stripcslashes($password);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $sql = "select * from users where Email = '" . $email . "' and Password = '" . $password . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            echo "<h1><center> Login successful </center></h1>";
        } else {
            echo "<h1> Login failed. Invalid username or password.</h1>";
        }

        $namefromSQL = "SELECT Name,token FROM `users` WHERE Email='$email'";
        $r = mysqli_query($conn, $namefromSQL);
        $n = mysqli_num_rows($r);
        if ($n > 0) {
            $ro = mysqli_fetch_assoc($r);
            echo ($ro['Name']);
            echo ($ro['token']);

            session_start();

            $currentusername = $ro['Name'];
            $currentusertoken = $ro['token'];
            echo $currentusername;
            echo $currentusertoken;

            $_SESSION['currentusername'] = $currentusername;
            $_SESSION['currentusertoken'] = $currentusertoken;
        } else {
            echo "No user";
        }
    }
    ?>
</body>

</html>