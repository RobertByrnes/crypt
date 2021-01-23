<?php
function Cipher($input, $oldAlphabet, $newAlphabet, &$output)
{
	$output = "";
	$inputLen = strlen($input);

	if (strlen($oldAlphabet) != strlen($newAlphabet))
		return false;

	for ($i = 0; $i < $inputLen; ++$i)
	{
		$oldCharIndex = strpos($oldAlphabet, strtolower($input[$i]));

		if ($oldCharIndex !== false)
			$output .= ctype_upper($input[$i]) ? strtoupper($newAlphabet[$oldCharIndex]) : $newAlphabet[$oldCharIndex];
		else
			$output .= $input[$i];
	}

	return true;
}

function Encipher($input, $cipherAlphabet, &$output)
{
	$plainAlphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
	return Cipher($input, $plainAlphabet, $cipherAlphabet, $output);
}

function Decipher($input, $cipherAlphabet, &$output)
{
	$plainAlphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
	return Cipher($input, $cipherAlphabet, $plainAlphabet, $output);
}

$text = "Bijme2012";
$cipherAlphabet = "y7hkqgv9xf2ol0u56apw4mtz8ec3jdbsnri1";
$cipherText;
$plainText;

$encipherResult = Encipher($text, $cipherAlphabet, $cipherText);
$decipherResult = Decipher($cipherText, $cipherAlphabet, $plainText);


echo $cipherText.'<br>';
echo $plainText .'<br>';