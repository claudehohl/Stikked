<?php

/**
 * CodeIgniter Port of 'Minify_CSS' CSS Compression Library from Minify ( http://code.google.com/p/minify/ )
 * 
 * Minifies CSS, preserving comments as directed. Note: This port moves the Minify_CommentPreserver 
 * class into this file, and adds a simple meta class to access the normal minify_css class.
 * 
 * @author Tony Dewan <tony@tonydewan.com>
 * @version 1.1 (2009-01-28)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD license, as per the original Minify_CSS class
 * 
 **/

/*
	===============================================================================================
	 USAGE
	===============================================================================================
	
	Load the library as normal:
	-----------------------------------------------------------------------------------------------
	$this->load->library('cssmin');
	-----------------------------------------------------------------------------------------------
	
	Minify a string like so:
	-----------------------------------------------------------------------------------------------
	$this->cssmin->minify( file_get_contents('styles.css') );
	-----------------------------------------------------------------------------------------------
	
	
	There are two options:
	
	'preserveComments'
	Boolean flag for preserving comments.  Only comments starting with /*! are preserved. 
	Defaults to true.
	
	'relativePath'
	String that will be prepended to all relative URIs in import/url declarations.  
	Defaults to null.
	
	
	The options can either be set globally using the config function:
	-----------------------------------------------------------------------------------------------
	$cssmin_options = array(
		  'preserveComments'=> TRUE,
		  'relativePath'=> 'http://www.example.com/styles/images/'
	);
	
	$this->cssmin->config($cssmin_options);
	-----------------------------------------------------------------------------------------------
	
	
	Or on individual calls to the minify function:
	-----------------------------------------------------------------------------------------------
	$this->cssmin->minify( $string, FALSE, $path );
	-----------------------------------------------------------------------------------------------
	
	NOTE: Global settings override settings in individual calls.
	===============================================================================================
*/
 
 class cssmin {
 	
 	public function cssmin()
 	{
 		log_message('debug', 'CSSMin library initialized.');
 	}
 	
 	
 	public function config($config)
 	{
		foreach ($config as $key => $value)
		{
			$this->$key = $value;
		}
 	
 	}
 	
 	public function minify($css, $preserveComments = TRUE, $relativePath = null)
 	{	
 		$c = ( isset($this->preserveComments) ) ? $this->preserveComments : $preserveComments;
 		$p = ( isset($this->relativePath) ) ? $this->relativePath : $relativePath;

 		$min = new Minify_CSS();
 		return $min->minify($css, array('preserveComments'=> $c, 'prependRelativePath' => $p));
 	}
 
 }


/**
 * Class Minify_CSS  
 * @package Minify
 */

/**
 * Compress CSS
 *
 * This is a heavy regex-based removal of whitespace, unnecessary
 * comments and tokens, and some CSS value minimization, where practical.
 * Many steps have been taken to avoid breaking comment-based hacks, 
 * including the ie5/mac filter (and its inversion), but expect tricky
 * hacks involving comment tokens in 'content' value strings to break
 * minimization badly. A test suite is available.
 * 
 * @package Minify
 * @author Stephen Clay <steve@mrclay.org>
 * @author http://code.google.com/u/1stvamp/ (Issue 64 patch)
 */
class Minify_CSS {

    /**
     * Defines which class to call as part of callbacks, change this
     * if you extend Minify_CSS
     * @var string
     */
    protected static $className = 'Minify_CSS';
    
    /**
     * Minify a CSS string
     * 
     * @param string $css
     * 
     * @param array $options available options:
     * 
     * 'preserveComments': (default true) multi-line comments that begin
     * with "/*!" will be preserved with newlines before and after to
     * enhance readability.
     * 
     * 'prependRelativePath': (default null) if given, this string will be
     * prepended to all relative URIs in import/url declarations
     * 
     * 'currentDir': (default null) if given, this is assumed to be the
     * directory of the current CSS file. Using this, minify will rewrite
     * all relative URIs in import/url declarations to correctly point to
     * the desired files. For this to work, the files *must* exist and be
     * visible by the PHP process.
     * 
     * @return string
     */
    public static function minify($css, $options = array()) 
    {
        if (isset($options['preserveComments']) 
            && !$options['preserveComments']) {
            return self::_minify($css, $options);    
        }

        // recursive calls don't preserve comments
        $options['preserveComments'] = false;
        return Minify_CommentPreserver::process(
            $css
            ,array(self::$className, 'minify')
            ,array($options)
        );
    }

    /**
     * Minify a CSS string
     * 
     * @param string $css
     * 
     * @param array $options To enable URL rewriting, set the value
     * for key 'prependRelativePath'.
     * 
     * @return string
     */
    protected static function _minify($css, $options) 
    {
        $css = str_replace("\r\n", "\n", $css);
        
        // preserve empty comment after '>'
        // http://www.webdevout.net/css-hacks#in_css-selectors
        $css = preg_replace('@>/\\*\\s*\\*/@', '>/*keep*/', $css);
        
        // preserve empty comment between property and value
        // http://css-discuss.incutio.com/?page=BoxModelHack
        $css = preg_replace('@/\\*\\s*\\*/\\s*:@', '/*keep*/:', $css);
        $css = preg_replace('@:\\s*/\\*\\s*\\*/@', ':/*keep*/', $css);
        
        // apply callback to all valid comments (and strip out surrounding ws
        self::$_inHack = false;
        $css = preg_replace_callback('@\\s*/\\*([\\s\\S]*?)\\*/\\s*@'
            ,array(self::$className, '_commentCB'), $css);

        // remove ws around { } and last semicolon in declaration block
        $css = preg_replace('/\\s*{\\s*/', '{', $css);
        $css = preg_replace('/;?\\s*}\\s*/', '}', $css);
        
        // remove ws surrounding semicolons
        $css = preg_replace('/\\s*;\\s*/', ';', $css);
        
        // remove ws around urls
        $css = preg_replace('/
                url\\(      # url(
                \\s*
                ([^\\)]+?)  # 1 = the URL (really just a bunch of non right parenthesis)
                \\s*
                \\)         # )
            /x', 'url($1)', $css);
        
        // remove ws between rules and colons
        $css = preg_replace('/
                \\s*
                ([{;])              # 1 = beginning of block or rule separator 
                \\s*
                ([\\*_]?[\\w\\-]+)  # 2 = property (and maybe IE filter)
                \\s*
                :
                \\s*
                (\\b|[#\'"])        # 3 = first character of a value
            /x', '$1$2:$3', $css);
        
        // remove ws in selectors
        $css = preg_replace_callback('/
                (?:              # non-capture
                    \\s*
                    [^~>+,\\s]+  # selector part
                    \\s*
                    [,>+~]       # combinators
                )+
                \\s*
                [^~>+,\\s]+      # selector part
                {                # open declaration block
            /x'
            ,array(self::$className, '_selectorsCB'), $css);
        
        // minimize hex colors
        $css = preg_replace('/([^=])#([a-f\\d])\\2([a-f\\d])\\3([a-f\\d])\\4([\\s;\\}])/i'
            , '$1#$2$3$4$5', $css);
        
        // remove spaces between font families
        $css = preg_replace_callback('/font-family:([^;}]+)([;}])/'
            ,array(self::$className, '_fontFamilyCB'), $css);
        
        $css = preg_replace('/@import\\s+url/', '@import url', $css);
        
        // replace any ws involving newlines with a single newline
        $css = preg_replace('/[ \\t]*\\n+\\s*/', "\n", $css);
        
        // separate common descendent selectors w/ newlines (to limit line lengths)
        $css = preg_replace('/([\\w#\\.\\*]+)\\s+([\\w#\\.\\*]+){/', "$1\n$2{", $css);
        
        // Use newline after 1st numeric value (to limit line lengths).
        $css = preg_replace('/
            ((?:padding|margin|border|outline):\\d+(?:px|em)?) # 1 = prop : 1st numeric value
            \\s+
            /x'
            ,"$1\n", $css);
        
        $rewrite = false;
        if (isset($options['prependRelativePath'])) {
            self::$_tempPrepend = $options['prependRelativePath'];
            $rewrite = true;
        } elseif (isset($options['currentDir'])) {
            self::$_tempCurrentDir = $options['currentDir'];
            $rewrite = true;
        }
        if ($rewrite) {
            $css = preg_replace_callback('/@import\\s+([\'"])(.*?)[\'"]/'
                ,array(self::$className, '_urlCB'), $css);
            $css = preg_replace_callback('/url\\(\\s*([^\\)\\s]+)\\s*\\)/'
                ,array(self::$className, '_urlCB'), $css);
        }
        self::$_tempPrepend = self::$_tempCurrentDir = '';
        return trim($css);
    }
    
    /**
     * Replace what looks like a set of selectors  
     *
     * @param array $m regex matches
     * 
     * @return string
     */
    protected static function _selectorsCB($m)
    {
        // remove ws around the combinators
        return preg_replace('/\\s*([,>+~])\\s*/', '$1', $m[0]);
    }
    
    /**
     * @var bool Are we "in" a hack? 
     * 
     * I.e. are some browsers targetted until the next comment?   
     */
    protected static $_inHack = false;
    
    /**
     * @var string string to be prepended to relative URIs   
     */
    protected static $_tempPrepend = '';
    
    /**
     * @var string directory of this stylesheet for rewriting purposes   
     */
    protected static $_tempCurrentDir = '';
    
    /**
     * Process a comment and return a replacement
     * 
     * @param array $m regex matches
     * 
     * @return string   
     */
    protected static function _commentCB($m)
    {
        $m = $m[1]; 
        // $m is the comment content w/o the surrounding tokens, 
        // but the return value will replace the entire comment.
        if ($m === 'keep') {
            return '/**/';
        }
        if ($m === '" "') {
            // component of http://tantek.com/CSS/Examples/midpass.html
            return '/*" "*/';
        }
        if (preg_match('@";\\}\\s*\\}/\\*\\s+@', $m)) {
            // component of http://tantek.com/CSS/Examples/midpass.html
            return '/*";}}/* */';
        }
        if (self::$_inHack) {
            // inversion: feeding only to one browser
            if (preg_match('@
                    ^/               # comment started like /*/
                    \\s*
                    (\\S[\\s\\S]+?)  # has at least some non-ws content
                    \\s*
                    /\\*             # ends like /*/ or /**/
                @x', $m, $n)) {
                // end hack mode after this comment, but preserve the hack and comment content
                self::$_inHack = false;
                return "/*/{$n[1]}/**/";
            }
        }
        if (substr($m, -1) === '\\') { // comment ends like \*/
            // begin hack mode and preserve hack
            self::$_inHack = true;
            return '/*\\*/';
        }
        if ($m !== '' && $m[0] === '/') { // comment looks like /*/ foo */
            // begin hack mode and preserve hack
            self::$_inHack = true;
            return '/*/*/';
        }
        if (self::$_inHack) {
            // a regular comment ends hack mode but should be preserved
            self::$_inHack = false;
            return '/**/';
        }
        return ''; // remove all other comments
    }
    
    protected static function _urlCB($m)
    {
        $isImport = (0 === strpos($m[0], '@import'));
        if ($isImport) {
            $quote = $m[1];
            $url = $m[2];
        } else {
            // is url()
            // $m[1] is either quoted or not
            $quote = ($m[1][0] === "'" || $m[1][0] === '"')
                ? $m[1][0]
                : '';
            $url = ($quote === '')
                ? $m[1]
                : substr($m[1], 1, strlen($m[1]) - 2);
        }
        if ('/' !== $url[0]) {
            if (strpos($url, '//') > 0) {
                // probably starts with protocol, do not alter
            } else {
                // relative URI, rewrite!
                if (self::$_tempPrepend) {
                    $url = self::$_tempPrepend . $url;    
                } else {
                    // rewrite absolute url from scratch!
                    // prepend path with current dir separator (OS-independent)
                    $path = self::$_tempCurrentDir 
                        . DIRECTORY_SEPARATOR . strtr($url, '/', DIRECTORY_SEPARATOR);
                    // strip doc root
                    $path = substr($path, strlen(realpath($_SERVER['DOCUMENT_ROOT'])));
                    // fix to absolute URL
                    $url = strtr($path, DIRECTORY_SEPARATOR, '/');
                    // remove /./ and /../ where possible
                    $url = str_replace('/./', '/', $url);
                    // inspired by patch from Oleg Cherniy
                    do {
                        $url = preg_replace('@/[^/]+/\\.\\./@', '/', $url, -1, $changed);
                    } while ($changed);
                }
            }
        }
        return $isImport 
            ? "@import {$quote}{$url}{$quote}"
            : "url({$quote}{$url}{$quote})";
    }
    
    /**
     * Process a font-family listing and return a replacement
     * 
     * @param array $m regex matches
     * 
     * @return string   
     */
    protected static function _fontFamilyCB($m)
    {
        $m[1] = preg_replace('/
                \\s*
                (
                    "[^"]+"      # 1 = family in double qutoes
                    |\'[^\']+\'  # or 1 = family in single quotes
                    |[\\w\\-]+   # or 1 = unquoted family
                )
                \\s*
            /x', '$1', $m[1]);
        return 'font-family:' . $m[1] . $m[2];
    }
}

/**
 * Class Minify_CommentPreserver 
 * @package Minify
 */

/**
 * Process a string in pieces preserving C-style comments that begin with "/*!"
 * 
 * @package Minify
 * @author Stephen Clay <steve@mrclay.org>
 */
class Minify_CommentPreserver {
    
    /**
     * String to be prepended to each preserved comment
     *
     * @var string
     */
    public static $prepend = "\n";
    
    /**
     * String to be appended to each preserved comment
     *
     * @var string
     */
    public static $append = "\n";
    
    /**
     * Process a string outside of C-style comments that begin with "/*!"
     *
     * On each non-empty string outside these comments, the given processor 
     * function will be called. The first "!" will be removed from the 
     * preserved comments, and the comments will be surrounded by 
     * Minify_CommentPreserver::$preprend and Minify_CommentPreserver::$append.
     * 
     * @param string $content
     * @param callback $processor function
     * @param array $args array of extra arguments to pass to the processor 
     * function (default = array())
     * @return string
     */
    public static function process($content, $processor, $args = array())
    {
        $ret = '';
        while (true) {
            list($beforeComment, $comment, $afterComment) = self::_nextComment($content);
            if ('' !== $beforeComment) {
                $callArgs = $args;
                array_unshift($callArgs, $beforeComment);
                $ret .= call_user_func_array($processor, $callArgs);    
            }
            if (false === $comment) {
                break;
            }
            $ret .= $comment;
            $content = $afterComment;
        }
        return $ret;
    }
    
    /**
     * Extract comments that YUI Compressor preserves.
     * 
     * @param string $in input
     * 
     * @return array 3 elements are returned. If a YUI comment is found, the
     * 2nd element is the comment and the 1st and 2nd are the surrounding
     * strings. If no comment is found, the entire string is returned as the 
     * 1st element and the other two are false.
     */
    private static function _nextComment($in)
    {
        if (
            false === ($start = strpos($in, '/*!'))
            || false === ($end = strpos($in, '*/', $start + 3))
        ) {
            return array($in, false, false);
        }
        $ret = array(
            substr($in, 0, $start)
            ,self::$prepend . '/*' . substr($in, $start + 3, $end - $start - 1) . self::$append
        );
        $endChars = (strlen($in) - $end - 2);
        $ret[] = (0 === $endChars)
            ? ''
            : substr($in, -$endChars);
        return $ret;
    }
}