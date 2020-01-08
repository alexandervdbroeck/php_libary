<?php
// How to get the first day of a week using the date  time class
$time = new DateTime("17-05-1982",new DateTimeZone("Europe/Brussels"));
$week = $time->format("W");
$year = $time->format("Y");
$time2 = new DateTime("$year".W."$week",new DateTimeZone("Europe/Brussels"));
for($i=0;$i<7;$i++)
{
    $time3 = $time2->format("l-d-m-Y ");
    echo "<p>". $time3."</p>";
    $time2 = $time2->modify("next day");
}

// function that prints a week in a table, when giving it a week number (2digit) and a year
function PrintWeekfromYearAndWeek($week, $year){
    for( $day=1; $day <= 7; $day++ )
    {
        $d = strtotime($year . "W" . $week . $day);
        $sqldate = date("Y-m-d", $d);
        $sql = "SELECT taa_omschrijving FROM tken WHERE taa_datum = '".$sqldate."'" ;
        $data = GetData($sql);

        $taken = array();
        foreach( $data as $row )
        {
            $taken[] = $row['taa_omschrijving'];
        }
        $takenlijst = "<ul><li>" . implode( "</li><li>" , $taken ) . "</li></ul>";

        echo "<tr>";
        echo "<td>" . date("l", $d). "</td>";
        echo "<td>" . date("d/m/Y", $d). "</td>";
        echo "<td>" . $takenlijst . "</td>";
        echo "</tr>" ;
    }

    echo "</table>";

}

//------------scrolling  a agenda day by day, using database , get, and datetime class---------

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
