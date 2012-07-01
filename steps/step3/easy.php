<?php
//Easy modding - Made possible with jQuery (Just Drag 'n Drop the Mods into a virtual container)
?>
<h1>Easy Mode</h1>
<h6>Minecraft Version: 1.2.5 - Last Update: 30. 06. 2012</h6>

<p>I've developed this mode to make this modding stuff easier to understand and quicker to do. You just have to drag 'n drop the Mods below into the box on the right. Not all of the mods do have images, but they aren't as important as a working modding process ;)</p>
<br>
<p>If you're one of those guys who would love to look into my system, visit my developer site. I've done a good API to interact with my server, which is accessable through javascript (Yea Server-Side JavaScript!). Due to security problems you don't have direct PHP-Access. Hope you understand!<br>
    <a href="#develop">Developer Base</a>
</p>

<div id="AvailableMods">
    <div class="ModBox" id="NEI">
        <div class="ModBoxInfo">
            <h1>NEI</h1>
            <h2>Not Einough Items</h2>
            <p>The ingame inventory-editor by chickenbones.</p>
        </div>
        <div class="expand">
            <a href="http://www.minecraftforum.net/topic/909223-125-smp-chickenbones-mods/"><h1>Not Enough Items</h1></a>
            <p>Inventory editing in a new way.</p>
            <h2>Installs:</h2>
            <ol>
                <li>ModLoader</li>
                <li>CodeChickenCore</li>
            </ol>
        </div>
    </div>
    <div class="ModBox" id="TMI">
        
    </div>
    <div class="ModBox" id="SPC">
        
    </div>
</div>

<input type="button" value="Download!" onclick="DownloadModded()">