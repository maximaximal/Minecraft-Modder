<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/import.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/ajaxfileupload.js"></script>
        <title>Minecraft Modder</title>
    </head>
    <body onload="SiteLoaded()">
        <!-- Includes - Boxes -->
            <?php include "includes/messagebox.html"?>
            <?php include "includes/loading.html"?>
            <?php include "includes/no_javascript.html"?>
        <!-- Page-Content -->
        <header>
            <div class="container_12">
                <?php include "includes/header.html"?>
            </div>
        </header>
        
        <div id="main" class="container_12">
            <div class="grid_8">
                <!-- Hier ist der Haupt-Content Bereich! -->
                    <div id="step"> 
                        
                    </div>
                        
            </div>
            <div class="grid_4">
                <!-- Hier ist die Seitenleiste! -->
                    <div id="InstallMessages">
                    </div>
            </div>
        </div>
        
        <footer>
            Minecraft Modder - Made by <a href="http://maximaximal.com">maximaximal</a> - Your Process-Number: <span id="footer_processnumber">Not Available!</span>
        </footer>
        <div id="loading">
            <div id="loading_box">
                <h1>Loading</h1>
                <h2 id="loading_title" >Content</h2>
                <img src="css/ajax-loader.gif" alt="Loading...">
            </div>
        </div>
    </body>
</html>
