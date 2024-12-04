<?php
    function getHeader($title, $page) { ?>
        <!DOCTYPE html>
        <html lang="en-US">

        <head>
            <title><?=$title?></title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
            <link href="../css/style_common.css" rel="stylesheet">
            <link href="../css/style_about_us.css" rel="stylesheet">
            <link href="../css/style_sign_in.css" rel="stylesheet">
            <link href="../css/style_sign_up.css" rel="stylesheet">
            <link href="../css/style_q_a.css" rel="stylesheet">
            <link href="../css/style_q_a_thread.css" rel="stylesheet">
            <link href="../css/style_edit_profile.css" rel="stylesheet">
            <link href="../css/style_ask_question.css" rel="stylesheet">
            <link href="../css/style_user_profile.css" rel="stylesheet">
            <link href="../css/style_other_profile.css" rel="stylesheet">
            <link href="../css/style_mod_appeals.css" rel="stylesheet">
            <link href="../css/style_reports.css" rel="stylesheet">
            <link href="../css/style_mods_dashboard.css" rel="stylesheet">
            <link rel="icon" href="../images/icon.png">
            <script src="../js/common.js" defer></script>
            <script src="../js/q_a_thread.js" defer></script>
            <script src="../js/mod_appeals.js" defer></script>
            <script src="../js/reports.js" defer></script>
        </head>

        <body>
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand px-1" href="../pages/about_us.php">
                        <img  src="../images/logo.png"  height="40" alt="">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <?php getButtons($page) ?>
                    
                </nav>
            </header>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <?php }


    function getButtons($page) {
        if($page === "about_us" || $page === "sign_in" || $page === "sign_up") { ?>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a id="about_us_button" class="nav-link" href="../pages/about_us.php">About Us </a>
                    </li>
                    <li class="nav-item">
                        <a id="q_a_button" class="nav-link" href="../pages/q_a.php">Q&As</a>
                    </li>
                    <li class="nav-item">
                        <a id="sign_up_button" class="nav-link " href="../pages/sign_up.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a id="log_in_button" class="nav-link " href="../pages/sign_in.php">Log In</a>
                    </li>
                    </ul>
                </div>                    
        <?php }
        else { ?>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a id="about_us_button" class="nav-link" href="../pages/about_us.php">About Us </a>
                    </li>
                    <li class="nav-item">
                        <a id="q_a_button" class="nav-link" href="../pages/q_a.php">Q&As</a>
                    </li>
                    <li class="nav-item">
                        <a id="reports_button" class="nav-link" href="../pages/reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a id="mod_appeals_button" class="nav-link" href="../pages/mod_appeals.php">Mod Appeals</a>
                    </li>
                    <li class="nav-item">
                        <a id="mods_dashboard_button" class="nav-link" href="../pages/mods_dashboard.php">Mods Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Profile
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a id="profile_button" class="dropdown-item" href="../pages/user_profile.php">My Profile
                        </a>
                        <a id="edit_profile_button" class="dropdown-item" href="../pages/edit_profile.php">Edit Profile</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a id="log_out_button" class="nav-link" href="../pages/about_us.php">Log Out</a>
                    </li>
                    </ul>
                </div>      
        <?php }
    }
?>