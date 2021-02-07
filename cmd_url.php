<?php

/**
 * @author Robert Byrnes
 * @created 06/02/2021
 **/

require('classes/CheckUrl.php');

$urlArray = getopt(null, ['url:']);
$prettyArray = getopt(null, ['pretty:']);
$fileArray = getopt(null, ['file:']);

$url = $urlArray['url'];
$pretty = $prettyArray['pretty'];
$filename = $fileArray['file'];

$target = new CheckURL($url, $pretty);
$target->logInfo($filename);