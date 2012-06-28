//------------------------------
// Install Script
//------------------------------
function install()
{
    for (var i=0; i < document.ModForm.invedit.length; i++)
    {
        if (document.ModForm.invedit[i].checked)
        {
            var invedit = document.ModForm.invedit[i].value;
        }
    }
    
    ModdingStatus = true;
    
    
    if (getFile("mods/" + MCVersion + "/ModLoader.php?process=" + ProcessNumber) != "true")
            ModdingStatus = false;
    if (invedit == "tmi" && ModdingStatus == true)
        if (getFile("mods/" + MCVersion + "/TMI.php?process=" + ProcessNumber) != "true")
            ModdingStatus = false;
    if (invedit == "nei" && ModdingStatus == true)
        if (getFile("mods/" + MCVersion + "/NEI.php?process=" + ProcessNumber) != "true")
            ModdingStatus = false;
}
