<h1>Step 3: Select your Mods Advanced Mode</h1>
<p>
    This is the advanced mode! You have to upload your own mod-files, and you'll have to look for them by yourself!
    
    The uploaded files will be extracted to the destination (choosen by you) and there won't be any checks for compability!
    
    You can select the "mods/" folder, or the minecraft.jar!
</p>

<div id="ModList_Container">
    
</div>
<form enctype="multipart/form-data" method="POST" action="" name="UploadMod">
    <input type="file" name="mod" id="mod"><br>
    <select name="Type">
        <option name="MOD" value="MOD">mods Folder</option>
        <option name="JAR" value="JAR">minecraft.jar</option>
    </select>
    <input type="text" name="ModName">Name of the mod<br>
    <input type="button" value="Send" onclick="uploadMinecraftMod()"><br>
</form>

<input type="button" value ="Download - Will delete the files on the Server!!!" onclick="DownloadModded()">