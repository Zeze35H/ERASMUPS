<?php
    function getThread() { ?>
        <main id="q_a_thread">
            <?php getQuestion(); getAnswers(); ?>
            <div class="row">
                <div class="post_answer col-md-8 offset-md-2">
                <textarea class="form-control" id="exampleFormControlTextarea1"  placeholder="Answer this question"></textarea>
                    <button class="btn btn-default button_small">Post Answer</button>
                </div>
            </div>
        </main>
    <?php }

    function getQuestion() { ?>
        <div class="question row">
            <div class="col-md-2 question_opt">
                <div class="user"  onclick="window.location.href='../pages/other_profile.php';">
                    <img class="avatar" src="../images/user.png" alt="user profile picture" width="50" height="50"><br>
                    <span>Pedro123</span>
                </div>
                <div class="score">
                    <img src="../images/upvote.png" alt="upvote icon" width="15" height="15"><br>
                    <span>420</span><br>
                    <img src="../images/downvote.png" alt="downvote icon" width="15" height="15">
                </div>
                <div class="signs">
                    <div class="edit">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                    <div class="reports">
                        <?php $id="0"; ?> <!-- To be obtained from the databse -->
                        <a class="report_button"> <i  data-toggle="modal" data-target="#popupquestion<?=$id?>" class="far fa-flag report_flag"></i> </a>
                        <?php getReportPopUp("question", $id); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8 card question_body">
                <div class="card-body">
                    <h1 class="card-title">Como é que peço titulo de trabalhador estudante? (me ajuda)</h1>
                    <p class="card-text">Ola eu ser aluno russo e estudar e trabalhar em porto como faltar aulas ajuda</p>
                    <div class="question_images">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#popupimage"><i class="fas fa-images"></i> View Images </button>
                        <?php getImagePopUp(); ?>
                    </div>
                    &nbsp;
                    <div class="date">
                        <p><strong> Date: </strong>21/02/2021</p>
                    </div>
                    <div id="tags">
                     <button type="button" class="btn btn-light btn-sm">Torradeira</button>
                     <button type="button" class="btn btn-light btn-sm">2021</button>
                     <button type="button" class="btn btn-light btn-sm">Engenharia Informatica</button>
                     <button type="button" class="btn btn-light btn-sm">Urgente</button>
                  </div>
                </div>
            </div>       
        </div>
    <?php }

    function getAnswers() { ?>
        <section class="answers">
            <?php for($i = 0; $i < 3; $i++) { // i correspondera ao id do comment ?>
            <div class="answer row">
                <div class="col-md-3 answer_opt">
                    <div class="user"  onclick="window.location.href='../pages/user_profile.php';">
                        <img class="avatar" src="../images/user.png" alt="user profile picture" width="50" height="50"><br>
                        <span>Souto</span>
                    </div>
                    <div class="score">
                        <img src="../images/upvote.png" alt="upvote icon" width="15" height="15"><br>
                        <span>-3</span><br>
                        <img src="../images/downvote.png" alt="downvote icon" width="15" height="15">
                    </div>
                    <div class="signs">
                        <div class="edit">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="star">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="answer_reports">
                            <a class="report_button"> <i  data-toggle="modal" data-target="#popupanswer<?=$i?>" class="far fa-flag report_flag"></i> </a>
                            <?php getReportPopUp("answer", $i); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 card answer_body">
                    <div class="card-body">
                        <p class="card-text">nao sei, recurso </p>
                        <div class="date">
                            <p><strong> Date: </strong>21/02/2021</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php getComments(); ?>
            <div class="row input_row">
                <div class="post_comment col-md-6 offset-md-4">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" cols="70" placeholder="Comment this answer"></textarea>
                    <button class="btn btn-default button_small">Post Comment</button>
                </div> 
            </div>
            <?php } ?>
        </section>
    <?php }

    function getComments() { ?>
        <section class="comments">
        <?php for($i = 0; $i < 3; $i++) { // i correspondera ao id do comment?>
            <div class="comment row">
                <div class="col-md-4 comment_opt">
                    <div class="user" onclick="window.location.href='../pages/user_profile.php';">
                        <img class="avatar" src="../images/user.png" alt="user profile picture" width="50" height="50"><br>
                        <span>Pedro123</span>
                    </div>
                    <div class="score">
                        <img src="../images/upvote.png" alt="upvote icon" width="15" height="15"><br>
                        <span>-3</span><br>
                        <img src="../images/downvote.png" alt="downvote icon" width="15" height="15">
                    </div>
                    <div class="signs">
                        <div class="edit">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="comment_reports">
                            <a class="report_button"> <i  data-toggle="modal" data-target="#popupcomment<?=$i?>" class="far fa-flag report_flag"></i> </a>
                            <?php getReportPopUp("comment", $i); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 card comment_body">
                    <div class="card-body">
                        <p class="card-text">comentario maior aqui comentario maior aqui comentario maior aqui comentario maior aqui </p>
                        <div class="date">
                            <p><strong> Date: </strong> 21/02/2021</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </section>
    <?php }

    // type -> question, comment, answer
    // id -> the id of the corresponding in the database
    function getReportPopUp($type, $id) { ?>
        <div class="modal fade reportPopUpWindow" id="popup<?=$type.$id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-type=<?=$type?> data-id=<?=$id?>>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="going_to_report_window" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Why are you reporting this?</h5>
                    <a class="close_report_window" data-dismiss="modal"> <i class="fas fa-times"></i> </a>
                </div>
                <div class="modal-body">
                    <div><label><input required type="radio" name="report" value="inconv_or_disres"> It's inconvenient/disrespectful</label></div>
                    <div><label><input type="radio" name="report" value="not_val"> It does not add anything valuable</label></div>
                    <div><label><input type="radio" name="report" value="other"> Other</label><input type="text" name="reason" placeholder="Reason"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Report</button>
                </div>
            </div>
            <div id="report_done_window" class="modal-content" hidden>
                <div class="modal-header">
                    <a class="close_report_window" data-dismiss="modal"> <i class="fas fa-times"></i> </a>
                </div>
                <div class="modal-body">
                    <p>We will review your report!</p>
                    <p>Thank you for your feedback.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Accept</button>
                </div>
            </div>
        </div>
        </div>
    <?php }

function getImagePopUp() { ?>
    <div class="modal fade imagePopUpWindow" id="popupimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <img src="../images/porto.jpg">
                <img src="../images/star.png">
                <img src="../images/search.png">
                <img src="../images/logo.png">
                <img src="../images/cities.png">
            </div>
        </div>
    </div>
<?php }
?>