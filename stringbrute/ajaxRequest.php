<?php

/**
 * @author Robert Byrnes
 * @created 30/01/2021
 **/

require('classes/Cracker.php');
require('classes/ShiftyOneWay.php');


// hash Gen
if (isset($_POST['inputString'])) {
    $inputString = $_POST['inputString'];
    $hashType = $_POST['hashType'];
    $hash = ShiftyOneWay::hashGen($inputString, $hashType);
    echo $hash;
}

// md5 Brute submission
if (isset($_POST['md5hash'])) {
    $md5hash = $_POST['md5hash'];
    $timeLimit = $_POST['timeLimit'];
    $hash = Cracker::handleMD5input($md5hash, false, $timeLimit);
    echo $hash;   
}

// hash Brute submission
if (isset($_POST['hashBrute'])) {
    $hash = $_POST['hashBrute'];
    $hashType = $_POST['hashType']; 
    if (($hashType != 'md5') || ($hashType != 'unknown')) {
        $result = implode(": ",Cracker::verifyByComparison($hash));
        echo $result;
    } else {
        echo 'feature in next release.';
    }
}

// Benchmark Server submission
if (isset($_POST['targetTime'])) {
    $targetTime = $_POST['targetTime'];
    settype($targetTime, 'float');
    $cost = ShiftyOneWay::benchmarkServer($targetTime);
    echo $cost;
}