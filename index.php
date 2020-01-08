<?php
include_once "lib/lib.php";

?>
<!DOCTYPE html>
<html>
<head lang="nl">
    <meta charset="UTF-8">
    <title>Spaintastic</title>
    <link href="./css/opmaak.css" rel="stylesheet">
    <meta name="viewport"  content="width=device-width, initial-scale=1">
</head>
<body>
<header>
    <h1>basic</h1>
</header>

<?php
PrintNavBar();
?>

<main>
    <?php
    // if there is a date put it in a variable for evaluation by datetime class
    $date = $_GET['dag'];
    // if there is no date in the url the date of today wil be active
    $time = (!isset($_GET['dag'])) ? new DateTime("NOW",new DateTimeZone("Europe/Brussels")):new DateTime("$date",new DateTimeZone("Europe/Brussels"));
    $now = $time->format("Y-m-d");
    $url = $_SERVER['PHP_SELF']."?dag=";
    // get data from the server concerning searching on the day
    $data = GetData("select * from test where tijd like '".$now."%'");
    // Modify the date for the <a> buttons , next and previous day
    $back = $time->modify("-1 day")->format("Y-m-d");
    $up = $time->modify("+2 days")->format("Y-m-d");

    if(count($data)== 0)
    {
        echo "<p> today = ".$time->format("l d-m-Y")." there are no tasks</p>";
    }else {
        // search for data that is the same as today
        foreach ($data as $key)
        {
            $time = $key['tijd'];
            $time = new DateTime("$time",new DateTimeZone("Europe/Brussels"));
            $date = $time->format("l d-m-Y ");
            $hour = $time->format("h:i a");
            echo "<p>".$date." om ".$hour." => uw taak => ".$key['activiteit']."</p>";
        }
    }




    ?>
    <a href="<?php echo $url.$back?>">vorige dag<=====</a>
    <a href="<?php echo $url.$up?>">=====>Volgende dag</a>

</main>
<aside>

</aside>

<footer>

</footer>



</body></html>
