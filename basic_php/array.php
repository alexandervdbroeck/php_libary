<?php
$eerste = array("bla","bla","blabla");
$tweede = ["bla","bla","blablabla"];

// assosiative
$eerste = array("bla"=>1,"blabla"=>2);
print_r($eerste);

// toegang tot array

echo array_key_exists("bla",$eerste);
//
echo in_array(1,$eerste);

//uit een array helen

$laatste_item = array_pop($eerste);
// verwijderd en geeft het 'laatste element door aan var

unset($tweede[1],$eerste);
var_dump($eerste,$tweede);


// sorteren van array's

sort($tweede );
rsort($eerste);

// loopen door een aray van ass arays:

$filePath = basename($_SERVER['SCRIPT_NAME']);
$items_temp = LoadTemplate('page_section_nav_items');
// nav bar items samenstellen
foreach ( $data as $key => $val )
{

    if($data[$key]['nav_path'] == $filePath){
        $data[$key]['active'] = "active";
    }else{
        $data[$key]['active'] = "";
    }

}

// een ass array naar een tabel schrijven

function ArrayToTable($array){
    $table = "<table>";
    foreach ($array as $item => $value) {
        $table .= "<tr><td>".ucfirst($item)."</td><td>$value</td></tr>";
    }
    $table .="</table>";
    return $table;
}