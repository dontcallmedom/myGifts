
if (screen && screen.width) {
	var screenWidth=screen.width;
	var screenHeight=screen.height;
}

function openWindow(theUrl, windowId, width, height, windowOptions) {
	if (theUrl.indexOf('?') < 0) {
		theUrl += '?';
	} else {
		theUrl += '&';
	}

	if (screenWidth && width > screenWidth+32) {
		if (width > screenWidth+182)
			theUrl += '&resizedX=2';
		else
			theUrl += '&resizedX=1';
		width=screenWidth-8;
	}
	if (screenHeight && height > screenHeight+32) {
		height=screenHeight-40;
		theUrl += '&resizedY=1';
	}
	theUrl += 'width='+width+'&height='+height;

    if (navigator && !navigator.javaEnabled())
        theUrl += '&nojava=1';
    else
        theUrl += '&java=1';
        
	var theWindow = window.open(theUrl, windowId, 'width='+width+',height='+height+','+windowOptions);
    if (theWindow.focus)
        theWindow.focus();
}
