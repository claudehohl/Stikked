/*

Clipboard - Copy utility for jQuery
Version 2.0
November 24, 2007

Project page:

	http://bradleysepos.com/projects/jquery/clipboard/

Files:

	Source:            jquery.clipboard.js
	Source (packed):   jquery.clipboard.pack.js
	Flash helper:      jquery.clipboard.swf

Usage examples:

	// Basic usage:
	$.clipboardReady(function(){
		$( "a" ).click(function(){
			$.clipboard( "You clicked on a link and copied this text!" );
			return false;
		});
	});

	// With options:
	$.clipboardReady(function(){
		$( "a" ).click(function(){
			$.clipboard( "You clicked on a link and copied this text!" );
			return false;
		});
	}, { swfpath: "path/to/jquery.clipboard.swf", debug: true } );

Compatibility:

	IE 6+, FF 2+, Safari 2+, Opera 9+
	Requires jQuery 1.2+
	Non-IE browsers require Flash 8 or higher.


Released under an MIT-style license

LICENSE
------------------------------------------------------------------------

Copyright (c) 2007 Bradley Sepos

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

------------------------------------------------------------------------

*/

(function($){

// Some variables that need scope
var flashMinVersion = [8,0,0];
var flashDetectedVersion = [0,0,0];
var swfpath;
var debugging;

var flashdetect = function( minVersion ){
	// Flash detection
	// Based on swfObject 2.0: http://code.google.com/p/swfobject/
	var d = null;
	if (typeof navigator.plugins != "undefined" && typeof navigator.plugins["Shockwave Flash"] == "object") {
		d = navigator.plugins["Shockwave Flash"].description;
		if (d) {
			// Got Flash, parse version
			d = d.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
			flashDetectedVersion[0] = parseInt(d.replace(/^(.*)\..*$/, "$1"), 10);
			flashDetectedVersion[1] = parseInt(d.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
			if ( /r/.test(d) ) {
				flashDetectedVersion[2] = parseInt(d.replace(/^.*r(.*)$/, "$1"), 10);
			} else {
				flashDetectedVersion[2] = 0;
			}
			if (flashDetectedVersion[0] > minVersion[0] || (flashDetectedVersion[0] == minVersion[0] && flashDetectedVersion[1] > minVersion[1]) || (flashDetectedVersion[0] == minVersion[0] && flashDetectedVersion[1] == minVersion[1] && flashDetectedVersion[2] >= minVersion[2])){
				// Version ok
				return true;
			} else {
				// Version too old
				return false;
			}
		}
	}
	// No Flash detected
	return false;
};

var iecopydetect = function(){
	// Check for IE method
	if ( typeof window.clipboardData != "undefined" ){
		return true;
	}
};

var debug = function( string ){
	if ( debugging && typeof console != "undefined" && typeof console.log == "function" ){
		console.log( string );
	}
};

var swfready = function(){
	
	// The swf is already loaded, ignore
	if ( $.clipboardReady.done ) {
		return false;
	}
	
	// Count how many times swfready() has been called
	if ( typeof $.clipboardReady.counter == 'undefined' ){
		// Init counter
		$.clipboardReady.counter = 0;
	}
	// Increment counter
	$.clipboardReady.counter++;
	if ( $.clipboardReady.counter > 599 ){
		// Terminate process after 600 executions to avoid calling indefinitely and crashing some 
		// browsers (observed in Firefox 2.x). At 100ms interval, this should be plenty of time for 
		// the swf to load on even the slowest connections.
		clearInterval( $.clipboardReady.timer );
		// Debug
		debug("Waited "+$.clipboardReady.counter/10+" seconds for Flash object to load, terminating.");
		return false;
	}
	if ( ($.clipboardReady.counter % 100) == 0 ){
		// Debug
		debug("Waited "+$.clipboardReady.counter/10+" seconds for Flash object to load so far...");
	}
	
	// Check to see if the swf's external interface is ready
	var swf = $("#jquery_clipboard_swf:first");
	var swfdom = $(swf).get(0);
	if ( typeof swfdom.jqueryClipboardCopy == "function" && swfdom.jqueryClipboardAvailable ){
		
		// Swf is ready, stop checking
		clearInterval( $.clipboardReady.timer );
		$.clipboardReady.timer = null;
		
		// Set copy method
		$.clipboard.method = 'flash';
		
		// Execute queued functions
		for ( var i = 0; i < $.clipboardReady.ready.length; i++ ){
			$.clipboardReady.ready[i]();
		}
		
		// Remember that the swf is ready
		$.clipboardReady.ready = null;
		$.clipboardReady.done = true;
		
		// Everything is totally ready now
		debug( "jQuery.clipboard: OK. Initialized and ready to copy using Flash method." );
	}
};

$.clipboardReady = function( f, options ){
	
	// Options
	options = jQuery.extend({
		swfpath: "jquery.clipboard.swf",
		debug: false
	}, options);
	swfpath = options.swfpath;
	debugging = options.debug;
	
	// Run immediately if IE method available
	if ( iecopydetect() ){
		$.clipboard.method = 'ie';
		debug( "jQuery.clipboard: OK. Initialized and ready to copy using native IE method." );
		return f();
	}
	
	// Run immediately if Flash 8 is available and loaded
	if ( $.clipboardReady.done ){
		return f();
	}
	
	// If we've already added a function
	if ( $.clipboardReady.timer ){
		
		// Add to the existing array
		$.clipboardReady.ready.push( f );
		
	} else {
		
		// Check for Flash and Flash version
		if ( flashdetect( flashMinVersion ) ){
			
			// Flash detected OK
			
			// Destroy any existing elements
			$( "#jquery_clipboard_swf" ).remove();
			$( "#jquery_clipboard_div" ).remove();
			
			// Create the wrapper div
			var div;
			div = $( "<div/>" )
				.attr( "id", "jquery_clipboard_div" )
				.css( "width", "0" )
				.css( "height", "0" )
				.appendTo( "body" )
				.html( "" );
			// Create the helper swf
			// Use embed method since we're only targeting non-IE browsers anyway
			var swf;
			swf = $( '<embed id="jquery_clipboard_swf" name="jquery_clipboard_swf" src="'+swfpath+'" type="application/x-shockwave-flash"></embed>' );
			$( swf )
				.css( "width", "0" )
				.css( "height", "0" )
				.appendTo( div );
			
			// Init the functions array
			$.clipboardReady.ready = [ f ];
			
			// Continually check to see if the swf is loaded
			$.clipboardReady.timer = setInterval( swfready, 100 );
			
			// Debug
			debug( "jQuery.clipboard: INFO. Waiting for Flash object to become ready. Detected Flash version: "+flashDetectedVersion[0]+"."+flashDetectedVersion[1]+"."+flashDetectedVersion[2] );
			
		} else if ( flashDetectedVersion[0] === 0 ){
			
			// Flash not detected
			debug( "jQuery.clipboard: ERROR. Flash plugin not detected." );
			return false;
			
		} else {
			
			// Flash version too old
			debug( "jQuery.clipboard: ERROR. Minimum Flash version: "+flashMinVersion[0]+"."+flashMinVersion[1]+"."+flashMinVersion[2]+" Detected Flash version: "+flashDetectedVersion[0]+"."+flashDetectedVersion[1]+"."+flashDetectedVersion[2] );
			return false;
			
		}
	}
};

$.clipboard = function( text ){
	
	// Check arguments
	if ( arguments.length < 1 || typeof text != "string" ){
		// First argument is not text
		debug( "jQuery.clipboard: ERROR. Nothing to copy. You must specify a string as the first parameter." );
		return false;
	}
	
	// Looks good, perform copy
	
	// Internet Explorer's built-in method
	if ( $.clipboard.method == 'ie' ){
		try {
			window.clipboardData.setData( "Text", text );
			debug( "jQuery.clipboard: OK. Copied "+text.length+" bytes to clipboard using native IE method." );
			return true;
		} catch (e) {
			debug( "jQuery.clipboard: ERROR. Tried to copy using native IE method but an unknown error occurred." );
			return false;
		}
	}
	
	// Flash method
	if ( $.clipboard.method == 'flash'){
		var swf = $("#jquery_clipboard_swf:first");
		var swfdom = $(swf).get(0);
		if ( swfdom.jqueryClipboardCopy( text ) ){
			// Copy succeeded
			debug( "jQuery.clipboard: OK. Copied "+text.length+" bytes to clipboard using Flash method." );
			return true;
		} else {
			// Copy failed
			debug( "jQuery.clipboard: ERROR. Tried to copy using Flash method but an unknown error occurred." );
			return false;
		}
	}
	
	// Uh-oh. Somebody called $.clipboard() without $.clipboardReady()
	debug( "jQuery.clipboard: ERROR. You must use $.clipboardReady() in conjunction with $.clipboard()." );
	return false;
	
};

})(jQuery); /* jQuery.clipboard */
