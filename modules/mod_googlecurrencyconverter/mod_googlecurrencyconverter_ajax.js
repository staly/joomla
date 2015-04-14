/**
* GoogleCurrencyConverter module
* This module allows you to add the Google Currency Converter in a module position.
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* v1.5 August 21, 2008
*/

//window.onload = prepareForm;

function googlecurrency_prepareForm(mod_id) {
	if(!document.getElementById) {
		return;
	}
	if(!document.getElementById("googlecurrencyForm"+mod_id)) {
		return;
	}
	document.getElementById("googlecurrencyForm"+mod_id).onsubmit = function() {
		var data = "";
		for (var i=0; i<this.elements.length; i++) {
			data+= this.elements[i].name;
			data+= "=";
			data+= escape(this.elements[i].value);
			data+= "&";
		}
		data+= "process=1";
		return !googlecurrency_sendData(mod_id, data);
	};
}

function googlecurrency_sendData(mod_id, data) {
	var request = googlecurrency_getHTTPObject();
	if (request) {
		googlecurrency_displayLoading(mod_id, document.getElementById("googlecurrency_loading"+mod_id));
		request.onreadystatechange = function() {
			googlecurrency_parseResponse(request, mod_id);
		};
		//url = lib_url+"?"+data+"&submit_button_label="+submit_button_label;
		url = eval('lib_url'+mod_id)+"?"+data
		+"&submit_button_label="+eval('submit_button_label'+mod_id)
		+"&label_convert="+eval('label_convert'+mod_id)
		+"&label_into="+eval('label_into'+mod_id)
		+"&use_curl="+eval('googlecurrency_use_curl'+mod_id)
		+"&style="+eval('style'+mod_id)
		+"&mod_id="+mod_id;
		request.open( "GET", url, true );
		request.send(null);
		return true;
	} else {
		return false;
	}
}

function googlecurrency_parseResponse(request, mod_id) {
	if (request.readyState == 4) {
		if (request.status == 200 || request.status == 304) {
			var container = document.getElementById("googlecurrency_container"+mod_id);
			container.innerHTML = request.responseText;
			googlecurrency_prepareForm(mod_id);
		}
	}
}

function googlecurrency_getHTTPObject() {
	var xhr = false;
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e) {
				xhr = false;
			}
		}
	}
	return xhr;
}

function googlecurrency_displayLoading(mod_id, element) {
	var image = document.createElement("img");
	//image.setAttribute("src", progress_gif);
	image.setAttribute("src", eval('progress_gif'+mod_id));
	image.setAttribute("alt","Loading...");
	image.setAttribute("align","middle");
	element.appendChild(image);
}
