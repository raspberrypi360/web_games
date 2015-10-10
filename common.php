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
?>