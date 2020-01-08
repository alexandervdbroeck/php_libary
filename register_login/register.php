<?php
            /*Some examples of register forms used in different projects
            A lot of functions where they make use of are not included, but, you can figure  them out by there name, i think
            som of them may be included in te this library */
/*----------------variabelen --------------------------------------------------------------------*/

$formname = $_POST["formname"];
$tablename = $_POST["tablename"];
$pkey = $_POST["pkey"];
unset($_SESSION['message']);

/*------------------formulieren--------------------------------------------------------------------*/

if ($formname == "registration_form" AND $_POST['registerbutton'] == "Registreer") {
    $_SESSION["message"] = "sorry u kan tijdelijk niet in registreren";
    header("Location: ".$_application_folder."login.php");
    die;

    //controle of gebruiker al bestaat

    $sql = SqlRegisterUserCheckEmail($_POST['usr_email']);
    $data = GetData($sql);
    if (count($data) > 0) {

        $_SESSION["message"] = "Dit e-mailadres is al in gebruik<br> ";
    }
    // controle of de username al in gebruik is.

    $sql = SqlRegisterUserCheckLogin($_POST['usr_login']);
    $data = GetData($sql);
    if (count($data) > 0) {

        $_SESSION["message"] = "Deze username is al in gebruik<br> ";
    }

    //controle wachtwoord minimaal 8 tekens

    if (strlen($_POST["usr_paswoord"]) < 8){
        $_SESSION["message"] .= "Het paswoord moet minsens 8 karakters lang zijn <br>";

    }

    //controle geldig e-mailadres

    if (!filter_var($_POST["usr_email"],FILTER_VALIDATE_EMAIL)){
        $_SESSION["message"] .= "Dit e-mailadres is niet geldig<br> ";

    }
    // als er geen fouten opgetreden zijn

    if (!isset($_SESSION["message"])){

        //wachtwoord coderen

        $password_encrypted = password_hash($_POST["usr_paswoord"], PASSWORD_DEFAULT);
        $sql = SqlRegisterUserInsertUser($_POST['usr_voornaam'],$_POST['usr_naam'],$_POST['usr_email'],$password_encrypted,$_POST['usr_login'],$_POST['tablename']);

//        //gebruiker toevoegen

        if (ExecuteSQL($sql)) {

            if (StartLoginSession($_POST["usr_email"], $_POST["usr_paswoord"])){
                $_SESSION["message"]= "Bedankt voor uw registratie!".$_SESSION['usr']['usr_voornaam'];
                header("Location:../ontdek.php");
                die;
            }
        } else {
            $_SESSION["message"] = "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen.";

            header("Location: ../register.php");
            die;
        }
    }else {
        header("Location: ../register.php");
    }
}

// used in php cours
$formname = $_POST["formname"];
$tablename = $_POST["tablename"];
$pkey = $_POST["pkey"];

if ( $formname == "registration_form" AND $_POST['registerbutton'] == "Register" )
{
    //controle of gebruiker al bestaat
    $sql = "SELECT * FROM users WHERE usr_login='" . $_POST['usr_login'] . "' ";
    $data = GetData($sql);
    if ( count($data) > 0 ) die("Deze gebruiker bestaat reeds! Gelieve een andere login te gebruiken.");

    //controle wachtwoord minimaal 8 tekens
    if ( strlen($_POST["usr_paswd"]) < 8 ) die("Uw wachtwoord moet minstens 8 tekens bevatten!");

    //controle geldig e-mailadres
    if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL)) die("Ongeldig email formaat voor login");

    //wachtwoord coderen
    $password_encrypted = password_hash ( $_POST["usr_paswd"] , PASSWORD_DEFAULT );

    $sql = "INSERT INTO $tablename SET " .
        " usr_voornaam='" . htmlentities($_POST['usr_voornaam'], ENT_QUOTES) . "' , " .
        " usr_naam='" . htmlentities($_POST['usr_naam'], ENT_QUOTES) . "' , " .
        " usr_straat='" . htmlentities($_POST['usr_straat'], ENT_QUOTES) . "' , " .
        " usr_huisnr='" . htmlentities($_POST['usr_huisnr'], ENT_QUOTES) . "' , " .
        " usr_busnr='" . htmlentities($_POST['usr_busnr'], ENT_QUOTES) . "' , " .
        " usr_postcode='" . htmlentities($_POST['usr_postcode'], ENT_QUOTES) . "' , " .
        " usr_gemeente='" . htmlentities($_POST['usr_gemeente'], ENT_QUOTES) . "' , " .
        " usr_telefoon='" . htmlentities($_POST['usr_telefoon'], ENT_QUOTES) . "' , " .
        " usr_login='" . $_POST['usr_login'] . "' , " .
        " usr_paswd='" . $password_encrypted . "'  " ;

    if ( ExecuteSQL($sql) )
    {
        $_SESSION["msg"][] = "Bedankt voor uw registratie!" ;

        if ( ControleLoginWachtwoord( $_POST["usr_login"] , $_POST["usr_paswd"]) )
        {
            header("Location: " . $_application_folder . "/steden.php");
        }
    }
    else
    {
        $_SESSION["msg"][] = "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen" ;
    }
}