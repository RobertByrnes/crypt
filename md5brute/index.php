<!doctype html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <link href="md5brute.css" rel="stylesheet" type="text/css"/>
        <link href="md5brute.js" type="text/javascript"/>
        <title>md5Brute</title>
    </head>
    <body>
        <div class="container register">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-justified">
                        <li>
                            <a data-toggle="tab" id="hashGen" href="#hashGen-tab">#hashGen </a>
                        </li>
                        <li>
                            <a data-toggle="tab" id="brute1" href="#brute1-tab">md5 Brute 1 </a>
                        </li>
                        <li>
                            <a data-toggle="tab" id="brute2" href="#brute2-tab">md5 Brute 2 </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active text-align form-new" id="hashGen-tab">
                            <h3 class="register-heading text-center">#hashGen</h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form name="hashForm" method="post" action="?hashGen">
                                        <div class="form-group">
                                            <input type="text" name="timeLimit" class="form-control" placeholder="enter a string of characters to generate a hash" value="" required/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                        <label for="hashType"><b style="color:white;">Select Type of Encrpytion:&nbsp;&nbsp;</b></label>
                                        <select name="hashType" id="hashType">
                                            <option value="md5">md5</option>
                                            <option value="bcrypt">bcrypt</option>
                                            <option value="argon2i">argon2i</option>
                                            <option value="argon2id">argon2id</option>
                                        </select>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" name="hashGen" class="btnContactSubmit" value="Generate a hash"/>
                                        </div>
                                    </form>
                                    <div class="form-group">
                                        <input type="text" name="md5bruteResponse" class="form-control" placeholder="Your hash..." value=""/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show text-align form-new" id="brute1-tab">
                            <h3 class="register-heading text-center">md5 Brute 1</h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post" action="?data">
                                        <div class="form-group">
                                            <input type="text" name="timeLimit" class="form-control" placeholder="Set server time limit in seconds e.g. 600" value="" required=""/>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="md5hash" class="form-control" placeholder="Paste md5 hash" value="" required=""/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" name="md5brute" class="btnContactSubmit" value="Brute Go"/>
                                        </div>
                                    </form>
                                    <div class="form-group">
                                        <input type="text" name="md5bruteResponse" class="form-control" placeholder="Your response..." value=""/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show text-align form-new" id="brute2-tab">
                            <h3  class="register-heading text-center">md5 Brute 2</h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" name="md5hash" class="form-control" placeholder="Your Email *" value="" required/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="LGform2_pwd" class="form-control" placeholder="Your Password *" value="" required/>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="LGform2" class="btnContactSubmit" value="Login" />
                                            <a href="ForgetPassword.php" class="btnForgetPwd" value="Brute Go">Forget Password?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
include "../classes/cracker.php";
if (isset($_POST['hashGen'])) {
   print_r($_POST['hashGen']);     
}