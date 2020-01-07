<?php

//   My function to save images to a dir

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
    <input class="uploadbutton" type="file" name="filename[]" id="filename" multiple>

    <input type="submit" value="Opladen" name="submit">
</form>
function DeleteAllPostPicturesDirectory($postid){
    $sql = SqlPostImages($postid);
    $data = GetData($sql);
    foreach ( $data as $row )
    {
        foreach($row as $field => $value)
        {
            if($field == "afb_locatie"){
                $value = "../".$value;
                if(!unlink($value)){
                    // als de fotos niet van de server verwijderd kunnen worden zal er een error in de database ingevuld worden
                    $error = " een foto van deze blog werd niet verwijdered";
                    ErrorToDatabase($postid,$error);

                }
            }
        }
    }}

function DeletePostFromDatabase($postid){
    $sql = SqlPostDelete($postid);
    if(ExecuteSQL($sql)){
        return true;
    }else{
        return false;
    }
}
function CheckImages(){
    // controle of er wel een foto is toegevoegd
    if($_FILES["filename"]["name"][0] == ""){
        $_SESSION['error']= "u moet minimum 1 foto toevoegen,";
        return false;
    }
    // check of foto een jpg, png of jpeg is en het extensie van de afbeelding
    $ext_allowed = array(
        "png",
        "jpg",
        "jpeg"
    );
    $countfiles = count($_FILES["filename"]["name"]);
    for($i=0;$i<$countfiles;$i++){

        // Alle afbeeldingen overlopen of deze het juiste fromaat hebben
        $filename = strtolower($_FILES["filename"]["name"][$i]) ;
        $fileExplode = explode(".",$filename);
        $fileExt = end($fileExplode);
        if (! in_array($fileExt,$ext_allowed)){
            $_SESSION['error'] = " u mag enkel jpg, jpeg of png bestanden toevoegen, ";
            return false;
        }
        if ($_FILES['filename']["size"][$i] > 8000000){
            $_SESSION['error'] .= "een afbeelding mag maximum 8MB zijn";
            return false;
        }
    }
    // als er geen errors zijn zal True meegeven worden
    return true;
}



function InsertDatabasePost($tablename){
    global $_application_folder;
    $blogtekst = $_POST['post_blog'];
    $date = new DateTime('NOW', new DateTimeZone('Europe/Brussels'));

    $date = $date->format('d-m-Y');
    $sql = SqlPostInsert($tablename,$blogtekst,$date);

    // Post in database opslaan
    if (!ExecuteSQL($sql)){
        $_SESSION['error']= "er liep iets mis met het opslaan van uw blog ";
        header ("location:".$_application_folder."inspireer.php");
        die;
    }
}
function GetLatestPostid($user_id){
    $sql =  SqlPostGetPostid($user_id);
    $post_id = GetDataOneRow($sql );
    return $post_id['post_id'];
}

function InsertImagesInDirectory($post_id, $user_id){
    global $_application_folder;
    // controle of de user map in de imgages map reeds bestaat en anders aanmaken. (USR_XX)
    if(!is_dir("../images/user_".$user_id))mkdir("../images/user_".$user_id);
    $target_dir = "../images/user_".$user_id."/";

    // controleren hoeveel foto's er toegevoegd moeten worden
    $countfiles = count($_FILES["filename"]["name"]);
    // als er reeds foto's toegevoegd waren, tellen hoeveel.
    $fotonr = 0;
    $fotos = array();

    for($i=0;$i<$countfiles;$i++){

        // foto extensie ophalen in lowercase letters
        $filename = strtolower($_FILES["filename"]["name"][$i]) ;
        $fileExplode = explode(".",$filename);
        $fileExt = end($fileExplode);

        //fotonr creeren aan de hand van de $i
        $fotonr += 1;
        $_FILES["filename"]["name"][$i] = $post_id."_".$fotonr.".".$fileExt;
        $target_file = $target_dir.basename($_FILES["filename"]["name"][$i]);

        // als de fotonaam reeds bestaat de nr verhogen en bestandsnaam veranderen
        while(file_exists($target_file)) {
            $fotonr += 1;
            $_FILES["filename"]["name"][$i] = $post_id."_".$fotonr.".".$fileExt;
            $target_file = $target_dir.basename($_FILES["filename"]["name"][$i]);
        }
        /* deze functie werkt niet op de synta server omwille van instellingen in de php.ini*/
//      compressImage($_FILES["filename"]["tmp_name"][$i],$target_file,40);

        // het opslaan van de afbeeldingen (als dit niet lukt wordt er een foutmelding naar de database bijgehouden
        if(!move_uploaded_file($_FILES["filename"]["tmp_name"][$i],$target_file)){
            $_SESSION['error']= "Sorry, er is een probleem, uw blogtext is opgeslagen, maar een of meerdere van uw foto's niet";
            ErrorToDatabase($post_id,$_SESSION['error']);
            header ("location:../".$_application_folder."inspireer.php");
            die;
        };
//         filename  aan lijst toevoegen voor later gebruik(in database invoer)
        array_push($fotos,$_FILES["filename"]["name"][$i]);

    }
    return $fotos;
}

function InsertImagesDatabase($fotos, $post_id, $user_id){
    $countfiles = count($fotos);
    $sql = "";
    for($i=0;$i<$countfiles;$i++){
        $sql .= "INSERT INTO afbeelding SET afb_post_id =". $post_id.",afb_filename='".$fotos[$i]."', afb_locatie= 'images/user_".$user_id."/".$fotos[$i]."';";
    }
    ExecuteSQL($sql);
}

function DeleteImagesUpdate($postid){

    $data = $_POST['afb_filename'];
    foreach ( $data as $row => $value )
    {
        $sql = SqlSearchImage($value);
        $afb = GetDataOneRow($sql);
        $dir  = "../".$afb['afb_locatie'];
        if(!unlink($dir)){
            // als de fotos niet van de server verwijderd kunnen worden zal er een error in de database ingevuld worden
            $error = " een foto van deze blog werd niet verwijdered";
            ErrorToDatabase($postid,$error);
            die;
        }
        $sql = SqlDeleteImage($value);
        ExecuteSQL($sql);

    } }

$target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
$max_size = 5000000;                                                           //maximum grootte in bytes
$allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];       //toegelaten bestandsextensies

if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" ) //als het juiste form gesubmit werd
{
    //overloop alle bestanden in $_FILES
    foreach ( $_FILES as $f )
    {
        $upfile = array();
        $upfile["name"]                            = basename($f["name"]);
        $upfile["tmp_name"]                    = $f["tmp_name"];
        $upfile["target_path_name"]       = $target_dir . $upfile["name"]; //samenstellen definitieve bestandsnaam (+pad)    //basename
        $upfile["extension"]                      = pathinfo($upfile["name"], PATHINFO_EXTENSION);
        $upfile["getimagesize"]                = getimagesize($upfile["tmp_name"]);                 //getimagesize geeft false als het bestand geen afbeelding is
        $upfile["size"]                                = $f["size"];

        $result = CheckUploadedFile( $upfile, $check_real_image = true, $check_if_exists = false, $check_max_size = true, $check_allowed_extensions = true );

        if ( !$result ) echo "Sorry, your file was not uploaded.<br>";
        else
        {
            //bestand verplaatsen naar definitieve locatie + naam
            if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] ))
            {
                echo "The file " . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"] . "<br>";
            }
            else
            {
                echo "Sorry, there was an unexpected error uploading file " . $upfile["name"] . "<br>";
            }
        }
    }
}

function CheckUploadedFile( $upfile, $check_real_image = true, $check_if_exists = true, $check_max_size = true, $check_allowed_extensions = true )
{
    global $allowed_extensions, $max_size;

    $returnvalue = true;

    // Check if image file is a actual image or fake image
    if ( $check_real_image AND $upfile["getimagesize"] === false )
    {
        echo "File " . $upfile["name"] . " is not an image.<br>"; $returnvalue = false;
    }

    // Check if file already exists
    if ( $check_if_exists AND file_exists($upfile["target_path_name"]))
    {
        echo "File  " . $upfile["name"] . " already exists.<br>"; $returnvalue = false;
    }

    // Check file size
    if ( $check_max_size AND $upfile["size"] > $max_size )
    {
        echo "File  " . $upfile["name"] . "  is too large.<br>"; $returnvalue = false;
    }

    // Allow only certain file formats
    if ( $check_allowed_extensions )
    {
        if ( ! in_array( $upfile["extension"], $allowed_extensions) )
        {
            echo "Wrong extension. Only " . implode(", ", $allowed_extensions) . " files are allowed.<br>";
            $returnvalue = false;
        }
    }
    return $returnvalue;
}
?>