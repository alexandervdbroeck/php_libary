<?php
include_once "lib/lib.php";
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

