<?php
	require("tree.php");
	$tree = new Tree("5, 3, 7");
	$treeStr = $tree->printTree();
	print($treeStr . "\n");
	$JSONTree = $tree->toJSON();
	print(json_encode($JSONTree, JSON_PRETTY_PRINT));
?>