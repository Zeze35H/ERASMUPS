<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_about_us.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS", "about_us");
    getAboutUs();
    getNotifications();
    getFooter();
?>
