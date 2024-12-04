<?php
    function getAboutUs() { ?>
        <main id="about_us">
            <div id="img">
            <img id="cities_image" src="../images/cities.png" class="img-fluid" alt="Several Cities"></img>
            </div>
            <h2>Enriching lives, opening minds.</h2><br>
            <div id="description">
                <p><img id="logo_in_text" src="../images/logo.png" class="img-fluid" alt="Responsive image" ></img> is an open
                community for any student interested or already enrolled in the ERASMUS program. We
                help you get answers to your doubts and share your experience with others!</p>
            </div>
            <button type="button" name="browse_questions" onclick="window.location.href='../pages/q_a.php';">Browse questions</button>
        </main>
    <?php }
?>