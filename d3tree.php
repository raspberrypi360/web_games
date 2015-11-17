<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Collapsible Tree Example</title>

    <style>

	.node circle {
	  fill: #fff;
	  stroke: steelblue;
	  stroke-width: 3px;
	}

	.node text { font: 12px sans-serif; }

	.link {
	  fill: none;
	  stroke: #ccc;
	  stroke-width: 2px;
	}
   	#treeStr {
   		display: inline;
   		vertical-align: middle;
   		width: 30%;
   	}
   	h1 {
   		text-align: left;
   	}  
    </style>
    <h1>Build a Tree</h1>

  </head>

  <body>

<!-- load the d3.js library -->	
<script src="js/d3.js"></script>
<script src="js/jquery-2.1.4.js"></script>
<form action="treeUpdate.php" id="searchForm">
  <input type="text" name="treeStr" placeholder="Tree String Ex: 5, 3, 7" id="treeStr">
  <input type="submit" value="Make Tree">
</form>
<br>
<!-- the result of the search will be rendered inside this div -->
<script>

function searchError() {
	alert("error");
	console.log("search error");
}
function updateDone(data){
	//$( "#result" ).empty().append( data );
	
	treeData = JSON.parse(data);
	margin = {top: 20, right: 120, bottom: 20, left: 120},
	width = 960 - margin.right - margin.left,
	height = 500 - margin.top - margin.bottom;
	
	i = 0;
	
	tree = d3.layout.tree()
		.size([height, width]);
	
	diagonal = d3.svg.diagonal()
		.projection(function(d) { return [d.x, d.y]; });
	
	valueline = d3.svg.line()
		.x(function(d) { return d.x; })
		.y(function(d) { return d.y; })
		.interpolate("linear");
	d3.select("svg").remove();
	svg = d3.select("body").append("svg")
		.attr("width", width + margin.right + margin.left)
		.attr("height", height + margin.top + margin.bottom)
	  	.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
	root = treeData[0];
	  
	update(root);

}

$( "#searchForm" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
  var $form = $( this ),
    term = $form.find( "input[name='treeStr']" ).val(),
    url = $form.attr( "action" );

	var options = {
	  		url : url,
			cache : false,
			async : true,
			data : {treeStr: term},
			datatype : "json",
			success: updateDone,
			error: searchError
		};
	$.ajax(options);
	return true;
});

// ************** Generate the tree diagram	 *****************

function update(source) {

  // Compute the new tree layout.
  var nodes = tree.nodes(root).reverse(),
	  links = tree.links(nodes);

  // Normalize for fixed-depth.
  nodes.forEach(function(d) { d.y = d.depth * 150; });

  // Declare the nodesâ€¦
  var node = svg.selectAll("g.node")
	  .data(nodes, function(d) { return d.id || (d.id = ++i); });

  // Enter the nodes.
  
  var nodeEnter = node.enter().append("g")
	  .attr("class", "node")
	  .attr("transform", function(d) { 
		  return "translate(" + d.x + "," + d.y + ")"; });

  nodeEnter.append("circle")
	  .attr("r", 10)
	  .style("fill", "#fff");

  nodeEnter.append("text")
	  .attr("x", function(d) { 
		  return d.children || d._children ? -13 : 13; })
	  .attr("dy", ".35em")
	  .attr("text-anchor", function(d) { 
		  return d.children || d._children ? "end" : "start"; })
	  .text(function(d) { return d.name; })
	  .style("fill-opacity", 1);

  // Declare the linksâ€¦
  var link = svg.selectAll("path.link")
	  .data(links, function(d) { return d.target.id; });

  // Enter the links.
  link.enter().insert("path", "g")
	  .attr("class", "link")
	  .attr("d", diagonal);

}

</script>
	
  </body>
</html>