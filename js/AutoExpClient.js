var AutoExpClient = function() {
}

AutoExpClient.prototype.formatAvailableExperiments = function(data) {
    var experiments = "<table>";
    experiments += "<tr><td><b>Type</b></td><td><b>Name</b></td><td><b>Action</b></td></tr>";
    
    $.each(data, function(index, itemData) {
	experiments += "<tr>";
	experiments += "<td>" + itemData["type"] + "</td>";
	experiments += "<td>" + itemData["label"] + "</td>";
	experiments += "<td><a style=\"cursor: pointer; text-decoration: underline; color: blue\" onclick='runExperiment(\"" + itemData["type"] + "\")';\">Run</a></td>";
	experiments += "</tr>";
    });
    experiments += "</table>";
    
    return experiments;
};

AutoExpClient.prototype.formatQueuedExperiments = function(data) {
    var experiments = "<table>";
    experiments += "<tr><td><b>Status</b></td><td><b>Type</b></td><td><b>Name</b></td><td><b>Runtime</b></td><td><b>Actions</b></td></tr>";
    
    $.each(data, function(index, itemData) {
	var status = "";
	
	if(itemData["pid"] != "") {
	    status = "Running";
	} else {
	    status = "Queued";
	}
	
	experiments += "<tr>";
	experiments += "<td>" + status + "</td>";
	experiments += "<td>" + itemData["type"] + "</td>";
	experiments += "<td>" + itemData["name"] + "</td>";
	experiments += "<td>" + itemData["runtime"] + "</td>";
	
	if(itemData["pid"] != "") {
	    experiments += "<td><a style=\"cursor: pointer; text-decoration: underline; color: blue\" onclick=\"killExperiment(" + itemData["id"] + ");\">Kill</a></td>";
	} else {
	    experiments += "<td><a style=\"cursor: pointer; text-decoration: underline; color: blue\" onclick=\"killExperiment(" + itemData["id"] + ");\">Remove</a></td>";
	}
	
	experiments += "</tr>";
    });
    experiments += "</table>";
    
    return experiments;
};

AutoExpClient.prototype.addUser = function(bla) {
};

AutoExpClient.prototype.checkStatus = function() {
    var self = this;
    var cbSuccess = function(data) {
	$("#queued_experiments").html(self.formatQueuedExperiments(data.queued_experiments));
    }
    
    $.ajax({type: "POST",
	    url: "",
	    data: {do: "check_status"},
	    success: cbSuccess,
	    error: function(jqXHR, textStatus, errorThrown) {
		alert("ERROR! " + textStatus);
	    }});
};

AutoExpClient.prototype.listExperiments = function() {
    var self = this;
    
    $.ajax({type: "POST",
	    url: "",
	    data: {do: "list_experiments"},
	    success: function(data) {
		console.log(data.available_experiments);
		$("#available_experiments").html(self.formatAvailableExperiments(data.available_experiments));
	    },
	    error: function(jqXHR, textStatus, errorThrown) {
		alert("ERROR! " + textStatus + errorThrown);
	    }});
};

AutoExpClient.prototype.killExperiment = function(expid) {
    $.post("",
	   {do: "kill_experiment",
	    id: expid},
	   function(data) {
	       //$("#div1").html("Result: " + data.name);
	   }, "json");
};

AutoExpClient.prototype.runExperiment = function(exptype) {
    $.post("",
	   {do: "run_experiment",
	    type: exptype},
	   function(data) {
	       //alert(data.id);
	       //$("#div1").html("Result: " + data.name);
	   }, "json");
};
