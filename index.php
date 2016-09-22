<?php

include("helpers.php");


$do = "";

if(isset($_POST["do"])) {
    $do = $_POST["do"];
}

if($do != "") {
    header("Content-Type: application/json");
} else {
    header("Content-Type: text/html");
}

?>

<?php if($do == "") { ?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<title>Auto Experimenter</title>
	
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="js/jquery/jquery-ui.min.js" type="text/javascript"></script>
	
	<script>
	 function checkStatus() {
	     $(function() {
		 $.ajax({type: "POST",
			 url: "",
			 data: {do: "check_status"},
			 success: function(data) {
			     $("#running_experiments").html(formatRunningExperiments(data.running_experiments));
			 },
			 error: function(jqXHR, textStatus, errorThrown) {
			     alert("ERROR! " + textStatus);
			 }});
	     });
	 }
	 
	 function listExperiments() {
	     $(function() {
		 $.ajax({type: "POST",
			 url: "",
			 data: {do: "list_experiments"},
			 success: function(data) {
			     $("#available_experiments").html(formatAvailableExperiments(data.available_experiments));
			 },
			 error: function(jqXHR, textStatus, errorThrown) {
			     alert("ERROR! " + textStatus);
			 }});
	     });
	 }
	 
	 function killExperiment(expid) {
	     $.post("",
		    {do: "kill_experiment",
		     id: expid},
		    function(data) {
			//$("#div1").html("Result: " + data.name);
		    }, "json");
	 }
	 
	 function runExperiment(exptype) {
	     $.post("",
		    {do: "run_experiment",
		     type: exptype},
		    function(data) {
			//$("#div1").html("Result: " + data.name);
		    }, "json");
	 }
	 
	 function formatAvailableExperiments(data) {
	     var experiments = "<table>";
	     experiments += "<tr><td><b>Type</b></td><td><b>Name</b></td><td><b>Run</b></td></tr>";
	     
	     $.each(data, function(index, itemData) {
		 experiments += "<tr>";
		 experiments += "<td>" + itemData["type"] + "</td>";
		 experiments += "<td>" + itemData["label"] + "</td>";
		 experiments += "<td><a style=\"cursor: pointer; text-decoration: underline; color: blue\" onclick='runExperiment(\"" + itemData["type"] + "\")';\">Run</a></td>";
		 experiments += "</tr>";
	     });
	     experiments += "</table>";
	     
	     return experiments;
	 }
	 
	 function formatRunningExperiments(data) {
	     var experiments = "<table>";
	     experiments += "<tr><td><b>Type</b></td><td><b>Name</b></td><td><b>Runtime</b></td><td><b>Kill</b></td></tr>";
	     
	     $.each(data, function(index, itemData) {
		 experiments += "<tr>";
		 experiments += "<td>" + itemData["type"] + "</td>";
		 experiments += "<td>" + itemData["name"] + "</td>";
		 experiments += "<td>" + itemData["runtime"] + "</td>";
		 experiments += "<td><a style=\"cursor: pointer; text-decoration: underline; color: blue\" onclick=\"killExperiment(" + itemData["id"] + ");\">Kill</a></td>";
		 experiments += "</tr>";
	     });
	     experiments += "</table>";
	     
	     return experiments;
	 }
	 
	 $(document).ready(function() {
	     $(function() {
		 $(".widget input[type=submit], .widget a, .widget button").button();
		 $("button, input, a").click(function(event) {
		     event.preventDefault();
		 });
	     });
	     
	     $("#submit_list").click(function(){
		 listExperiments();
	     });
	     
	     setInterval(checkStatus, 1000);
	 });
	</script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="js/jquery/jquery-ui.css">
	<link rel="stylesheet" href="css/portal.css">
    </head>
    
    <body>
	<form>
	    <button class="ui-button ui-widget ui-corner-all" id="submit_list">List Experiments</button>
	</form>
	
	<div id="div1">Nop.</div>
	<div id="available_experiments">None yet.</div>
	<div id="running_experiments">None yet.</div>
    </body>
</html>
<?php

} else {
    include("expdatabase.php");
    
    $db = new ExpDatabase();
    
    switch($do) {
	case "check_status":
	    echo '{"running_experiments": [{"type": "ltfnp", "name": "Jan\'s experiment", "runtime": "0", "id": 123}, {"type": "chemlab", "name": "Gheorghe\'s experiment", "runtime": "3", "id": 456}]}';
	    break;
	    
	case "list_experiments":
	    echo '{"available_experiments": [{"type": "ltfnp", "label": "Longterm Fetch and Place"}, {"type": "chemlab", "label": "Chemical Laboratory"}]}';
	    break;
	    
	default:
	    echo '{status: unknown}';
    }
}

?>
