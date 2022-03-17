<?php

$showAlert = false;
$showError = false;
$exists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include file which makes the
    // Database Connection.
    include 'dbconnect.php';

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $token = rand(1, 99999999);

    $sql = "Select * from users where Name='$name'";

    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);

    // This sql query is use to check if the username is already present or not in our Database
    if ($num == 0) {
        if (($password == $cpassword) && $exists == false) {

            $hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Password Hashing is used here. 
            $sql = "INSERT INTO `users` ( `Name`, 
                    `Email`, `Password`,`token`) VALUES ('$name', 
                    '$email', '$password','$token')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }

    if ($num > 0) {
        $exists = "Username not available";
    }
}
?>

<!-- Image Upload -->
<?php

// If upload button is clicked ...
if (isset($_POST['upload'])) {

    $filename = $_FILES["photo"]["name"];
    $tempname = $_FILES["photo"]["tmp_name"];
    $folder = "uploadphotos/" . $filename;

    // Get all the submitted data from the form
    $sql = "INSERT INTO users (ProfilePhoto) VALUES ('$filename')";

    // Execute query
    mysqli_query($conn, $sql);

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }
}
// $result = mysqli_query($conn, "SELECT * FROM users");
// while ($data = mysqli_fetch_array($result)) {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        #signupcontainer {
            border: 1px solid gray;
            background-color: white;
            margin-right: 32em;
            margin-left: 32em;
            margin-top: 3em;
            margin-bottom: 1em;
            border-radius: 10px;

        }

        #signupcontainer1 {
            border: 1px solid gray;
            background-color: white;
            text-align: center;
            margin-right: 39em;
            margin-left: 39em;
            padding-top: 20px;
            padding-bottom: 20px;
            font-family: 'Noto Sans', sans-serif;
            font-size: 13px;
            border-radius: 10px;

        }

        #signedupsuccess {
            text-align: center;
            font-family: 'Noto Sans', sans-serif;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div id="signupcontainer">
        <form class="signinform" action="#" method="POST">
            <h1 style="font-family: 'Great Vibes', cursive; font-size: 50px; margin-top: -1em; ">Letschat</h1>
            <div>
                <input style="padding: 10px; margin: 10px" type="text" name="name" placeholder="Enter your name">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="email" name="email" placeholder="Enter your Email">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="password" name="password" placeholder="Enter your password">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="password" name="cpassword" placeholder="Confirm your password">
            </div>
            <div>
                <input style="padding: 10px; margin: 10px" type="file" name="photo" placeholder="Set your Profile photo">
            </div>
            <div>
                <button style="padding: 5px; margin-top: 5px; margin-bottom: 15px; border-radius: 5px; cursor: pointer" type="submit" id="signupbutton">SignUp</button>
            </div>

        </form>
    </div>
    <div>
        <p id="signedupsuccess"></p>
        <p id="signupcontainer1">After Registering, go to <a style=" text-decoration: none; color: blue;" href="signin.php">SIGN IN</a> page.</p>
    </div>

    <script>
        var signedup = document.getElementById("signupbutton");
        signedup.addEventListener("click", func);

        function func() {
            console.log("touched");
            var b = document.getElementById("signedupsuccess");

            b.innerHTML = "You are successfully registered.";
        }
    </script>
</body>

</html>