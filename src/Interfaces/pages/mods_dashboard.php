<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_mods_dashboard.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - Mods Dashboard", "mods_dashboard");
    getModsDashBoard();
    getNotifications();
    getFooter();
?>
