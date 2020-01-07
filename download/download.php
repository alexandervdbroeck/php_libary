<?php
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