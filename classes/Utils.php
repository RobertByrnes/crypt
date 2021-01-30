<?php


/* Example Usage

what happens if the measurement targets two points A and B in different php files?

what if we need different measurements like time based, code execution duration, external resource access duration?

what if we need to organize our measurements in categories where every one has a different starting point?

As you suspect we need some global variables to be accessed by a class object or a static method: I choose the 2nd approach and here it is:

File A
------
\call_user_func_array(\g3\Utils::dt()->start, [0]);   // point A
...
File B
------
$dt = \call_user_func_array(\g3\Utils::dt()->end, [0]);  // point B
Value $dt contains the milliseconds of wall clock duration between points A and B.

To estimate the time took for php code to run:

File A
------
\call_user_func_array(\g3\Utils::dt()->codeStart, [1]);   // point A
...
File B
------
$dt = \call_user_func_array(\g3\Utils::dt()->codeEnd, [1]);  // point B

the results are in milliseconds with decimal part – centurian Dec 29 '20 at 13:40
method \g3\Utils::dt()->stats($i) returns the sub-array of all measures for group $i
based on a unique starting point; moreover if you subtract the i-1 from i value you
get the tine difference between these successive measurements. – centurian Dec 29 '20 at 19:51
*/ 
class Utils {
   public function __construct() {}

   public static $UtilsDtStart = [];
   public static $UtilsDtStats = [];

   public static function dt() {
      global $UtilsDtStart, $UtilsDtStats;
      $obj = new \stdClass();
      $obj->start = function(int $ndx = 0) use (&$UtilsDtStart) {
         $UtilsDtStart[$ndx] = \microtime(true) * 1000;
      };
      $obj->codeStart = function(int $ndx = 0) use (&$UtilsDtStart) {
         $use = \getrusage();
         $UtilsDtStart[$ndx] = ($use["ru_utime.tv_sec"] * 1000) + ($use["ru_utime.tv_usec"] / 1000);
      };
      $obj->resourceStart = function(int $ndx = 0) use (&$UtilsDtStart) {
         $use = \getrusage();
         $UtilsDtStart[$ndx] = $use["ru_stime.tv_usec"] / 1000;
      };
      $obj->end = function(int $ndx = 0) use (&$UtilsDtStart, &$UtilsDtStats) {
         $t = @$UtilsDtStart[$ndx];
          if($t === null)
            return false;
         $end = \microtime(true) * 1000;
         $dt = $end - $t;
         $UtilsDtStats[$ndx][] = $dt;
         return $dt;
      };
      $obj->codeEnd = function(int $ndx = 0) use (&$UtilsDtStart, &$UtilsDtStats) {
         $t = @$UtilsDtStart[$ndx];
         if($t === null)
            return false;
         $use = \getrusage();
         $dt = ($use["ru_utime.tv_sec"] * 1000) + ($use["ru_utime.tv_usec"] / 1000) - $t;
         $UtilsDtStats[$ndx][] = $dt;
         return $dt;
      };
      $obj->resourceEnd = function(int $ndx = 0) use (&$UtilsDtStart, &$UtilsDtStats) {
         $t = @$UtilsDtStart[$ndx];
         if($t === null)
            return false;
         $use = \getrusage();
         $dt = ($use["ru_stime.tv_usec"] / 1000) - $t;
         $UtilsDtStats[$ndx][] = $dt;
         return $dt;
              };
      $obj->stats = function(int $ndx = 0) use (&$UtilsDtStats) {
         $s = @$UtilsDtStats[$ndx];
         if($s !== null)
            $s = \array_slice($s, 0);
         else
            $s = false;
         return $s;
      };
      $obj->statsLength = function() use (&$UtilsDtStats) {
         return \count($UtilsDtStats);
      };
      return $obj;
   }
}
call_user_func_array(Utils::dt()->start, [0]);
call_user_func_array(Utils::dt()->codeStart, [1]);
sleep(3);
call_user_func_array(Utils::dt()->codeEnd, [1]);
$dt = call_user_func_array(Utils::dt()->end, [0]);
// print_r($dt);
echo $dt;