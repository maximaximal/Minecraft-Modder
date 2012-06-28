<?php

/**
 * Description of functions
 *
 * @author Max Heisinger
 */


/**
 * Löschen eines kompletten Directorys inklusive
 * vorhandenen Files.
 *
 * @param string $path 
 * @return boolean
 */

class Mod {
   
    var $minecraft_jar;
    var $minecraft_bin;
    var $minecraft_folder;
    
    function Init(string $process_number) {
        //This inits the modding process
        mkdir("work/$process_number/modding");
        echo "mod->init: Modding Directory was created!";
        mkdir("work/$process_number/modding/bin");
        echo "mod->init: Bin-Directory was created!";
        mkdir("work/$process_number/modding/bin/minecraft");
        echo "mod->init: minecraft-jar-Directory was created!";
    }
}

function delete_directory($dirname) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            unlink($dirname."/".$file);
         else
            delete_directory($dirname.'/'.$file);    
      }
   }
   closedir($dir_handle);
   rmdir($dirname);
   return true;
}

function CopyDirectory($SourceDirectory, $TargetDirectory)
{
    //THIS FUNCTION IS FROM http://snippets.simplecontent.net/copy_directory.html ! - ALL CREDITS TO THE AUTHOR!
    // add trailing slashes
    if (substr($SourceDirectory,-1) != '/'){
        $SourceDirectory .= '/';
    }
    if (substr($TargetDirectory,-1) != '/'){
        $TargetDirectory .= '/';
    }



    $handle = @opendir($SourceDirectory);
    if (!$handle) {
        die("Das Verzeichnis $SourceDirectory konnte nicht geöffnet werden.");
    }


    if (!is_dir($TargetDirectory)) {
        mkdir($TargetDirectory);
        chmod($TargetDirectory, 0755); 
    }


    while ($entry = readdir($handle) ){
        if ($entry[0] == '.'){
            continue;
        }

        if (is_dir($SourceDirectory.$entry)) {
            // Unterverzeichnis
            $success = CopyDirectory($SourceDirectory.$entry, $TargetDirectory.$entry);

        }else{
                $target = $TargetDirectory.$entry;
            copy($SourceDirectory.$entry, $target);
            chmod($target, 0755); 
        }
    }
    return true;
}

?>
