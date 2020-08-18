<?php 


function echoError($s){
	return '<div class="error">'.$s.'<div>';
}


if(!isset($_POST['link']))  die('<div class="error">Please put valid link <div>');
	
$url =  $_POST['link'];

//$url = filter_var($url, FILTER_SANITIZE_URL);
if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    die(echoError(' Not Valid Link'));
}



$cmd = 'F:\setupFile\wamp\www\me\videoconverter\youtube-dl\youtube-dl.exe -F '.$url . " 2>&1";

exec($cmd, $output , $ret);


if (strpos($output[sizeof($output)-1], 'ERROR') !== false) {
   echo echoError(substr($output[sizeof($output)-1] ,6));
	die("");
}



$options = [];
$options[] = array('quality'=>'default' , 'code'=>'best');

foreach ($output as $val) {
	$s = "";
	
	if(strpos($val , '360p'))  $s .= "360p";
	if(strpos($val , '480p'))    $s .='480p';
	if(strpos($val , '540p'))    $s .='540p';
	elseif(strpos($val , '720p'))    $s .='720p';
	elseif(strpos($val , '240p'))   $s .='240p';
	elseif(strpos($val , '144p'))   $s .='144p';
	elseif(strpos($val , '1080p'))    $s.='1080p';
	elseif(strpos($val , '2160p'))    $s.='2160p';
	
	
	
	if( strlen($s) > 2 && strpos($val , 'mp4') && strpos($val , 'video only' ) === false){
		
		$options[] = array('quality'=> $s , 'code' => substr( $val , 0 ,strpos($val,' ') ) );
	}
}

$cmd = 'F:\setupFile\wamp\www\me\videoconverter\youtube-dl\youtube-dl.exe --skip-download --get-duration --no-warnings '.$url . " 2>&1";
exec($cmd, $out , $ret);

	
$lenVid = $out[0];

$mn = 0;
$sec = 0 ;

if($lenVid[2] == ':'){ 
	$mn = (int)substr($lenVid,0,2);
	$sec = (int)substr($lenVid,3,4);
}else {
	$mn = (int)substr($lenVid,0,1);
	$sec = (int)substr($lenVid,2,3);
}


// create the form .......



echo  '  
		<form id="formOptions" onsubmit = "getOptions(event)">
					
					<label class="lehead"> choose quality </label>
';

foreach ($options as $op){
	echo ' <label> <input type="radio" name="quality" value="'.$op['code'] .'" ';
	if($op['quality'] == 'default') echo 'checked';
	echo '>'.$op['quality'] .  '</label>   ';
}







echo '
						
					<label class="lehead"> trim </label>
					
					<div class="startDiv">
						<input type="number" min="0" max="59"  class="trimTime" id="sm" value="00"> :
						<input type="number" min="0" max="59" class="trimTime" id="ss" value="00"> :
						<input type="number" min="0" max="99"  class="trimTime" id="sms" value="00">
						<div class="startBtn  trimBtn" id="startBtn">Start</div>
					</div>
					<div class="endDiv">
						<input type="number" min="0" max="59" class="trimTime" id="em" value="'.$mn .'"> :
						<input type="number" min="0" max="59" class="trimTime" id="es" value="'.$sec.'"> :
						<input type="number" min="0" max="99" class="trimTime" id="ems" value="00">
						<div class="endBtn trimBtn" id="endBtn">End</div>
					</div>
					
					<label class="lehead"> convert </label>
					<select name="format" id="format" class="format">
						<option value="mp4">mp4</option>
						<option value="mp3">mp3</option>
						<option value="mkv">mkv</option>
						<option value="gif">gif</option>
					</select>
					
					
					<input type="submit" name="submitOptions" >
				</form>
';















