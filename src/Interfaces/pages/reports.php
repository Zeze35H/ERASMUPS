<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_reports.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS", "reports");
    getReportsPage();
    getNotifications();
getFooter();
?>
