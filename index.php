<?php

include("helpers.php");

$do = get("do");

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
	 $(document).ready(function(){
	     $(function() {
		 $(".widget input[type=submit], .widget a, .widget button").button();
		 $("button, input, a").click(function(event) {
		     event.preventDefault();
		 });
	     });
	     
	     $("#submit_it").click(function(){
		 $.getJSON("?do=something", function(data) {
		     $("#div1").html("Result: " + data.name);
		 });
	     });
	 });
	</script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="js/jquery/jquery-ui.css">
	<link rel="stylesheet" href="css/portal.css">
    </head>
    
    <body>
	<form>
	    <button class="ui-button ui-widget ui-corner-all" id="submit_it">blabla</button>
	</form>
	
	<div id="div1">Nop.</div>
    </body>
</html>
<?php

} else {
    include("expdatabase.php");
    
    $db = new ExpDatabase();
    
    echo '{ "status" : "success", "name" : "test1" }';
}

?>
