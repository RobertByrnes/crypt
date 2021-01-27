<?php
/**
 * @author Robert Byrnes
 * @created 22/01/2021
 * @license MIT
 **/

declare(strict_types=1);

/************************/
/* Demonstration output */
/************************/

/* Example 1 - substitute and XOR */
// $text = "Nothing is impossible, the word itself says “I’m possible” -- Audrey Hepburn";
// $cipherText = '';
// $plainText = '';
// echo '<b>Original text: </b>'.$text.'<br>';
// ShiftyTwoWay::encipher($text, $cipherText);
// echo '<b>Encrypted with character substitues: </b>'.$cipherText.'<br>';
// $cipherText = ShiftyTwoWay::XORCipher($cipherText);
// echo '<b>Further encrypted with bitwise XOR: </b>'.$cipherText.'<br>';
// $cipherText = ShiftyTwoWay::XORCipher($cipherText);
// echo '<b>Decrypted from bitwise XOR to substitution: </b>'.$cipherText.'<br>';
// ShiftyTwoWay::decipher($cipherText, $plainText);
// echo '<b>Returned to original text: </b>'.$plainText.'<br>';

// Example 2 - 

Class ShiftyTwoWay
{
	private static string $standardAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 *-+#!="£$%&(),.\/\'?@[]{}';
	private static string $cipherAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ!£"y7h.k($&+%qgv)9@x?f2,o/l0*\u5[6a=pw }]4-mt{z8ec3jdbsnri1#\'';
	private static string $key = '02356648799988775';

	/**
	 * used to encypher a string later to be deciphered with the decipher function
	 * @param [type] $input
	 * @param [type] $output
	 * @return bool
	 * @example ShiftyTwoWay::encipher($text, $cipherText);
	 */
	public static function encipher($input, &$output) : bool
	{
		return self::cipher($input, self::$standardAlphabet, self::$cipherAlphabet, $output);
	}


	/**
	 * used to decypher a string enciphered with the encipher() function
	 * @param [string] $input
	 * @param [string] $output
	 * @return bool
	 * @example ShiftyTwoWay::decipher($cipherText, $plainText);
	 */
	public static function decipher($input, &$output) : bool
	{
		return self::cipher($input, self::$cipherAlphabet, self::$standardAlphabet, $output);
	}


	/**
	 * modifies a string but swapping out characters from the original alphabet string to 
	 * the substitue alphabet, reorders whitespaces. This function is called from within the 
	 * class by either encipher() or decipher()
	 * @param [string] $input
	 * @param [static member] $standardAlphabet
	 * @param [static member] $cipherAlphabet
	 * @param [string] $output
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
	 * @param [string] $data to be encrypted or decrypted
	 * @return string
	 * @example $plainText = ShiftyTwoWay::XORCipher($cipherText);
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
	 * @param [string] $text
	 * @param [empty string] $cipherText
	 * @return string
	 * @example $userDetail = ShiftyTwoWay::lockUserDetail($text, $cipherText);
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
	 * @param [string] $cipherText = encrypted string
	 * @param [empty string] $plainText = to modified to contain the output
	 * @return string
	 * @example $plainText = ShiftyTwoWay::freeUserDetail($cipherText, $plainText);
	 */
	public static function freeUserDetail($cipherText, $plainText) : string
	{
		$cipherText = self::XORCipher($cipherText);
		self::decipher($cipherText, $plainText);
		return $plainText;
	}
}