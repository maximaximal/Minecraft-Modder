<?php

?>
<h1>Log in to minecraft.net!</h1>
<p>You have to login into your minecraft.net Account to verify you have bought the game. I won't steal any passwords or something, because that's stupid and not social. Your data will be transfered to minecraft.net and (if the login is correct) the minecraft.jar will be downloaded from the official servers. This happenbs serverside, so you can't hack the system (You could hack the scripts, but then you wouldn't have a minecraft.jar for your mods ;) ).</p> 
<h2>To Do</h2>
<ol>
    <li>Login to minecraft.net</li>
    <li>Lean back and wait</li>
    <li>Proceed to step2</li>
</ol>
<h2>Login to minecraft.net!</h2>
<form enctype="multipart/form-data" method="POST" action="" name="minecraft_login">
    <table cellspacing="20">
        <tr>
            <td><label name="minecraft_Username">Username</label></td>
            <td><input type="text" name="minecraft_Username"></td>
        </tr>
        <tr>
            <td><label name="minecraft_Password">Password</label></td>
            <td><input type="password" name="minecraft_Password"></td>
            <td><br></td>
            <td><input type="button" value="Send" onclick="verifyUser()"></td>
        </tr>
    </table>
</form>