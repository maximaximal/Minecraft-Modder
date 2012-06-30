<?php
include "../installAPI.php";
include "../../pclzip.lib.php";

$Process = $_GET['process'];
$API = new installAPI();
$API->Init($Process);

$Status = true;

//Installation Script

if(!$API->ExtractToJar("CodeChickenCore.zip") && $Status)
{
    echo "Error unzipping the file CodeChickenCore.zip";
    $Status = false;
}

if(!$API->ExtractToJar("NEI.zip") && $Status)
{
    echo "Error unzipping the file NEI.zip";
    $Status = false;
}
//Return true
echo "true";
?>
