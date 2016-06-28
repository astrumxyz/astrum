<?php

    require_once("connect.php");
include("../php/Session.class.php");
$sess = new Session();
$sess->Init();

    if(isset($_GET['c_id'])){
        //get the conversation id and
        $conversation_id = base64_decode($_GET['c_id']);
        //fetch all the messages of $user_id(loggedin user) and $user_two from their conversation
        $q = mysqli_query($con, "SELECT * FROM `pm_messages` WHERE conversation_id='$conversation_id'");
        //check their are any messages
        if(mysqli_num_rows($q) > 0){
            while ($m = mysqli_fetch_assoc($q)) {
                //format the message and display it to the user
                $user_form = $m['user_from'];
                $user_to = $m['user_to'];
                $message = $m['message'];

                //get name and image of $user_form from `user` table
                $user = mysqli_query($con, "SELECT username FROM `accounts` WHERE id='$user_form'");
                $user_fetch = mysqli_fetch_assoc($user);
                $user_form_username = $user_fetch['username'];
                //$user_form_img = $user_fetch['img'];

                //display the message
                //sub in <img class='chatimg' src='".$sess->getChatImageActual(3)."'/>
                echo "
                            <div class='message'>
                                <div class='img-con'>
                                    <img class='chatimg' src='../images/noimage3.png'/>
                                </div>
                                <div class='text-con'>
                                    <a href='#''>{$user_form_username} : </a>
                                    <p>{$message}</p>
                                </div>
                            </div>
                            <hr>";

            }
        }else{
            echo "No Messages";
        }
    }

?>