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

// function that prints a week in a tabel, when giving it a weeknumer (2digit) and a year
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
