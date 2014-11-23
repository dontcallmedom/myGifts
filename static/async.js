function setValue(obj, value) {
	if (obj) {
		if (obj.firstChild)
			obj.firstChild.nodeValue = value;
		else
			obj.innerText = value;
	}
}

function clearMsgContainer() {
	setValue(_msgContainer, '');
}

function handleHttpResponse() {
	if (http.readyState == 4) {
		// Split the comma delimited response into an array
		setValue(_msgContainer, unescape(http.responseText));
		window.setTimeout('clearMsgContainer()', 10000);
	}
	return null;
}

function sendRequest(form, handler, paramNames, msgContainer) {
	_msgContainer = msgContainer;
	var request = "async.php?handler="+escape(handler);
	for (var paramName in paramNames) {
		var element = eval("form."+paramNames[paramName]);
		var value = "";
		if (element.type != "checkbox" || element.checked)
			value = element.value;
		request += "&"+escape(paramNames[paramName])+"="+escape(value);
	}
	http.open("GET", request, true);
	http.onreadystatechange = handleHttpResponse;
	http.send(null);
}

function getHTTPObject() {
  var xmlhttp;
  /*@cc_on
  @if (@_jscript_version >= 5)
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
  @else
  xmlhttp = false;
  @end @*/
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}
var http = getHTTPObject(); // We create the HTTP Object