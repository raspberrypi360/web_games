<!DOCTYPE html>

<html>
    <body>
    	<style>
	    	textarea {
				width: 43%;
				height: 120px;
				border: 3px solid #dddddd;
				padding: 5px;
				font-family: Tahoma, sans-serif;
				background-image: url(bg.gif);
				background-position: bottom right;
				background-repeat: no-repeat;
    			margin-left: auto;
    			margin-right: auto;
    			display: inline;
	    		text-align: left;
	    		vertical-align: middle;
	    	}
	    	input{
	    		display: inline;
	    		vertical-align: middle;
	    	}
	    	h1 {
	    		text-align: center;
	    	}
	    </style>
	    <h1>
	    	Move Zeroes to the Back
	    </h1>
        <form method="get" id="type">
            <textarea autofocus name="nums" placeholder="Numbers" form="type"><?php echo($_GET["nums"])?></textarea>
        	<input type="submit" value="Move Zeroes"/>
			<textarea readonly form="type">
				<?php
					require("common.php");
					$nums2 = $_GET["nums"];
					$nums = explode(", ", $nums2);
					moveZeroes($nums);
					print(implode(", ", $nums));
				?>
			</textarea>
        </form>
    </body>
</html>