<?php
/**
 * Class and Function List:
 * Function list:
 * Classes list:
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

//codemirror languages
$config['codemirror_languages'] = array(
	'html5' => array(
		'mode' => 'htmlmixed',
		'js' => array(
			array(
				'codemirror/mode/xml/xml.js'
			) ,
			array(
				'codemirror/mode/javascript/javascript.js'
			) ,
			array(
				'codemirror/mode/css/css.js'
			) ,
			array(
				'codemirror/mode/htmlmixed/htmlmixed.js'
			) ,
		) ,
	) ,
	'css' => array(
		'mode' => 'css',
		'js' => array(
			array(
				'codemirror/mode/css/css.js'
			) ,
		) ,
	) ,
	'javascript' => array(
		'mode' => 'javascript',
		'js' => array(
			array(
				'codemirror/mode/javascript/javascript.js'
			) ,
		) ,
	) ,
	'php' => array(
		'mode' => 'php',
		'js' => array(
			array(
				'codemirror/mode/xml/xml.js'
			) ,
			array(
				'codemirror/mode/javascript/javascript.js'
			) ,
			array(
				'codemirror/mode/css/css.js'
			) ,
			array(
				'codemirror/mode/clike/clike.js'
			) ,
			array(
				'codemirror/mode/php/php.js'
			) ,
		) ,
	) ,
	'python' => array(
		'mode' => 'python',
		'js' => array(
			array(
				'codemirror/mode/python/python.js'
			) ,
		) ,
	) ,
	'ruby' => array(
		'mode' => 'ruby',
		'js' => array(
			array(
				'codemirror/mode/ruby/ruby.js'
			) ,
		) ,
	) ,
	'lua' => array(
		'mode' => 'text/x-lua',
		'js' => array(
			array(
				'codemirror/mode/lua/lua.js'
			) ,
		) ,
	) ,
	'bash' => array(
		'mode' => 'text/x-sh',
		'js' => array(
			array(
				'codemirror/mode/shell/shell.js'
			) ,
		) ,
	) ,
	'go' => array(
		'mode' => 'text/x-go',
		'js' => array(
			array(
				'codemirror/mode/go/go.js'
			) ,
		) ,
	) ,
	'c' => array(
		'mode' => 'text/x-csrc',
		'js' => array(
			array(
				'codemirror/mode/clike/clike.js'
			) ,
		) ,
	) ,
	'cpp' => array(
		'mode' => 'text/x-c++src',
		'js' => array(
			array(
				'codemirror/mode/clike/clike.js'
			) ,
		) ,
	) ,
	'diff' => array(
		'mode' => 'diff',
		'js' => array(
			array(
				'codemirror/mode/diff/diff.js'
			) ,
		) ,
	) ,
	'latex' => array(
		'mode' => 'stex',
		'js' => array(
			array(
				'codemirror/mode/stex/stex.js'
			) ,
		) ,
	) ,
	'sql' => array(
		'mode' => 'mysql',
		'js' => array(
			array(
				'codemirror/mode/mysql/mysql.js'
			) ,
		) ,
	) ,
	'xml' => array(
		'mode' => 'xml',
		'js' => array(
			array(
				'codemirror/mode/xml/xml.js'
			) ,
		) ,
	) ,
	'text' => 'Plain Text',
	'4cs' => '4CS',
	'6502acme' => 'MOS 6502',
	'6502kickass' => 'MOS 6502 Kick Assembler',
	'6502tasm' => 'MOS 6502 TASM/64TASS',
	'68000devpac' => 'Motorola 68000 Devpac Assembler',
	'abap' => 'ABAP',
	'actionscript' => 'Actionscript',
	'actionscript3' => 'ActionScript3',
	'ada' => 'Ada',
	'algol68' => 'ALGOL 68',
	'apache' => 'Apache',
	'applescript' => 'AppleScript',
	'apt_sources' => 'Apt sources.list',
	'asm' => 'x86 Assembler',
	'asp' => 'ASP',
	'autoconf' => 'autoconf',
	'autohotkey' => 'Autohotkey',
	'autoit' => 'AutoIT',
	'avisynth' => 'AviSynth',
	'awk' => 'Awk',
	'bascomavr' => 'BASCOM AVR',
	'basic4gl' => 'Basic4GL',
	'bf' => 'Brainfuck',
	'bibtex' => 'BibTeX',
	'blitzbasic' => 'BlitzBasic',
	'bnf' => 'BNF (Backus-Naur form)',
	'boo' => 'Boo',
	'c_loadrunner' => 'C (for LoadRunner)',
	'c_mac' => 'C for Macs',
	'caddcl' => 'CAD DCL (Dialog Control Language)',
	'cadlisp' => 'AutoCAD/IntelliCAD Lisp',
	'cfdg' => 'CFDG',
	'cfm' => 'ColdFusion',
	'chaiscript' => 'ChaiScript',
	'cil' => 'CIL (Common Intermediate Language)',
	'clojure' => 'Clojure',
	'cmake' => 'CMake',
	'cobol' => 'COBOL',
	'coffeescript' => 'CoffeeScript',
	'csharp' => array(
		'mode' => 'text/x-csharp',
		'js' => array(
			array(
				'codemirror/mode/clike/clike.js'
			) ,
		) ,
	) ,
	'cuesheet' => 'Cuesheet',
	'd' => 'D',
	'dcs' => 'DCS',
	'delphi' => 'Delphi (Object Pascal)',
	'div' => 'DIV',
	'dos' => 'DOS',
	'dot' => 'dot',
	'e' => 'E',
	'ecmascript' => 'ECMAScript',
	'eiffel' => 'Eiffel',
	'email' => 'Email (mbox/eml/RFC format)',
	'epc' => 'Enerscript',
	'euphoria' => 'Euphoria',
	'f1' => 'Formula One',
	'falcon' => 'Falcon',
	'fo' => 'fo',
	'fortran' => 'Fortran',
	'freebasic' => 'FreeBasic',
	'fsharp' => 'F#',
	'gambas' => 'GAMBAS',
	'gdb' => 'GDB',
	'genero' => 'Genero',
	'genie' => 'Genie',
	'gettext' => 'GNU Gettext .po/.pot',
	'glsl' => 'glSlang',
	'gml' => 'GML',
	'gnuplot' => 'Gnuplot script',
	'groovy' => 'Groovy',
	'gwbasic' => 'GwBasic',
	'haskell' => 'Haskell',
	'hicest' => 'HicEst',
	'hq9plus' => 'HQ9+',
	'html4strict' => array(
		'mode' => 'htmlmixed',
		'js' => array(
			array(
				'codemirror/mode/xml/xml.js'
			) ,
			array(
				'codemirror/mode/javascript/javascript.js'
			) ,
			array(
				'codemirror/mode/css/css.js'
			) ,
			array(
				'codemirror/mode/htmlmixed/htmlmixed.js'
			) ,
		) ,
	) ,
	'icon' => 'Icon',
	'idl' => 'Unoidl',
	'ini' => 'INI',
	'inno' => 'Inno Script',
	'intercal' => 'INTERCAL',
	'io' => 'Io',
	'j' => 'J',
	'java' => array(
		'mode' => 'text/x-java',
		'js' => array(
			array(
				'codemirror/mode/clike/clike.js'
			) ,
		) ,
	) ,
	'java5' => array(
		'mode' => 'text/x-java',
		'js' => array(
			array(
				'codemirror/mode/clike/clike.js'
			) ,
		) ,
	) ,
	'jquery' => 'jQuery 1.3',

	//'kixtart' => 'PHP',
	'klonec' => 'KLone with C',
	'klonecpp' => 'KLone with C++',
	'lb' => 'Liberty BASIC',
	'lisp' => 'Generic Lisp',
	'llvm' => 'LLVM',
	'locobasic' => 'Locomotive Basic (Amstrad CPC series)',
	'logtalk' => 'Logtalk',
	'lolcode' => 'LOLcode',
	'lotusformulas' => '@Formula/@Command',
	'lotusscript' => 'LotusScript',
	'lscript' => 'Lightwave Script',
	'lsl2' => 'Linden Scripting',
	'm68k' => 'Motorola 68000 Assembler',
	'magiksf' => 'MagikSF',
	'make' => 'Make',
	'mapbasic' => 'MapBasic',
	'matlab' => 'Matlab M-file',
	'mirc' => 'mIRC Scripting',
	'mmix' => 'MMIX Assembler',
	'modula2' => 'Modula-2',
	'modula3' => 'Modula-3',
	'mpasm' => 'Microchip Assembler',
	'mxml' => 'MXML',
	'mysql' => array(
		'mode' => 'mysql',
		'js' => array(
			array(
				'codemirror/mode/mysql/mysql.js'
			) ,
		) ,
	) ,
	'newlisp' => 'newLISP',
	'nsis' => 'Nullsoft Scriptable Install System',
	'oberon2' => 'Oberon-2',
	'objc' => 'Objective-C',
	'objeck' => 'Objeck Programming Language',
	'ocaml' => 'OCaml (Objective Caml)',
	'oobas' => 'OpenOffice.org Basic',
	'oracle11' => 'Oracle 11i',
	'oracle8' => 'Oracle 8',
	'oxygene' => 'Delphi Prism (Oxygene)',
	'oz' => 'Oz',
	'pascal' => 'Pascal',
	'pcre' => 'PCRE',
	'per' => 'Per (forms)',
	'perl' => 'Perl',
	'perl6' => 'Perl 6',
	'pf' => 'OpenBSD packet filter',
	'pic16' => 'PIC16 Assembler',
	'pike' => 'Pike',
	'pixelbender' => 'Pixel Bender 1.0',
	'pli' => 'PL/I',
	'plsql' => 'Oracle 9.2 PL/SQL',
	'postgresql' => 'PostgreSQL',
	'povray' => 'Povray',
	'powerbuilder' => 'PowerBuilder (PowerScript)',
	'powershell' => 'PowerShell',
	'proftpd' => 'ProFTPd',
	'progress' => 'Progress',
	'prolog' => 'Prolog',
	'properties' => 'Property',
	'providex' => 'ProvideX',
	'purebasic' => 'PureBasic',
	'q' => 'q/kdb+',
	'qbasic' => 'QBasic/QuickBASIC',
	'rails' => 'Ruby (with Ruby on Rails Framework)',
	'rebol' => 'Rebol',
	'reg' => 'Microsoft Registry Editor',
	'robots' => 'robots.txt',
	'rpmspec' => 'RPM Spec',
	'rsplus' => 'R',
	'sas' => 'SAS',
	'scala' => 'Scala',
	'scheme' => 'Scheme',
	'scilab' => 'SciLab',
	'sdlbasic' => 'sdlBasic',
	'smalltalk' => 'Smalltalk',
	'smarty' => 'Smarty template',
	'systemverilog' => 'SystemVerilog IEEE 1800-2009(draft8)',
	'tcl' => 'TCL/iTCL',
	'teraterm' => 'Tera Term Macro',
	'thinbasic' => 'thinBasic',
	'tsql' => 'T-SQL',
	'typoscript' => 'TypoScript',
	'unicon' => 'Unicon',
	'uscript' => 'UnrealScript',
	'vala' => 'Vala',
	'vb' => 'Visual Basic',
	'vbnet' => 'VB.NET',
	'verilog' => 'Verilog',
	'vhdl' => 'VHDL',
	'vim' => 'Vim scripting',
	'visualfoxpro' => 'Visual FoxPro',
	'visualprolog' => 'Visual Prolog',
	'whitespace' => 'Whitespace',
	'whois' => 'Whois response (RPSL format)',
	'winbatch' => 'WinBatch',
	'xbasic' => 'XBasic',
	'xorg_conf' => 'xorg.conf',
	'xpp' => 'Axapta/Dynamics Ax X++',
	'yaml' => 'YAML',
	'z80' => 'ZiLOG Z80 Assembler',
	'zxbasic' => 'ZXBasic',
);
