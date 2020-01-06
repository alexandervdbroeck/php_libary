<?php
//In de auto load wordt de toegang zo geregeld:

session_start();
$_SESSION["head_printed"] = false;
//$_application_folder = "/wdev_steven/testremote";
$_application_folder ="/phpcursus/oefeningen/testremote_new-master";
require_once "passwd.php";
require_once "pdo.php";                          //database functies
require_once "view_functions.php";      //basic_head, load_template, replacecontent...
require_once "authorisation.php";      //controle login e.d.
require_once "show_messages.php";
//
//redirect naar NO ACCESS pagina als de gebruiker niet ingelogd is en niet naar
//de loginpagina gaat
if ( ! isset($_SESSION['usr']) AND ! $login_form AND ! $register_form AND ! $no_access)
{
    header("Location: " . $_application_folder . "/no_access.php");
}

// op de pagina's waar men toegang heeft maar best niet op komt als men reeds ingelogd is:
$login_form = true;
require_once "lib/autoload.php";

//redirect naar homepage als de gebruiker al ingelogd is
if ( isset($_SESSION['usr']) )
{
    $_SESSION["msg"][] = "U bent al ingelogd!";
    header("Location: " . $_application_folder . "/steden.php");
    exit;
}

// op de pagina's waar men geen toegang tot heeft:
$no_access = true;