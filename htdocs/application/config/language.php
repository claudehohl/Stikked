<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Language
 *
 * Which language to use
 * Translate Stikked to your own language, see htdocs/application/language files
 * Currently: english, german, swissgerman, spanish, norwegian, danish, portuguese, turkish, french, japanese, polish, russian, chinese-simplified, chinese-traditional, indonesia
 *
*/

$config['supported_languages'] = array(
    'en' => array(
        'name'        => 'English',
        'folder'      => 'english',
        'direction'   => 'ltr',
        'codes'       => array('en', 'english', 'en-US'),
        'ckeditor'    => NULL
    ),
    'de' => array(
        'name'        => 'Deutsch',
        'folder'      => 'german',
        'direction'   => 'ltr',
        'codes'       => array('de', 'german', 'de'),
        'ckeditor'    => NULL
    ),
    'sw' => array(
        'name'        => 'Schweizerdeutsch',
        'folder'      => 'swissgerman',
        'direction'   => 'ltr',
        'codes'       => array('sw', 'swissgerman', 'de-CH'),
        'ckeditor'    => NULL
    ),
    'es' => array(
        'name'        => 'Espa&ntilde;ol',
        'folder'      => 'spanish',
        'direction'   => 'ltr',
        'codes'       => array('esp', 'spanish', 'es-ES'),
        'ckeditor'    => NULL
    ),
    'no' => array(
        'name'	      => 'norsk',
        'folder'      => 'norwegian',
        'direction'   => 'ltr',
        'codes'	      => array('no', 'norwegian', 'no-NO'),
        'ckeditor'    => NULL
    ),
	'da' => array(
        'name'	      => 'dansk',
        'folder'      => 'danish',
        'direction'   => 'ltr',
        'codes'	      => array('da', 'danish', 'da-DA'),
        'ckeditor'    => NULL
    ),
    'pt' => array(
        'name'        => 'Portugu&ecirc;s de Portugal',
        'folder'      => 'portuguese',
        'direction'   => 'ltr',
        'codes'       => array('ptb', 'portuguese-portugal', 'pt-PT'),
        'ckeditor'    => 'pt-pt'
    ),
    'tr' => array(
        'name'        => 'Türkçe',
        'folder'      => 'turkish',
        'direction'   => 'ltr',
        'codes'       => array('tr', 'turkish', 'tr-TR'),
        'ckeditor'    => NULL
    ),
    'fr' => array(
        'name'        => 'Français',
        'folder'      => 'french',
        'direction'   => 'ltr',
        'codes'       => array('fra', 'french', 'fr-FR'),
        'ckeditor'    => NULL
    ),
    'jp' => array(
        'name'        => '日本語',
        'folder'      => 'japanese',
        'direction'   => 'ltr',
        'codes'       => array('jp', 'japanese', 'jp-JP'),
        'ckeditor'    => NULL
    ),
    'pl' => array(
        'name'        => 'Polski',
        'folder'      => 'polish',
        'direction'   => 'ltr',
        'codes'       => array('plk', 'polish', 'pl-PL'),
        'ckeditor'    => NULL
    ),
    'ru' => array(
        'name'        => 'Русский',
        'folder'      => 'russian',
        'direction'   => 'ltr',
        'codes'       => array('rus', 'russian', 'ru-RU'),
        'ckeditor'    => NULL
    ),
    'cn' => array(
        'name'        => '繁體中文',
        'folder'      => 'chinese-simplified',
        'direction'   => 'ltr',
        'codes'       => array('cht', 'chinese-simplified', 'zh-CN'),
        'ckeditor'    => NULL
    ),
    'zh' => array(
        'name'        => '繁體中文',
        'folder'      => 'chinese-traditional',
        'direction'   => 'ltr',
        'codes'       => array('cht', 'chinese-traditional', 'zh-TW'),
        'ckeditor'    => NULL
    ),
    'lt' => array(
        'name' => 'Lietuvių',
        'folder' => 'lithuanian',
        'direction' => 'ltr',
        'codes' => array('lt', 'lithuanian', 'lt-LT'),
        'ckeditor'    => NULL
    ),
    'id' => array(
        'name'        => 'Indonesia',
        'folder'      => 'indonesia',
        'direction'   => 'ltr',
        'codes'       => array('id', 'indonesia', 'id-ID'),
        'ckeditor'    => NULL
    ),
);

/*
 * Default Language
 *
 * If no language is specified, which one to use?
 * Currently: english (en) | german (de)    | swissgerman (sw) 
 *            spanish (es) | norwegian (no) | portuguese (pt) 
 *            turkish (tr) | french (fr)    | japanese (jp) 
 *            polish (pl)  | russian (ru)   | bahasa indonesia (id)
 *            chinese-simplified (cn) |  chinese-traditional (zh) | lithuanian (lt)
 *				
*/
$config['language'] = 'en';

