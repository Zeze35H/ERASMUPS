<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_mod_appeals.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - Mod Appeals", "mod_appeals");
    getModAppeals();
    getNotifications();
    getFooter();
?>
