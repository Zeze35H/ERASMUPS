<?php
    function getSignUp() { ?>
        <main id="sign_up">
            <div class="col-md-6 offset-md-3">
                <h2>Sign Up</h2>
                <form>
                <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="inputName4">Name</label>
                        <input type="text" class="form-control" id="inputName4" placeholder="Pedro Pedrito">
                        </div>
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="inputUsername4">Username</label>
                        <input type="text" class="form-control is-invalid" id="inputUsername4" placeholder="Pedro12">
                        <div class="invalid-feedback">
                        This username already exists.
                        </div>    
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                            <label for="inputEmal">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control is-valid" id="inputPassword4" placeholder="*******">
                        <div class="valid-feedback">
                            Looks good!
                        </div>    
                    </div>
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="inputPassword4">Confirm Password</label>
                        <input type="password" class="form-control is-valid" id="inputPassword4" placeholder="*******">
                        <div class="valid-feedback">
                            Looks good!
                        </div>      
                    </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 offset-md-3">
                        <label for="inputDate4" class=" col-form-label">Birthday</label>
                         <input class="form-control" type="date" value="yy-mm-dd" id="inputDate4">
                        </div>
                        <div class="form-group col-md-6 offset-md-3">
                            <label for="exampleSelect1">Country</label>
                            <select class="form-control" id="exampleSelect1">
                            <option>Portugal</option>
                            <option>UK</option>
                            <option>Spain</option>
                            <option>France</option>
                            <option>Italy</option>
                            </select>
                        </div>
                    </div>
                    <div class="radio_buttons text-center">
                        <label class="radio_input"><input type="radio" name="in_out" value="in">ERASMUS IN*</label>
                        <label class="radio_input"><input type="radio" name="in_out" value="out">ERASMUS OUT**</label>
                    </div>                &nbsp;
                    &nbsp;
                    &nbsp;
                    <div class="submit text-center">
                    <button id="submit" class="btn btn-default button_small" type="button" type="submit" value="Create Account">Sign Up</button>
                    
                    </div> 
                </form>
                &nbsp;
                <footer class="notes text-center">
                <a href="./sign_in.php" >Already have an account? Log In!</a>
                    <p>* If you are, have been or pretend to be an ERASMUS student at University of Porto</p>
                    <p>** If you are a student from the University of Porto and are, have been or pretend to be an ERASMUS student elsewhere</p>
                </footer>
            </div>
        </main>
    <?php }
?>