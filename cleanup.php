<?php
/*
 * This cleans up the download directory!
 */

include "functions.php";

echo "<h1>Cleanup Script - Output</h1>";

echo "<h2>Cleaning the downloads...</h2>";

foreach (glob("download/"."*.zip") as $filename){
    $censored_filename = substr($filename, 9);
    $old = time() - filectime($filename);
    $remainingTime = 1000 - $old;
    echo "Filename = '$censored_filename' - Is ".$old." sec old - ".$remainingTime."s until delete... (".(filesize($filename) / 1024 / 1024)." MB)<br>";
    if (filectime($filename) + 1000 <= time())
    {
        unlink($filename);
        echo "<strong style='color: red'>DELETED: </strong> '$censored_filename' - was ".$old."sec old (".(filesize($filename) / 1024 / 1024)." MB)<br>";
    } 
}


echo "<h2>Cleaning the work-directories</h2>";
$verz = $_SERVER['DOCUMENT_ROOT']."/work/";
            chdir($verz);
            $handle = opendir($verz);
                    while ($dname = readdir($handle))
                    {                     
                        if (is_dir($dname) and $dname != '.' and $dname != '..')
                        {
                            $filename = $_SERVER['DOCUMENT_ROOT']."/work/$dname/status";
                            
                            $old = time() - filectime($filename);
                            
                            if ($old > 4000)
                            {
                                echo "<strong style='color: red'>DELETED:</strong> Directory $dname - older than 4000 seconds ($old seconds) (".get_gesamt_size($_SERVER['DOCUMENT_ROOT']."/work/$dname/").")<br>";
                                if (exec("rm -r /usr/www/users/maximat/MC-Modder/work/$dname/"))
                                    echo "    <strong>-Delete failed!</strong> <br>";
                                
                            }
                            else
                                echo "Directory $dname is $old seconds old. - ".(4000 - $old)." seconds until delete (".((get_gesamt_size($_SERVER['DOCUMENT_ROOT']."/work/$dname/")) / 1024 / 1024)." MB)<br>";
                        }
                    }
                    closedir ($handle);
echo "<h2>Refresh</h2>";
echo "<input type='button' value='Refresh' onclick='RefreshCleanupSite()'>";


function get_gesamt_size($dir)
{ //From http://www.tutorials.de/php/181032-ordnergroesse-anzeigen-mb.html
   $fp=opendir($dir);
   while($file=readdir($fp)){
   if ($file != "." && $file != "..") {
   if(is_dir($dir.$file)) $size=get_gesamt_size($dir.$file."/")+$size;
   else $size=filesize($dir.$file)+$size;
   }
   }
   closedir($fp);
   return $size;
   }
?>