<?php
include 'functions.php';

$filename=$_FILES['uploaded']['name'];
$tempfilename=$_FILES['uploaded']['tmp_name'];
$filetype = "application/x-jar";

$process_number = $_GET["process"];

if ($filename == "minecraft.jar" && $filetype == "application/x-jar")
{  
    $target = "work/$process_number/"; 
    $target = $target.basename($_FILES['uploaded']['name']);
    
    
        //Make the Directory (Process)
    mkdir("work/$process_number/");

     
    if (move_uploaded_file($tempfilename, $target)) {
    }
    else {
        echo "false";
        $handler = fOpen("work/$process_number/status" , "w");
        fWrite($handler , "false");
        fclose($handler);
    }  
    mkdir("work/$process_number/modding");
    mkdir("work/$process_number/modding/mods");
    mkdir("work/$process_number/modding/bin");
    mkdir("work/$process_number/modding/bin/minecraft");
        //Extract the JAR
    include('pclzip.lib.php');
    $archive = new PclZip($target);
    if ($archive->extract(PCLZIP_OPT_PATH, "work/$process_number/modding/bin/minecraft",
                          PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
      die("Error : ".$archive->errorInfo(true));
    }

    $handler = fOpen("work/$process_number/status" , "w");
    fWrite($handler , "true");
    fclose($handler);
    
    unlink("$target");  
    if (!unlink("work/$process_number/modding/bin/minecraft/META-INF"))
    {
        
    }
}
else
{
    echo "false";
    $handler = fOpen("work/$process_number/status" , "w");
    fWrite($handler , "false");
    fclose($handler);
}
?>
