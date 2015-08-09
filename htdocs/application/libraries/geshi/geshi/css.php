<?php
/*************************************************************************************
 * css.php
 * -------
 * Author: Nigel McNie (nigel@geshi.org), Zéfling (zefling@ikilote.net)
 * Copyright: (c) 2004 Nigel McNie (http://qbnz.com/highlighter/)
 * Release Version: 1.0.8.12
 * Date Started: 2004/06/18
 *
 * CSS language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2014/07/14 (1.0.8.12)
 *  - update for current CSS3 (properties, value, expression, unites & color)
 *  - remove pseudo class regex
 *  - add rules regex
 * 2008/05/23 (1.0.7.22)
 *  -  Added description of extra language features (SF#1970248)
 * 2004/11/27 (1.0.3)
 *  -  Added support for multiple object splitters
 * 2004/10/27 (1.0.2)
 *   -  Changed regexps to catch "-" symbols
 *   -  Added support for URLs
 * 2004/08/05 (1.0.1)
 *   -  Added support for symbols
 * 2004/07/14 (1.0.0)
 *   -  First Release
 *
 * TODO (updated 2004/11/27)
 * -------------------------
 * * Improve or drop regexps for class/id highlighting
 * * Re-look at keywords - possibly to make several CSS language
 *   files, all with different versions of CSS in them
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
    'LANG_NAME' => 'CSS',
    'COMMENT_SINGLE' => array(),
    'COMMENT_MULTI' => array('/*' => '*/'),
    'COMMENT_REGEXP' => array(
        2 => "/(?<=\\()\\s*(?:(?:[a-z0-9]+?:\\/\\/)?[a-z0-9_\\-\\.\\/:]+?)?[a-z]+?\\.[a-z]+?(\\?[^\)]+?)?\\s*?(?=\\))/i"
        ),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array('"', "'"),
    'ESCAPE_CHAR' => '',
    'ESCAPE_REGEXP' => array(
        //Simple Single Char Escapes
        //1 => "#\\\\[nfrtv\$\"\n\\\\]#i",
        //Hexadecimal Char Specs
        2 => "#\\\\[\da-fA-F]{1,6}\s?#i",
        //Unicode Char Specs
        //3 => "#\\\\u[\da-fA-F]{1,8}#i",
        ),
    'KEYWORDS' => array(
        // properties
        1 => array(
            'align-content','align-items','align-self','all','animation',
            'animation-delay','animation-direction','animation-duration',
            'animation-fill-mode','animation-iteration-count','animation-name',
            'animation-play-state','animation-timing-function',
            'backface-visibility','background','background-attachment',
            'background-blend-mode','background-clip','background-color',
            'background-image','background-origin','background-position',
            'background-repeat','background-size','border','border-bottom',
            'border-bottom-color','border-bottom-left-radius',
            'border-bottom-right-radius','border-bottom-style',
            'border-bottom-width','border-collapse','border-color',
            'border-image','border-image-outset','border-image-repeat',
            'border-image-slice','border-image-source','border-image-width',
            'border-left','border-left-color','border-left-style',
            'border-left-width','border-radius','border-right',
            'border-right-color','border-right-style','border-right-width',
            'border-spacing','border-style','border-top','border-top-color',
            'border-top-left-radius','border-top-right-radius',
            'border-top-style','border-top-width','border-width','bottom',
            'box-decoration-break','box-shadow','box-sizing','break-after',
            'break-before','break-inside','caption-side','clear','clip',
            'clip-path','color','columns','column-count','column-fill',
            'column-gap','column-rule','column-rule-color','column-rule-style',
            'column-rule-width','column-span','column-width','content',
            'counter-increment','counter-reset','cursor','direction','display',
            'empty-cells','filter','flex','flex-basis','flex-direction',
            'flex-flow','flex-grow','flex-shrink','flex-wrap','float','font',
            'font-family','font-feature-settings','font-kerning',
            'font-language-override','font-size','font-size-adjust',
            'font-stretch','font-style','font-synthesis','font-variant',
            'font-variant-alternates','font-variant-caps',
            'font-variant-east-asian','font-variant-ligatures',
            'font-variant-numeric','font-variant-position','font-weight','grid',
            'grid-area','grid-auto-columns','grid-auto-flow',
            'grid-auto-position','grid-auto-rows','grid-column',
            'grid-column-start','grid-column-end','grid-row','grid-row-start',
            'grid-row-end','grid-template','grid-template-areas',
            'grid-template-rows','grid-template-columns','height','hyphens',
            'icon','image-rendering','image-resolution','image-orientation',
            'ime-mode','justify-content','left','letter-spacing','line-break',
            'line-height','list-style','list-style-image','list-style-position',
            'list-style-type','margin','margin-bottom','margin-left',
            'margin-right','margin-top','marks','mask','mask-type','max-height',
            'max-width','min-height','min-width','mix-blend-mode','nav-down',
            'nav-index','nav-left','nav-right','nav-up','object-fit',
            'object-position','opacity','order','orphans','outline',
            'outline-color','outline-offset','outline-style','outline-width',
            'overflow','overflow-wrap','overflow-x','overflow-y',
            'overflow-clip-box','padding','padding-bottom','padding-left',
            'padding-right','padding-top','page-break-after','page-break-before',
            'page-break-inside','perspective','perspective-origin',
            'pointer-events','position','quotes','resize','right',
            'shape-image-threshold','shape-margin','shape-outside',
            'table-layout','tab-size','text-align','text-align-last',
            'text-combine-horizontal','text-decoration','text-decoration-color',
            'text-decoration-line','text-decoration-style','text-indent',
            'text-orientation','text-overflow','text-rendering','text-shadow',
            'text-transform','text-underline-position','top','touch-action',
            'transform','transform-origin','transform-style','transition',
            'transition-delay','transition-duration','transition-property',
            'transition-timing-function','unicode-bidi','unicode-range',
            'vertical-align','visibility','white-space','widows','width',
            'will-change','word-break','word-spacing','word-wrap',
            'writing-mode','z-index'
            ),
        // value
        2 => array(
            'absolute','activeborder','activecaption','after-white-space',
            'ahead','alternate','always','appworkspace','aqua','armenian','auto',
            'avoid','background','backwards','baseline','below','bidi-override',
            'blink','block','block clear','block width','block-axis','bold',
            'bolder','border','border-box','both','bottom','break-word','button',
            'button-bevel','buttonface','buttonhighlight','buttonshadow',
            'buttontext','capitalize','caption','captiontext','caret','center',
            'checkbox','circle','cjk-ideographic','clip','close-quote',
            'collapse','compact','condensed','content','content-box',
            'continuous','crop','cross','crosshair','cursive','dashed','decimal',
            'decimal-leading-zero','default','disc','discard','dot-dash',
            'dot-dot-dash','dotted','double','down','e-resize','element',
            'ellipsis','embed','end','expanded','extra-condensed',
            'extra-expanded','fantasy','fast','fixed','forwards','georgian',
            'graytext','groove','hand','hebrew','help','hidden','hide','higher',
            'highlight','highlighttext','hiragana','hiragana-iroha',
            'horizontal','icon','ignore','inactiveborder','inactivecaption',
            'inactivecaptiontext','infinite','infobackground','infotext',
            'inherit','initial','inline','inline-axis','inline-block',
            'inline-table','inset','inside','intrinsic','invert','italic',
            'justify','katakana','katakana-iroha','landscape','large','larger',
            'left','level','lighter','lime','line-through','list-item','listbox',
            'listitem','logical','loud','lower','lower-alpha','lower-greek',
            'lower-latin','lower-roman','lowercase','ltr','marker','match',
            'medium','menu','menulist','menulist-button','menulist-text',
            'menulist-textfield','menutext','message-box','middle',
            'min-intrinsic','mix','monospace','move','multiple','n-resize',
            'narrower','ne-resize','no-close','no-close-quote','no-open-quote',
            'no-repeat','none','normal','nowrap','nw-resize','oblique','once',
            'open-quote','outset','outside','overline','padding','pointer',
            'portrait','pre','pre-line','pre-wrap','push-button','radio',
            'read-only','read-write','read-write-plaintext-only','relative',
            'repeat','repeat-x','repeat-y','reverse','ridge','right','round',
            'rtl','run-in','s-resize','sans-serif','scroll','scrollbar',
            'scrollbarbutton-down','scrollbarbutton-left',
            'scrollbarbutton-right','scrollbarbutton-up',
            'scrollbargripper-horizontal','scrollbargripper-vertical',
            'scrollbarthumb-horizontal','scrollbarthumb-vertical',
            'scrollbartrack-horizontal','scrollbartrack-vertical',
            'se-resize','searchfield','searchfield-close','searchfield-results',
            'semi-condensed','semi-expanded','separate','serif','show','single',
            'skip-white-space','slide','slider-horizontal','slider-vertical',
            'sliderthumb-horizontal','sliderthumb-vertical','slow','small',
            'small-caps','small-caption','smaller','solid','space','square',
            'square-button','start','static','status-bar','stretch','sub',
            'super','sw-resize','table','table-caption','table-cell',
            'table-column','table-column-group','table-footer-group',
            'table-header-group','table-row','table-row-group','text',
            'text-bottom','text-top','textfield','thick','thin',
            'threeddarkshadow','threedface','threedhighlight',
            'threedlightshadow','threedshadow','top','ultra-condensed',
            'ultra-expanded','underline','unfurl','up','upper-alpha',
            'upper-latin','upper-roman','uppercase','vertical','visible',
            'visual','w-resize','wait','wave','wider','window','windowframe',
            'windowtext','x-large','x-small','xx-large','xx-small'
            ),
        // function xxx()
        3 => array(
            'attr','calc','contrast','cross-fade','cubic-bezier','cycle',
            'device-cmyk','drop-shadow','element','ellipse','hsl','hsla','hwb',
            'image','matrix','matrix3d','minmax','gray','grayscale',
            'perspective','polygon','radial-gradient','translate','translatex',
            'translatey','translatez','translate3d','skew','skewx','skewy',
            'saturate','sepia','scale','scalex','scaley','scalez','scale3d',
            'steps','rect','repeating-linear-gradient',
            'repeating-radial-gradient','repeat','rgb','rgba','rotate','rotatex',
            'rotatey','rotatez','rotate3d','url','var'
            ),
        // colors
        4 => array(
            'aliceblue','antiquewhite','aqua','aquamarine','azure','beige',
            'bisque','black','blanchedalmond','blue','blueviolet','brown',
            'burlywood','cadetblue','chartreuse','chocolate','coral',
            'cornflowerblue','cornsilk','crimson','cyan','darkblue','darkcyan',
            'darkgoldenrod','darkgray','darkgreen','darkgrey','darkkhaki',
            'darkmagenta','darkolivegreen','darkorange','darkorchid','darkred',
            'darksalmon','darkseagreen','darkslateblue','darkslategray',
            'darkslategrey','darkturquoise','darkviolet','deeppink',
            'deepskyblue','dimgray','dimgrey','dodgerblue','firebrick',
            'floralwhite','forestgreen','fuchsia','gainsboro','ghostwhite',
            'gold','goldenrod','gray','green','greenyellow','grey','honeydew',
            'hotpink','indianred','indigo','ivory','khaki','lavender',
            'lavenderblush','lawngreen','lemonchiffon','lightblue','lightcoral',
            'lightcyan','lightgoldenrodyellow','lightgray','lightgreen',
            'lightgrey','lightpink','lightsalmon','lightseagreen','lightskyblue',
            'lightslategray','lightslategrey','lightsteelblue','lightyellow',
            'lime','limegreen','linen','magenta','maroon','mediumaquamarine',
            'mediumblue','mediumorchid','mediumpurple','mediumseagreen',
            'mediumslateblue','mediumspringgreen','mediumturquoise',
            'mediumvioletred','midnightblue','mintcream','mistyrose','moccasin',
            'navajowhite','navy','oldlace','olive','olivedrab','orange',
            'orangered','orchid','palegoldenrod','palegreen','paleturquoise',
            'palevioletred','papayawhip','peachpuff','peru','pink','plum',
            'powderblue','purple','rebeccapurple','red','rosybrown','royalblue',
            'saddlebrown','salmon','sandybrown','seagreen','seashell','sienna',
            'silver','skyblue','slateblue','slategray','slategrey','snow',
            'springgreen','steelblue','tan','teal','thistle','transparent',
            'tomato','turquoise','violet','wheat','white','whitesmoke','yellow',
            'yellowgreen'
            ),
        // pseudo class
        5 => array(
            'active','after','before','checked','choices','default','dir',
            'disabled','empty','enabled','first','first-child','first-letter',
            'first-line','first-of-type','focus','fullscreen','hover',
            'indeterminate','in-range','invalid','lang','last-child',
            'last-of-type','left','link','not','nth-child','nth-last-child',
            'nth-last-of-type','nth-of-type','only-child','only-of-type',
            'optional','out-of-range','read-only','read-write','repeat-index',
            'repeat-item','required','right','root','scope','selection','target',
            'valid','value','visited'
            )
        ),
    'SYMBOLS' => array(
        '(', ')', '{', '}', ':', ';',
        '>', '+', '*', ',', '^', '='
        ),
    'CASE_SENSITIVE' => array(
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            1 => 'color: #000000; font-weight: bold;',
            2 => 'color: #993333;',
            3 => 'color: #9932cc;',
            4 => 'color: #dc143c;',
            5 => 'color: #F5758F;',
            ),
        'COMMENTS' => array(
            1 => 'color: #a1a100;',
            2 => 'color: #ff0000; font-style: italic;',
            'MULTI' => 'color: #808080; font-style: italic;'
            ),
        'ESCAPE_CHAR' => array(
            0 => 'color: #000099; font-weight: bold;',
            //1 => 'color: #000099; font-weight: bold;',
            2 => 'color: #000099; font-weight: bold;'
            //3 => 'color: #000099; font-weight: bold;'
            ),
        'BRACKETS' => array(
            0 => 'color: #00AA00;'
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
            0 => 'color: #00AA00;'
            ),
        'SCRIPT' => array(
            ),
        'REGEXPS' => array(
            0 => 'color: #cc00cc;',
            1 => 'color: #6666ff;',
            2 => 'color: #3F84D9; font-weight: bold;',
            3 => 'color: #933;',
            4 => 'color: #444;'
            )
        ),
    'URLS' => array(
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => ''
        ),
    'OOLANG' => false,
    'OBJECT_SPLITTERS' => array(
        ),
    'REGEXPS' => array(
        //DOM Node ID
        0 => '\#[a-zA-Z0-9\-_]+(?:\\\\:[a-zA-Z0-9\-_]+)*',
        //CSS classname
        1 => '\.(?!\d)[a-zA-Z0-9\-_]+(?:\\\\:[a-zA-Z0-9\-_]+)*\b(?=[\{\.#\s,:].|<\|)',
        //CSS rules
        2 => '\@(?!\d)[a-zA-Z0-9\-_]+(?:\\\\:[a-zA-Z0-9\-_]+)*\b(?=[\{\.#\s,:].|<\|)',
        //Measurements
        3 => '[+\-]?(\d+|(\d*\.\d+))(em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in|pt|pc|px|deg|grad|rad|turn|s|ms|Hz|kHz|dpi|dpcm|dppx|%)',
        //var
        4 => '(--[a-zA-Z0-9\-]*)'
        ),
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => array(
        ),
    'HIGHLIGHT_STRICT_BLOCK' => array(
        ),
    'TAB_WIDTH' => 4,
    'PARSER_CONTROL' => array(
        'KEYWORDS' => array(
            'DISALLOWED_AFTER' => '(?![\-a-zA-Z0-9_\|%\\-&\.])',
            'DISALLOWED_BEFORE' => '(?<![\-a-zA-Z0-9_\|%\\~&\.])'
        )
    )
);
