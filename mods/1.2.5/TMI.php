<?php
include "../installAPI.php";
include "../../pclzip.lib.php";

$Process = $_GET['process'];
$API = new installAPI();
$API->Init($Process);

$Status = true;

//Installation Script

if(!$API->ExtractToJar("TMI.zip"))
{
    echo "Error unzipping the file TMI.zip";
    $Status = false;
}

//Return true
echo "true";
?>
