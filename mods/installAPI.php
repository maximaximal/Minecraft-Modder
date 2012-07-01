<?php
class installAPI
{
    private $Process = null;
    private $Jar = "";
    private $Mods = "";
    private $Modding = "";
    private $Log = "";
    private $Scripts = "";
    
    public $Version = "0.5";
    
    public function Init($Process)
    {
        $Home = $_SERVER["DOCUMENT_ROOT"];
        $this->Process = $Process;
        $this->Jar = "$Home/work/$Process/modding/bin/minecraft/";
        $this->Mods = "$Home/work/$Process/modding/mods/";
        $this->Modding = "$Home/work/$Process/modding/";
        $this->Log = "$Home/work/$Process/modding/log/";
        $this->Scripts = "$Home/scripts/";
        if(!file_exists($this->Log))
            mkdir($this->Log);
        $this->log_Root("installAPI - V $this->Version initialized!");
        include "$Home/functions.php";
    }
    private function log_Root($Line)
    {
        $Line = "[".date("d.M.Y H:i:s")."] $Line \n";
        $handle = fopen($this->Log."install.log", "a+");
        fwrite($handle, $Line);
        fclose($handle);
    }
    private function log_Script($Line, $Name)
    {
        $Line = "[".date("d.M.Y H:i:s")."] $Line \n";
        $handle = fopen($this->Log."$Name.log", "a+");
        fwrite($handle, $Line);
        fclose($handle);
    }
    public function log($Line, $From)
    {
        $Line = "# [".date("d.M.Y H:i:s")."] [$From] $Line \n";
        $handle = fopen($this->Log."install.log", "a+");
        fwrite($handle, $Line);
        fclose($handle);
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
            $this->log_Root("Extracted $file to $target");
            return true;
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
                    $this->log_Root("The path \"$Path\" is nice!");
                    return true;
                }
                else
                    $this->log_Root("The path \"$Path\" is bad!");
                    return false;
            }
            else
                $this->log_Root("The path \"$Path\" is bad!");
                return false;
        }
        else
            $this->log_Root("The path \"$Path\" is bad!");
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
            $CensoredPath = $Path;
            $Path = $this->Jar."$Path";
            if(is_file($Path))
            {
                unlink($Path);
                $this->log_Root("The file \"$CensoredPath\" was deleted!");
                return true;
            }
            else if(!is_file($Path))
            {
                if(!delete_directory($Path))
                {
                    $this->log_Root("The directory \"$CensoredPath\" was not deleted!");
                    return false;
                }
                $this->log_Root("The directory \"$CensoredPath\" was deleted!");
                return true;
            }
        }
        else
            $this->log_Root("Nothing happened with \"$CensoredPath\" because it's bad!");
            return false;
    }
    public function ExtractToJar($file, $Folder = "database")
    {
        if($this->TestPath($file))
        {
            $Target = $this->Jar;
            if ($Folder == "modding")
                $file = $this->Modding;
            $archive = new PclZip($file);
            if ($archive->extract(PCLZIP_OPT_PATH, $Target,
                              PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
                $this->log_Root("Extraction of $file failed, this is the error:".$archive->errorInfo(true));
                die("Error : ".$archive->errorInfo(true));
            }
            $this->log_Root("$file extracted succefully to minecraft.jar!");
            return true;
        }
        $this->log_Root("Nothing happened with \"$file\" because it's bad!");
    }
    public function Delete($Path)
    {
        if($this->TestPath($Path))
        {
            $CensoredPath = $Path;
            $Path = $this->Modding."$Path";
            if(is_file($Path))
            {
                unlink($Path);
                $this->log_Root("The file \"$CensoredPath\" was deleted!");
                return true;
            }
            else if(!is_file($Path))
            {
                if(!delete_directory($Path))
                {
                    $this->log_Root("The directory \"$CensoredPath\" was not deleted!");
                    return false;
                }
                $this->log_Root("The directory \"$CensoredPath\" was deleted!");
                return true;
            }
        }
        else
            $this->log_Root("Nothing happened with \"$CensoredPath\" because it's bad!");
            return false;
    }
    public function Compress($Directory, $Name)
    {
        if ($this->TestPath($Directory) == true)
        {
            $Directory = $this->Modding.$Directory;
            exec("cd /usr/www/users/maximat/MC-Modder/work/".$this->Process."/modding/$Directory && zip -r $Name *") or die("ZIP FAIL!");
        }
        $this->log_Root("Nothing happened with \"$Directory\" named $Name, because it's bad!");
    }
    public function InterpretScript($Path)
    {
        $this->log_Root("Script Interpreter called - Script-Path: $Path");
        if ($this->TestPath($Path))
        {
            $Home = $_SERVER["DOCUMENT_ROOT"];
            $Name = substr($Path, 0, -5);
            
            $handle = fopen($this->Scripts."$Path", "r");
            $Script = fread($handle, filesize($this->Scripts."$Path"));
            fclose($handle);
            
            $Script = str_replace("\r\n", '', $Script);
            $Script = str_replace("\n", '', $Script);
            $Script = str_replace(chr(13), '', $Script);
            
            $Script_Lines = explode(";", $Script);
            $this->log_Root("$Path Script running...");
            $this->log_Script("Started Script Execution", $Name);
            
            foreach($Script_Lines as $Key => $Line)
            {
                $Cmd = explode(" ", $Line);
                switch($Cmd[0])
                {
                    case "ExtractToJar":
                        $this->log_Script("[$Key] - ExtractToJar (Args: \"$Cmd[1]\", \"$Cmd[2]\")", $Name);
                        $this->ExtractToJar($Cmd[2], $Cmd[1]);
                        break;
                    case "log":
                        $Words = "";
                        foreach($Cmd as $Word)
                        {
                            $Words = "$WordsBefore $Word";
                            $WordsBefore = $Words;
                        }
                        $Words = substr($Words, 5);
                        $this->log_Script("[$Key] - $Words", "$Name");
                        $Words = "";
                        $WordsBefore = "";
                        break;
                    default:
                        $this->log_Script("[$Key] - Command $Cmd[0] was not known by the interpreter!", "$Name");
                }
            }
            $this->log_Root("$Path Script ran out succefully!");
        }
        $this->log_Root("Script Interpreter aborted - Invalid script path!");
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
