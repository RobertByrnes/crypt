<?php

function XORCipher($data, $key) {
	$dataLen = strlen($data);
	$keyLen = strlen($key);
	$output = $data;

	for ($i = 0; $i < $dataLen; ++$i) {
		$output[$i] = $data[$i] ^ $key[$i % $keyLen];
	}

	return $output;
}

$text = "This is a cool form of encryption.";
$key = "panda";
$cipherText = XORCipher($text, $key);
$plainText = XORCipher($cipherText, $key);
echo $cipherText.'<br>';
echo $plainText .'<br>';