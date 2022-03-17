<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "getrecentcontacts.php",
                type: "POST",
                success: function(data) {
                    $("#recentcontacts").html(data);
                    $(".names").on("click", function() {
                        // $(this).css("color", "red");
                        var name = $(this).html();
                        // $("#recievername").html(name);
                    })
                }
            })
        });
    </script>

    <p id="GFG_DOWN"></p>

    <script>
        var el_down = document.getElementById("GFG_DOWN");

        function GFG_click(clickedusertoken) {
            el_down.innerHTML = "token = " + clickedusertoken;
            // console.log(clickedusertoken);
        }
    </script>
    <?php
    include 'dbconnect.php';

    session_start();
    $currentname = $_SESSION['currentusername'];

    $tokenfromSQL = "SELECT token FROM users WHERE Name='" . mysqli_escape_string($conn, $currentname) . "'";
    $r11 = mysqli_query($conn, $tokenfromSQL);
    $n11 = mysqli_num_rows($r11);
    if ($n11 > 0) {
        $ro11 = mysqli_fetch_assoc($r11);
        $sender_token = $ro11['token'];
    }
    $reciever_token = $_SESSION['reciever_token'];

    $message_input = $_POST["message_input"];

    $sql = "INSERT INTO `messages` (`Sender_token`, `Reciever_token`, `Message`) VALUES ('$sender_token', ' $reciever_token', '$message_input');";

    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
    ?>
</body>

</html>