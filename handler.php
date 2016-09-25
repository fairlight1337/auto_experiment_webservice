<?php

    include("expdatabase.php");

    $db = new ExpDatabase();

    switch($do) {
	case "check_status":
	    echo(json_encode(array("status" => "success", "queued_experiments" => $db->queuedExperiments())));
	    break;
	    
	case "list_experiments":
	    echo(json_encode(array("status" => "success", "available_experiments" => $db->availableExperiments())));
	    break;
	    
	case "run_experiment":
	    $type = $_POST["type"];
	    $owner_uid = "some-uid";
	    
	    $expid = $db->queueExperiment($type, $owner_uid);
	    
	    echo '{"status": "success", "id": "' . $expid . '"}';
	    break;
	    
	case "kill_experiment":
	    $db->removeQueuedExperiment($_POST["id"]);
	    break;
	    
	default:
	    echo '{"status": "failure"}';
    }

?>
