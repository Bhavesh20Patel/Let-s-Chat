<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAT</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: lavender;
        }

        /* Scroll Bar CSS */
        /* width */
        ::-webkit-scrollbar {
            width: 3px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        #headbar {
            background-color: skyblue;
            height: 50px;
            width: 100%;
        }

        #logo {
            margin-left: 10px;
            padding: 10px;
            font-size: 30px;

        }

        #leftside {
            /* border: 2px solid green; */
            background-color: white;
            border-radius: 10px;
            margin: 10px;
            padding: 10px;
            float: left;
            max-width: 20%;
            min-width: 20%;
            height: 32.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        #rightside {
            margin: 10px;
            padding: 10px;
            border-radius: 10px;
            background-color: lavender;
            float: right;
            max-width: 75%;
            min-width: 75%;
            height: 32em;
            box-sizing: border-box;
        }

        #recievernameshow {
            padding: 15px;
            border-radius: 5px;
            background-color: lavender;
            border-bottom: 1px solid gray;
        }

        #recievername {
            font-family: 'Nunito Sans', sans-serif;
            font-size: 30px;
            font-weight: bold;
        }

        #chats {
            background-color: lavender;
            height: 22em;
            /* margin: 4px, 4px; */
            margin-top: 1em;
            padding: 4px;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: justify;
            border-radius: 10px;
        }

        #writemessageinput {

            margin-top: 1em;
            /* box-sizing: border-box; */
        }

        #messageinput {
            width: 85%;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid white;
        }

        #searchfield {
            padding: 9px;
            background-color: lavender;
            padding-left: 10px;
            padding-right: 84px;
            margin-left: 0em;
            margin-top: 10px;
            border: 1px solid lavender;
        }


        #attachfilebutton {
            height: 35px;
            width: 35px;
            margin: 5px;
            /* margin-top: 1em; */
            float: right;
            margin-top: -3em;
            margin-right: 3em;
            cursor: pointer;

        }

        #sendbutton {
            height: 35px;
            width: 35px;
            margin: 5px;
            /* margin-top: 1em; */
            float: right;
            margin-top: -3em;
            margin-right: 0em;
            cursor: pointer;

        }

        #attachfilebutton:hover,
        #sendbutton:hover {
            background-color: white;
            /* border-radius: 50%; */
            border-color: lightseagreen;


        }


        #chatpagewelcomebackline {
            font-family: 'Nunito Sans', sans-serif;
            /* border: 1px solid chartreuse; */
            background-color: white;
            border-radius: 10px;
            margin-top: 5px;
            margin-left: 0.5em;
            font-size: 20px;
            padding: 15px;
            max-width: 19%;

        }

        #navbarchat {
            background-color: white;
            float: right;
            width: 75%;
            padding: 5px;
            border-radius: 10px;
            font-family: 'Great Vibes', cursive;
            font-size: 40px;
        }

        #contactsbutton,
        #settingsbutton {
            float: right;
            margin: 1px 7px 1px 1px;
            padding: 10px;
            cursor: pointer;
            height: 30px;
            width: 30px;
        }

        #contactsbutton:hover,
        #settingsbutton:hover {
            background-color: lightskyblue;
            border-radius: 50%;
            border-color: lightseagreen;
        }
    </style>
</head>


<body>

    <div id="navbarchat">
        Letschat
        <!-- <button id="contactsbutton" type="submit">Contacts</button>
        <button id="settingsbutton" type="submit">Settings</button> -->
        <a href="contacts.php"><img id="contactsbutton" src="images/phone-book.png" alt=""></a>
        <a href="settings.php"><img id="settingsbutton" src="images/settings.png" alt=""></a>

    </div>


    <?php

    include 'dbconnect.php';
    // error_reporting(0);
    // include 'navbar.php';
    session_start();

    echo "<div id='chatpagewelcomebackline'>";
    echo "WELCOME BACK ";
    echo $_SESSION['currentusername'];
    echo "!!";
    echo "</div>";
    $currentname = $_SESSION['currentusername'];

    // $reciever_token = "<script>document.writeln(clickedusertoken1);</script>";
    // echo $reciever_token;
    // $reciever_token2 = $_SESSION['reciever_token'];
    ?>



    <div id="leftside">
        <h3 style="font-family: 'Nunito Sans', sans-serif;">Recent Chats</h3>

        <input style="font-family: 'Nunito Sans', sans-serif;" id="searchfield" type="text" name="searchbox" placeholder="Search..">
        <div id="recentcontacts"></div>
        <script src="jquery.js"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    async: false,
                    url: "getrecentcontacts.php",
                    type: "POST",
                    success: function(data) {
                        $("#recentcontacts").html(data);
                        $(".names").on("click", function() {
                            var name = $(this).html();
                            $("#recievername").html(name);
                            //below code to get the clicked reciever name :)
                            // $(document).ready(function() {
                            //     var chattingtoname = $("#recievername").html();
                            //     return chattingtoname;
                            //     // console.log(chattingtoname);
                            // });
                            start_chat();
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

        <script src="jquery.js"></script>
        <script>

        </script>

    </div>
    <div id="rightside">
        <div id="recievernameshow">
            <span id="recievername">Start a Chat</span>
        </div>
        <div style="font-family: 'Nunito Sans', sans-serif;" id="chats">
            <!-- Here comes the chats -->

        </div>
        <div id="writemessageinput">
            <form action="#" method="POST">
                <input style="font-family: 'Nunito Sans', sans-serif;" id="messageinput" type="text" name="message" placeholder="type a message....">
                <div>
                    <img id="attachfilebutton" src="images/attach-file.png" alt="">

                    <img id="sendbutton" src="images/send.png" alt="">

                </div>
            </form>
        </div>

    </div>

    <script src="jquery.js"></script>
    <script>
        function start_chat() {
            $(document).ready(function() {
                function showmessage() {
                    $.ajax({
                        url: "getallmessages.php",
                        type: "POST",
                        success: function(data) {
                            $("#chats").html(data);
                        }
                    })
                }
                showmessage();

                $("#sendbutton").on("click", function(e) {
                    e.preventDefault();
                    var messageinput = $("#messageinput").val();
                    $.ajax({
                        url: "message_insert.php",
                        type: "POST",
                        data: {
                            message_input: messageinput
                        },
                        success: function(data) {
                            // if (data == 1) {
                            //     showmessage();
                            // } else if (data == 0) {
                            //     alert("Cannot insert message in the database");
                            // }
                            showmessage();
                        }
                    });
                })
            })
        }
    </script>



    <?php
    mysqli_close($conn);
    ?>
</body>

</html>