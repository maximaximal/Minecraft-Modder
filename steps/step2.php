<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1>Step 2: Select your Version</h1>
<p>
    Please choose the version of the uploaded minecraft.jar in the dropdown-list. We are trying to keep this up to date, but you could still select the "Advanced" option, which won't give you some mods to install. <br> All listed versions will have some mods, which are installable with only one click!
</p>
<form enctype="multipart/form-data" name="mcversion" method="POST" action="">
    <select name="version">
        <option>Advanced</option>
        <option>1.2.5</option>
    </select>
    <input type="button" value="Select" onclick="gotoStep3()">
</form>