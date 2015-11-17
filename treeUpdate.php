<?php
	require("tree.php");
	$treeStr = $_REQUEST["treeStr"];
	$tree = new Tree($treeStr);
	//$tree = tree($treeStr);
	$JSONTree = $tree->toJSON();
	print(json_encode($JSONTree, JSON_PRETTY_PRINT));
	//print(json_encode($tree, JSON_PRETTY_PRINT));
?>
