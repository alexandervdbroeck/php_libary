<?php

// csv bestand schrijven aan de hand van een sql statement
function CreateCsvFromSql($sql,$filename){
    // data ophalen
    $data = GetData("$sql");
    // hoofding verzamelen

    $arr = array();
    foreach ($data[0] as $head => $val){
        $arr[].= $head;
    }
    $tekst = implode(";",$arr)."\r\n";

    // data invullen
    $arr = array();
    foreach ($data as $user){
        foreach ($user as $val){
            // klein aanpassing om te vermijden als er in een text newlines voorkomen dat deze een nieuwe lijn in het csv bestand gaan maken.
            $arr[].= preg_replace('[\r\n]+', '', $val);
        }
        $tekst .= implode(";",$arr)."\r\n";
        $arr = array();
    }

    //bestand schrijven
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, $tekst) or die("unable to write file");
    fclose($myfile);
}



function GetCsvFromFile($filename){
    $content =array();
    $i = 0;
    if (($handle = fopen("postlijst.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $content[$i]= $data;
            $i++;

        }
        fclose($handle);
    }
    return $content;
}

function DownloadFile($name){
    $f=$name;

    $file = ("$f");

    $filetype=filetype($file);

    $filename=basename($file);

    header ("Content-Type: ".$filetype);

    header ("Content-Length: ".filesize($file));

    header ("Content-Disposition: attachment; filename=".$filename);

    readfile($file);

}

function OpenFileAndRead($filename){
    $file = fopen($filename,"r");
    $content = fread($file,filesize($filename));
    fclose($filename);
    return $content;
}


// Schrijf een bestand , en bevistigd of dit is uitgevoerd of niet
function WriteFile($file,$tekst){

    $myfile = fopen($file, "w");
    if (fwrite($myfile, $tekst))
    {
        fclose($myfile);
        return true;
    }
    else
    {
        return false;
    }

}

function GetFileAndWrap($filename,$wrap= 20){
    $content = OpenFileAndRead($filename);
    $content = str_replace(array("\n", "\r"), ' ', $content);
    $newcontent = wordwrap("$content",$wrap);
    return $newcontent;
}