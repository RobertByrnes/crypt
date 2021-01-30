<?php

 /**
 * @author Robert Byrnes
 * @created 27/01/2021
 **/

declare(strict_types=1);

/************************/
/* Demonstration output */
/************************/

// Example 1 - password hashing - one way algorithm
// $string = '!comingOutOfLockdown2021!';
// echo "<b>password_hash with manual cost set to 12: </b>".password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options).'<br>';


// Server benchmark test
// ShiftyOneWay::benchmarkServer();

Class ShiftyOneWay
{
    static string $hash;

    /**
     * returns a hash of the input string using password_hash function.
     * @param string $string
     * @param string $hashType
     * @return string
     */
    public static function hashGen(string $string, $hashType=NULL) : string
    {
        if($hashType == NULL) {
            $hashType = 'null';
        }
        switch ($hashType) {
            case 'null':        $hashType = PASSWORD_DEFAULT;           break;
            case 'md5':         $md5 = md5($string);                    break;
            case 'argon2i':     $md5 = $hashType = PASSWORD_ARGON2I;    break;
            case 'bcrypt':      $hashType = PASSWORD_BCRYPT;            break;
            case 'argon2id':    $hashType = PASSWORD_ARGON2ID;          break;
        }
        if($hashType != 'md5') {
            return password_hash($string, $hashType);
        } else {
            return $md5;
        }
    }

    
    /**
     * This code will benchmark your server to determine how high of a cost you can
     * afford. You want to set the highest cost that you can without slowing down
     * you server too much. 8-10 is a good baseline, and more is good if your servers
     * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
     * which is a good baseline for systems handling interactive logins.
     * @param float $targetTime
     * @return integer
     */
    public static function benchmarkServer(float $targetTime=NULL) : int
    {
        if($targetTime == NULL) {
            $targetTime = 0.05;
        }
        $cost = 8;
        do {
            $cost++;
            $mtime = microtime(); 
            $mtime = explode(" ",$mtime);
            $mtime = $mtime[1] + $mtime[0];
            $starttime = $mtime;
            echo "<b>Server benchmarch test iterations > 8*: </b>".password_hash("getmeoutofhere2021!", PASSWORD_BCRYPT, ["cost" => $cost]).'<Br>';
            $end = microtime(true);
        }
        while (($end - $starttime) < $targetTime);
        echo "<b>Appropriate Cost Found: </b>" . $cost.'<Br>';
        return $cost;
    }


    /**
     * BCRYPT will always generate a 60 characters in length hash,
     * set cost to allocate server resources 8-10 is a good recommendation.
     * @param string $string
     * @param integer $cost
     * @return string
     */
    public static function hashWithKnownCost(string $string, int $cost=NULL) : string
    {
        if ($cost == NULL) {
            $cost = 8;
        }
        $options = [
            'cost' => $cost,
        ];
        return password_hash($string, PASSWORD_BCRYPT, $options);
    }


    /**
     * one way password_hash cannot be reversed, therefore password_verify generates a hash of given string,
     * this is tested against the original hash.
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public static function verifyByComparison(string $password, string $hash) : bool
    {
        if (password_verify($password, $hash)) {
            echo "<b>default: </b>Let me in, I'm genuine!".'<Br>';
            return true;
        } else {
            echo "<b>default: </b>If your name's not on the list, you're not coming in!".'<Br>';
            return false;
        }
    }
}

// if (password_verify($password, $hashTwo)) {
//    echo "<b>BCRYPT: </b>Let me in, I'm genuine!".'<Br>';
// }

// if (password_verify($password, $hashThree)) {
//    echo "<b>ARGON2I: </b>Let me in, I'm genuine!".'<Br>';
// }

// if (password_verify($password, $hashFour)) {
//    echo "<b>ARGON2ID: </b>Let me in, I'm genuine!".'<Br>';
// }
