<?php

$user = $_POST['user'];
$pass = $_POST['pass'];
$process = $_POST['process'];

$DownloadKey = null;

$validate = ValidateUser($user, $pass);
error_reporting(0);
try
{
    mkdir("work/$process");
    mkdir("work/$process/modding");
    mkdir("work/$process/modding/mods");
    mkdir("work/$process/modding/bin");
    mkdir("work/$process/modding/bin/minecraft");
}
catch(Exception $e)
{
    //Nothing to do; 
}
if ($validate != false)
{
    $handler = fopen("work/$process/status" , "w+");
    fWrite($handler , "auth_true;$DownloadKey");
    fclose($handler);
    echo "1";
}
if (!$validate)
{
    $handler = fopen("work/$process/status" , "w");
    fWrite($handler , "auth_failed");
    fclose($handler);
    echo "Auth Failed!";
}


function ValidateUser($Username, $Password) {
  $data_to_send = "user=$Username&password=$Password&version=15";
  $fp = fsockopen("login.minecraft.net", 80);
  fputs($fp, "POST / HTTP/1.1\r\n");
  fputs($fp, "Host: login.minecraft.net\r\n");
  fputs($fp, "Referer: maximaximal.com - Minecraft Login\r\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-length: ". strlen($data_to_send) ."\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  fputs($fp, $data_to_send);
  while(!feof($fp)) {
      $res .= fgets($fp, 128);
  }
  fclose($fp);
  
  $resarr = explode("Close", $res);
  $csvres = explode(":", $resarr[1]);
  
  if ($csvres[1] == "") {
      return false;
  }
  if ($csvres[1] == "deprecated") {
      return $csvres[1];
  }
  else
      return false;
}
?>
