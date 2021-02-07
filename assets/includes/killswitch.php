<?php
 /**
 * @author Robert Byrnes
 * @created 04/02/2021
 * @about Powershell Exection Script from PHP
 **/

 /* Check Powershell Execution Policy */
// $exPol = 'powershell.exe Get-ExecutionPolicy';
// $exPol = shell_exec($exPol);
// echo $exPol.'<br>';

/* Set Powershell Execution Policy */
// $newPol = "powershell.exe \"Set-ExecutionPolicy -ExecutionPolicy RemoteSigned\" 2>&1";
// $newPol = shell_exec($newPol);
// echo $newPol.'<br>';

// CHeck user
// echo get_current_user().'<br>';
// $return=exec("whoami");
// echo '<br>'.$return.'<br>';

echo 'working...'.'<br>';
$return;
$output;
exec("Start-Process powershell_ise.exe -NoProfile -ExecutionPolicy Bypass -File \"C:/wamp64/www/repositories/crypt/stringbrute/shells/killswitch.ps1\"  -Verb RunAs;", $output, $return);
echo '<br>'.$return.'<br>';
print_r($output);
// C:\Program Files (x86)\Nmap