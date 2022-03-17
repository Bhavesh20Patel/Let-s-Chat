<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contacts</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Gluten:wght@600&display=swap" rel="stylesheet">

    <style>
        #namesincontacts {
            text-align: center;

        }

        #contactswelcomeline {
            text-align: center;
            /* font-size: 20px; */
            font-family: 'Comfortaa', cursive;
        }
    </style>
</head>

<body>
    <div id="contactswelcomeline">
        <?php

        include 'dbconnect.php';
        session_start();

        echo "WELCOME BACK ";
        echo $_SESSION['currentusername'];
        echo "!!";
        $currentname = $_SESSION['currentusername'];
        echo "<br>";
        include 'navbar.php';
        ?>
    </div>
    <div id="namesincontacts">
        <p>Select one of the contacts to chat with them.</p>
        <!-- <br> -->
        <!-- <p>Your Contacts are:</p> -->
        <!-- <br> -->
        <?php
        $sql = "select Name from users where token not in(select token from users where Name='$currentname')";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            for ($i = 0; $i < $num; $i++) {
                $row = mysqli_fetch_assoc($result);

                echo "<div id='contactspagenames'>";
                // echo "<a class='touchedname' href='chat.php'>" . $row['Name'] . "</a>";
                echo "</div>";
                $names[$i] = $row['Name'];


                echo "<br>";
            }
        }
        ?>
    </div>
    <!-- <button type="submit" id="getcontacts">Get Contacts </button> -->

    <script src="jquery.js"></script>
    <script>
        $(document).ready(function() {
            // $("#getcontacts").on("click", function(e) {
            $.ajax({
                url: "getallcontacts.php",
                type: "POST",
                success: function(data) {
                    $("#contactspagenames").html(data);
                    // console.log(data);

                    $(".names").on("click", function() {
                        $(this).css("color", "red");
                        var name = $(this).html();
                        $("#youhaveclicked").html(name);
                    })
                    // $("#name2").on("click", function() {
                    //     $("#name2").css("color", "red");
                    //     var name = $("#name2").html();
                    //     // console.log(name);
                    //     $("#youhaveclicked").html(name);
                    // })
                }
            })
            // });
        });
    </script>
    <p id="GFG_DOWN"></p>
    <div>
        <h4 id="youhaveclicked">You have clicked </h4>
    </div>

    <script>
        var el_down = document.getElementById("GFG_DOWN");

        function GFG_click(clickedusertoken) {
            el_down.innerHTML = "token = " + clickedusertoken;
            console.log(clickedusertoken);
        }
    </script>
    <?php

    mysqli_close($conn);

    ?>
</body>

</html>