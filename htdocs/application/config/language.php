<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Language
 *
 * Which language to use
 * Translate Stikked to your own language, see htdocs/application/language files
 * Currently: english, german, swissgerman, spanish, norwegian, portuguese, turkish, french, japanese, polish, russian, chinese-simplified, chinese-traditional
 *
*/

$config['supported_languages'] = array(
    'en' => array(
        'name'        => 'English',
        'folder'      => 'english',
        'direction'   => 'ltr',
        'codes'       => array('en', 'english', 'en_US'),
        'ckeditor'    => NULL
    ),
    'de' => array(
        'name'        => 'Deutsch',
        'folder'      => 'german',
        'direction'   => 'ltr',
        'codes'       => array('de', 'german', 'de_DE'),
        'ckeditor'    => NULL
    ),
    'sw' => array(
        'name'        => 'Schweizerdeutsch',
        'folder'      => 'swissgerman',
        'direction'   => 'ltr',
        'codes'       => array('sw', 'swissgerman', 'sw_SW'),
        'ckeditor'    => NULL
    ),
    'es' => array(
        'name'        => 'Espa&ntilde;ol',
        'folder'      => 'spanish',
        'direction'   => 'ltr',
        'codes'       => array('esp', 'spanish', 'es_ES'),
        'ckeditor'    => NULL
    ),
    'no' => array(
        'name'	      => 'norsk',
        'folder'      => 'norwegian',
        'direction'   => 'ltr',
        'codes'	      => array('no', 'norwegian', 'no_NO'),
        'ckeditor'    => NULL
    ),
    'pt' => array(
        'name'        => 'Portugu&ecirc;s de Portugal',
        'folder'      => 'portuguese',
        'direction'   => 'ltr',
        'codes'       => array('ptb', 'portuguese-portugal', 'pt_PT'),
        'ckeditor'    => 'pt-pt'
    ),
    'tr' => array(
        'name'        => 'Türkçe',
        'folder'      => 'turkish',
        'direction'   => 'ltr',
        'codes'       => array('tr', 'turkish', 'tr_TR'),
        'ckeditor'    => NULL
    ),
    'fr' => array(
        'name'        => 'Français',
        'folder'      => 'french',
        'direction'   => 'ltr',
        'codes'       => array('fra', 'french', 'fr_FR'),
        'ckeditor'    => NULL
    ),
    'jp' => array(
        'name'        => '日本語',
        'folder'      => 'japanese',
        'direction'   => 'ltr',
        'codes'       => array('jp', 'japanese', 'jp_JP'),
        'ckeditor'    => NULL
    ),
    'pl' => array(
        'name'        => 'Polski',
        'folder'      => 'polish',
        'direction'   => 'ltr',
        'codes'       => array('plk', 'polish', 'pl_PL'),
        'ckeditor'    => NULL
    ),
    'ru' => array(
        'name'        => 'Русский',
        'folder'      => 'russian',
        'direction'   => 'ltr',
        'codes'       => array('rus', 'russian', 'ru_RU'),
        'ckeditor'    => NULL
    ),
    'cn' => array(
        'name'        => '繁體中文',
        'folder'      => 'chinese-simplified',
        'direction'   => 'ltr',
        'codes'       => array('cht', 'chinese-simplified', 'zh_CN'),
        'ckeditor'    => NULL
    ),
    'zh' => array(
        'name'        => '繁體中文',
        'folder'      => 'chinese-traditional',
        'direction'   => 'ltr',
        'codes'       => array('cht', 'chinese-traditional', 'zh_TW'),
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
 *            polish (pl)  | russian (ru) 
 *            chinese-simplified (cn) |  chinese-traditional (zh)
 *
*/
$config['default_language'] = 'en';

