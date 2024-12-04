<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_user_profile.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - User Profile", "user_profile");
    getUserProfile();
    getNotifications();
    getFooter();
?>