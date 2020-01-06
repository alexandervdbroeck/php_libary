<?php
// case

$kleur = "yellow";

switch($kleur){
    case"green":
        echo "green";
        break;
    case "yellow":
        echo "yellow";
        break;
    case "blue":
        echo "blue";
        break;
}

// foreach
$array = ["item 1","item 2","item 3"];
foreach ($array as $title ){
    echo $title;
}

// foreach assosiative array

$array = [1=>"item 1",2=>"item 2",3=>"item 3"];
ksort($array);
foreach ($array as $key=>$val){
    echo "<p>".$key." = ".$val."</p>";
}

// sorteren van arrays
//sort() - sort arrays in ascending order
//rsort() - sort arrays in descending order
//asort() - sort associative arrays in ascending order, according to the value
//ksort() - sort associative arrays in ascending order, according to the key
//arsort() - sort associative arrays in descending order, according to the value
//krsort() - sort associative arrays in descending order, according to the key

// for loop
$array = ["item 1","item 2","item 3"];

for($i = 0; $i< count($array);$i++){
    echo"<p>".$array[$i]."</p>";
}

// while loop
$array = ["item 1","item 2","item 3"];
$i = 0;
while ($i < count($array)){
    echo"<p>".$array[$i]."</p>";
    $i++;
}

// do while
$array = ["item 1","item 2","item 3"];
$i = 0;

do {
    echo"<p>".$array[$i]."</p>";
    $i++;
}
while ($i < count($array));

