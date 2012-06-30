<?php

/*
 * This downloads the full ZIP of the Game-Folder.
 * The Mods are added in the add_mods.php file.
 * 
 * Author: Max Heisinger (maximaximal)
 */

include "functions.php";

//Process-Number
$process = $_GET['process'];

exec("cd /usr/www/users/maximat/MC-Modder/work/$process/modding/bin/minecraft/ && zip -r ../minecraft.jar *");
exec("rm -r /usr/www/users/maximat/MC-Modder/work/$process/modding/bin/minecraft");
exec("cd /usr/www/users/maximat/MC-Modder/work/$process/modding && zip -r ../../../download/download_$process.zip *");
exec("rm -r /usr/www/users/maximat/MC-Modder/work/$process/modding/");

delete_directory("work/$process/");

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"Extract me in your minecraft folder.zip\"");

readfile("download/download_$process.zip");
?>

