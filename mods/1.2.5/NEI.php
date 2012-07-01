<?php
include "../installAPI.php";
include "../../pclzip.lib.php";

$Process = $_GET['process'];
$API = new installAPI();
$API->Init($Process);

$Status = true;

//Installation Script

$API->InterpretScript("NEI.mcms");

//if(!$API->ExtractToJar("CodeChickenCore.zip") && $Status)
//{
//    echo "Error unzipping the file CodeChickenCore.zip";
//    $API->log("CodeChickenCore.zip was not extracted!", "NEI-Install");
//    $Status = false;
//}
//
//if(!$API->ExtractToJar("NEI.zip") && $Status)
//{
//    echo "Error unzipping the file NEI.zip";
//    $API->log("NEI.zip was not extracted!", "NEI-Install");
//    $Status = false;
//}

//Return true
echo "true";
?>
