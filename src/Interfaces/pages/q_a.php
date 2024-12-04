<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_q_a.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS", "q_a");
    getQuestions();
    getNotifications();
    getFooter();
   
?>
