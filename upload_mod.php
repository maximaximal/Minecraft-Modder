<?php
echo "MOD-UPLOAD SCRIPT<br>";
echo "by maximaximal<br>";

echo '<a href="javascript:window.close()">Fenster schließen</a>'; //Fenster Schließen

    //required for many functions!
include 'functions.php';
echo "Functions included!<br>";


$process = $_GET["process"];    //Process-Number
echo "The Process-Number of this Mod-Upload is: $process <br>";

$filename=$_FILES['mod']['name'];  //Filename of the Uploaded File
$tempfilename=$_FILES['mod']['tmp_name']; //Tempfilename

echo "<hr><h2>Statistics of the file</h2>";
echo "Filename: ".$_FILES['mod']['name']."<br>";
echo "Filetype: ".$_FILES['mod']['type']."<br>";

$handler = fOpen("work/$process/status" , "w");
    fWrite($handler , "$filename");
    fclose($handler);

echo "<hr>";
if ($_GET["type"] == "JAR")
{
    echo "Now unpacking the ZIP...";
    include('pclzip.lib.php');
    $archive = new PclZip($tempfilename);
    if ($archive->extract(PCLZIP_OPT_PATH, "work/$process/modding/bin/minecraft",
                          PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
      die("Error : ".$archive->errorInfo(true));
    }
    echo "Unpacked ZIP & installed it to the jar!";
}
else if ($_GET["type"] == "MOD")
{
    echo "Now copying the MOD!";
    move_uploaded_file($tempfilename, "work/$process/modding/mods/$filename");
    echo "Mod Installed!";
}
?>
