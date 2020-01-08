<?php

/* The message system is uses the super global sessions as an array to store multiple errors or messages  on the top of the page you
can find the session configuration and  the print is don in a <p> tag with specific classes (error and message) who can be used for
styling*/
session_start();
$_SESSION['error'][]= "hello world i am a error";
$_SESSION['error'][]= "hello world again, me to";
$_SESSION['message'][]= "hello world i am a message";
$_SESSION['message'][]= "hello world again and i am also a message";




function PrintMessage(){
    if(isset($_SESSION['message'])){
        foreach ($_SESSION["message"]as $key => $message)
            $message = "<p class=\"message container\">".$message."</p>";
        print $message;
        unset($_SESSION["message"]);
    }
    if(isset($_SESSION['error'])){
        foreach ($_SESSION["error"] as $key => $error)
        {
            $message .= "<p class=\"error container\">".$error."</p>";
        }

        print $message;
        unset($_SESSION["error"]);

    }

}
