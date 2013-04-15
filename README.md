Stikked is an Open-Source PHP Pastebin, with the aim of keeping a simple and easy to use user interface.

Stikked allows you to easily share code with anyone you wish. Stikked was created for the following reasons:

* IRC and Private Chats were spammed.
* Pastebins were ugly.
* Pastebins were confusing.
* Pastebins were messy and not thought through.
* Stikked rethought code collaboration, by making it easy to paste code.

Based on the original Stikked (http://code.google.com/p/stikked/) with lots of bugfixes and improvements.

Thanks to Rebecca Chapnik for this great review: http://maketecheasier.com/run-your-own-pastebin-with-stikked/2013/01/11


Try it out
----------
http://paste.scratchbook.ch/


Installation
------------

1.  Download stikked from https://github.com/claudehohl/Stikked/tags
2.  Create a user and database for Stikked
3.  Edit configuration settings in application/config/stikked.php - everything is described there
4.  You're done!

* The database structure will be created automatically if it doesn't exist.
* No special file permissions are needed by default. Optional: If you want to have the JavaScript- and CSS-files minified, the static/asset/ folder has to be writable.
* To ensure that pastes with an expiration set get cleaned up, define the cron key in the config and set up a cronjob, for example:
  * */5 * * * * curl --silent http://yoursite.com/cron/[key]


Changelog
---------

### Version 0.8.5:

* Themes! Configure a different theme in config/stikked.php - or create your own
* Multilanguage support. Configure a different language in config/stikked.php
* Diff view for paste replies! View differences between the original paste and its reply
* Possibility to set default expiration time
* Lots of minor fixes and improvements

#### Upgrade instructions

The following lines must be present config/stikked.php

```php
$config['theme'] = 'default';
```

You can choose between default, bootstrap, gabdark and gabdark3.

Create you own theme. See doc/CREATING_THEMES.md

```php
$config['language'] = 'english';
```

You can choose between english, german and swissgerman ;)

Help translating Stikked into your language! See doc/TRANSLATING_STIKKED.md

### Version 0.8.4:

* Trending pastes: http://paste.scratchbook.ch/trends
* LDAP authentication (thanks to Daniel, https://github.com/lightswitch05)
* Blocked words; maintain a comma separated list in your config, e.g. '.es.tl, mycraft.com, yourbadword' - pastes with this words will never get pasted
* Spam trap for bots
* Bugfix: Remove\_invisible\_characters removing legitimate paste content (https://github.com/claudehohl/Stikked/issues/28)
* Possibility to manually set the paste's displayed URL (used with mod\_rewrite configurations)
* Print layout for pastes
* Updated to CodeIgniter version 2.1.3

### Version 0.8.3:

* From now on, IPs get logged in the DB
* Added spamadmin:
  * Enter credentials in config/stikked.php
  * Visit /spamadmin, login
  * Click on an IP to list all pastes belonging to it
  * You can remove all the pastes listed, and optionally block the IP range
* Updated to CodeIgniter version 2.1.2

### Version 0.8.2:

* Database optimizations: Pastes use less space (if you upgrade from a previous version, execute this SQL statement: "ALTER TABLE pastes DROP paste;"
* Anti spam features:
  * Option to disable recent pastes
  * Option to require the user to enter a captcha

### Version 0.8.1:

* Cleaner options
* Valid RSS feed
* Simpler API response (non-JSON)
* Favicon
* gw.gd URL shortener (replaces bit.ly)
* Minor fixes

### Version 0.8:

* Added backup function (yoursite.com/backup; set credentials in stikked.php config)
* Added pagination to the replies table
* Added RSS-Feeds to recent pastes and paste replies
* Embeddable pastes
* GeSHi updated to version 1.0.8.10
* Codemirror turned off by default
* Codemirror: Syntax changes dynamically with selection in language dropdown

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

