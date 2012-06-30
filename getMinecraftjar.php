<?php

$user = $_POST['user'];
$process = $_POST['process'];

$handler = fopen("work/$process/status" , "r");
$status = fread($handler, 20);
fclose($handler);

$statusarr = explode(";", $status);

if ($statusarr[0] == "auth_true")
{
    $jar = file_get_contents("http://s3.amazonaws.com/MinecraftDownload/minecraft.jar?user=$user");
    $handler = fopen("work/$process/minecraft.jar", "w+");        
    fwrite($handler, $jar);
    fclose($handler);
    include('pclzip.lib.php');
    $archive = new PclZip("work/$process/minecraft.jar");
    if ($archive->extract(PCLZIP_OPT_PATH, "work/$process/modding/bin/minecraft",
                          PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
      die("Error : ".$archive->errorInfo(true));
    }
    unlink("work/$process/minecraft.jar");
    echo "true";
}
else
    echo "no_auth";

?>
