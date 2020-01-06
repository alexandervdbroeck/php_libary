<?php
function GetConnection()
{
    require_once "password.php";
    $arr_connection = GetConnectionData();
    $dbhost = $arr_connection['dbhost'];
    $dbname = $arr_connection['dbname'];
    $dbuser = $arr_connection['dbuser'];
    $dbpasswd = $arr_connection['dbpasswd'];

    $dsn = "mysql:host=$dbhost;dbname=$dbname" ;

    $pdo = new PDO($dsn, $dbuser, $dbpasswd);
    return $pdo;
}

function GetData( $sql )
{
    $pdo = GetConnection();

    $stm = $pdo->prepare($sql);
    $stm->execute();

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function GetDataOneRow( $sql )
{
    $pdo = GetConnection();

    $stm = $pdo->prepare($sql);
    $stm->execute();

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $rows[0];
}

function ExecuteSQL( $sql )
{
    $pdo = GetConnection();

    $stm = $pdo->prepare($sql);

    if ( $stm->execute() ) return true;
    else return false;
}
$data = GetDataOneRow("select * from user");
var_dump($data);