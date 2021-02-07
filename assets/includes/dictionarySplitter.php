<?php

 /**
 * @author Robert Byrnes
 * @created 31/01/2021
 **/

if (shell_exec('pwsh -File C:/wamp64/www/repositories/crypt/shells/fileSplitter.ps1 > /dev/null 2>&1 &')) {
   echo '<pre>'.str_repeat('=', 14)."\nDictionary Splitter:\n".str_repeat('=', 14)."\n  FILE: ".__FILE__."\n  LINE: ".__LINE__."\n".str_repeat('=', 14)."\n SUCCESS! </pre>";
}