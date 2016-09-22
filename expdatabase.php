<?php

class ExpDatabase extends SQLite3 {
    function __construct() {
	$this->open("db/experiments.db");//, SQLITE3_OPEN_CREATE);
    }
    
    function addExperimentInstance(type, pid, starttime) {
	
    }
    
    function removeExperimentInstance(id) {
	
    }
}

?>
