<?php
include_once "lib/lib.php";
session_start();
print_r($_SESSION['error']);
UploadFiles("img/");
function UploadFiles($target_dir)
{
    $upload_file_array = UploadFileToArray();
    if(UploadFileToArray()=== false)
    {
        $_SESSION['error'][] = "Sorry some ting went wrong, are there images selected?";
        return false;
    }
    if(!CheckImages($upload_file_array,$target_dir))
    {
        return false;
    }elseif(UploadFileToServer($upload_file_array,$target_dir))
    {
        $_SESSION['error'][] = "Succes, your images are saved";
        return true;
    }else{
        return false;
    }

}



function  CheckFileNotEmpty()
{
    if(in_array(0,$_FILES['filename']['size']))
    {
       return false;
    }
    else
    {
        return true;
    }
}

function UploadFileToArray()
{
    if (CheckFileNotEmpty())
    {
        $upload_file_array = array();
        $count = count($_FILES['filename']['name']);
        foreach ($_FILES['filename'] as $key => $value)
        {
            for($x=0;$x< $count;$x++)
            {
                //Save Filename in lowercase
                $upload_file_array[$x][$key]=  ($key == "name")? strtolower($value[$x]): $value[$x];
            }
        }
        return $upload_file_array;
    }else
    {
        return false;
    }
}
function CheckImages($upload_file_array,$target_dir){

    // check of foto een jpg, png of jpeg is en het extensie van de afbeelding
    $ext_allowed = array(
        "png",
        "jpg",
        "jpeg"
    );
    $countfiles = count($upload_file_array);
    for($i=0;$i<$countfiles;$i++){

        // Alle afbeeldingen overlopen of deze het juiste fromaat hebben
        $filename = $upload_file_array[$i]['name'] ;
        $fileExplode = explode(".",$filename);
        $fileExt = end($fileExplode);
        $dir_name = $target_dir.$upload_file_array[$i]['name'];
        if (file_exists($dir_name))
        {
            $_SESSION['error'][] = "this image already  exists";
            return false;
        }
        if (! in_array($fileExt,$ext_allowed)){
            $_SESSION['error'][] = "Sorry only jpeg, gif ,jpg end png allowed";
            return false;
        }
        if ($upload_file_array[$i]['size'] > 8000000){
            $_SESSION['error'][] = "A Image may not be greater then 8 mb";
            return false;
        }
    }
    // als er geen errors zijn zal True meegeven worden
    return true;
}

function UploadFileToServer($upload_file_array,$target_dir){
    foreach ($upload_file_array as $file)
    {
        $dir_name = $target_dir.$file['name'];
        if(!file_exists($dir_name))
        {
            move_uploaded_file($file['tmp_name'],$dir_name);
            return true;
        }else
        {
            $_SESSION['error'][] = " Sorry there seem to be a problem when uploading your files ";
            return false;
        }
    }

}
foreach ($_SESSION['error']as $message=>$key)
{
  print_r($key);
}

unset($_SESSION["error"]);

?>
<form action="#" method="post" enctype="multipart/form-data">
    Select images to upload:
    <input class="uploadbutton" type="file" name="filename[]" id="filename" >

    <input type="submit" value="Opladen" name="submit">
</form>
