
$.showChildTable = function(object,id,filterType, orderby, dir){

	$('#'+object+' .inner-content').html('<img class="spinner" src="images/loading.gif"/>');
	
	obj = object.split("_")[0];
	
	$.ajax({
		type: "GET",
		url: "functions/show.php",
		data: "object="+obj+"&id="+id+"&filterType="+filterType+(orderby?"&orderby="+orderby+"&dir="+dir:""),
		success: function(msg){	
			$('#'+object+' .inner-content').html($.trim(msg));
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});
};

$.showGraph = function(show,id){
	if(show){
		$("#graph").html("");
		$("#weightsSet_Graph").show();
		$(".weights_set").hide();
		
		var ajaxDataRenderer = function(url, plot, options) {
			var ret = null;
			$.ajax({
				async: false,
				url: url,
				dataType:"json",
				success: function(data) {
					ret = data;
				 }
			});
			return ret;
		};
		 
	  // The url for our json data
	  var jsonurl = "graph.php?id="+id;
	 
	  // passing in the url string as the jqPlot data argument is a handy
	  // shortcut for our renderer.  You could also have used the
	  // "dataRendererOptions" option to pass in the url.
	  var plot = $.jqplot('graph', jsonurl,{
		title: "Planned vs Actual Comparison",
		dataRenderer: ajaxDataRenderer,
		dataRendererOptions: {
		  unusedOptionalUrl: jsonurl
		},
		axes: {
			// options for each axis are specified in seperate option objects.
			xaxis: {
			  label: "Set #",
			  tickInterval: 1,
			  min:0,
			  tickOptions: {
				formatString: '%.0f', 
			  }
			},
			yaxis: {
			  label: "Weight (KG)",
			  tickInterval: 2,
			  min:0,
			  tickOptions: {
				formatString: '%.0f', 
			  }
			}
		},
		series:[{label:'Planned',color:'red'},{label:'Actual',color:'black'}],
		legend: {show: true,placement: 'outsideGrid'}
	  });
		
	}
	else{
		$("#WeightsSet_Graph").hide();
		$(".weights_set").show();
	}
};