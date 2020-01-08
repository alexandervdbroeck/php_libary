<?php
//First part is the auto-load section which is loaded on every page, if users are not logged in they get redirected

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
//Redirect if user is not logged in , and not visiting 'login, n access, register)
if ( ! isset($_SESSION['usr']) AND ! $login_form AND ! $register_form AND ! $no_access)
{
    header("Location: " . $_application_folder . "/no_access.php");
}

// op de pagina's waar men toegang heeft maar best niet op komt als men reeds ingelogd is:
$login_form = true;
require_once "lib/autoload.php";

//Rederect if users are not logged in
if ( isset($_SESSION['usr']) )
{
    $_SESSION["msg"][] = "U bent al ingelogd!";
    header("Location: " . $_application_folder . "/steden.php");
    exit;
}

// On pages where a user who is not logged in can get access to:
$no_access = true;
$login_form = true;
$register_form = true;