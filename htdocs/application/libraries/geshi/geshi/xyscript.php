<?php
/*************************************************************************************
 * XYScript.php
 * --------
 * Author: Mithrin (mithrin@hotmail.com)
 * Copyright: (c) 2013 Mithrin and GeSHi
 * Release Version: 1.0.8.12
 * Date Started: 2013/07/29
 *
 * XYScript language file for GeSHi.
 *
 * File exention .xys
 *
 * CHANGES
 * -------
 * Release 1.0. (2013/07/29)
 * - First Release
 *
 * TODO
 * ----
 * Reference: http://www.xyplorer.com/
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
    'LANG_NAME' => 'XYScript',
    'COMMENT_SINGLE' => array(1 => '//'),
    'COMMENT_MULTI' => array('/*' => '*/'),
// Regular Expressions
    'COMMENT_REGEXP' => array(
        2 => "/(?<=[\\s^])s\\/(?:\\\\.|(?!\n)[^\\/\\\\])+\\/(?:\\\\.|(?!\n)[^\\/\\\\])+\\/[gimsu]*(?=[\\s$\\.\\;])|(?<=[\\s^(=])m?\\/(?:\\\\.|(?!\n)[^\\/\\\\])+\\/[gimsu]*(?=[\\s$\\.\\,\\;\\)])/iU"),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array("'", '"'),
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => array(
// Scripting Commands
        1 => array(
            'abs,', 'asc,', 'assert,', 'attrstamp,', 'backupto,', 'beep,', 'box,', 'br,', 'break,', 'button,', 'catalogload,', 'catalogreport,',
            'ceil,', 'charview,', 'chr,', 'compare,', 'confirm,', 'continue,', 'copy,', 'copyas,', 'copydata,', 'copyitem,', 'copytext,',
            'copyto,', 'ctbicon,', 'ctbstate,', 'datediff,', 'delete,', 'download,', 'echo,', 'end,', 'eval,', 'exists,', 'exit,', 'filesize,',
            'filetype,', 'filter,', 'floor,', 'focus,', 'folderreport,', 'format,', 'formatbytes,', 'formatdate,', 'formatlist,', 'get,',
            'getkey,', 'getpathcomponent,', 'gettoken,', 'global,', 'goto,', 'hash,', 'hexdump,', 'hextodec,', 'highlight,', 'html,', 'incr,',
            'input,', 'inputfile,', 'inputfolder,', 'inputselect,', 'internetflags,', 'isset,', 'isunicode,', 'listfolder,', 'listpane,', 'load,',
            'loadsearch,', 'loadtree,', 'makecoffee,', 'md5,', 'moveas,', 'moveto,', 'msg,', 'new,', 'now,', 'open,', 'openwith,', 'perm,',
            'popupmenu,', 'property,', 'quickfileview,', 'quote,', 'rand,', 'readfile,', 'readpv,', 'readurl,', 'recase,', 'regexmatches,',
            'regexreplace,', 'releaseglobals,', 'rename,', 'renameitem,', 'replace,', 'replacelist,', 'report,', 'resolvepath,', 'rtfm,',
            'rotate,', 'round,', 'run,', 'savesettings,', 'sel,', 'selectitems,', 'self,', 'selfilter,', 'seltab,', 'set,', 'setkey,',
            'setting,', 'settingp,', 'sortby,', 'sound,', 'status,', 'step,', 'strlen,', 'strpos,', 'strrepeat,', 'sub,', 'substr,',
            'swapnames,', 'sync,', 'tab,', 'tabset,', 'tag,', 'taglist,', 'text,', 'timestamp,', 'toolbar,', 'trim,', 'unset,',
            'unstep,', 'urldecode,', 'urlencode,', 'utf8decode,', 'utf8encode,', 'wipe,', 'writefile,', 'writepv',
            ),
// Core Funtions
        2 => array(
            'TRUE', 'FALSE', 'NOT', 'if', 'elseIf', 'else', 'while', 'foreach', 'and', 'or', 'xor', 'Like', 'LikeI', 'UnLike', 'UnLikeI'
            ),
// XYplorer Native built-in variables Read-Only (Scripting only, Scripting with Portable File Associations only, Constants, UDC Open With only, Date Variables)
        3 => array(
            '<curpath>', '<curpath_s>', '<curpath_dos>', '<curtab>', '<curfolder>', '<curitem>', '<curitemprev>', '<curitem_dos>', '<curitempath>',
            '<curbase>', '<curext>', '<curname>', '<cursize>', '<curver>', '<curlen>', '<focitem>', '<selitems>', '<datem yyyymmdd_hhnnss>',
            '<date yyyymmdd_hhnnss>', ' <xy>', '<xyexe>', '<xypath>', '<xydata>', '<xycatalogs>', '<xythumbs>', '<xyicons>', '<xypane>', '<xypane1>',
            '<xypane2>', '<xytagdat>', ' <xynewitems>', ' <xyscripts>', '<xyini>', '<xydrive>', '<xyver>', '<clipboard>', '<hwnd>', ' <pfaitem>',
            ' <crlf>', '<tab>', ' <items>', '<item1>', '<item2>', '<base>', '<title>', '<date>', '<datem>', '<datec>', '<datea>', '<dateexif>',
            '<date yyyy>', '<datem yyyy-mm-dd>', '<datec yyyy-mm-dd hh:nn:ss>', '<datea yymmdd_hh_nn_ss>', '<date List>', ', <datem List>',
            '<datem +8h yyyymmdd_hhnnss>', '<datec -8d yyyymmdd>', '<date Zodiac>', '<date ISOWeek>', '<get ...>', '<prop ...>'
            ),
// Environment Variables (Common Windows, Administrative Windows, XYplorer only)
        4 => array(
            '%allusersprofile%', '%appdata%', '%commonprogramfiles%', '%programfiles%', '%systemdrive%', '%systemroot%', '%temp%', '%tmp%',
            '%userprofile%', '%windir%', '%CLIENTNAME%', '%COMPUTERNAME%', '%FP_NO_HOST_CHECK%', '%HOMEPATH%', '%NUMBER_OF_PROCESSORS%', '%OS%',
            '%PATHEXT%', '%PROCESSOR_ARCHITECTURE%', '%PROCESSOR_IDENTIFIER%', '%PROCESSOR_LEVEL%', '%PROCESSOR_REVISION%', '%SESSIONNAME%',
            '%USERDOMAIN%', '%USERNAME%', '%computer%', '%desktop%', '%net%', '%recycler%', '%personal%', '%desktopreal%', '%personalreal%',
            '%winsysdir%', '%winsysnative%', '%commonappdata%', '%commondesktop%', '%winver%', '%osbitness%'
            ),
    ),
    'SYMBOLS' => array(
        '(', ')', '[', ']', '{', '}', '<', '>',
        '+', '-', '*', '/', '$', '%',
        '!', '@', '&', '|', '^', '_',
        ',', ';', '?', ':', '.', '=',
        '++','--', '::', '!=',
        '<=', '>=', '<<', '>>', '<<<','>>>',
        ),
    'CASE_SENSITIVE' => array(
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            1 => 'color: #0058B0;',
            2 => 'color: #D80000;',
            3 => 'color: #008080;',
            4 => 'color: #F47A00;',
            ),
        'COMMENTS' => array(
            1 => 'color: #808080; font-style: italic;',
            2 => 'color: #808080; font-style: italic;',
        'MULTI' => 'color: #808080; font-style: italic;',
            ),
        'ESCAPE_CHAR' => array(
            0 => 'color: #808080;',
            ),
        'BRACKETS' => array(
            0 => 'color: #800000;',
            ),
        'STRINGS' => array(
            0 => 'color: #3366CC;',
            ),
        'NUMBERS' => array(
            0 => 'color: #8080FF;',
            ),
        'METHODS' => array(
            1 => 'color: #660066;',
            ),
        'SYMBOLS' => array(
            0 => 'color: #007740;',
            ),
        'REGEXPS' => array(
            ),
        'SCRIPT' => array(
            0 => '',
            1 => '',
            2 => '',
            3 => '',
            ),
        ),
    'URLS' => array(
        1 => 'http://www.xyplorer.com/tour/index.php?page=scripting',
        2 => 'http://www.xyplorer.com/xyfc/viewforum.php?f=7',
        3 => '',
        4 => '',
        ),
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => array(
        1 => '',
        ),
    'REGEXPS' => array(
        ),
    'STRICT_MODE_APPLIES' => GESHI_MAYBE,
    'SCRIPT_DELIMITERS' => array(),
    'HIGHLIGHT_STRICT_BLOCK' => array(
        3 => true,
        4 => true,
        ),
    'TAB_WIDTH' =>  4,
);
