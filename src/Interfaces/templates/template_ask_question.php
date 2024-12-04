<?php
    function getAskQuestion() { ?>
        <main id="ask_question">
        <div class="col-md-12">
                <h2>Ask a Question</h2><br>
                <div id="description">
                    <p>Don't forget to include all the information someone would need to answer your question!</p>
                </div>
                <form>
                <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="inputTitle">Title</label>
                            <input type="text" class="form-control" id="inputTitle4" placeholder="Title of your question">
                        </div>
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="exampleFormControlTextarea1">Body</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="Insert your question here"></textarea>
                            &nbsp;
                            <div class="form-group">
                            <label for="exampleFormControlTextarea1">Media Attachment(s)</label>
                                <div class="col-md-4">
                                    <span class="btn btn-default btn-file">
                                        <input id="input-2" name="input2[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 offset-md-3">
                        <p .class="description"><label for="inputTitle">Tags</label>
                            <small style="color: grey">Using the right tags makes it easier for other to find and answer your question.</p>
                            <input type="text" class="form-control" id="inputTitle4" placeholder="Insert up to 5 tags">
                        </div>
                        </div>
                </div>
                
                </form>
                <div id="buttons">
                    <button id="submit" class="btn btn-default button_small" type="button" name="submit_question">Submit question</button>
                    <button id="cancel" class="btn btn-default button_small_red" type="button" name="cancel" onclick="window.location.href='../pages/q_a.php';">Cancel</button>
                </div>
                </form>

        </main>
    <?php }
?>