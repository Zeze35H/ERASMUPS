<?php
    include_once("../templates/template_header.php");
    include_once("../templates/template_notifications.php");
    include_once("../templates/template_ask_question.php");
    include_once("../templates/template_footer.php");

    getHeader("ERASMUPS - Ask Question", "ask_question");
    getAskQuestion();
    getNotifications();
    getFooter();
?>
