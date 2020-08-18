// global 

var inlink = document.getElementById("inlink");
var footer = document.getElementById("footer");
var showQu = document.getElementById("show-qu");
var noVid  = document.getElementById("noVid");
var showVid  = document.getElementById("show-vid");
var outLink  = document.getElementById("outLink");


//////////////// AJAX Functions

function getAjaxInstance(){
	var xml;
	try{
		if(window.XMLHttpRequest) xml = new XMLHttpRequest();
		else {
			xml = new ActiveXobject("Microsoft.XMLHTTP");
		}
	}catch(err){
		alert("Can't make the request");
	}
	return xml;
}

function myAjax(ele,page,par){
	var xmlhttp = getAjaxInstance();
	xmlhttp.onreadystatechange = function(){
		ele.innerHTML = '<img width="480px" src="image/load.gif">';
		if(this.readyState == 4 && this.status == 200){
			ele.innerHTML = this.responseText;;
		}
	}
	xmlhttp.open("POST",page , true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(par);
}


/////////////////////////////////////////////////////


inlink.onkeyup = function(e){
	if(e.keyCode == 13){
		showQu.innerHTML = "";
		showVid.innerHTML = "";
		outLink.innerHTML = "";
		myAjax(showQu,'ajax/getQuality.ajax.php','link='+inlink.value);
		myAjax(showVid,'ajax/getVideo.ajax.php','link='+inlink.value);
	}
	if(e.keyCode == 13 && showQu.innerHTML == "") console.log('empty');
}


function setStartTime(){
	console.log(document.getElementById('myPlayer'));
}


//
//startBtn.onclick = function(e){
//	//get the video now
//}
//
//endBtn.onclick = function(e){
//	//get 
//}


function getOptions(e){
	e.preventDefault();
	
	var qua = document.querySelector('input[name="quality"]:checked').value;
	var sm = document.getElementById('sm').value;
	var ss = document.getElementById('ss').value;
	var sms = document.getElementById('sms').value;
	
	var em = document.getElementById('em').value;
	var es = document.getElementById('es').value;
	var ems = document.getElementById('ems').value;
	
	var f = document.getElementById("format");
	var format = f.options[f.selectedIndex].value;
	
	var formValues = 'quality='+ qua + '&sm='+sm+'&ss='+ss+'&sms='+sms
					+ '&em='+em+'&es='+es + '&ems='+ems + '&format='+format+'&link='+inlink.value;
		
	myAjax(outLink , 'ajax/getOutLink.ajax.php' ,formValues );
//	formOptions.style.display = 'none';
}


