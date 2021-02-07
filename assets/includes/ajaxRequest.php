<?php

/**
 * @author Robert Byrnes
 * @created 30/01/2021
 **/

require('../../classes/LockPick.php');
require('../../classes/Shifty.php');
require('../../classes/CheckUrl.php');

// hash Gen
if (isset($_POST['inputString'])) {
    $inputString = $_POST['inputString'];
    $hashType = $_POST['hashType'];
    $hash = Shifty::hashGen($inputString, $hashType);
    echo $hash;
}

// md5 Brute submission
if (isset($_POST['md5hash'])) {
    $md5hash = $_POST['md5hash'];
    $timeLimit = $_POST['timeLimit'];
    $hash = LockPick::handleMD5input($md5hash, false, $timeLimit);
    echo $hash;   
}

// hash Brute submission
if (isset($_POST['hashBrute'])) {
    $hash = $_POST['hashBrute'];
    $hashType = $_POST['hashType']; 
    $timedBrute = $_POST['timedBrute'];
    if (($hashType != 'md5') || ($hashType != 'unknown')) {
        $result = implode(": ", LockPick::verifyByComparison($hash, $timedBrute));
        echo $result;
    } else {
        echo 'feature in next release.';
    }
}

// Benchmark Server submission
if (isset($_POST['targetTime'])) {
    $maxlen = $_POST['maxlen'];
    $targetTime = $_POST['targetTime'];
    settype($targetTime, 'float');
    $cost = Shifty::benchmarkServer($maxlen, $targetTime);
    echo $cost;
}

// URL checkout submission
if (isset($_POST['url'])) {
    $url = $_POST['url'];
    $filename = $_POST['filename'];
    $pretty = null;
    $result = (new CheckURL($url, $pretty))->logInfo($filename);
    echo 'Primary IP address: '.$result['primary_ip'];
}

// Killswitch
if(isset($_POST['message'])) {
    if ($_POST['message'] == 'kill') {
        session_destroy();
    }
}