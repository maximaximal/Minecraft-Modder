<?php
//Unbedingt Session Starten, sonst gehen die Daten des Session-Arrays verloren
session_start();

if(!isset($_SESSION['ip-sperre'])||$_SESSION['ip-sperre']<time()-30)
{
    $_SESSION["ip-sperre"] = time();
    $process_number_absolute = fopen("process_number", "r");
    $process_number = fgets($process_number_absolute);
    fclose($process_number_absolute);

    echo $process_number;
    
    $process_number = $process_number + 1;
    $handler = fOpen("process_number" , "w");
    fWrite($handler , $process_number);
    fClose($handler);
}
else
{
    echo "false";
}
?>
