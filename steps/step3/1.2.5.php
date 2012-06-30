<h1>Easy Mode</h1>
<h6>Minecraft Version: 1.2.5 - Last Update: 30. 06. 2012</h6>

<p>Now you will have to select your mods, which you want to include in your minecraft installation. All mods listed here are hosted with <a href="http://mcmodder.maximaximal.com#permission" target="this">permission</a> of the authors on our server.</p>
<form enctype="multipart/form-data" method="POST" name="ModForm" action="">
    <h2>Inventory Editing</h2>
        <input type="radio" name="invedit" value="tmi"> Too Many Items <br>
        <input type="radio" name="invedit" value="nei"> Not Enough Items <br>
        <input type="radio" name="invedit"> None <br>
    <h2>Miscelanous</h2>
        <input type="checkbox" name="spc"> Single Player Commands <br>
        <input type="checkbox" name="spc"> Rei's Minimap <br>
    <h2>Install</h2>
        <input type="button" value="Install selected Mods!" onclick="install()">
</form>

<input type="button" value="Download!" onclick="DownloadModded()">
