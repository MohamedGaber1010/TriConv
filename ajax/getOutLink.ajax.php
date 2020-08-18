<?php


if(isset($_POST['quality'])){
	
	$quality = $_POST['quality'];
	$sm =(int) $_POST['sm'];
	$ss =(int) $_POST['ss'];
	$sms =(int) $_POST['sms'];
	$em =(int) $_POST['em'];
	$es =(int) $_POST['es'];
	$ems =(int) $_POST['ems'];
	$format = $_POST['format'];
	$url = $_POST['link'];
	
	
//	var_dump($_POST);
	

	$cmd = 'F:\setupFile\wamp\www\me\videoconverter\youtube-dl\youtube-dl.exe --skip-download --get-title --no-warnings '.$url . " 2>&1";
	exec($cmd, $output , $ret);
	
//	
//	$cmd = 'F:\setupFile\wamp\www\me\videoconverter\youtube-dl\youtube-dl.exe --skip-download --get-duration --no-warnings '.$url . " 2>&1";
//	exec($cmd, $out , $ret);
//	$lenName = $out[0];
	
	
	
	$cmd = 'F:\setupFile\wamp\www\me\videoconverter\youtube-dl\youtube-dl.exe -g '.$url . " 2>&1";
	exec($cmd, $output , $re);
	
	
	function getEndT($sm,$ss,$sms,$em,$es,$ems){
		$s = $sm*60*100+$ss*100+$sms;
		$e = $em*60*100+$es*100+$ems;
		$ret = $e -$s;
		if($ret <= 0) die('Please Enter Valid Time to Trim');
		$rm = (int)($ret/(100*60));
		$rs = (int)($ret - $rm*60*100)/100;
		$rms = (int)($ret - $rm*60*100 - $rs *100);
		
		return $rm.':'.$rs.'.'.$rms;
	}
	
	
	$endTime = getEndT($sm,$ss,$sms,$em,$es,$ems);
	
	$cmd = 'F:\setupFile\wamp\www\me\videoconverter\youtube-dl\ffmpeg.exe -ss ';
	$cmd.= $sm.':'.$ss.'.'.$sms;
	$cmd.= ' -i "'.$output[1].'" -ss ';
	$cmd.= $sm.':'.$ss.'.'.$sms;
	$cmd.= ' -i "'.$output[2].'" -t '.$endTime;
//	if($format != 'gif' && $format != 'mp3') $cmd.=' -map 0:v -map 1:a -c:v libx264 -c:a aac ';
	$cmd.= ' out2.'.$format;
	$cmd.= " 2>&1";
	
	exec($cmd , $o,$rt);
	
//	var_dump($o);
	
	$output[0].=' '.time();
	rename('out2.'.$format , $output[0].'.'.$format);
	
	echo '<a href="download.php?file='.$output[0].'.'.$format  . '"> Download </a> ' ;
}

