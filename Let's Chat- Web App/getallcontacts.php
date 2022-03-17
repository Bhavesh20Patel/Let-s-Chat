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
        .names{
            background-color: burlywood;
        }
    </style>
</body>
</html>

<?php

include 'dbconnect.php';

session_start();
$currentname = $_SESSION['currentusername'];

$sql = "select Name , token from users where token not in(select token from users where Name='$currentname')";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    $output1 = "<div> Contacts are: </div>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output1 .= " <p class='names' id='{$row['token']}' onClick='GFG_click(this.id)'> {$row['Name']}</p>";
    }

    mysqli_close($conn);

    echo $output1;
    
}
?>
