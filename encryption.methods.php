<?php

 /**
 * @author Robert Byrnes
 * @created 20/01/2021
 **/

$password = '!comingOutOfLockdown2021!';

/*************/
/***BASE 64***/
/*************/

 // base 64 encode/decode
 $cipher = base64_encode($password);
 echo '<b>base64_encode: </b>'.$cipher.'<Br>';

 $decoded = base64_decode($cipher);
 echo '<b>base64_decode: </b>'.$decoded.'<Br>';

/************/
/***SODIUM***/
/************/

// Secret key encryption
$key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
echo "<b>random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES): </b>".$key.'<br>';

$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
echo "<b>random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES): </b>".$nonce.'<br>';

$ciphertext = sodium_crypto_secretbox("Hello World !", $nonce, $key);
echo "<b>sodium_crypto_secretbox(\'Hello World !\', $nonce, $key): </b>".$ciphertext.'<br>';

$plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
if ($plaintext === false) {
    throw new Exception("Bad ciphertext");
}

echo "<b>sodium_crypto_secretbox_open($ciphertext, $nonce, $key): </b>".$plaintext;

$encoded = base64_encode($nonce . $ciphertext);
echo '<b>base64_encode sodium and prepend nonce for db entry: </b>';
var_dump($encoded);
// string 'v6KhzRACVfUCyJKCGQF4VNoPXYfeFY+/pyRZcixz4x/0jLJOo+RbeGBTiZudMLEO7aRvg44HRecC' (length=76)

$decoded = base64_decode($encoded);
$nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
$ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
$plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
echo '<b>base64_decode sodium and separate nonce from db query: </b>';
var_dump($plaintext);
// string 'This is a secret!' (length=17)

/*************/
/***OPENSSL***/
/*************/
$ciphers             = openssl_get_cipher_methods();
$ciphers_and_aliases = openssl_get_cipher_methods(true);
$cipher_aliases      = array_diff($ciphers_and_aliases, $ciphers);

//ECB mode should be avoided
$ciphers = array_filter( $ciphers, function($n) { return stripos($n,"ecb")===FALSE; } );

//At least as early as Aug 2016, Openssl declared the following weak: RC2, RC4, DES, 3DES, MD5 based
$ciphers = array_filter( $ciphers, function($c) { return stripos($c,"des")===FALSE; } );
$ciphers = array_filter( $ciphers, function($c) { return stripos($c,"rc2")===FALSE; } );
$ciphers = array_filter( $ciphers, function($c) { return stripos($c,"rc4")===FALSE; } );
$ciphers = array_filter( $ciphers, function($c) { return stripos($c,"md5")===FALSE; } );
$cipher_aliases = array_filter($cipher_aliases,function($c) { return stripos($c,"des")===FALSE; } );
$cipher_aliases = array_filter($cipher_aliases,function($c) { return stripos($c,"rc2")===FALSE; } );

// if (preg_match('/wamp64|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {echo '<pre><b>'.str_repeat('=', 17)."\nPRINT_R CIPHERS:\n".str_repeat('=', 17)."\n  FILE: ".__FILE__."\n  LINE: ".__LINE__."\n".str_repeat('=', 17)."\n</b>".print_r($ciphers, true).'</pre>';}

// if (preg_match('/wamp64|repositories/i', __DIR__) || !empty($_REQUEST['debug'])) {echo '<pre>'.str_repeat('=', 28)."\nPRINT_R CIPHERS AND ALIASES:\n".str_repeat('=', 28)."\n  FILE: ".__FILE__."\n  LINE: ".__LINE__."\n".str_repeat('=', 28)."\n".print_r($cipher_aliases, true).'</pre>';}


for ($i = 1; $i <= 4; $i++) {
    $bytes = openssl_random_pseudo_bytes($i, $cstrong);
    $key   = bin2hex($bytes);

    echo "Lengths: Bytes: $i and Hex: " . strlen($key) . PHP_EOL;
    var_dump($key);
    var_dump($cstrong);
    echo PHP_EOL;
}


//$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
$plaintext = "message to be encrypted";
$cipher = "aes-128-gcm";
if (in_array($cipher, openssl_get_cipher_methods()))
{
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
    //store $cipher, $iv, and $tag for decryption later
    $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
   
    echo $ciphertext."\n";

    echo $original_plaintext."\n";
}