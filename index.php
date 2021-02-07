<?php
/**
* @author Robert Byrnes
* @created 28/01/2021
*/

include "classes/LockPick.php";
include "classes/Shifty.php";
include "classes/CheckUrl.php";
?>

<!doctype html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
        <link href="assets/css/crypt.css" rel="stylesheet" type="text/css"/>
        <title>Crypt</title>
    </head>
    <body>
        <div class="container register">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <ul class="nav nav-tabs nav-justified">
                            <li>
                                <a data-toggle="tab" id="hashGen-selector" href="#hashGen-tab">#hashGen </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="md5Brute-selector" href="#md5Brute-tab">md5 Brute </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="hashBrute-selector" href="#hashBrute-tab">#hashBrute </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="benchmark-selector" href="#benchmark-tab">Benchmark Server </a>
                            </li>
                            <li>
                                <a data-toggle="tab" id="checkurl-selector" href="#checkurl-tab">URL checkout </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content d-flex justify-content-center" id="myTabContent">

                        <!-- Hash Gen -->
                        <div class="tab-pane fade show active text-align form-new pt-3" id="hashGen-tab">
                            <h3 class="register-heading text-center mb-3">
                                <img src="assets/images/tooltip-info.png" class="info" data-toggle="tooltip" data-placement="left" data-html="true" title="Outputs an encrypted string, select an encryption algorithm.">#hashGen
                            </h3>
                            <div class="row tab-form">
                                <div class="col-md-12">
                                    <form method="post" id="hashGen_form">
                                        <div class="form-group">
                                            <input type="text" id="inputString" class="form-control text-box" placeholder=" Enter a string of characters to generate a hash" value="" autocomplete="off" required/>
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
                                            <input type="submit" id="hashGen_submit" class="btnContactSubmit" value="Generate a hash"/>
                                        </div>
                                    </form>
                                    <span class="text-dark">
                                        <b id="hashMessage">Hash for string: </b>
                                        <b id="stringHashed"> - </b>
                                    </span>
                                    <span id="hashGen_div" class="text-dark"></span>
                                    <span id="copyButton">
                                        <button class="copyButton btnCopy" type="button">Copy</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- MD5 Brute -->
                        <div class="tab-pane fade show text-align form-new pt-3" id="md5Brute-tab">
                            <h3 class="register-heading text-center mb-3">
                                <img src="assets/images/tooltip-info.png" class="info" data-toggle="tooltip" data-placement="left" data-html="true" title="Enter a string that has been encrypted with the md5 algorithm e.g. 'c0af77cf8294ff93a5cdb2963ca9f038'. Select the amount of time allowable for the server to exeucute a brute force algorithm to resolve the original string.">md5 Brute
                            </h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" id="md5hash" class="form-control text-box" placeholder="Paste md5 hash to Brute Force Test" autocomplete="off" required/>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="timeLimit" class="form-control text-box" placeholder="Set server time limit in seconds e.g. 600" autocomplete="off"/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" id="md5brute_submit" class="btnContactSubmit" value="Brute Go"/>
                                        </div>
                                    </form>
                                    <div class="progress working mx-auto">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 100%"
                                        id="progressbar_md5brute" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <button type=submit id="md5axe"><img src="assets/images/script_axe.jpg" class="script-axe"></button>                                    <span class="text-dark">
                                        <b id="md5Message">Result: </b>
                                    </span>
                                    <div id="md5brute_div" class="text-dark"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Hash Brute -->
                        <div class="tab-pane fade show text-align form-new pt-3" id="hashBrute-tab">
                            <h3  class="register-heading text-center mb-3">
                                <img src="assets/images/tooltip-info.png" class="info" data-toggle="tooltip" data-placement="left" data-html="true" title="Enter an encrypted string and select the encryption method use to encrypt it, otherwise select 'unknown'. This script will use a 'large' dictionary to resolve it to the original string. See the readme.md for instruction on how to expand upon the included dictionaries.">#hashBrute
                            </h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" id="hashBrute_input" class="form-control text-box" placeholder="Paste or enter an encrypted string to Brute Force Test" autocomplete="off" required/>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="timedBrute" class="form-control text-box" placeholder="Set server time limit in seconds e.g. 600" autocomplete="off"/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <label for="hashType" class="selectType"><b style="color:white;">Select Type of Encrpytion:&nbsp;&nbsp;</b></label>
                                            <select name="hashType" id="SB_hashType" required>
                                                <option value="" selected>Select</option>
                                                <option value="unknown">unknown</option>
                                                <option value="bcrypt">bcrypt</option>
                                                <option value="argon2i">argon2i</option>
                                                <option value="argon2id">argon2id</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" id="stringBrute" class="btnContactSubmit" value="Brute Go"/>
                                        </div>
                                    </form>
                                    <button type="submit" id="bruteaxe"><img src="assets/images/script_axe.jpg" class="script-axe"></button>
                                    <div class="progress working mx-auto">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 100%"
                                        id="progressbar_hashbrute" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-dark">
                                        <b id="hashBrute_message">Decryption of hash: </b>
                                        <b id="hashBrute_string"> - </b>
                                        <div id="hashBrute_div" class="text-dark"></div> 
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Benchmark Server -->
                        <div class="tab-pane fade show text-align form-new pt-3" id="benchmark-tab">
                            <h3  class="register-heading text-center mb-3">
                                <img src="assets/images/tooltip-info.png" class="info" data-toggle="tooltip" data-placement="left" data-html="true" title="This script will benchmark your server for adding 'cost' to the PHP password_hash bcrypt algorithm. A higher cost will generate a more secure encryption and will consume greater resources in doing so.  Cost is the amount of iterations over the encryption algorithm.">Benchmark Server
                            </h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="number" id="maxlen" class="form-control text-box" placeholder=" Enter maximum allowable input string length" autocomplete="off"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" step="0.01" id="targetTime" class="form-control text-box" placeholder=" Enter target time in milliseconds e.g. 0.05" autocomplete="off"/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" id="benchmark_submit" class="btnContactSubmit" value="Begin Test"/>
                                        </div>
                                    </form>
                                    <span class="text-dark">
                                        <b id="benchmark_message">Server result for a target time of: </b>
                                        <b id="targetTime_used"> - </b>
                                    </span>
                                    <div id="benchmark_div" class="text-dark"></div> 
                                </div>
                            </div>
                        </div>

                        <!-- URL checkout -->
                        <div class="tab-pane fade show text-align form-new pt-3" id="checkurl-tab">
                            <h3 class="register-heading text-center mb-3">
                                <img src="assets/images/tooltip-info.png" class="info" data-toggle="tooltip" data-placement="left" data-html="true" title="Enter a url in full e.g. http://www.example.com to issue a curl_getinfo and save to a specified text file (do not add .txt).">URL checkout
                            </h3>
                            <div class="row register-form">
                                <div class="col-md-12">
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" id="url" class="form-control text-box" placeholder="Enter target URL in full." autocomplete="off" required/>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="filename" class="form-control text-box" placeholder="Enter the filename you wish to save to, this file will be created in /logs/{filename}.txt." autocomplete="off"/>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="submit" id="checkurl" class="btnContactSubmit" value="Check URL"/>
                                        </div>
                                    </form>
                                    <div class="progress working mx-auto">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 100%"
                                        id="progressbar_checkurl" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        <b id="checkurlMessage">Result: </b>
                                    </div>
                                    <div id="checkurl_div" class="text-dark"></div>
                                    <span id="copyButton2">
                                        <button class="copyButton btnCopy" type="button">Copy</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/crypt.js"></script>
    </body>
</html>