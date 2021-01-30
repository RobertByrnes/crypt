<?php

/**
 * @author Robert Byrnes
 * @created 29/01/2021
 **/

/* Example */
// $start = new Timer;
// sleep(3);
// $start->endTimer(1);

Class Timer {

    /**
     * stores float startTime upon calling of contructor.
     */
    private float $startTime;

    public function __construct ()
    {
        $this->startTime = $this->startTimer();
    }

    /**
     * called from the constructor, begins microsecond timer based on unix epoch time,
     * i.e. seconds since Unix Epoch on January 1st, 1970 at UTC.
     * @return float
     */
    private function startTimer() : float
    {
        $mTime = microtime(); 
        $mTime = explode(" ",$mTime);
        $mTime = $mTime[1] + $mTime[0];
        $this->startTime = $mTime;
        return $this->startTime;
    }

    /**
     * Called from a class object - ends timer and returns execution time as a float,
     * if paramater $echo is passed as '1' will echo timer result.
     * @param boolean $echo
     * @return float
     */
    public function endTimer($echo=NULL) : float
    {
        $mTime = microtime();
        $mTime = explode(" ",$mTime); 
        $mTime = $mTime[1] + $mTime[0]; 
        $endTime = $mTime; 
        $executionTime = number_format(($endTime - $this->startTime), 4);
        if($echo != NULL) {
            echo "This page was created in ".number_format($executionTime,4)." seconds"; 
        }
        return $executionTime;
    }
}
 
