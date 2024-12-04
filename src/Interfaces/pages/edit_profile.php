<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_edit_profile.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - Edit Profile", "edit_profile");
    getEditProfile();
    getNotifications();
    getFooter();
?>