<?php
$birthday = (isset($_POST)) ? new DateTime($_POST['leeftijd']): new DateTime("now");
echo $birthday->format("d/m/Y")."<br>";
$age = $birthday->diff(new DateTime("now", new DateTimeZone("Europe/Brussels")))->days;
echo $age;

echo $birthday->format("d-m-Y")."<br>";
echo $age * 24 * 60 ."minuten oud <br>";

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