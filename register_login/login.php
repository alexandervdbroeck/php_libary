<?php
/*Some examples of login forms used in different projects
A lot of functions where they make use of are not included, but, you can figure  them out by there name, i think
som of them may be included in te this library */



$formname = $_POST["formname"];
$buttonvalue = $_POST['loginbutton'];

if ($formname == "login_form" AND $buttonvalue == "Log in") {
    if (ControleLoginWachtwoord($_POST['usr_login'], $_POST['usr_paswd'])) {
        $_SESSION["msg"][] = "Welkom, " . $_SESSION['usr']['usr_voornaam'] . "!";
        LogLoginUser();
        header("Location: " . $_application_folder . "/steden.php");
    } else {
        $_SESSION["msg"][] = "Sorry! Verkeerde login of wachtwoord!";
        header("Location: " . $_application_folder . "/login.php");
    }
} else {
    $_SESSION["msg"][] = "Foute formname of buttonvalue";
}

// used in project inspireis

$formname = $_POST["formname"];
$buttonvalue = $_POST['loginbutton'];

/* controle of het juiste formulier ingezonden is */
if ( $formname == "login_form" AND $buttonvalue == "Log in" )
{   /* controle van de user zijn gegevens*/
//    $_SESSION["message"] = "sorry wij zijn even met vakantie,...";
//    header("Location: ".$_application_folder."login.php");
//    die;
    if ( StartLoginSession( $_POST['usr_login'], $_POST['usr_paswoord'] ) )
    {
        $_SESSION["message"]= "Welkom, " . $_SESSION['usr']['usr_voornaam'] . "!" ;
        header("Location: ".$_application_folder."index.php");
    }
    else
    {
        $_SESSION["message"] = "Verkeerde login of paswoord";
        header("Location: ".$_application_folder."login.php");
    }
}

else
{
    $_SESSION["message"] = "Foute formname of buttonvalue";
    header("Location:".$_application_folder."login.php");
}