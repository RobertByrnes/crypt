<?php

/**
 * @author Robert Byrnes
 * @created 30/01/2021
 **/

require('../classes/ShiftyTwoWay.php');

if (isset($_POST['stringBrute'])) {
    $hash = $_POST['stringBrute'];
    $hashType = $_POST['hashType']; 
}