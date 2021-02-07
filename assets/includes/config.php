<?php

 /**
 * @author Robert Byrnes
 * @created 24/01/2021
 **/

require "../../classes/Cracker.php";

Cracker::init(array(
    'timezone'    => 'Europe/Amsterdam', // Time zone for the output file.
    'wordlist'    => 'wordlist/wordlist.txt', // Path to the wordlist.
    'outputfile'  => 'logs/output.txt' // Output file where the matching combo('s) will be stored in.
));