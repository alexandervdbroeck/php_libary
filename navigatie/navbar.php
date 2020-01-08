<?php
function PrintNavBar()
{
    //navbar items ophalen

    $data = GetData("select * from navigation order by nav_order ");

    // welke webpagina is actief
    $filePath = basename($_SERVER['SCRIPT_NAME']);
    $items_temp = LoadTemplate('nav_items');
    // nav bar items samenstellen
    foreach ( $data as $row => $value )
    {

        if($data[$row]['nav_path'] == $filePath){
            $data[$row]['active'] = "active";
        }else{
            $data[$row]['active'] = "";
        }

    }
    $items = ReplaceContent($data,$items_temp);
    $temp = LoadTemplate('nav');
    print str_replace("@@navitems@@",$items,$temp);
}