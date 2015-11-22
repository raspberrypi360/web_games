<!DOCTYPE html>
<meta charset="utf-8">
<style> /* set the CSS */

body { font: 12px Arial;}

path { 
    stroke: steelblue;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 1;
    shape-rendering: crispEdges;
}

.grid .tick {
    stroke: lightgrey;
    stroke-opacity: 0.7;
    shape-rendering: crispEdges;
}
.grid path {
          stroke-width: 0;
}

.area {
    fill: lightsteelblue;
    stroke-width: 0;
}
</style>
<body>

<!-- load the d3.js library -->    
<script src="js/d3.js"></script>
<script src="js/jquery-2.1.4.js"></script>
<form action="yahooFinance.php" id="searchForm">
  <input type="text" name="symbol" placeholder="Symbol Ex: RHT, YHOO" id="symbol">
  <input type="text" name="startDate" placeholder="Start Date Ex: 2009-08-12" id="startDate">
  <input type="text" name="endDate" placeholder="End Date Ex: 2010-06-30" id="endDate">
  <input type="submit" value="Make Graph">
</form>
<script>

// Set the dimensions of the canvas / graph
function update(error, data) {
	var margin = {top: 30, right: 40, bottom: 30, left: 60},
    width = 700 - margin.left - margin.right,
    height = 270 - margin.top - margin.bottom;
	// Parse the date / time
	var parseDate = d3.time.format("%Y-%m-%d").parse;
	
	// Set the ranges
	var x = d3.time.scale().range([0, width]);
	var y = d3.scale.linear().range([height, 0]);
	
	// Define the axes
	var xAxis = d3.svg.axis().scale(x)
	    .orient("bottom").ticks(5);
	
	var yAxis = d3.svg.axis().scale(y)
	    .orient("left").ticks(5);
	
	// Define the line
	var valueline = d3.svg.line()
	    .x(function(d) { return x(d.date); })
	    .y(function(d) { return y(d.close); });
	
	var valueline2 = d3.svg.line()
	.x(function(d) { return x(d.date); })
	.y(function(d) { return y(d.open); });
	// Adds the svg canvas
	d3.select("svg").remove();
	var svg = d3.select("body")
	    .append("svg")
	        .attr("width", width + margin.left + margin.right)
	        .attr("height", height + margin.top + margin.bottom)
	    .append("g")
	        .attr("transform", 
	              "translate(" + margin.left + "," + margin.top + ")");
	
	function make_x_axis() {		
	    return d3.svg.axis()
	        .scale(x)
	        .orient("bottom")
	        .ticks(5)
	}
	function make_y_axis() {		
	    return d3.svg.axis()
	        .scale(y)
	        .orient("left")
	        .ticks(5)
	}
    data.forEach(function(d) {
        d.date = parseDate(d.date);
        d.close = +d.close;
        d.open = +d.open; 
    });
    // Scale the range of the data
    x.domain(d3.extent(data, function(d) { return d.date; }));
    y.domain([d3.min(data, function(d) { 
        return Math.min(d.close, d.open); }), d3.max(data, function(d) { 
            return Math.max(d.close, d.open); })]);
    //y.domain([0, d3.max(data, function(d) { 
        //return Math.max(d.close, d.open); })]);

    // Add the valueline path.
    svg.append("path")
        .attr("class", "line")
        //.style("stroke-dasharray", ("3, 3")) 
        .attr("d", valueline(data));

    svg.append("path")          // Add the valueline2 path.
    	.style("stroke", "red")
    	.attr("d", valueline2(data));

/*    svg.append("path")
	    .datum(data)
	    .attr("class", "area")
	    .attr("d", area);*/

    // Add the X Axis
    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);

    svg.append("text")             // text label for the x axis
    .attr("transform",
            "translate(" + (width/2) + " ," + 
                           (height+margin.bottom) + ")")
    .style("text-anchor", "middle")
    .text("Date");

    // Add the Y Axis
    svg.append("g")
        .attr("class", "y axis")
        .call(yAxis);

    svg.append("text")
    .attr("x", (width / 2))				
    .attr("y", 0 - (margin.top / 2))
    .attr("text-anchor", "middle")	
    .style("font-size", "16px") 
    .style("text-decoration", "underline") 	
    .text("Value vs Date Graph");

    svg.append("text")
    .attr("transform", "rotate(-90)")
    .attr("y", 0 - margin.left)
    .attr("x",0 - (height / 2))
    .attr("dy", "1em")
    .style("text-anchor", "middle")
    .text("Value");

	svg.append("text")
	.attr("transform", "translate(" + (width+3) + "," + y(data[0].open) + ")")
	.attr("dy", ".35em")
	.attr("text-anchor", "start")
	.style("fill", "red")
	.text("Open");

	svg.append("text")
	.attr("transform", "translate(" + (width+3) + "," + y(data[0].close) + ")")
	.attr("dy", ".35em")
	.attr("text-anchor", "start")
	.style("fill", "steelblue")
	.text("Close");

    svg.append("g")			
    .attr("class", "grid")
    .attr("transform", "translate(0," + height + ")")
    .call(make_x_axis()
        .tickSize(-height, 0, 0)
        .tickFormat("")
    )

	svg.append("g")			
	    .attr("class", "grid")
	    .call(make_y_axis()
	        .tickSize(-width, 0, 0)
	        .tickFormat("")
	    )
};
/*var stocks = [
	{ "date": "2010-03-10", "high": "30.42", "low": "30.08", "open": "30.129999", "close": "30.360001" }, 
	{ "date": "2010-03-09", "high": "30.450001", "low": "29.76", "open": "29.90", "close": "30.209999" }, 
	{ "date": "2010-03-08", "high": "30.24", "low": "29.83", "open": "30.15", "close": "30.01" }, 
	{ "date": "2010-03-05", "high": "30.719999", "low": "29.860001", "open": "30.00", "close": "30.27" }
];
update(null, stocks);*/
$( "#searchForm" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
  var $form = $( this ),
    symbol = $form.find( "input[name='symbol']" ).val(),
    startDate = $form.find( "input[name='startDate']" ).val(),
    endDate = $form.find( "input[name='endDate']" ).val(),
    url = $form.attr( "action" );

  var options = {
	  		url : url,
			cache : false,
			async : true,
			data : {symbol: symbol, startDate: startDate, endDate: endDate},
			datatype : "json",
			success: updateDone,
			error: searchError
		};
	$.ajax(options);
	return true;
});
// Get the data
function updateDone(data){
	if (data == "time span is too long"){
		alert(data);
	}
	else{
		var jsonData = JSON.parse(data);
		update(null, jsonData);
	}
}
function searchError() {
	alert("error");
	console.log("search error");
}
</script>
</body>