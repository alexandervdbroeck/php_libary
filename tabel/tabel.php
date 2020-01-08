<?php

// the first function makes a table (including the head of the tabel) from a sql statement and returns the tabel
// second function returns a table from an array.
function CreateTableFromSQL($sql){
    $data = GetData($sql);
    $arr = array();
    // prints the head first from the values
    $tekst = "<thead><tr><th>";
    foreach ($data[0] as $head => $val){
        $arr[].= $head;
    }
    $tekst .= implode("</th><th>",$arr)."</th></tr></thead><tbody>";

    // starting from the second row the data is filed in
    $arr = array();
    foreach ($data as $user){
        foreach ($user as $val){
            $arr[].= $val;
        }
        $tekst .= "<tr><td>".implode("</td><td>",$arr)."</tr>";
        $arr = array();
    }
    $tekst .= "</tbody>";
    return $tekst;

}

function ArrayToTable($array){
    $table = "<table>";
    foreach ($array as $item => $value) {
        $table .= "<tr><td>".ucfirst($item)."</td><td>$value</td></tr>";
    }
    $table .="</table>";
    return $table;
}
