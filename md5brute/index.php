<?php
/**
* @author Robert Byrnes
* @created 28/01/2021
*/
include "../classes/cracker.php";
include "../classes/ShiftyOneWay.php";
?>

<!doctype html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <link href="md5brute.css" rel="stylesheet" type="text/css"/>
        <title>md5Brute</title>
    </head>
    <body>
        <div class="container register">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <ul class="nav nav-tabs nav-justified">
                            <li>
                                <a data-toggle="tab" id="hashGen" href="#hashGen-tab">#hashGen </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="brute1" href="#brute1-tab">md5 Brute </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="brute2" href="#brute2-tab">string Brute </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="bench" href="#benchmark-tab">Benchmark Server </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content d-flex justify-content-center" id="myTabContent">
                        <div class="tab-pane fade show active text-align form-new pt-3" id="hashGen-tab">
                            <h3 class="register-heading text-center mb-3">#hashGen</h3>
                            <div class="row tab-form">
                                <div class="col-md-12">
                                    <form name="hashForm" method="post" action="?hashGen">
                                        <div class="form-group">
                                            <input type="text" name="inputString" class="form-control text-box" placeholder=" Enter a string of characters to generate a hash" value="" autocomplete="off" required/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <label for="hashType" class="selectType"><b style="color:white;">Select Type of Encrpytion:&nbsp;&nbsp;</b></label>
                                            <select name="hashType" id="hashType" required>
                                                <option value="" selected>Select</option>
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
                                    <p class="text-dark text-bold">
                                        <?php 
                                            if (isset($_POST['hashGen'])) {
                                                $inputString = $_POST['inputString'];
                                                $hashType = $_POST['hashType'];
                                                unset($_POST);
                                                $hash = ShiftyOneWay::hashGen($inputString, $hashType);
                                                echo 'md5 hash of string "'.$inputString.'" : ';  
                                            }
                                        ?>
                                    </p>
                                    <div id="text" class="text-dark">
                                        <?php 
                                        if(isset($hash)) {
                                            echo $hash;
                                        }
                                        ?>
                                    </div> 
                                     <button class="copyButton" type="button">Copy Text</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show text-align form-new pt-3" id="brute1-tab">
                            <h3 class="register-heading text-center mb-3">md5 Brute</h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post" action="?brute1">
                                        <div class="form-group">
                                        <div class="form-group">
                                            <input type="text" name="md5hash" class="form-control text-box" placeholder="Paste md5 hash to Brute Force Test" autocomplete="off" required/>
                                        </div>
                                            <input type="number" name="timeLimit" class="form-control text-box" placeholder="Set server time limit in seconds e.g. 600" autocomplete="off"/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" name="brute1" class="btnContactSubmit" value="Brute Go"/>
                                        </div>
                                    </form>
                                    <div class="form-group">
                                        <?php 
                                            if (isset($_POST['md5hash'])) {
                                                $md5hash = $_POST['md5hash'];
                                                $timeLimit = $_POST['timeLimit'];
                                                unset($_POST);
                                                $null = null;
                                                $hash = Cracker::handleMD5input($md5hash, false, $timeLimit);
                                                echo $hash;   
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show text-align form-new pt-3" id="brute2-tab">
                            <h3  class="register-heading text-center mb-3">string Brute</h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" id="stringBruteText" class="form-control text-box" placeholder="Paste or enter string to Brute Force Test" autocomplete="off" required/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" id="stringBrute" class="btnContactSubmit" value="Brute Go" />
                                        </div>
                                    </form>
                                    <p class="text-dark text-bold">
                                        <?php 
                                            if (isset($_POST['hashGen'])) {
                                                $inputString = $_POST['inputString'];
                                                $hashType = $_POST['hashType'];
                                                unset($_POST);
                                                $hash = ShiftyOneWay::hashGen($inputString, $hashType);
                                                echo 'md5 hash of string "'.$inputString.'" : ';  
                                            }
                                        ?>
                                    </p>
                                    <div id="stringBrute" class="text-dark"></div> 
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show text-align form-new pt-3" id="benchmark-tab">
                            <h3  class="register-heading text-center mb-3">Benchmark Server</h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="number" name="targetTime" class="form-control text-box" placeholder=" Enter target time in milliseconds e.g. 0.05" autocomplete="off"/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" name="benchmark" class="btnContactSubmit" value="Begin Test"/>
                                        </div>
                                        <div class="form-group">
                                            <?php 
                                                if (isset($_POST['benchmark'])) {
                                                    $targetTime = $_POST['targetTime'];   
                                                    unset($_POST);
                                                    settype($targetTime, 'float');
                                                    ShiftyOneWay::benchmarkServer($targetTime);
                                                }
                                            ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="md5brute.js"></script>
    </body>
</html>