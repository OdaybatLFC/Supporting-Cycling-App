<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="cycleApp.css">
    <link rel="icon" href="cycleIcon.png"/>
    <link rel="apple-touch-icon" href="cycleIcon.png"/>
    <link rel="shortcut icon" href="cycleIcon.png" type="image/x-icon"/>
    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="mobile-web-app-fullscreen" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <title>Getting Started</title>

</head>
<body>

    <header><a href="index.html"><img src="homeIcon.png" id="homeNav"></a>
        <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Getting Started</header>

    <main>
        <div id = "logout">
        <p>You successfully logged out!</p>
        <?php
            // delete the currentUser cookie, as the current user is logged out
            setcookie("currentUser", "", time() - 1);
        ?>
        <p class="message">Go back to the <a href="index.html">main</a> page?</p>
            <img src="Tick.webp" id="pic">
        </div>
    </body>
</html>