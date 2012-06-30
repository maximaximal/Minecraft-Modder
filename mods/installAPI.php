<?php
class installAPI
{
    private $Process = null;
    
    private $Jar = "";
    private $Mods = "";
    private $Modding = "";
    
    public function Init($Process)
    {
        $Home = $_SERVER["DOCUMENT_ROOT"];
        $this->Process = $Process;
        $this->Jar = "$Home/work/$Process/modding/bin/minecraft/";
        $this->Mods = "$Home/work/$Process/modding/mods/";
        $this->Modding = "$Home/work/$Process/modding/";
        
        include "../../functions.php";
    }
    
    public function Extract($file, $Target)
    {
        if ($this->TestPath($file) == true)
        {
            $file = $this->Modding.$file; //Set the path to the modding-Directory / File
            $archive = new PclZip($file);
            if ($archive->extract(PCLZIP_OPT_PATH, $Target,
                              PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
               die("Error : ".$archive->errorInfo(true));
            }
        }
    }
    public function TestPath($Path)
    {
        if($Path.substr($Path, 0, 2) != "..")
        {
            if($Path.substr($Path, 0, 1) != ".")
            {
                if($Path.substr($Path, 0, 1) != "/")
                {
                    return true;
                }
                else
                    return false;
            }
            else
                return false;
        }
        else
            return false;
    }
    /**
     *Löscht eine Datei/Ordner in der minecraft.jar
     * @param type $Path Pfad zur Datei/Ordner (Von der JAR-Datei ausgehend)
     * @return boolean Wenn erfolgreich, wird true zurückgegeben.
     */
    public function JarDelete($Path)
    {
        if($this->TestPath($Path))
        {
            $Path = $this->Jar."$Path";
            if(is_file($Path))
            {
                unlink($Path);
                return true;
            }
            else if(!is_file($Path))
            {
                if(!delete_directory($Path))
                    return false;
                return true;
            }
        }
        else
            return false;
    }
    public function ExtractToJar($file)
    {
        if($this->TestPath($file))
        {
            $Target = $this->Jar;
            $archive = new PclZip($file);
            if ($archive->extract(PCLZIP_OPT_PATH, $Target,
                              PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
                die("Error : ".$archive->errorInfo(true));
            }
            return true;
        }
    }
    public function Compress($Directory, $Name)
    {
        if ($this->TestPath($Directory) == true)
        {
            $Directory = $this->Modding.$Directory;
            exec("cd /usr/www/users/maximat/MC-Modder/work/".$this->Process."/modding/$Directory && zip -r $Name *") or die("ZIP FAIL!");
        }
    }
    
    //----------------------------------
    //  Allowed to get Files from a Remote-Server (Those files will be deleted!)
    //----------------------------------
    /**
     * Lädt eine Datei von einer URL unter einem gewissen Namen in das modding-Verzeichnis des Prozesses.
     * 
     * Enthält eine Funktion von macki http://stackoverflow.com/questions/2602612/php-remote-file-size-without-downloading-file
     * @param type $Url Die URL des Mods
     *                  Maximal 8MB groß, ansonsten wird der Download nicht gestartet!
     * @param type $Name Name der Datei die im modding-Verzeichnis des Prozesses gespeichert wird.
     * @param type $Overwrite Wenn der Name bereits im Modding Verzeichnis vorhanden ist, wird bei true die Datei überschrieben und bei false eine Errormeldung ausgegeben.
     */
    public function GetMod($Url, $Name, $Overwrite)
    {
        $handle = curl_init($Url) or die("false");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_HEADER, TRUE);
        curl_setopt($handle, CURLOPT_NOBODY, TRUE);
        $data = curl_exec($handle);
        $size = curl_getinfo($handle, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($handle);

        if (!$size > 8388608) // = 8 MegaByte - MB
        {
            $handle = fopen($Url, "r");
            $File = fread($handle, $size);
            fclose($handle);
            if(!file_exists($this->Modding."$Name"))
            {
                $handle = fopen($this->Modding."$Name", "w+");
                fwrite($handle, $File);
                fclose($handle);
                return true;
            }
            if(file_exists($this->Modding."$Name") && $Overwrite == true)
            {
                unlink($this->Modding."$Name");
                $handle = fopen($this->Modding."$Name", "w+");
                fwrite($handle, $File);
                fclose($handle);
                return true;
            }
            if(file_exists($this->Modding."$Name"))
                return false;
        }
        else
            return false;
    }
}
?>
