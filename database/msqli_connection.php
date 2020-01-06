<?php
function GetConnectionMysqli(){
    require_once "password.php";
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
        $_SESSION["msg"] = " er is een probleem met het verbinden met de database ". $conn->connect_error;
        return false;
    }else{
        $result = $conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $rows   ;
    };
}

function GetDataOneRowMysqli( $sql )
{
    $conn = GetConnectionMysqli();
    if ($conn->connect_error) {
        $_SESSION["msg"] = " er is een probleem met het verbinden met de database ". $conn->connect_error;
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
ExecuteMysqli("insert into user set usr_voornaam = 'joodelen',
                            usr_naam = 'tesgfhtje',
                            usr_email = 'tesfgdhtje',
                            usr_paswoord ='sdlksfdghdjfje'");


$rows = GetDataOneRowMysqli("Select * from user where usr_id = 15");
var_dump($rows);
