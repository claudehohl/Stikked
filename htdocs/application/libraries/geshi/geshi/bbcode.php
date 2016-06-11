<?php
/*************************************************************************************
 * bbcode.php
 * -------
 * Author: Christian Froehlich (zwiixx@googlemail.com)
 * Copyright: (c) 2016 Christian Froehlich
 * Release Version: 1.0.0.0
 * Date Started: 2016/06/11
 *
 * BBCode language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2016/06/11 (1.0.0)
 *   -  First Release
 *
 *************************************************************************************
 *
 *     This file is part of GeSHi.
 *
 *   GeSHi is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   GeSHi is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with GeSHi; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ************************************************************************************/

$language_data = array (
    'LANG_NAME' => 'bbcode',
    'COMMENT_SINGLE' => array(),
    'COMMENT_MULTI' => array(),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array("'", '"'),
    'ESCAPE_CHAR' => '',
    'KEYWORDS' => array(
        ),
    'SYMBOLS' => array(
        ),
    'CASE_SENSITIVE' => array(
        GESHI_COMMENTS => false,
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            ),
        'COMMENTS' => array(
            ),
        'ESCAPE_CHAR' => array(
            ),
        'BRACKETS' => array(
            0 => 'color: #66cc66;'
            ),
        'STRINGS' => array(
            0 => 'color: #ff0000;'
            ),
        'NUMBERS' => array(
            0 => 'color: #cc66cc;'
            ),
        'METHODS' => array(
            ),
        'SYMBOLS' => array(
            0 => 'color: #66cc66;'
            ),
        'SCRIPT' => array(
            0 => 'color: #00bbdd;',
            ),
        'REGEXPS' => array(
            0 => 'color: #000066;',
            1 => 'color: #000000; font-weight: bold;',
            )
        ),
    'URLS' => array(
        ),
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => array(
        ),
    'REGEXPS' => array(
        0 => array(//attribute names
            GESHI_SEARCH => '([a-z_:][\w\-\.:]*)(=)',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => '\\2'
            ),
        1 => array(//Tag end markers
            GESHI_SEARCH => '(([\/|\?])?\])',
            GESHI_REPLACE => '\\1',
            GESHI_MODIFIERS => 'i',
            GESHI_BEFORE => '',
            GESHI_AFTER => ''
            ),
        ),
    'STRICT_MODE_APPLIES' => GESHI_ALWAYS,
    'SCRIPT_DELIMITERS' => array(
        0 => array(
            '[' => ']'
            )
    ),
    'HIGHLIGHT_STRICT_BLOCK' => array(
        0 => true
        ),
    'TAB_WIDTH' => 2,
    'PARSER_CONTROL' => array(
        'ENABLE_FLAGS' => array(
            'NUMBERS' => GESHI_NEVER
        )
    )
);
