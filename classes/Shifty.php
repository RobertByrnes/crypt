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

// Example 2- Server benchmark test
// Shifty::benchmarkServer();

// Example 3 - substitute and XOR
// $text = "Nothing is impossible, the word itself says “I’m possible” -- Audrey Hepburn";
// $cipherText = '';
// $plainText = '';
// echo '<b>Original text: </b>'.$text.'<br>';
// Shifty::encipher($text, $cipherText);
// echo '<b>Encrypted with character substitues: </b>'.$cipherText.'<br>';
// $cipherText = Shifty::XORCipher($cipherText);
// echo '<b>Further encrypted with bitwise XOR: </b>'.$cipherText.'<br>';
// $cipherText = Shifty::XORCipher($cipherText);
// echo '<b>Decrypted from bitwise XOR to substitution: </b>'.$cipherText.'<br>';
// Shifty::decipher($cipherText, $plainText);
// echo '<b>Returned to original text: </b>'.$plainText.'<br>';


Class Shifty
{  
    private static string $standardAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 *-+#!="£$%&(),.\/\'?@[]{}';
	private static string $cipherAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ!£"y7h.k($&+%qgv)9@x?f2,o/l0*\u5[6a=pw }]4-mt{z8ec3jdbsnri1#\'';
	private static string $key = '02356648799988775';
    static string $hash;


    /**
	 * used to encypher a string later to be deciphered with the decipher function
	 * @param string $input
	 * @param string $output
	 * @return bool
	 * @example Shifty::encipher($text, $cipherText);
	 */
	public static function encipher($input, &$output) : bool
	{
		return self::cipher($input, self::$standardAlphabet, self::$cipherAlphabet, $output);
	}


    /**
	 * used to decypher a string enciphered with the encipher() function
	 * @param string $input
	 * @param string $output
	 * @return bool
	 * @example Shifty::decipher($cipherText, $plainText);
	 */
	public static function decipher($input, &$output) : bool
	{
		return self::cipher($input, self::$cipherAlphabet, self::$standardAlphabet, $output);
	}


	/**
	 * modifies a string by swapping out characters from the original alphabet string to 
	 * the substitue alphabet, reorders whitespaces. This function is called from within the 
	 * class by either encipher() or decipher()
	 * @param string $input
	 * @param string $standardAlphabet
	 * @param string $cipherAlphabet
	 * @param string $output
	 * @return bool
	 */
	private static function cipher($input, $standardAlphabet, $cipherAlphabet, &$output) : bool
	{
		$output = "";
		$inputLen = strlen($input);

		if (strlen($standardAlphabet) != strlen($cipherAlphabet)) {
			return false;
		}

		for ($i = 0; $i < $inputLen; $i++)
		{
			$origin = strpos($standardAlphabet, $input[$i]);
			
			if ($origin !== false) { 
				$output .= $cipherAlphabet[$origin];
			} else {
				$output .= $input[$i];
			}
		}
		return true;
	}


	/**
	 * enciphers a string using bitwise xor operator, this function is also used to decipher a string
	 * previously enciphered with this function
	 * @param string $data to be encrypted or decrypted
	 * @return string
	 * @example $plainText = Shifty::XORCipher($cipherText);
	 */
	public static function XORCipher(string $data) : string
	{
		$dataLen = strlen($data);
		$keyLen = strlen(self::$key);
		$output = $data;

		for ($i = 0; $i < $dataLen; ++$i) {
			$output[$i] = $data[$i] ^ self::$key[$i % $keyLen];
		}
		return $output;
	}


	/**
	 * uses a two step combination of encipher() and XORCipher() functions to encypher a string 
	 * @param string $text
	 * @param string $cipherText
	 * @return string
	 * @example $userDetail = Shifty::lockUserDetail($text, $cipherText);
	 */
	public static function lockUserDetail($text, $cipherText) : string
	{
		self::encipher($text, $cipherText);
		$cipherText = self::XORCipher($cipherText);
		return $cipherText;
	}
	

	/**
	 * uses a two step combination of XORCipher() and decipher() functions to decipher a string
	 * previously enciphered with lockUserDetail()
	 * @param string $cipherText = encrypted string
	 * @param string $plainText = to modified to contain the output
	 * @return string
	 * @example $plainText = Shifty::freeUserDetail($cipherText, $plainText);
	 */
	public static function freeUserDetail($cipherText, $plainText) : string
	{
		$cipherText = self::XORCipher($cipherText);
		self::decipher($cipherText, $plainText);
		return $plainText;
	}


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
	 * @param int $maxlen
     * @return integer
     */
    public static function benchmarkServer(int $maxlen, float $targetTime=NULL) : int
    {
		function getRandomString($maxlen) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$string = '';
			
			for ($i = 0; $i < $maxlen; $i++) {
				$string .= $characters[mt_rand(0, strlen($characters) - 1)];
			}
			
			return $string;
		}
		
		$maxlenString = getRandomString($maxlen);

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
            echo "<b>Server benchmarch test iterations > 8*: </b>".password_hash($maxlenString, PASSWORD_BCRYPT, ["cost" => $cost]).'<Br>';
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