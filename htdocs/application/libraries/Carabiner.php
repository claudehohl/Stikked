<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// -------------------------------------------------------------------------------------------------
/**
 * Carabiner
 * Asset Management Library
 * 
 * Carabiner manages javascript and CSS assets.  It will react differently depending on whether
 * it is in a production or development environment.  In a production environment, it will combine, 
 * minify, and cache assets. (As files are changed, new cache files will be generated.) In a 
 * development environment, it will simply include references to the original assets.
 *
 * Carabiner requires the JSMin {@link http://codeigniter.com/forums/viewthread/103039/ released here}
 * and CSSMin {@link http://codeigniter.com/forums/viewthread/103269/ released here} libraries included.
 * You don't need to load them unless you'll be using them elsewhise.  Carabiner will load them
 * automatically as needed.
 *
 * Notes: Carabiner does not implement GZIP encoding, because I think that the web server should  
 * handle that.  If you need GZIP in an Asset Library, AssetLibPro {@link http://code.google.com/p/assetlib-pro/}
 * does it.  I've also chosen not to implement any kind of javascript obfuscation (like packer), 
 * because of the client-side decompression overhead. More about this idea from {@link http://ejohn.org/blog/library-loading-speed/ John Resig}.
 * However, that's not to say you can't do it.  You can easily provide a production version of a script
 * that is packed.  However, note that combining a packed script with minified scripts could cause
 * problems.  In that case, you can flag it to be not combined.
 *
 * Carabiner is inspired by Minify {@link http://code.google.com/p/minify/ by Steve Clay}, PHP 
 * Combine {@link http://rakaz.nl/extra/code/combine/ by Niels Leenheer} and AssetLibPro 
 * {@link http://code.google.com/p/assetlib-pro/ by Vincent Esche}, among other things.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Asset Management
 * @author		Tony Dewan <tonydewan.com/contact>	
 * @version		1.45
 * @license		http://www.opensource.org/licenses/bsd-license.php BSD licensed.
 *
 * @todo		fix new bugs. Duh.
 * @todo		check for 'absolute' path in asset references
 */

/*
	===============================================================================================
	 USAGE
	===============================================================================================
	
	Load the library as normal:
	-----------------------------------------------------------------------------------------------
		$this->load->library('carabiner');
	-----------------------------------------------------------------------------------------------
	
	Configuration can happen in either a config file (included), or by passing an array of values 
	to the config() method. Config options passed to the config() method will override options in 
	the	config file.
	
	See the included config file for more info.
	
	To configure Carabiner using the config() method, do this:
	-----------------------------------------------------------------------------------------------
		$carabiner_config = array(
			'script_dir' => 'assets/scripts/', 
			'style_dir'  => 'assets/styles/',
			'cache_dir'  => 'assets/cache/',
			'base_uri'	 => base_url(),
			'combine'	 => TRUE,
			'dev' 		 => FALSE,
			'minify_js'  => TRUE,
			'minify_css' => TRUE
		);
		
		$this->carabiner->config($carabiner_config);
	-----------------------------------------------------------------------------------------------
	
	
	There are 9 options. 3 are required:
	
	script_dir
	STRING Path to the script directory.  Relative to the CI front controller (index.php)
	
	style_dir
	STRING Path to the style directory.  Relative to the CI front controller (index.php)
	
	cache_dir
	STRING Path to the cache directory.  Must be writable. Relative to the CI front controller (index.php)
	
	
	6 are not required:

	base_uri
	STRING Base uri of the site, like http://www.example.com/ Defaults to the CI config value for 
	base_url.
	
	dev
	BOOL Flags whether your in a development environment or not.  See above for what this means.  
	Defaults to FALSE.
	
	combine
	BOOLEAN Flags whether to combine files.  Defaults to TRUE.
	
	minify_js
	BOOLEAN Flags whether to minify javascript. Defaults to TRUE.
	
	minify_css
	BOOLEAN Flags whether to minify CSS. Defaults to TRUE.
	
	force_curl
	BOOLEAN Flags whether cURL should always be used for URL file references. Defaults to FALSE.
	
	
	Add assets like so:
	-----------------------------------------------------------------------------------------------
		// add a js file
		$this->carabiner->js('scripts.js');
		
		// add a css file
		$this->carabiner->css('reset.css');
		
		// add a css file with a mediatype
		$this->carabiner->css('admin/print.css','print');
	-----------------------------------------------------------------------------------------------
	
	
	To set a (prebuilt) production version of an asset:
	-----------------------------------------------------------------------------------------------
		// JS: pass a second string to the method with a path to the production version
		$this->carabiner->js('wymeditor/wymeditor.js', 'wymeditor/wymeditor.pack.js' );

		// add a css file with prebuilt production version
		$this->carabiner->css('framework/type.css', 'screen', 'framework/type.pack.css');
	-----------------------------------------------------------------------------------------------
	
	
	And to prevent an individual asset file from being combined:
	-----------------------------------------------------------------------------------------------
		// JS: pass a boolean FALSE as the third attribute of the method
		$this->carabiner->js('wymeditor/wymeditor.js', 'wymeditor.pack.js', FALSE );

		// CSS: pass a boolean FALSE as the fourth attribute of the method
		$this->carabiner->css('framework/type.css', 'screen', 'framework/type.pack.css', FALSE);
	-----------------------------------------------------------------------------------------------
	
	
	You can also pass arrays (and arrays of arrays) to these methods. Like so:	
	-----------------------------------------------------------------------------------------------
		// a single array (this is redundant, but supported anyway)
		$this->carabiner->css( array('mobile.css', 'handheld', 'mobile.prod.css') );
		
		// an array of arrays
		$js_assets = array(
			array('dev/jquery.js', 'prod/jquery.js'),
			array('dev/jquery.ext.js', 'prod/jquery.ext.js'),
		)
		
		$this->carabiner->js( $js_assets );
	-----------------------------------------------------------------------------------------------
	

	Carabiner is smart enough to recognize URLs and treat them differently:
	-----------------------------------------------------------------------------------------------
		$this->carabiner->js('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js');
	-----------------------------------------------------------------------------------------------
	

	You can also define groups of assets
	-----------------------------------------------------------------------------------------------
		// Define JS
		$js = array(
			array('prototype.js'),
			array('scriptaculous.js')
		);

		// create group
		$this->carabiner->group('prototaculous', array('js'=>$js) );
		

		// an IE only group
		$css = array('iefix.css');
		$js = array('iefix.js');
		$this->carabiner->group('iefix', array('js'=>$js, 'css'=>$js) );
		
		// you can even assign an asset to a group individually 
		// by passing the group name to the last parameter of the css/js functions
		$this->carabiner->css('spec.css', 'screen', 'spec-min.css', TRUE, FALSE, 'spec');
	-----------------------------------------------------------------------------------------------

	
	To output your assets, including appropriate markup:
	-----------------------------------------------------------------------------------------------
		// display css
		$this->carabiner->display('css');
		
		//display js
		$this->carabiner->display('js');
		
		// display both
		$this->carabiner->display(); // OR $this->carabiner->display('both');
		
		// display group
		$this->carabiner->display('jquery'); // group name defined as jquery

		// display filterd group
		$this->carabiner->display('main', 'js'); // group name defined as main, only display JS
		
		// return string of asset references
		$string = $this->carabiner->display_string('main');
	-----------------------------------------------------------------------------------------------
	Note that the standard display function calls (the first 3 listed above) will only output
	those assets not associated with a group (which are all included in the 'main' group).  Groups 
	must be explicitly displayed via the 4th call listed above.
	
	
	
	Since Carabiner won't delete old cached files, you'll need to clear them out manually.  
	To do so programatically:
	-----------------------------------------------------------------------------------------------
		// clear css cache
		$this->carabiner->empty_cache('css');
		
		//clear js cache
		$this->carabiner->empty_cache('js');
		
		// clear both
		$this->carabiner->empty_cache(); // OR $this->carabiner->empty_cache('both');
	
		// clear before a certain date
		$this->carabiner->empty_cache('both', 'now');	// String denoting a time before which cache 
														// files will be removed.  Any string that 
														// strtotime() can take is acceptable. 
														// Defaults to 'now'.
	-----------------------------------------------------------------------------------------------	
	===============================================================================================
*/

class Carabiner {
    
    public $base_uri = '';
    
    public $script_dir  = '';
	public $script_path = '';
	public $script_uri  = '';
	
	public $style_dir  = '';
	public $style_path = '';
	public $style_uri  = '';
	
	public $cache_dir  = '';
	public $cache_path = '';
	public $cache_uri  = '';
	
	public $dev     = FALSE;
	public $combine = TRUE;
	
	public $minify_js  = TRUE;
	public $minify_css = TRUE;
	public $force_curl = FALSE;
	
	private $js  = array('main'=>array());
	private $css = array('main'=>array());
	private $loaded = array();
	
    private $CI;
	
	
	/** 
	* Class Constructor
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
		log_message('debug', 'Carabiner: Library initialized.');
		
		if( $this->CI->config->load('carabiner', TRUE, TRUE) ){
		
			log_message('debug', 'Carabiner: config loaded from config file.');
			
			$carabiner_config = $this->CI->config->item('carabiner');
			$this->config($carabiner_config);
		}
		
	}


	/** 
	* Load Config
	* @access	public
	* @param	Array of config variables. Requires script_dir(string), style_dir(string), and cache_dir(string).
	*			base_uri(string), dev(bool), combine(bool), minify_js(bool), minify_css(bool), and force_curl(bool) are optional.
	* @return   Void
	*/	
	public function config($config)
	{	

		foreach ($config as $key => $value)
		{
			if($key == 'groups') {
				
				foreach($value as $group_name => $assets){
					
					$this->group($group_name, $assets);
				}
				
				break;
			}
			
			$this->$key = $value;
		}
		
		
		
		// set the default value for base_uri from the config
		if($this->base_uri == '') $this->base_uri = $this->CI->config->item('base_url');

		// use the provided values to define the rest of them
		$this->script_path = FCPATH.$this->script_dir;
		$this->script_uri = $this->base_uri.$this->script_dir;
		
		$this->style_path = FCPATH.$this->style_dir;
		$this->style_uri = $this->base_uri.$this->style_dir;

		$this->cache_path = FCPATH.$this->cache_dir;
		$this->cache_uri = $this->base_uri.$this->cache_dir;

		log_message('debug', 'Carabiner: library configured.');
	}
	
	
	/** 
	* Add JS file to queue
	* @access	public
	* @param	String of the path to development version of the JS file.  Could also be an array, or array of arrays.
	* @param	String of the path to production version of the JS file. NOT REQUIRED
	* @param	Boolean flag whether the file is to be combined. NOT REQUIRED
	* @param	String of the group name with which the asset is to be associated. NOT REQUIRED
	* @return   Void
	*/	
	public function js($dev_file, $prod_file = '', $combine = TRUE, $minify = TRUE, $group = 'main')
	{	
	
		if( is_array($dev_file) ){
			
			if( is_array($dev_file[0]) ){
			
				foreach($dev_file as $file){
					
					$d = $file[0];
					$p = (isset($file[1])) ? $file[1] : '';
					$c = (isset($file[2])) ? $file[2] : $combine;
					$m = (isset($file[3])) ? $file[3] : $minify;
					$g = (isset($file[4])) ? $file[4] : $group;
					
					$this->_asset('js', $d, $p, $c, $m, NULL, $g);
				
				}
				
			}else{
				
				$d = $dev_file[0];
				$p = (isset($dev_file[1])) ? $dev_file[1] : '';
				$c = (isset($dev_file[2])) ? $dev_file[2] : $combine;
				$m = (isset($dev_file[3])) ? $dev_file[3] : $minify;
				$g = (isset($dev_file[4])) ? $dev_file[4] : $group;
				
				$this->_asset('js', $d, $p, $c, $m, NULL, $g);
				
			}

		}else{
		
			$this->_asset('js', $dev_file, $prod_file, $combine, $minify, NULL, $group);

		}
	}
	
	
	
	/**
	* Add CSS file to queue
	* @access	public
	* @param	String of the path to development version of the CSS file. Could also be an array, or array of arrays.
	* @param	String of the media type, usually one of (screen, print, handheld) for css. Defaults to screen.
	* @param	String of the path to production version of the CSS file. NOT REQUIRED
	* @param	Boolean flag whether the file is to be combined. NOT REQUIRED
	* @param	Boolean flag whether the file is to be minified. NOT REQUIRED
	* @param	String of the group name with which the asset is to be associated. NOT REQUIRED
	* @return   Void
	*/		
	public function css($dev_file, $media = 'screen', $prod_file = '', $combine = TRUE, $minify = TRUE, $group = 'main')
	{

		if( is_array($dev_file) ){
			
			if( is_array($dev_file[0]) ){
			
				foreach($dev_file as $file){
					
					$d = $file[0];
					$m = (isset($file[1])) ? $file[1] : $media;
					$p = (isset($file[2])) ? $file[2] : '';
					$c = (isset($file[3])) ? $file[3] : $combine;
					$y = (isset($file[4])) ? $file[4] : $minify;
					$g = (isset($file[5])) ? $file[5] : $group;

					$this->_asset('css', $d, $p, $c, $y, $m, $g);
				
				}
				
			}else{

				$d = $dev_file[0];
				$m = (isset($dev_file[1])) ? $dev_file[1] : $media;
				$p = (isset($dev_file[2])) ? $dev_file[2] : '';
				$c = (isset($dev_file[3])) ? $dev_file[3] : $combine;
				$y = (isset($dev_file[4])) ? $dev_file[4] : $minify;
				$g = (isset($dev_file[5])) ? $dev_file[5] : $group;
									
				$this->_asset('css', $d, $p, $c, $y, $m, $g);
				
			}
			
		}else{
		
			$this->_asset('css', $dev_file, $prod_file, $combine, $minify, $media, $group);
	
		}
	}
	
	
	/**
	* Add Assets to a group
	* @access	public
	* @param	String of the name of the group.  should not contain spaces or punctuation
	* @param	array of assets to be included in the group
	* @return   Void
	*/		
	public function group($group_name, $assets)
	{

		if(!isset($assets['js']) && !isset($assets['css']) ){
			log_message('error', "Carabiner: The asset group definition named '{$group_name}' does not contain a well formed array.");
			return;
		}

		if( isset($assets['js']) )
			$this->js($assets['js'], '', TRUE, TRUE, $group_name);
			
		if( isset($assets['css']) )
			$this->css($assets['css'], 'screen', '', TRUE, TRUE, $group_name);

	}
	
	
	
	/**
	* Add an asset to queue
	* @access	private
	* @param	String of the type of asset (lowercase). css | js
	* @param	String of the path to development version of the asset.
	* @param	String of the path to production version of the asset. NOT REQUIRED
	* @param	Boolean flag whether the file is to be combined. Defaults to true. NOT REQUIRED
	* @param	Boolean flag whether the file is to be minified. Defaults to true. NOT REQUIRED
	* @param	String of the media type associated with the asset.  Only applicable to CSS assets. NOT REQUIRED
	* @param	String of the group name with which the asset is to be associated. NOT REQUIRED
	* @return   Void
	*/		
	private function _asset($type, $dev_file, $prod_file = '', $combine = TRUE, $minify = TRUE, $media = 'screen', $group = 'main')
	{
		if ($type == 'css') : 
		
			$this->css[$group][$media][] = array( 'dev'=>$dev_file );
			$index = count($this->css[$group][$media]) - 1;

			if($prod_file != '') $this->css[$group][$media][$index]['prod'] = $prod_file;
			$this->css[$group][$media][$index]['combine'] = $combine;
			$this->css[$group][$media][$index]['minify'] = $minify;
			
		else : 

			$this->js[$group][] = array( 'dev'=>$dev_file );
			$index = count($this->js[$group]) - 1;
			
			if($prod_file != '') $this->js[$group][$index]['prod'] = $prod_file;
			$this->js[$group][$index]['combine'] = $combine;
			$this->js[$group][$index]['minify'] = $minify;
			
		endif;
	
	}


	/** 
	* Display HTML references to the assets
	* @access	public
	* @param	String flag the asset type: css || js || both, OR the group name
	* @param	String flag the asset type to filter a group (e.g. only show 'js' for this group)
	* @return   Void
	*/		
	public function display($flag = 'both', $group_filter = NULL)
	{	

		switch($flag){
			
			case 'JS':
			case 'js':
				$this->_display_js();
			break;
			
			case 'CSS':
			case 'css':
				$this->_display_css();
			break;
			
			case 'both':
				$this->_display_js();
				$this->_display_css();
			break;
			
			default:
				if( isset($this->js[$flag]) && ($group_filter == NULL || $group_filter == 'js') )
					$this->_display_js($flag);
				
				if( isset($this->css[$flag]) && ($group_filter == NULL || $group_filter == 'css') )
					$this->_display_css($flag);
			break;
		}
	}


	/** 
	* HTML references to the assets, returned as a string
	* @access	public
	* @param	String flag the asset type: css || js || both, OR the group name
	* @return   String of HTML references
	*/
	public function display_string($flag='both', $group_filter = NULL)
	{
		ob_start(); // note: according to the manual, nesting ob calls is okay
					// so this shouldn't cause any problems even if you're using ob already
		
			$this->display($flag, $group_filter);
		
			$contents = ob_get_contents();

		ob_end_clean();
		
		return $contents;

	}

	
	/** 
	* Display HTML references to the js assets
	* @access	private
	* @param	String of the asset group name
	* @return   Void
	*/		
	private function _display_js($group = 'main')
	{

		if( empty($this->js) ) return; // if there aren't any js files, just stop!
		
		if( !isset($this->js[$group]) ): // the group you asked for doesn't exist. This should never happen, but better to be safe than sorry.

			log_message('error', "Carabiner: The JavaScript asset group named '{$group}' does not exist.");
			return;
		
		endif;
		
		// if we're in a dev environment
		if($this->dev){
				
			foreach($this->js[$group] as $ref):
			
				echo $this->_tag('js', $ref['dev']);
				
			endforeach;				

		
		// if we're combining files and minifying them
		} elseif($this->combine && $this->minify_js) {

			$lastmodified = 0;
			$files = array();
			$filenames = '';
			
			
			foreach($this->js[$group] as $ref):

				// get the last modified date of the most recently modified file
				$lastmodified = max( $lastmodified , filemtime(realpath($this->script_path.$ref['dev'])) );

				$filenames .= $ref['dev'];

				if(!$ref['combine']):
					echo (isset($ref['prod'])) ? $this->_tag('js', $ref['prod']) : $this->_tag('js', $ref['dev']);					
				elseif(!$ref['minify']):
					$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'], 'minify'=>$ref['minify'] ) : array('dev'=>$ref['dev'], 'minify'=>$ref['minify']);
				else:
					$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'] ) : array('dev'=>$ref['dev']);
				endif;
				
			endforeach;

			$lastmodified = ($lastmodified == 0) ? '0000000000' : $lastmodified;
			
			$filename = $lastmodified . md5($filenames).'.js';
			
			if( !file_exists($this->cache_path.$filename) )	$this->_combine('js', $files, $filename);

			echo $this->_tag('js', $filename, TRUE);


		// if we're combining files but not minifying
		} elseif($this->combine && !$this->minify_js) {

			$lastmodified = 0;
			$files = array();
			$filenames = '';

				
			foreach($this->js[$group] as $ref):
			
				// get the last modified date of the most recently modified file
				$lastmodified = max( $lastmodified , filemtime(realpath($this->script_path.$ref['dev'])) );

				$filenames .= $ref['dev'];

				if(!$ref['combine']):
					echo (isset($ref['prod'])) ? $this->_tag('js', $ref['prod']) : $this->_tag('js', $ref['dev']);					
				else:
					$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'], 'minify'=> FALSE ) : array('dev'=>$ref['dev'], 'minify'=> FALSE);
				endif;
				
			endforeach;

			$lastmodified = ($lastmodified == 0) ? '0000000000' : $lastmodified;
			
			$filename = $lastmodified . md5($filenames).'.js';
			
			if( !file_exists($this->cache_path.$filename) )	$this->_combine('js', $files, $filename);

			echo $this->_tag('js', $filename, TRUE);
			


		// if we're minifying. but not combining
		} elseif(!$this->combine && $this->minify_js) {

				
			foreach($this->js[$group] as $ref):
			
				if( isset( $ref['prod']) ){
			
					$f = $ref['prod'];
			
				} elseif( !$ref['minify'] ){
				
					$f = $ref['dev'];
			
				} else {
			
					$f = filemtime( realpath( $this->script_path . $ref['dev'] ) ) . md5($ref['dev']) . '.js';

					if( !file_exists($this->cache_path.$f) ):

						$c = $this->_minify( 'js', $ref['dev'] );
						$this->_cache($f, $c);
				
					endif;
				
				}
			
				echo $this->_tag('js', $f, TRUE);
				
			endforeach;

			
		// we're not in dev mode, but combining isn't okay and minifying isn't allowed.
		// -- this will just display the production version if there is one, dev if there isn't.
		}else{
				
			foreach($this->js[$group] as $ref):
		
				$f = (isset($ref['prod'])) ? $ref['prod'] : $ref['dev'];
				echo $this->_tag('js', $f);
			
			endforeach;				

						
		}

	}



	/** 
	* Display HTML references to the css assets
	* @access	private
	* @param	String of the asset group name
	* @return   Void
	*/		
	private function _display_css($group = 'main')
	{

		if( empty($this->css) ) return; // there aren't any css assets, so just stop!

		if( !isset($this->css[$group]) ): // the group you asked for doesn't exist. This should never happen, but better to be safe than sorry.

			log_message('error', "Carabiner: The CSS asset group named '{$group}' does not exist.");
			return;
		
		endif;
		
		if($this->dev){ // we're in a development environment
				
			foreach($this->css[$group] as $media => $refs):
		
				foreach($refs as $ref):

					echo $this->_tag('css', $ref['dev'], FALSE, $media);
			
				endforeach;
			
			endforeach;				

			
		} elseif($this->combine && $this->minify_css) { // we're combining and minifying

			foreach($this->css[$group] as $media => $refs):
	
				// lets try to cache it, shall we?
				$lastmodified = 0;
				$files = array();
				$filenames = '';
		
				foreach ($refs as $ref):
		
					$lastmodified = max($lastmodified, filemtime( realpath( $this->style_path . $ref['dev'] ) ) );
					$filenames .= $ref['dev'];
			
					if(!$ref['combine']):
						echo (isset($ref['prod'])) ? $this->_tag('css', $ref['prod'], $media) : $this->_tag('css', $ref['dev'], $media);
					elseif(!$ref['minify']):
						$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'], 'minify'=>$ref['minify'] ) : array('dev'=>$ref['dev'], 'minify'=>$ref['minify']);
					else:
						$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'] ) : array('dev'=>$ref['dev']);
					endif;	
									
				endforeach;
				
				$lastmodified = ($lastmodified == 0) ? '0000000000' : $lastmodified;
				
				$filename = $lastmodified . md5($filenames).'.css';
		
				if( !file_exists($this->cache_path.$filename) ) $this->_combine('css', $files, $filename);

				echo $this->_tag('css',  $filename, TRUE, $media);
		
			endforeach;
			

		
		} elseif($this->combine && !$this->minify_css) { // we're combining bot not minifying
			
			foreach($this->css[$group] as $media => $refs):
		
				// lets try to cache it, shall we?
				$lastmodified = 0;
				$files = array();
				$filenames = '';
			
				foreach ($refs as $ref):
			
					$lastmodified = max($lastmodified, filemtime( realpath( $this->style_path . $ref['dev'] ) ) );
					$filenames .= $ref['dev'];
				
					if($ref['combine'] == false):
						echo (isset($ref['prod'])) ? $this->_tag('css', $ref['prod'], $media) : $this->_tag('css', $ref['dev'], $media);
					else:
						$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'], 'minify'=>FALSE ) : array('dev'=>$ref['dev'], 'minify'=>FALSE);
					endif;
				
				endforeach;
				
				$lastmodified = ($lastmodified == 0) ? '0000000000' : $lastmodified;
				
				$filename = $lastmodified . md5($filenames).'.css';
			
				if( !file_exists($this->cache_path.$filename) ) $this->_combine('css', $files, $filename);

				echo $this->_tag('css',  $filename, TRUE, $media);
			
			endforeach;


		
		} elseif(!$this->combine && $this->minify_css) { // we want to minify, but not combine
			
			foreach($this->css[$group] as $media => $refs):
		
				foreach($refs as $ref):
				
					if( isset($ref['prod']) ){
				
						$f = $this->style_uri . $ref['prod'];

					} elseif( !$ref['minify'] ){
				
						$f = $this->style_uri . $ref['dev'];
				
					} else {
				
						$f = filemtime( realpath( $this->style_path . $ref['dev'] ) ) . md5($ref['dev']) . '.css';
				
						if( !file_exists($this->cache_path.$f) ):

							$c = $this->_minify( 'css', $ref['dev'] );
							$this->_cache($f, $c);
					
						endif;
					}

					echo $this->_tag('css', $f, TRUE, $media);
		
				endforeach;
			
			endforeach;

			
		
		}else{ // we're in a production environment, but not minifying or combining.
	
			foreach($this->css[$group] as $media => $refs):
		
				foreach($refs as $ref):
				
					$f = (isset($ref['prod'])) ? $ref['prod'] : $ref['dev'];
					echo $this->_tag('css', $f, FALSE, $media);
			
				endforeach;	
			
			endforeach;	

		}

	}
	
	
	/** 
	* Internal function for compressing/combining scripts
	* @access	private
	* @param	String flag the asset type: css|js
	* @param	array of file references to be combined. Should contain arrays, as included in primary asset arrays: ('dev'=>$dev, 'prod'=>$prod, 'minify'=>TRUE||FALSE)
	* @param	String of the filename of the file-to-be
	* @return   Void
	*/
	private function _combine($flag, $files, $filename)
	{

		$file_data = '';
		
		$path = ($flag == 'css') ? $this->style_path : $this->script_path;
		$minify = ($flag == 'css') ? $this->minify_css : $this->minify_js;
		
	
		foreach($files as $file):
			
			$v = (isset($file['prod']) ) ? 'prod' : 'dev';
			
			if( (isset($file['minify']) && $file['minify'] == true) || (!isset($file['minify']) && $minify) ):
				
				$file_data .=  $this->_minify( $flag, $file['dev'] ) . "\n";
				
			else:
			
				$r = ( $this->isURL($file[$v]) ) ? $file[$v] : realpath($path.$file[$v]);
				$file_data .=  $this->_get_contents( $r ) ."\n";
				
			endif;
		
		endforeach;
		
		$this->_cache( $filename, $file_data );

	}


	/** 
	* Internal function for minifying assets
	* @access	private
	* @param	String flag the asset type: css|js
	* @param	String of the path to the file whose contents should be minified
	* @return   String minified contents of file
	*/
	private function _minify($flag, $file_ref)
	{
		
		$path = ($flag == 'css') ? $this->style_path : $this->script_path;
		$ref  = ( $this->isURL($file_ref) ) ? $file_ref : realpath($path.$file_ref);

        //hack for stikked themes
        if(!file_exists($ref)){
            $path = ($flag == 'css') ? 'themes/default/css/' : $this->script_path;
            $ref  = ( $this->isURL($file_ref) ) ? $file_ref : realpath($path.$file_ref);
        }

		switch($flag){
			
			case 'js':
			
				$this->_load('jsmin');
				
				$contents = $this->_get_contents( $ref );
				return $this->CI->jsmin->minify($contents);
			
			break;
			
			
			case 'css':
			
				$this->_load('cssmin');
				
				$rel = ( $this->isURL($file_ref) ) ? $file_ref : dirname($this->style_uri.$file_ref).'/';
				$this->CI->cssmin->config(array('relativePath'=>$rel));

				$contents = $this->_get_contents( $ref );
				return $this->CI->cssmin->minify($contents);
			
			break;
		}
	
	}

	/** 
	* Internal function for getting a files contents, using cURL or file_get_contents, depending on circumstances
    * @access	private
	* @param	String of full path to the file (or full URL, if appropriate)
	* @return   String of files contents
	*/
	private function _get_contents($ref)
	{

		$contents = false;
		if( $this->isURL($ref) && ( ini_get('allow_url_fopen') == 0 || $this->force_curl ) ):

			$this->_load('curl');
			$contents = $this->CI->curl->simple_get($ref);
			
		else:
			if($ref){
				$contents = file_get_contents( $ref );
			}
			
		endif;
		
		return $contents;
		
	}
	
	/** 
	* Internal function for writing cache files
	* @access	private
	* @param	String of filename of the new file
	* @param	String of contents of the new file
	* @return   boolean	Returns true on successful cache, false on failure
	*/
	private function _cache($filename, $file_data)
	{
		
		if(empty($file_data)):
			log_message('debug', 'Carabiner: Cache file '.$filename.' was empty and therefore not written to disk at '.$this->cache_path);
			return false;
		endif;
		
		$filepath = $this->cache_path . $filename;
		$success = file_put_contents( $filepath, $file_data );
		
		if($success) : 
			log_message('debug', 'Carabiner: Cache file '.$filename.' was written to '.$this->cache_path);
			return TRUE;
		else : 
			log_message('error', 'Carabiner: There was an error writing cache file '.$filename.' to '.$this->cache_path);
			return FALSE;
		endif;
	}
	
	
	/** 
	* Internal function for making tag strings
	* @access	private
	* @param	String flag for type: css|js
	* @param	String of reference of file. 
	* @param	Boolean flag for cache dir.  Defaults to FALSE.
	* @param	String Media type for the tag.  Only applies to CSS links. defaults to 'screen'
	* @return	String containing an HTML tag reference to given reference
	*/
	private function _tag($flag, $ref, $cache = FALSE, $media = 'screen')
	{

		switch($flag){
		
			case 'css':
				
				$dir = ( $this->isURL($ref) ) ? '' : ( ($cache) ? $this->cache_uri : $this->style_uri );
				
				return '<link type="text/css" rel="stylesheet" href="'.$dir.$ref.'" media="'.$media.'" />'."\r\n";
			
			break;

			case 'js':
				
				$dir = ( $this->isURL($ref) ) ? '' : ( ($cache) ? $this->cache_uri : $this->script_uri );
				
				return '<script type="text/javascript" src="'.$dir.$ref.'" charset="'.$this->CI->config->item('charset').'"></script>'."\r\n";
			
			break;
		
		}
	
	}	
	
	
	/** 
	* Function used to clear the asset cache. If no flag is set, both CSS and JS will be emptied.
	* @access	public
	* @param	String flag the asset type: css|js|both
	* @param	String denoting a time before which cache files will be removed.  Any string that strtotime() can take is acceptable. Defaults to now.
	* @return   Void
	*/		
	public function empty_cache($flag = 'both', $before = 'now')
	{

		$this->CI->load->helper('file');
		
		$files = get_filenames($this->cache_path);
		$before = strtotime($before);
		
		switch($flag){

			case 'js':
			case 'css':
			
				foreach( $files as $file ){
					
					$ext = substr( strrchr( $file, '.' ), 1 );
					$fl = strlen(substr( $file, 0, -(strlen($flag)+1) ));
					
					if ( ($ext == $flag) && $fl >= 42 && ( filemtime( $this->cache_path . $file ) < $before) ) {
			
						$success = unlink( $this->cache_path . $file );
					
						if($success) : log_message('debug', 'Carabiner: Cache file '.$file.' was removed from '.$this->cache_path);
						else : log_message('error', 'Carabiner: There was an error removing cache file '.$file.' from '.$this->cache_path);
						endif;
						
					}
					
				}
			
			break;
			
			case 'both':
			default:
			
				foreach( $files as $file ){
					
					$ext = substr( strrchr( $file, '.' ), 1 );
					$fl = strlen(substr( $file, 0, -3 ));

					if ( ($ext == 'js' || $ext == 'css') && $fl >= 42 && ( filemtime( $this->cache_path . $file ) < $before) ) {
						
						$success = unlink( $this->cache_path . $file );
						
						if($success) : log_message('debug', 'Carabiner: Cache file '.$file.' was removed from '.$this->cache_path);
						else : log_message('error', 'Carabiner: There was an error removing cache file '.$file.' from '.$this->cache_path);
						endif;
					}
					
				}	
				
			break;
		
		}			
	
	}

	/** 
	* Function used to prevent multiple load calls for the same CI library
	* @access	private
	* @param	String library name
	* @return   FALSE on empty call and when library is already loaded, TRUE when library loaded
	*/
	private function _load($lib=NULL)
	{
		if($lib == NULL) return FALSE;
		
		if( isset($this->loaded[$lib]) ):
			return FALSE;
		else:
			$this->CI->load->library($lib);
			$this->loaded[$lib] = TRUE;

			log_message('debug', 'Carabiner: Codeigniter library '."'$lib'".' loaded');
			return TRUE;
		endif;
	}
	
	
	/**
	* isURL
	* Checks if the provided string is a URL. Allows for port, path and query string validations.  
	* This should probably be moved into a helper file, but I hate to add a whole new file for 
	* one little 2-line function.
	* @access	public
	* @param	string to be checked
	* @return   boolean	Returns TRUE/FALSE
	*/
	public static function isURL($string)
	{
		$pattern = '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@';
		return preg_match($pattern, $string);
	}
}
