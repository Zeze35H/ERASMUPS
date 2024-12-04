<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_q_a_thread.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - Q&A Thread", "q_a_thread");
    getThread();
    getNotifications();
    getFooter();
?>