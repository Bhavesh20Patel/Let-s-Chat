<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        .names{
            /* background-color: lightskyblue; */
            border-bottom: 1px solid  lavender;
            padding: 10px;
            margin: 15px;
            cursor: pointer;
            font-family: 'Nunito Sans', sans-serif;
            height: 50px;
            font-size: 20px;
            text-align: center;
            justify-content: center;
        }

        .names:hover{
            border: 1px  solid lightslategray;
            background-color: lavender;
        }
    </style>
</body>
</html>

<?php

include 'dbconnect.php';

session_start();
$currentname = $_SESSION['currentusername'];
$currenttoken = $_SESSION['currentusertoken'];

$sql1 = "SELECT Name , token FROM users where token IN (select DISTINCT Reciever_token from messages where Sender_token = '" . mysqli_escape_string($conn, $currenttoken) . "');";
$result = mysqli_query($conn, $sql1);
$num = mysqli_num_rows($result);

if ($num > 0) {
    $output2 = "<div></div>";
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['reciever_name']=$row['Name'];
        $_SESSION['reciever_token']=$row['token'];
        $output2 .= " <p class='names' id='{$_SESSION['reciever_token']}' onClick='GFG_click(this.id)'> {$_SESSION['reciever_name']}</p>";
    }
    mysqli_close($conn);
    echo $output2;
}
else{
    echo "No Recent Chats. Go to <a href='contacts.php'>Contacts</a> to chat";
}
?>
