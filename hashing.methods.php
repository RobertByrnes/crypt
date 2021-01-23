<?php

 /**
 * @author Robert Byrnes
 * @created 20/01/2021
 **/

$password = '!comingOutOfLockdown2021!';

// password hashing - one way algorithm

/**
* In this case, we want to increase the default cost for BCRYPT to 12.
* Note that we also switched to BCRYPT, which will always be 60 characters.
*/
$options = [
   'cost' => 12,
];
echo "<b>password_hash with manual cost set to 12: </b>".password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options).'<br>';


/*
* This code will benchmark your server to determine how high of a cost you can
* afford. You want to set the highest cost that you can without slowing down
* you server too much. 8-10 is a good baseline, and more is good if your servers
* are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
* which is a good baseline for systems handling interactive logins.
*/

$timeTarget = 0.05; // 50 milliseconds 

$cost = 8;
do {
  $cost++;
  $start = microtime(true);
  echo "<b>password_hash of ".$password.": </b>".password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]).'<Br>';
  $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "<b>Appropriate Cost Found: </b>" . $cost.'<Br>';

// password hash defined contstant examples
$hashOne = password_hash($password, PASSWORD_DEFAULT);
echo '<b>default hash: </b>'.$hashOne.'<Br>';

$hashTwo = password_hash($password, PASSWORD_ARGON2I);
echo '<b>ARGON2I hash: </b>'.$hashTwo.'<Br>';

$hashThree = password_hash($password, PASSWORD_BCRYPT);
echo '<b>bcrypt hash: </b>'.$hashThree.'<Br>';

$hashFour = password_hash($password, PASSWORD_ARGON2ID);
echo '<b>ARGON2ID hash: </b>'.$hashFour.'<Br>';

if (password_verify($password, $hashOne)) {
   echo "<b>default: </b>Let me in, I'm genuine!".'<Br>';
}

if (password_verify($password, $hashTwo)) {
   echo "<b>BCRYPT: </b>Let me in, I'm genuine!".'<Br>';
}

if (password_verify($password, $hashThree)) {
   echo "<b>ARGON2I: </b>Let me in, I'm genuine!".'<Br>';
}

if (password_verify($password, $hashFour)) {
   echo "<b>ARGON2ID: </b>Let me in, I'm genuine!".'<Br>';
}
