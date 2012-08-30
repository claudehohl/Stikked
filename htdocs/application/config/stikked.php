<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Site Name
 * 
 * The name of your site
 *
*/
$config['site_name'] = 'Stikked';

/**
 * Database connection
 * 
 * Credentials for your database
 * The database structure will be created automatically
 *
*/
$config['db_hostname'] = '127.0.0.1';
$config['db_database'] = 'stikked';
$config['db_username'] = 'stikked';
$config['db_password'] = 'stikked';

/**
 * Combine JS & CSS files
 * 
 * htdocs/static/asset/ folder must be writeable
 *
*/
$config['combine_assets'] = false;

/**
 * Key for Cron
 *
 * The password required to run the cron job
 * Example cron: 00, 30 * * * * curl --silent --compressed http://yoursite.com/cron/key &> /dev/null
 *
**/
$config['cron_key'] = '';

/**
 * gw.gd config
 *
 * Your own instance of the gw.gd URL-shortener (Download: https://github.com/neofutur/gwgd)
 * Default: http://gw.gd/
 *
**/
$config['gwgd_url'] = '';

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
$config['per_page'] = 10;

/**
 * Anti spam
 *
 * private_only: No recent pastes will be displayed.
 * enable_captcha: Users must enter a captcha to post.
 *
**/
$config['private_only'] = false;
$config['enable_captcha'] = false;
//spamadmin: accessible via /spamadmin (only active when user + pass is set)
$config['spamadmin_user'] = 'a';
$config['spamadmin_pass'] = 'a';

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
'Mockingbird', 'Mosquito', 'Moth', 'Partdridge', 'Bee', 'Penguin');

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
'Idiotic', 'Chunky');
