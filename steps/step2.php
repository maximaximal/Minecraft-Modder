<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1>Which method do you prefer?</h1>
<p>
    There are multiple ways to mod your MineCraft: The Advanced, the Easy and the Programmers way. They aren't finished yet, so please wait for them...
</p>
<form enctype="multipart/form-data" name="mcversion" method="POST" action="">
    <select name="version">
        <option>Advanced</option>
        <option>1.2.5</option>
        <option>easy</option>
    </select>
    <input type="button" value="Select" onclick="gotoStep3()">
</form>