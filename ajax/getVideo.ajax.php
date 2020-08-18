<?php


function echoError($s){
	return '<div class="error">'.$s.'<div>';
}


if(!isset($_POST['link']))  die('<div class="error">Please put valid link <div>');
	
$url =  $_POST['link'];

$url = filter_var($url, FILTER_SANITIZE_URL);
if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    die(echoError('Not a valid URL'));
}


if(strpos($url,'w.youtube.c') !== false){	
	parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );    
	
	if(isset($my_array_of_vars['v']))
	echo '
	<iframe id="myPlayer" width="700px" height="393px" src="https://www.youtube.com/embed/'. $my_array_of_vars['v']. ' "frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	';
}

