function proceed(from, to) {
    document.getElementById(from).style.display = "none"; 
    document.getElementById(to).style.display = "block"; 
}
function show(id) {
    document.getElementById(id).style.display = "block";
}
function hide(id) {
    document.getElementById(id).style.display = "none";
}
function modinfo(mod) {
    document.getElementById("mod_info").className = ""
}
//------------------------------
// Message-Box
// Includes:
//              includes/messagebox.html
//------------------------------
function message(titel, text) {
    document.getElementById("messagebox_titel").firstChild.nodeValue = titel;
    document.getElementById("messagebox_text").firstChild.nodeValue = text;
    document.getElementById("messagebox").style.display = "block";
    window.setTimeout("document.getElementById('messagebox').style.display = 'none';", 10000); //Delay for 10 seconds until hide
}
//------------------------------
// Loading
//------------------------------
function LoadingScreen_Show(title) {
    document.getElementById("loading_title").innerHTML = title;
    document.getElementById("loading").style.display = "block";
}
function LoadingScreen_Hide() {
    document.getElementById("loading").style.display = "none";
}
function LoadingBar_Show(title) {
    document.getElementById("loading_title").innerHTML = title;
    document.getElementById("loading_bar").style.display = "block";
}
function LoadingBar_Hide() {
    document.getElementById("loading_bar").style.display = "none";
}
//------------------------------
// Variables
//------------------------------
var ProcessNumber = 0;
var Anchor = null;
var MCVersion = null;
//------------------------------
// Onload
//------------------------------
function SiteLoaded()
{
    //Get the Anchor (To load sub-Sites)
    Anchor = document.location.hash.substr(1);
    if (Anchor == "")
        Anchor = null;
    //Run the cleanup script
    if(Anchor == "disclaimer")
    {
        document.getElementById("step").innerHTML = getFile("disclaimer.php", "Disclaimer");
    }
    if(Anchor == "cleanup")
    {
        document.getElementById("step").innerHTML = getFile("cleanup.php", "Cleanup");
    }
    else if(Anchor == null)
    {
        getFile("cleanup.php", "Cleaning up...");
        gotoStep1();
    }
    //Process Number to the Footer!
    document.getElementById("footer_processnumber").innerHTML = ProcessNumber;
    
}
//------------------------------
// Refresh Cleanup Site
//------------------------------
function RefreshCleanupSite()
    {
        document.getElementById("step").innerHTML = getFile("cleanup.php", "Cleanup Script");
    }
//------------------------------
// Goto Step 1
//------------------------------
function gotoStep1()
{
        //Get the Client-ID (Only after 20 sec!)
        ProcessNumber = getFile("getID.php", "Getting the Client ID");
        if (ProcessNumber > 0)
        {
            document.getElementById("step").innerHTML = getFile("steps/step1.php", "Step 1");
        }
        else
        {
            document.getElementById("step").innerHTML = "<h1>You've refreshed to often! (Or a server-fail...)</h1><p>You have to wait 30 seconds between each modding process.";
        }
}
//------------------------------
// Get the File from the Server with AJAX
//------------------------------
function getFile(url, text)
{
    var response = null;
    jQuery.ajax({
                url: url ,
                beforeSend:function(){
                LoadingBar_Show(text);
                },
                success:function(data) {
                    LoadingBar_Hide();
                    response = data;
                },
                error:function(){
                    LoadingBar_Hide();
                    message("Error", "There was an error in the Web-Request!")
                },
                async:false
            });
    LoadingBar_Hide();
    return response;
}
//------------------------------
// Check Uploaded File Status (Minecraft.jar)
//------------------------------
function checkMinecraftJar()
{
    if (getStatus() == "true")
    {
        gotoStep2();
    }
    else
    {
        document.getElementById("step").innerHTML = getFile("jarerror.php", "Error with the minecraft.jar");
    }
}
//------------------------------
// Get the Status
//------------------------------
function getStatus()
{
    var answer = null;
    jQuery.ajax({
            url: 'http://mcmodder.maximaximal.com/work/' + ProcessNumber + '/status' ,
            beforeSend:function(){
                LoadingBar_Show("Status");
            },
            success:function(data) {
                LoadingBar_Hide();
                if (data == "false")
                {
                }
            else
                {
                    answer = data;
                }
            },
            error:function(){
                LoadingBar_Hide();
            },
            async:false
        });
    return answer;
}

//------------------------------
// Step2
//------------------------------
function gotoStep2()
{
    document.getElementById("step").innerHTML = getFile("steps/step2.php");
}
//------------------------------
// Goto Step 3 (Form Data!)
//------------------------------
function gotoStep3()
{
    MCVersion = document.mcversion.version.value;
    document.getElementById("step").innerHTML = getFile("steps/step3/" + MCVersion + ".php", "Step 3");
    LoadingScreen_Hide();
    
    LoadingBar_Show("Install-Script");
    $.getScript('js/installscript.js', LoadingBar_Hide());
}
//------------------------------
// Info-Sidebar
// Includes:
//              includes/sidebar_info.html
//------------------------------

function sinfo_show(name) {
    id = "info_" + name;
    sinfo_hideall();
    document.getElementById(id).style.display = "block";
    return id;
}
function sinfo_hideall() {
    document.getElementById("info_ModLoader").style.display = "none";
    document.getElementById("info_minecraftjar").style.display = "none";
    document.getElementById("info_MC-Forge").style.display = "none";
    document.getElementById("info_TMI").style.display = "none";
}
function sinfo_hide(name){
    id = "info_" + name;
    document.getElementById(id).style.display = "none";
    return "Id: " + id + " succesfully hidden!";
}
//------------------------------
// Modlist
//------------------------------
var ModList = new Array();

function ModList_Get()
{
    var list = "<ul> <li>" + ModList.join("</li> <li>") + "</li> </ul>";
    return list;
}
function ModList_AddItem(name)
{
    ModList.push(name);
}
function ModList_Load()
{
    document.getElementById("ModList_Container").innerHTML = ModList_Get();
}

//------------------------------
// Download
//------------------------------
function DownloadModded() {
    document.getElementById("step").innerHTML = "<h1>Download</h1><p>Click <a href='download.php?process=" + ProcessNumber + "'>this link</a> to download your (and mine) hard work :)</p>"
}

//------------------------------
// Functions to get the jar
//------------------------------
function verifyUser() {
    var Userdata_String = "user=" + document.minecraft_login.minecraft_Username.value + "&pass=" + document.minecraft_login.minecraft_Password.value;
    jQuery.ajax({
            url: 'http://mcmodder.maximaximal.com/verifyUser.php',
            type: "POST",
            data: Userdata_String + "&process=" + ProcessNumber,
            beforeSend:function(){
                LoadingBar_Show("Checking Username...");
            },
            success:function(data) {
                LoadingBar_Hide();
                if (data == 1)
                {
                    loadJar();
                }
            else
                {
                    message("Authentification failed!", "Cannot verify the user \"" + document.minecraft_login.minecraft_Username.value + "\"! Is the login correct?")
                }
            },
            error:function(){
                LoadingBar_Hide();
            },
            async:false
        });
}
function loadJar() {
    jQuery.ajax({
            url: 'http://mcmodder.maximaximal.com/getMinecraftjar.php',
            type: "POST",
            data: "user=" + document.minecraft_login.minecraft_Username.value + "&process=" + ProcessNumber,
            beforeSend:function(){
                LoadingBar_Show("Get the minecraft.jar...");
            },
            success:function(data) {
                LoadingBar_Hide();
                if (data == "true")
                {
                    gotoStep2();
                }
            else if (data == "no_auth")
                {
                    message("Download failed!", "Your login data was not correct (because the status file said so) - Please reload and log in again!");
                }
            },
            error:function(){
                LoadingBar_Hide();
            },
            async:false
        });
}
//------------------------------
// Browser Detect Script
//      Source: http://www.quirksmode.org/js/detect.html
//------------------------------
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();