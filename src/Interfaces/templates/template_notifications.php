<?php
    function getNotifications() { ?>

        <div id="notification_bell" class="btn-group dropstart">
            <button class="btn dropdown-toggle dropstart" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            </button>
            <aside id="notifications" class="dropdown-menu">
                <div id="notification_cards">
                    <div class="card notification">
                        <div class="card-header">
                            Answer
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Answer to your question</h5>
                            <p class="card-text">Your question "Como obtenho estatuto trabalhador estudante?" was answered by Souto.</p>
                            <a href="#" class="btn btn-outline-primary">See answer</a>
                        </div>
                    </div>
                    <div class="card notification">
                        <div class="card-header">
                            Comment
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Comment on your answer</h5>
                            <p class="card-text">Your answer on "Como raio instalo o MINIX?" was commented by Souto.</p>
                            <a href="#" class="btn btn-outline-primary">See comment</a>
                        </div>
                    </div>
                    <div class="card notification">
                        <div class="card-header">
                            Report
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Content reported</h5>
                            <p class="card-text">Your comment on "Como raio instalo o MINIX?" was deleted. Reason: Offensive Language.</p>
                            <a href="#" class="btn btn-outline-primary">Ok :(</a>
                        </div>
                    </div>
                </div>
                <button id="clear" class="btn btn-default button_small_red text-center" type="button" name="clear">Clear</button>
            </aside> 
        </div>
    <?php }
?>
