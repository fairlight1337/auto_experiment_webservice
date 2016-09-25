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
	
	<script src="js/jquery/jquery-3.1.0.min.js"></script>
	<script src="js/jquery/jquery-ui.js" type="text/javascript"></script>
	<script src="js/AutoExpClient.js" type="text/javascript"></script>
	
	<script>
	 var aeClient = new AutoExpClient();
	 
	 $(document).ready(function() {
	     $(function() {
		 $(".widget input[type=submit], .widget a, .widget button").button();
		 $("button, input, a").click(function(event) {
		     event.preventDefault();
		 });
	     });
	     
	     $("#submit_list").click(function(){
		 aeClient.listExperiments();
	     });
	     
	     setInterval(aeClient.checkStatus.bind(aeClient), 1000);
	     
	     var dialog = $("#queue_experiment_dialog").dialog({
		 autoOpen: false,
		 height: 400,
		 width: 350,
		 modal: true,
		 buttons: {
		     "Create an account": aeClient.addUser,
		     Cancel: function() {
			 dialog.dialog("close");
		     }
		 },
		 close: function() {
		     //form[ 0 ].reset();
		     //allFields.removeClass( "ui-state-error" );
		 }
	     });
	     
	     $("#queue_experiment_button").button().on("click", function() {
		 dialog.dialog("open");
		 $("#id_experiments_list").selectmenu();
		 $("#id_experiments_list").html("<option disables>Loading experiments...</option>");
		 
		 $(function() {
		     $.ajax({type: "POST",
			     url: "",
			     data: {do: "list_experiments"},
			     success: function(data) {
				 var html = "";
				 
				 $.each(data.available_experiments, function(index, itemData) {
				     html += "<option value=\"" + itemData["type"] + "\">" + itemData["label"] + "</option>";
				 });
				 
				 $("#id_experiments_list").html(html);
			     },
			     error: function(jqXHR, textStatus, errorThrown) {
				 alert("ERROR! " + textStatus + errorThrown);
			     }});
		 });
	     });
	 });
	</script>
	
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="js/jquery/jquery-ui.css">
	<link rel="stylesheet" href="css/portal.css">
    </head>
    
    <body>
	<form>
	    <button class="ui-button ui-widget ui-corner-all" id="submit_list">List Experiments</button>
	<button class="ui-button ui-widget ui-corner-all" id="queue_experiment_button">Queue Experiment</button>
	</form>
	
	<div id="available_experiments"></div>
	<div id="queued_experiments"></div>
	
	<div id="queue_experiment_dialog" title="Queue Experiment">
	    <form action="#">
		<fieldset>
		    <label for="experiments_list">Select an Experiment</label>
		    <select name="experiments_list" id="id_experiments_list">
			<option disabled>Select Experiment</option>
		    </select>
		    
		    <label for="name">Name</label>
		    <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
		    <label for="email">Email</label>
		    <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
		    <label for="password">Password</label>
		    <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
		    
		    <!-- Allow form submission with keyboard without duplicating the dialog button -->
		    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
		</fieldset>
	    </form>
	</div>
	
    </body>
</html>
<?php

} else {
    include("handler.php");
}

?>
