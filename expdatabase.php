<?php

class ExpDatabase extends SQLite3 {
    function __construct() {
	$create = false;
	
	if(!file_exists("db/experiments.db")) {
	    $create = true;
	}
	
	$this->open("db/experiments.db");
	
	if($create) {
	    $this->exec("CREATE TABLE available_experiments (type STRING, label STRING)");
	    $this->exec("CREATE TABLE queued_experiments (id INTEGER PRIMARY KEY AUTOINCREMENT, type STRING, pid STRING, starttime NUMERIC, owner_uid STRING)");
	    
	    $this->addAvailableExperiment("ltfnp", "Longterm Fetch and Place");
	    $this->addAvailableExperiment("chemlab", "Chemical Laboratory");
	}
    }
    
    function addAvailableExperiment($type, $label) {
	$this->exec("INSERT INTO available_experiments VALUES('" . $this->escapeString($type) . "', '" . $this->escapeString($label) . "')");
    }
    
    function queueExperiment($type, $owner_uid) {
	$this->exec("INSERT INTO queued_experiments VALUES(null, '" . $this->escapeString($type) . "', '', datetime(), '" . $this->escapeString($owner_uid) . "')");
	
	$lastID = $this->lastInsertRowID();
	$lastRow = $this->query("SELECT * FROM queued_experiments WHERE rowid='" . $lastID . "'");
	
	if($lastRow) {
	    $result = $lastRow->fetchArray();
	    
	    if($result) {
		return $result["id"];
	    }
	}
	
	return false;
    }
    
    function removeQueuedExperiment($id) {
	$this->exec("DELETE FROM queued_experiments WHERE id='" . $this->escapeString($id) . "'");
    }
    
    function availableExperiments() {
	$experiments = array();
	
	$sql = "SELECT * FROM available_experiments";
	$result = $this->query($sql);
	
	while($row = $result->fetchArray()) {
	    $arr = array("type" => $row["type"], "label" => $row["label"]);
	    
	    array_push($experiments, $arr);
	}
	
	return $experiments;
    }
    
    function queuedExperiments() {
	$experiments = array();
	$result = $this->query("SELECT * FROM queued_experiments ORDER BY starttime ASC");
	
	while($row = $result->fetchArray()) {
	    array_push($experiments, $row);
	}
	
	return $experiments;
    }
}

?>
