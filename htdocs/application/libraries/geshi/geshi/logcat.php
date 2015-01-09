<?php
/*************************************************************************************
 * logcat.php
 * --------
 * Author: Konstantin Koslowski (konstantin.koslowski@gmail.com)
 * Copyright: none
 *
 * logcat highlighting for GeSHi.
 *
 *
 ************************************************************************************/

$language_data = array (
    'LANG_NAME' => 'logcat',
    'COMMENT_SINGLE' => array(),
    'COMMENT_MULTI' => array(),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array(),
    'ESCAPE_CHAR' => '/',
    'KEYWORDS' => array(
        ),
    'SYMBOLS' => array(
        ),
    'CASE_SENSITIVE' => array(
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            ),
        'COMMENTS' => array(
            ),
        'ESCAPE_CHAR' => array(
            ),
        'BRACKETS' => array(
            ),
        'STRINGS' => array(
            ),
        'NUMBERS' => array(
            ),
        'METHODS' => array(
            ),
        'SYMBOLS' => array(
            ),
        'SCRIPT' => array(
            ),
        'REGEXPS' => array(
            0 => 'color: #408080;',
            1 => 'color: #0000ff;',
            2 => 'color: #008000;',
            3 => 'color: #ff8000;',
            4 => 'color: #ff0000;',
            )
        ),
    'URLS' => array(
        ),
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => array(
        ),
    'REGEXPS' => array(
        0 => array( // VERBOSE
            //GESHI_SEARCH => '^V\/[A-Za-z-_]*',
            GESHI_SEARCH => '^V\/[A-Za-z-_]*(.)*$',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
            ),
        1 => array( // DEBUG
            //GESHI_SEARCH => '^D\/[A-Za-z-_]*',
            GESHI_SEARCH => '^D\/[A-Za-z-_]*(.)*$',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
            ),
        2 => array( // INFO
            //GESHI_SEARCH => '^I\/[A-Za-z-_]*',
            GESHI_SEARCH => '^I\/[A-Za-z-_]*(.)*$',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
            ),
        3 => array( // WARN
            //GESHI_SEARCH => '^W\/[A-Za-z-_]*',
            GESHI_SEARCH => '^W\/[A-Za-z-_]*(.)*$',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
            ),
        4 => array( // ERROR
            //GESHI_SEARCH => '^E\/[A-Za-z-_]*',
            GESHI_SEARCH => '^E\/[A-Za-z-_]*(.)*$',
            GESHI_MODIFIERS => 'm',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
            ),
        ),
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => array(
        ),
    'HIGHLIGHT_STRICT_BLOCK' => array(
        )
);

?>
