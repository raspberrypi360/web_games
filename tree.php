<?php 
	class TreeNode{
		var $value;
		var $parent;
		var $left;
		var $right;
		function TreeNode($val, $parent){
			$this->value = $val;
			$this->parent = $parent;
		}
	}
	class Tree
	{
		private $root;
 		function Tree($treeStr){
 			if ($treeStr != "" || $treeStr != "#"){
 				$this->buildTree($treeStr);
 			}
 		}
 		function printTree(){
 			$result = "";
 			$queue = array(&$this->root);
 			while (count($queue) != 0){
 				$parent = array_shift($queue);
 				if ($parent == null){
 					$result .= "#";
 					if (count($queue) != 0){
 						$result .= ", ";
 					}
 				}
 				else{
 					$result .= (string)$parent->value;
 					$result .= ", ";
 					array_push($queue, $parent->left);
 					array_push($queue, $parent->right);
 				}
 			}
 			return $result;
 		}
		private function buildTree($treeStr){
			$treeTok = strtok($treeStr, ", ");
			if (!$treeTok || $treeTok == "#"){
				return array();
			}
			$this->root = new TreeNode($treeTok, null);
			$queue = array(&$this->root);
			while (count($queue) != 0){
				$parent = &$queue[0];
				array_shift($queue);
				$treeTok = strtok(", ");
				if ($treeTok && $treeTok != "#"){
					unset($node);
					$node = new TreeNode($treeTok, $parent);
					$queue[] = &$node;
					$parent->left = &$node;
				}
				$treeTok = strtok(", ");
				if ($treeTok && $treeTok != "#"){
					unset($node);
					$node = new TreeNode($treeTok, $parent);
					$queue[] = &$node;
					$parent->right = &$node;
				}
			}
		}
		protected function nodeToArray($value, $parent){
			$node = array("name" => $value, "parent" => $parent, "children" => array());
			return $node;
		}
		function toJSON(){
			if ($this->root == null){
				return array();
			}
			$arrayRoot = $this->nodeToArray($this->root->value, null);
			$result = array(&$arrayRoot);
			$nodeArrayQueue = array(&$arrayRoot);
			$queue = array($this->root);
			while (count($queue) != 0 && count($nodeArrayQueue) != 0){
				$parent = array_shift($queue);
				$parentArray = &$nodeArrayQueue[0];
				array_shift($nodeArrayQueue);
				if ($parent->left != null){
					unset($nodeArray);
					$queue[] = $parent->left;
					$nodeArray = $this->nodeToArray($parent->left->value, $parent->value);
					$nodeArrayQueue[] = &$nodeArray;
					$parentArray["children"][] = &$nodeArray;
				}
// 				else{
// 					$parentArray["children"][] = null;
// 				}
				if ($parent->right != null){
					unset($nodeArray);
					$queue[] = $parent->right;
					$nodeArray = $this->nodeToArray($parent->right->value, $parent->value);
					$nodeArrayQueue[] = &$nodeArray;
					$parentArray["children"][] = &$nodeArray;
				}
// 				else{
// 					$parentArray["children"][] = null;
// 				}
			}
			return $result;
		}
	}
?>