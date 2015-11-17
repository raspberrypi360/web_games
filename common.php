<?php 			
	function moveZeroes(&$nums){
		$numsSize = count($nums);
		$nz = 0;
		$i = 0;
		while ($i < $numsSize)
		{
			if ($nums[$i] != "0")
			{
				if ($nz != 0)
				{
					$nums[$i - $nz] = $nums[$i];
					$nums[$i] = "0";
				}
			}
			else
			{
				$nz++;
			}
			$i++;
		}
	}

	function treeNode($value, $parent){
		$node = array("name" => $value, "parent" => $parent, "children" => array());
		return $node;
	}

	function &tree($treeStr){
		$treeTok = strtok($treeStr, ", ");
		if (!$treeTok || $treeTok == "#"){
			return array();
		}
		$root = treeNode($treeTok, null);
		$result = array(&$root);
		$queue = array(&$root);
		while (count($queue) != 0){
			$parent = &$queue[0];
			array_shift($queue);
			$treeTok = strtok(", ");
			if ($treeTok && $treeTok != "#"){
				unset($node);
				$node = treeNode($treeTok, $parent["name"]);
				$queue[] = &$node;
				$parent["children"][] = &$node;
			}
			$treeTok = strtok(", ");
			if ($treeTok && $treeTok != "#"){
				unset($node);
				$node = treeNode($treeTok, $parent["name"]);
				$queue[] = &$node;
				$parent["children"][] = &$node;
			}
		}
		return $result;
	}
?>