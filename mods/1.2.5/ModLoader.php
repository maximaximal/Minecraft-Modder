<?php
include "../installAPI.php";
include "../../pclzip.lib.php";

$Process = $_GET['process'];
$API = new installAPI;
$API->Init($Process);

//Installation Script

if(!$API->JarDelete("META-INF"))
    echo "Error deleting the META-INF Folder!";
if(!$API->ExtractToJar("ModLoader.zip"))
    echo "Error extracting ModLoader.zip!";

//Return true
echo "true";
?>
