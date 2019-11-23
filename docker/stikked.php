<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Site Name
 *
 * The name of your site
 *
*/
$config['site_name'] = 'Stikked';

/**
 * Base URL
 *
 * Set the base URL of Stikked. WITH trailing slash!
 *
*/
$config['base_url'] = 'http://localhost/';

/**
 * Database connection
 *
 * Credentials for your database
 * The database structure will be created automatically
 *
*/
$config['db_hostname'] = 'mysql';
$config['db_database'] = 'stikked';
$config['db_username'] = 'stikked';
$config['db_password'] = 'stikked';

// If you are using sqlite:
// uncomment the configuration lines below.
//$config['db_database'] = 'db/stikked'; // you need to create a directory "db" and give the webserver write access. sqlite needs a writable folder to work properly!
//$config['db_driver'] = 'sqlite';

/**
 * Table prefix
 * Generate table prefix for stikked db, commonly used if the webhoster only has one db.
 * Use underscore as suffix to easily see the tables.
 * example: $config['db_prefix'] = 'stikked_';
 * use $config['db_prefix'] = ''; if you don't want to use table prefix.
*/
$config['db_prefix'] = '';

/**
 * Theme
 *
 * Which theme to use
 * Folder name in htdocs/themes/
 * Currently: default, bootstrap, gabdark, gabdark3, geocities, snowkat, stikkedizr, cleanwhite, i386
 *
*/
$config['theme'] = 'default';

/**
 * Display QR code
 *
 * Whether or not to display the QR code
 *
*/
$config['qr_enabled'] = true;

/**
 * JavaScript-Editor
 *
 * Which editor to use
 * CodeMirror, ACE or none
 *
 * none:        ~130kb JS
 * CodeMirror:  ~300kb JS
 * ACE:         >800kb JS
 *
*/
$config['js_editor'] = ''; // codemirror, ace, ''

/**
 * Language
 *
 * Which language to use
 * Translate Stikked to your own language, see htdocs/application/language files
 * Currently: english, german, swissgerman, spanish, norwegian, danish, portuguese, turkish, french, japanese, polish, russian, chinese-simplified, chinese-traditional, indonesia
 *
*/
$config['language'] = 'english';

/**
 * Combine JS & CSS files (recommended)
 *
 * htdocs/static/asset/ folder must be writeable
 *
*/
$config['combine_assets'] = false;

/**
 * Content expiration
 *
 * Sets the "Expires:"-header to make use of browser-caching
 * Format: http://php.net/manual/en/function.strtotime.php
 * Examples: '+10 seconds', '+1 year', '-1 week'
 *
*/
$config['content_expiration'] = '-1 week';

/**
 * Key for Cron
 *
 * The password required to run the cron job */
// Example cron: */5 * * * * curl --silent http://yoursite.com/cron/[key]
//
//
$config['cron_key'] = '';

/**
 * url shortener config
 *
 * url_shortening_use:
 *    - Enables specific url shortening engine or disables them all
 *    - Valid values:
 *           @string yourls
 *           @string gwgd
 *           @string googl
 *           @string bitly
 *           @string polr
 *           @string random - Randomly chose any of upper API-s !WARNING! May be slow! For maximum performanse, it's recommended to either set all API keys or use random_url_engines to list working engines.
 *           @string none - same as off
 *
 * random_url_engines:
 *    - This variable sets list of APIs to be considered for usage if url_shortening_use is set to 'random'
 *      To consider all API-s, either leave it empty (as empty array or string) or type all apis available (yourls,gwgd,googl,bitly)
 *      be aware that considering all the APIs is not recommended because program will test them all, and that affects speed.
 *      This will greatly improve performance of 'random' mode if listed are only valid, filled APIs.
 *      Accepted inputs:
 *           @array array('use this', 'and this', 'and this of course')
 *           @string 'use this,and this,and this of course'
 *      - If input is @string it must be comma delimited, otherwise will be ignored.
 *      - Script will accept minimum of 2 APIs, ignored otherwise
 *      - Only alphanumeric characters and "." are allowed. Everything else is filtered out.
 *
 * -------------------------------------------------------------------------------------------------------------
 * yourls_url: Your own instance of yourls URL-shortener (Download: http://yourls.org/)
 * Example: http://example.com/yourls/
 *
 * yourls_signature: Your signature, used to authenticate API requests.
 * You can find your signature under http://your-yourls-installation.com/admin/tools.php
 *
 * gwgd_url: Your own instance of the gw.gd URL-shortener (Download: https://github.com/neofutur/gwgd)
 * Default: http://gw.gd/
 *
 * googl_url_api: URL shortening service provided by Google Inc. (API: http://code.google.com/apis/console/)
 * Usage: Your API key
 *
 * bitly_url_api: Famous URL shortening service (API: http://dev.bitly.com/get_started.html)
 * Usage: Your API key
 *
 * polr_url: Your own instance of polr URL-shortener (Download: https://github.com/cydrobolt/polr)
 * polr_api: Your polr api key
 *
**/
$config['url_shortening_use'] = 'off';
$config['random_url_engines'] = 'googl,bitly'; // Used only in random mode, read comment above for more info


// Yourls
$config['yourls_url'] = '';
$config['yourls_signature'] = '';

// gwgd_url
$config['gwgd_url'] = '';
$config['shorturl_selected'] = false;

// goo.gl API key
$config['googl_url_api'] = '';

// Bit.ly API key
$config['bitly_url_api'] = '';

// polr
$config['polr_url'] = '';
$config['polr_api'] = '';


/**
 * Credentials for the backup URL
 *
 * Basic auth user & pass for the backup URL, accessible via http://yoursite.com/backup
 *
**/
$config['backup_user'] = '';
$config['backup_pass'] = '';

/**
 * Pastes Per Page
 *
 * Number of pastes per page, on the recent pastes listings.
 *
**/
$config['per_page'] = 15;

/**
 * API key
 *
 * Require a key to interact with the API.
 * Append to all API requests: ?apikey=[yourkey]
 *
**/
$config['apikey'] = '';

/**
 * Soft API
 *
 * When set to true, allow interaction:
 *   without apikey: badword-check applies
 *   with apikey: badwords are ignored
 *
 * This is useful to maintain a restrictive blocklist
 * for spammers and bypass it using the apikey.
 *
**/
$config['soft_api'] = false;

/**
 * Anti spam
 *
 * private_only: No recent pastes will be displayed.
 * enable_captcha: Users must enter a captcha to post.
 * recaptcha_publickey & recaptcha_privatekey: If filled, reCaptcha will be used (get a key from https://www.google.com/recaptcha/admin/create)
 * disable_api: Don't allow pasting via API (because we can't use a captcha there...)
 * disable_keep_forever: Don't allow pasting without expiration
 * blocked_words: Comma separated list, e.g. '.es.tl, mycraft.com, yourbadword'
 * disable_shorturl: "Create Shorturl" option will be disabled
 * disallow_search_engines: displays a robots.txt that forbids indexing
 *
**/
$config['private_only'] = false;
$config['enable_captcha'] = true;
$config['recaptcha_publickey'] = '';
$config['recaptcha_privatekey'] = '';
$config['disable_api'] = false;
$config['disable_keep_forever'] = false;
$config['blocked_words'] = '';
$config['disable_shorturl'] = false;
$config['disallow_search_engines'] = false;

//spamadmin: accessible via /spamadmin (only active when user + pass is set)
$config['spamadmin_user'] = '';
$config['spamadmin_pass'] = '';

/**
 * Default paste expiration time (minutes)
 *
 * Possible values:
 *  burn (burn on reading)
 *  5 (5 minutes)
 *  60 (1 hour)
 *  1440 (1 day)
 *  10080 (1 week)
 *  40320 (1 month)
 *  483840 (1 year)
 *  0 (keep forever)
**/
$config['default_expiration'] = 0;

/**
 * Default language
 *
 * Preselected language. See application/config/geshi_languages.php for valid values (array keys)
 *
**/
$config['default_language'] = 'text';

/**
 * Name for anonymous poster
 *
 * What name is to be set for anonymous posters
 * DO NOT SET BLANK
 * Set to random for a random paste to be generated
 * NOTE: if changed only pastes from then on will be updated.
 *
**/
$config['unknown_poster'] = 'random';

/**
 * Name for untitled pastes
 *
 * What name is to be set for untitled pastes.
 * DO NOT SET BLANK
 * NOTE: if changed only pastes from then on will be updated.
**/
$config['unknown_title'] = 'Untitled';

/**
 * To require LDAP authentication or not.
 *
 * Weather to require LDAP authenticaiton or not.
 * Set to either 'true' to require authentication or 'false' not to.
 * NOTE: if changed, set LDAP settings in auth_ldap.php
**/
$config['require_auth'] = false;

/**
 * Override the displayed URL
 *
 * Display this URL in a paste's detail view instead of the main URL - e.g. if you use mod_rewrite
 * Variable $id: the paste_id
 * Example: 'http://example.com/$id'
 *
**/
$config['displayurl_override'] = '';

/**
 *
 *
 *  Words used for when unknown_poster is set to random
 *
 *
**/
$config['nouns'] = array('Hornbill', 'Elephant', 'Bison', 'Lion', 'Camel', 'Sheep',
'Monkey', 'Prairie Dog', 'Plover', 'Tapir', 'Capybara', 'Cheetah', 'Flamingo', 'Peccary', 'Eider',	'Porcupine', 'Pelican', 'Dove', 'Crane', 'Tortoise', 'Agouti',
'Tamarin', 'Pheasant', 'Owl', 'Gibbon', 'Goose', 'Baboon', 'Hamerkop', 'Zebra',
'Macaw', 'Gibbon', 'Madrill', 'Wolf', 'Stork', 'Armadillo', 'Ostrich', 'Marmoset',
'Lizard', 'Panda', 'Giraffe', 'Cassowary', 'Kangaroo', 'Gorilla', 'Pheasant',
'Finch', 'Duck', 'Matamata', 'Teal', 'Macaque', 'Goat', 'Lechwe', 'Ibis', 'Parrot',
'Parakeet', 'Bongo', 'Pudu', 'Echidna', 'Lemur', 'Bat', 'Curlew', 'Terrapin',
'Peafowl', 'Duck', 'Owl', 'Parakeet', 'Meerkat', 'Tern', 'Wigeon', 'Pintail',
'Meerkat', 'Motmot', 'Motmot', 'Shama', 'Dormouse', 'Horse', 'Rhinoceros', 'Sloth',
 'Mousedeer', 'Treeshrew', 'Bushbaby', 'Guinea Pig', 'Agouti', 'Water Vole', 'Hog',
'Pig', 'Anoa', 'Octupus', 'Butterfly', 'Cat', 'Kitten', 'Coyote', 'Crocodile',
'Cockroach', 'Crow', 'Bird', 'Dolphin', 'Earthworm', 'Frog', 'Hamster', 'Hedgehog',
'Hog', 'Human', 'Hummingbird', 'Iguana', 'Leech', 'Leopard', ' Marten',
'Mockingbird', 'Mockingjay', 'Mosquito', 'Moth', 'Partdridge', 'Bee', 'Penguin');

$config['adjectives'] = array('Ample', 'Mature', 'Bulky', 'Burly', 'Capacious',
'Colossal', 'Commodious', 'Thundering', 'Mammoth', 'Mungo', 'Voluminous',
'Walloping', 'Tiny', 'Baby', 'Bitty', 'Diminutive', 'Little', 'Paltry', 'Scanty',
'Trivial', 'Scribby', 'Blush', 'Tinct', 'Colorant', 'Aqua', 'Beige', 'Bistre',
'Buff', 'Bistre', 'Chartreuse', 'Chocolate', 'Cobalt', 'Coral', 'Cream', 'Crimson',
'Denim', 'Emerald', 'Gray', 'Gamboge', 'Ivory', 'Mustard', 'Silly', 'Perl',
'Whipped', 'Violet', 'Harmless', 'Gentle', 'Innocent', 'Reliable', 'Unreliable',
'Soft', 'Toxic', 'Anorexic', 'Beefy', 'Sexy', 'Morose', 'Rude', 'Ungracious',
'Abrupt', 'Gracious', 'Queen', 'Cute', 'Edgy', 'Insensitive', 'Round', 'Sharp',
'Gruff', 'Subtle', 'Crippled', 'Eratic', 'Social', 'Jittery', 'Sole', 'Unique',
'Botched', 'Tacky', 'Sludgy', 'Stained', 'Wet', 'Soiled', 'Big', 'Small', 'Sloppy',
'Smelly', 'Funky', 'Putrid', 'Melodic', 'Corrupt', 'Lousy', 'Fiery', 'Red',
'Sweet', 'Hot', 'Scorching', 'Sweltering', 'Torrid', 'Obese', 'Speedy', 'Flying',
'Idiotic', 'Chunky', 'Forensic');

/**
 *
 *
 *  Words used for expiring pastes
 *
 *
**/
$config['expires'] = array('expire', 'perish', 'go to its last resting place',
'go to meet its maker', 'cross the great divide', 'slip away', 'give up the ghost',
'kick the bucket', 'croak', 'bite the big one', 'check out', 'buy the farm',
'join the choir invisible', 'shuffle off the mortal coil', 'hop the perch',
'run down the curtain', 'die', 'self destruct', 'explode');
