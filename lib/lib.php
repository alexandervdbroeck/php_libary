<?php

function GetConnection()
{
    require_once "database/password.php";
    $arr_connection = GetConnectionData();
    $dbhost = $arr_connection['dbhost'];
    $dbname = $arr_connection['dbname'];
    $dbuser = $arr_connection['dbuser'];
    $dbpasswd = $arr_connection['dbpasswd'];

    $dsn = "mysql:host=$dbhost;dbname=$dbname";

    $pdo = new PDO($dsn, $dbuser, $dbpasswd);
    return $pdo;
}

function GetData($sql)
{
    $pdo = GetConnection();

    $stm = $pdo->prepare($sql);
    $stm->execute();

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function GetDataOneRow($sql)
{
    $pdo = GetConnection();

    $stm = $pdo->prepare($sql);
    $stm->execute();

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $rows[0];
}

function ExecuteSQL($sql)
{
    $pdo = GetConnection();

    $stm = $pdo->prepare($sql);

    if ($stm->execute()) return true;
    else return false;
}

function ReplaceContentOneRow( $row, $template_html )
{
    //replace fields with values in template
    $content = $template_html;
    foreach($row as $field => $value)
    {
        $content = str_replace("@@$field@@", $value, $content);
    }

    return $content;
}

function ReplaceContent( $data, $template_html )
{
    $returnval = "";

    foreach ( $data as $row )
    {
        //replace fields with values in template
        $content = $template_html;
        foreach($row as $field => $value)
        {
            $content = str_replace("@@$field@@", $value, $content);
        }

        $returnval .= $content;
    }

    return $returnval;
}
function LoadTemplate( $name )
{
//    $name = $submap."/".$name;
    if ( file_exists("$name.html") ) return file_get_contents("$name.html");
    if ( file_exists("template/$name.html") ) return file_get_contents("template/$name.html");
    if ( file_exists("../template/$name.html") ) return file_get_contents("../template/$name.html");
}

function GetConnectionMysqli(){
    require_once "database/password.php";
    $database_settings = GetConnectionData();
    $servername = $database_settings["dbhost"];
    $username = $database_settings["dbuser"];
    $password = $database_settings["dbpasswd"];;
    $dbname = $database_settings["dbname"] ;
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    return $conn;
// Create connection

}

function GetDataMysqli( $sql )
{
    $conn = GetConnectionMysqli();
    if ($conn->connect_error) {
        $_SESSION["msg"][] = " er is een probleem met het verbinden met de database ". $conn->connect_error;
        return false;
    }else{
        $result = $conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $rows  ;
    };
}

function GetDataOneRowMysqli( $sql )
{
    $conn = GetConnectionMysqli();
    if ($conn->connect_error) {
        $_SESSION["msg"][] = " er is een probleem met het verbinden met de database ". $conn->connect_error;
        return false;
    }else{
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
        $conn->close();
        return $rows   ;
    };
}
function ExecuteMysqli($sql){
    $conn = GetConnectionMysqli();
    if ($conn->connect_error) {
        $_SESSION["msg"] = " er is een probleem met het verbinden met de database ". $conn->connect_error;
        return false;
    }else{
        $prepare = $conn->prepare($sql);
        if ($prepare->execute()){
            return true;
        }else{
            $_SESSION["msg"] = " er is een probleem met het opslaan van gegevens in de databank";
            return false;
        }

    }
}