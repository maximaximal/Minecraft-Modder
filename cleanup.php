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
    echo "Filename = '$censored_filename' - Is ".$old." sec old - ".$remainingTime."s until delete...<br>";
    if (filectime($filename) + 1000 <= time())
    {
        unlink($filename);
        echo "<strong style='color: red'>DELETED: </strong> '$censored_filename' - was ".$old."sec old<br>";
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
                                echo "<strong style='color: red'>DELETED:</strong> Directory $dname - older than 4000 seconds ($old seconds) (".calcSize(get_size($filename, 0)).")<br>";
                                if (exec("rm -r /usr/www/users/maximat/MC-Modder/work/$dname/"))
                                    echo "    <strong>-Delete failed!</strong> <br>";
                                
                            }
                            else
                                echo "Directory $dname is $old seconds old. - ".(4000 - $old)." seconds until delete (".calcSize(get_size($filename, 0)).")<br>";
                        }
                    }
                    closedir ($handle);
echo "<h2>Refresh</h2>";
echo "<input type='button' value='Refresh' onclick='RefreshCleanupSite()'>";

function get_size($path,$size)
    {
      if(!is_dir($path))
        {
          $size+=filesize($path);
        }
      else
        {
          $dir = opendir($path);
          while($file = readdir($dir))
            {
              if(is_file($path."/".$file))
                $size+=filesize($path."/".$file);
              if(is_dir($path."/".$file) && $file!="." && $file!="..")
                $size=get_size($path."/".$file,$size);
            }
        }
      return($size);
    }
    function calcSize($size)
    {
  $measure = "Byte";
  if ($size >= 1024)
    {
      $measure = "KB";
      $size = $size / 1024;
    }
  if ($size >= 1024)
    {
      $measure = "MB";
      $size = $size / 1024;
    }
  if ($size >= 1024)
    {
      $measure = "GB";
      $size = $size / 1024;
    }
  $size = sprintf("%01.2f", $size);
  return $size . " " . $measure;
    }
?>