<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        .messages {
            background-color: lightgray;
            padding: 15px;
            border-radius: 10px;
            max-width: fit-content;
            margin-left: 0.7em;
            font-family: 'Nunito Sans', sans-serif;
        }
    </style>
</body>
<script src="jquery.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: chat.php,
            type: "POST",
            data: chattingtoname,
            success: function(data) {
                console.log(data);
            }
        })
    });
</script>

</html>

<?php

include 'dbconnect.php';

session_start();
$currentname = $_SESSION['currentusername'];
$currentrecievername = $_SESSION['reciever_name'];
$reciever_token1 = $_SESSION['reciever_token'];

$sql = "select Message from messages where Sender_token in (select token from users where Name= '" . mysqli_escape_string($conn, $currentname) . "') and Reciever_token ='" . mysqli_escape_string($conn, $reciever_token1) . "' ";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if ($num > 0) {
    $output = "<div> </div>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= " <p class='messages'> {$row['Message']}</p>";
    }
    mysqli_close($conn);
    echo $output;
}



?>