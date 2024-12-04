<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_other_profile.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - Other Profile", "other_profile");
    getOtherProfile();
    getNotifications();
    getFooter();
?>