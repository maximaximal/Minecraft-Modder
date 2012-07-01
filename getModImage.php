<?php
$Mod = $_GET['mod'];
//This calculates a Image for a Mod (64x64)
header ("Content-type: image/png");
if(file_exists("mods/img/$Mod.png"))
    $image = imagecreatefrompng("mods/img/$Mod.png");
else
{
    $image = imagecreatefrompng("mods/img/standard.png");
    $Mod = substr($Mod, 0, 3);
    imagettftext($image, 20, 0, 8, 30, 000000000, "mods/img/arial.ttf", $Mod);
}
imagePNG($image);
imagedestroy($image);
?>
