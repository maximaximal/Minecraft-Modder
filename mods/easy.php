<?php
//Easy modding - Made possible with jQuery (Just Drag 'n Drop the Mods into a virtual container)
?>

<h1>Step 3: Select your Mods (Version 1.2.5)</h1>
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