<?php
    function getSignIn() { ?>
        <main id="sign_in">
            <div class="col-md-6 offset-md-3">
                <h2>Welcome back!</h2><br>
                <form>
                    <div class="form-row">
                            <div class="form-group col-md-6 offset-md-3">
                                <label for="inputEmail4">Email</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6 offset-md-3">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="********">   
                            </div>
                    </div>
                    
                    <div class="submit text-center">
                        <button id="submit" class="btn btn-default button_small" type="button" type="submit" value="Sign In">Sign In</button>
                    </div> 
                </form>
            </div>
        </main>
    <?php }
?>