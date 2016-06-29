<style type="text/css">
    p#promo {
        margin-left: 23px;
        font-weight: bold;
        text-align: center;
        margin-top: -16px;
        font-size: 14px;
    }
    p.login-disclaimer {
        margin-top: 10px;
        margin-bottom: -20px;
        margin-right: 35px;
        font-size: 12px;
        text-align: center;
    }
    .modal form p.error {
        color: red;
        font-weight: bold;
    }

</style>

<!-- MODAL FOR THE SIGN UP AND USER LOGIN -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" id="signin_login_modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Register/Login to 4UImg</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="logbox">
                        <div class="col-md-6">
                            <!-- REGISTRATION PORTION -->
                            <h4>CREATE AN ACCOUNT</h4>

                            <form id="signup" method="post" action="handle_signup.php" style="
                                  margin-bottom: 0px;
                                  ">
                          <input class="form-control" id="email_signup" name="signup_email" type="email" placeholder="Email address" style="
                                                                    width: 100%;
                                                                    margin-left: 0;
                                                                ">

                                <br>
                                <div class="row">
                                        <input class="form-control" id="email_signup" name="signup_username" type="text" placeholder="Username" required="required">
                                </div>
                                                                
                                <br>
                      
                                <div class="row">

                                    <div class="col-md-6">
                                        <input class="form-control" id="pass1" name="signup_firstname" type="text" placeholder="First Name" required="required">
                                    </div>
                                 
                                    <div class="col-md-6">
                                        <input class="form-control" id="pass2" name="signup_lastname" type="text" placeholder="Last Name" required="required">
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" id="pass1" name="user_password" type="password" placeholder="Choose a password" required="required">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" id="pass2" name="user_password2" type="password" placeholder="Confirm password" required="required">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="radio">
                                        <label id="label">Who are you?</label>
                                        <br>
                                        <label>
                                            <input type="radio" name="identity">Artist</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="radio" name="identity">Customer</label>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#" data-toggle="modal" data-target="#instructions">what's this?</a>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <p id="promo"><i><mark>Sign up now to receive full access to exclusive offers to amazing artwork from amazing artists!</mark></i></p>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" name="submit" value="signup" class="btn btn-primary">Sign Up</button>
                                        </div>
                                    </div>
                                    <p class="login-disclaimer">By signing up, you agree to our <a href="" data-toggle="modal" data-target="#terms_of_use">Terms</a> and that you have read our <a href="" data-toggle="modal" data-target="#privacy_policy">Privacy Policy</a>.</p>

                                </div>
                            </form>
                        </div>
                        <!-- LOGIN SIDE -->
                        <div class="col-md-6">
                            <h4>LOG IN</h4>
                            <form id="login" method="POST" action="handle_login.php">
                                <input class="form-control" name="user_username" placeholder="Enter username">
                                <br>
                                <input class="form-control" name="user_password" type="password" placeholder="Enter password" required="required">
                                <?php
                                    if (isset($login_failed) && $login_failed) {
                                        echo "<p class=\"error\">Invalid username or password</p>";
                                    }
                                ?>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" name="submit" value="login" class="btn btn-primary">Login</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="redirect_target" value="<?php
                                    if (isset($redirect_target)) {
                                        echo $redirect_target;
                                    }
                                ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
