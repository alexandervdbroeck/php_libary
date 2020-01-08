<?php

/*Some examples of loginout actions used in different projects
A lot of functions where they make use of are not included, but, you can figure  them out by there name, i think
som of them may be included in te this library */
session_start();
LogLogoutUser();

session_destroy();
unset($_SESSION);

session_start();
session_regenerate_id();
$_SESSION["msg"][] = "U bent afgemeld!";
header("Location: " . $_application_folder . "/login.php");

// used in the project inspireis


include_once "user_log.php";
$formname = $_POST["formname"];

if ($formname == "logout"){
    session_start();
    // de log uit beweging van de gebruiker registreren
    LogoutUser();
    session_destroy();
    unset($_SESSION);
    session_start();
    session_regenerate_id();
    $_SESSION["message"] = "U bent afgemeld!";
    header("Location: ".$_application_folder."login.php");
}
?>


