# php_libary
my first php libary

For the functions which needs connection to the database, use this one:

function GetConnectionData()
{
    return array( "dbhost" => "localhost",
        "dbname" => "stedenphp",
        "dbuser" => "root",
        "dbpasswd" => "xxxxxxx" ) ;
}
