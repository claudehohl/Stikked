Stikked is an Open-Source PHP Pastebin, with the aim of keeping a simple and easy to use user interface.

Stikked allows you to easily share code with anyone you wish. Stikked was created for the following reasons:

* IRC and Private Chats were spammed.
* Pastebins were ugly.
* Pastebins were confusing.
* Pastebins were messy and not thought through.
* Stikked rethought code collaboration, by making it easy to paste code.

I copied the original Stikked (http://code.google.com/p/stikked/) and fixed several bugs.
Try it out: http://paste.scratchbook.ch/


Installation
------------

1.  Download stikked from https://github.com/claudehohl/Stikked/downloads
2.  Create a user and database for Stikked
3.  Edit configuration settings in application/config/stikked.php (view on Github: https://github.com/claudehohl/Stikked/blob/master/htdocs/application/config/stikked.php)


Changelog
---------

### Version 0.8:

* Added pagination to the replies table
* GeSHi updated to version 1.0.8.10 (TODO: list missing languages)
* Codemirror turned off by default
* Codemirror: Syntax changes dynamically with selection in language dropdown
* Backup function

### Version 0.7:

* An API (see http://paste.scratchbook.ch/api)
* Integration of Codemirror (http://codemirror.net)

### Version 0.6:

* The language-selection was broken; the dropdown now features all the languages that GeSHi supports
* Updated to CodeIgniter version 2.1.0
* Creation of bit.ly-URLs (instead of snipurl)
* Fixed download link
* Paste downloads as a .txt file
* No need to have PHP short tags enabled
* Automatic creation of all necessary MySQL tables
* Raw-mode is now like the raw-mode on pastebin.com
* Minification and concatenation of CSS and JavaScript files (can be turned on/off)
* Breached the license by removing the nasty copyright footer

### Version 0.5:

* Paste Replies
* Fluid width pastes
* Auto copying paste url to clipboard.
* Paste expiration.
* Fully standards compliant css and xhtml.
* Random generating names for anonymous users
* Paste downloading

