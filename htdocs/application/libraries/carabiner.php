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
 * You don't need to include them, unless you'll be using them elsewhise.  Carabiner will include them
 * automatically as needed.
 *
 * Notes: Carabiner does not implement GZIP encoding, because I think that the web server should  
 * handle that.  If you need GZIP in an Asset Library, AssetLibPro {@link http://code.google.com/p/assetlib-pro/ }
 * does it.  I've also chosen not to implement any kind of javascript obfuscation (like packer), 
 * because of the client-side decompression overhead. More about this idea from {@link http://ejohn.org/blog/library-loading-speed/ John Resig }.
 * However, that's not to say you can't do it.  You can easily provide a production version of a script
 * that is packed.  However, note that combining a packed script with minified scripts could cause
 * problems.  In that case, you can flag it to be not combined.
 *
 * Carabiner is inspired by PHP Combine {@link http://rakaz.nl/extra/code/combine/ by Niels Leenheer }
 * and AssetLibPro {@link http://code.google.com/p/assetlib-pro/ by Vincent Esche }, among others.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Asset Management
 * @author		Tony Dewan <tonydewan.com>	
 * @version		1.2
 * @license		http://www.opensource.org/licenses/bsd-license.php BSD licensed.
 */

/*
	===============================================================================================
	 USAGE
	===============================================================================================
	
	Load the library as normal:
	-----------------------------------------------------------------------------------------------
		$this->load->library('carabiner');
	-----------------------------------------------------------------------------------------------
	
	Configure it like so:
	-----------------------------------------------------------------------------------------------
		$carabiner_config = array(
			'script_dir' => 'assets/scripts/', 
			'style_dir'  => 'assets/styles/',
			'cache_dir'  => 'assets/cache/',
			'base_uri'	 => $base,
			'combine'	 => TRUE,
			'dev' 		 => FALSE
		);
		
		$this->carabiner->config($carabiner_config);
	-----------------------------------------------------------------------------------------------
	
	
	There are 8 options. 4 are required:
	
	script_dir
	STRING Path to the script directory.  Relative to the CI front controller (index.php)
	
	style_dir
	STRING Path to the style directory.  Relative to the CI front controller (index.php)
	
	cache_dir
	STRING Path to the cache directory.  Must be writable. Relative to the CI front controller (index.php)
	
	base_uri
	STRING Base uri of the site, like http://www.example.com/
	
	
	4 are not required:
	
	dev
	BOOL Flags whether your in a development environment or not.  See above for what this means.  
	Defaults to FALSE.
	
	combine
	BOOLEAN Flags whether to combine files.  Defaults to TRUE.
	
	minify_js
	BOOLEAN Flags whether to minify javascript. Defaults to TRUE.
	
	minify_css
	BOOLEAN Flags whether to minify CSS. Defaults to TRUE.
	
	
	Add assets like so:
	-----------------------------------------------------------------------------------------------
		// add a js file
		$this->carabiner->js('scripts.js');
		
		// add a css file
		$this->carabiner->css('reset.css');
		
		// add a css file with a mediatype
		$this->carabiner->css('admin/print.css','print');
	-----------------------------------------------------------------------------------------------

	
	
	To set a (prebuilt) production version of a js asset:
	-----------------------------------------------------------------------------------------------
		// JS: pass a second string to the method with a path to the production version
		$this->carabiner->js('wymeditor/wymeditor.js', 'wymeditor/wymeditor.pack.js' );

		// add a css file with prebuilt production version
		$this->carabiner->css('framework/type.css', 'screen', 'framework/type.pack.css');
	-----------------------------------------------------------------------------------------------
	
	
	And to prevent a file from being combined:
	-----------------------------------------------------------------------------------------------
		// JS: pass a boolean FALSE as the third attribute of the method
		$this->carabiner->js('wymeditor/wymeditor.js', 'wymeditor.pack.js', FALSE );

		// CSS: pass a boolean FALSE as the fourth attribute of the method
		$this->carabiner->css('framework/type.css', 'screen', 'framework/type.pack.css', FALSE);
	-----------------------------------------------------------------------------------------------


	
	You can also pass arrays (and arrays of arrays) to these methods. Like so:	
	-----------------------------------------------------------------------------------------------
		// a single array
		$this->carabiner->css( array('mobile.css', 'handheld', 'mobile.prod.css') );
		
		// an array of arrays
		$js_assets = array(
			array('dev/jquery.js', 'prod/jquery.js'),
			array('dev/jquery.ext.js', 'prod/jquery.ext.js'),
		)
		
		$this->carabiner->js( $js_assets );
	-----------------------------------------------------------------------------------------------
	
	
	To output your assets, including appropriate markup:
	-----------------------------------------------------------------------------------------------
		// display css
		$this->carabiner->display('css');
		
		//display js
		$this->carabiner->display('js');
	-----------------------------------------------------------------------------------------------
	
	
	Since Carabiner won't delete old cached files, you'll need to clear them out manually.  
	To do so programatically:
	-----------------------------------------------------------------------------------------------
		// clear css cache
		$this->carabiner->empty_cache('css');
		
		//clear js cache
		$this->carabiner->empty_cache('js');
		
		// clear both
		$this->carabiner->empty_cache();
	-----------------------------------------------------------------------------------------------	
	===============================================================================================
*/

class Carabiner {
    
    var $base_uri = '';
    
    var $script_dir  = '';
	var $script_path = '';
	var $script_uri  = '';
	
	var $style_dir  = '';
	var $style_path = '';
	var $style_uri  = '';
	
	var $cache_dir  = '';
	var $cache_path = '';
	var $cache_uri  = '';
	
	var $dev     = FALSE;
	var $combine = TRUE;
	
	var $minify_js  = TRUE;
	var $minify_css = TRUE;
	
	var $js  = array();
	var $css = array();
	
    var $CI;
	
	
	/** 
	* Class Constructor
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
		log_message('debug', 'Carabiner Asset Management library initialized.');

	}


	/** 
	* Load Config
	* @param	Array of config variables. Requires script_dir(string), style_dir(string), cache_dir(string), and base_uri(string).
	*			dev(bool), combine(bool), minify_js(bool), minify_css(bool) are optional.
	*/	
	public function config($config)
	{
		foreach ($config as $key => $value)
		{
			$this->$key = $value;
		}

		// use the provided values to define the rest of them
		//$this->script_path = dirname(BASEPATH).'/'.$this->script_dir;
		$this->script_path = $this->script_dir;
		$this->script_uri = $this->base_uri.$this->script_dir;
		
		//$this->style_path = dirname(BASEPATH).'/'.$this->style_dir;
		$this->style_path = $this->style_dir;
		$this->style_uri = $this->base_uri.$this->style_dir;

		//$this->cache_path = dirname(BASEPATH).'/'.$this->cache_dir;
		$this->cache_path = $this->cache_dir;
		$this->cache_uri = $this->base_uri.$this->cache_dir;
	}
	
	
	
	/** 
	* Add JS file to queue
	* @param	String of the path to development version of the JS file.  Could also be an array, or array of arrays.
	* @param	String of the path to production version of the JS file. NOT REQUIRED
	* @param	Flag whether the file is to be combined NOT REQUIRED
	*/	
	public function js($dev_file, $prod_file = '', $combine = TRUE)
	{	
		
		if( is_array($dev_file) ){
			
			if( is_array($dev_file[0]) ){
			
				foreach($dev_file as $file){
					
					$d = $file[0];
					$p = (isset($file[1])) ? $file[1] : '';
					$c = (isset($file[2])) ? $file[2] : $combine;

					$this->_asset('js', $d, $p, $c);
				
				}
				
			}else{
				
				$d = $dev_file[0];
				$p = (isset($dev_file[1])) ? $dev_file[1] : '';
				$c = (isset($dev_file[2])) ? $dev_file[2] : $combine;
				
				$this->_asset('js', $d, $p, $c);
				
			}
			
		}else{
		
			$this->_asset('js', $dev_file, $prod_file, $combine);
	
		}
	}
	
	
	
	/**
	* Add CSS file to queue
	* @param	String of the path to development version of the CSS file. Could also be an array, or array of arrays.
	* @param	String of the media type, usually one of (screen, print, handheld) for css. Defaults to screen.
	* @param	String of the path to production version of the CSS file. NOT REQUIRED
	* @param	Flag whether the file is to be combined. NOT REQUIRED
	*/		
	public function css($dev_file, $media = 'all', $prod_file = '', $combine = TRUE)
	{

		if( is_array($dev_file) ){
			
			if( is_array($dev_file[0]) ){
			
				foreach($dev_file as $file){
					
					$d = $file[0];
					$m = (isset($file[1])) ? $file[1] : $media;
					$p = (isset($file[2])) ? $file[2] : '';
					$c = (isset($file[3])) ? $file[3] : $combine;
					
					$this->_asset('css', $d, $p, $c, $m);
				
				}
				
			}else{

				$d = $dev_file[0];
				$m = (isset($file[1])) ? $file[1] : $media;
				$p = (isset($dev_file[2])) ? $dev_file[2] : '';
				$c = (isset($dev_file[3])) ? $dev_file[3] : $combine;
					
				$this->_asset('css', $d, $p, $c, $m);
				
			}
			
		}else{
		
			$this->_asset('css', $dev_file, $prod_file, $combine, $media);
	
		}
	}
	
	
	/**
	* Add an asset to queue
	* @param	String of the type of asset (lowercase) . css | js
	* @param	String of the path to development version of the asset.
	* @param	String of the path to production version of the asset. NOT REQUIRED
	* @param	Flag whether the file is to be combined. Defaults to true. NOT REQUIRED
	* @param	String of the media type associated with the asset.  Only applicable to CSS assets. NOT REQUIRED
	*/		
	private function _asset($type, $dev_file, $prod_file = '', $combine = TRUE, $media = 'screen')
	{
		if ($type == 'css') : 
		
			$this->css[$media][] = array( 'dev'=>$dev_file );
			$index = count($this->css[$media]) - 1;
			
			if($prod_file != '') $this->{$type}[$media][$index]['prod'] = $prod_file;
			$this->css[$media][$index]['combine'] = $combine;
			
		else : 
		
			$this->{$type}[] = array( 'dev'=>$dev_file );
			$index = count($this->{$type}) - 1;
			
			if($prod_file != '') $this->js[$index]['prod'] = $prod_file;
			$this->js[$index]['combine'] = $combine;
			
		endif;
	
	}
	
	
	/** 
	* Display HTML references to the assets
	* @param	Flag the asset type: css|js
	*/		
	public function display($flag)
	{
		switch($flag){
			
			case 'js':
				
				if( empty($this->js) ) return; // if there aren't any js files, just stop!

				// if we're in a dev environment
				if($this->dev){
					
					foreach($this->js as $ref):
					
						echo $this->_tag('js', $ref['dev']);
					
					endforeach;
				
				
				// if we're combining files
				} elseif($this->combine) {

					$lastmodified = 0;
					$files = array();
					$filenames = '';
					$not_combined = '';
					
					foreach ($this->js as $ref) {
						
						// get the last modified date of the most recently modified file
						$lastmodified = max( $lastmodified , filemtime( realpath($this->script_path.$ref['dev']) ) );
						$filenames .= $ref['dev'];

						if($ref['combine'] == false):
							$not_combined .= (isset($ref['prod'])) ? $this->_tag('js', $ref['prod']) : $this->_tag('js', $ref['dev']);							
						else:
								$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'] ) : array('dev'=>$ref['dev']);
						endif;					
					}

					$filename = $lastmodified . md5($filenames).'.js';
					
					if( !file_exists($this->cache_path.$filename) )	$this->_combine('js', $files, $filename);

					echo $not_combined;
					echo $this->_tag('js', $filename, TRUE);



				// if we're minifying. but not combining
				} elseif(!$this->combine && $this->minify_js) {
					
					// minify each file, cache it, and serve it up. Oy.
					foreach($this->js as $ref):
						
						if( isset($ref['prod']) ){
						
							$f = $ref['prod'];
							
							echo $this->_tag('js', $f, FALSE);
						
						} else {
						
							$f = filemtime( realpath( $this->script_path . $ref['dev'] ) ) . md5($ref['dev']) . '.js';

							if( !file_exists($this->cache_path.$f) ):
	
								$c = $this->_minify( 'js', $ref['dev'] );
								$this->_cache($f, $c);
							
							endif;
							
							echo $this->_tag('js', $f, TRUE);
						}
				
					endforeach;	
	
				}else{
				
					foreach($this->js as $ref):
					
						$f = (isset($ref['prod'])) ? $ref['prod'] : $ref['dev'];
						echo $this->_tag('js', $f);
						
					endforeach;
								
				}

			break;

			case 'css':
				
				if( empty($this->css) ) return; // there aren't any css assets, so just stop!
				
				if($this->dev){ // we're in a development environment
					
					foreach($this->css as $media => $refs):
					
						foreach($refs as $ref):

							echo $this->_tag('css', $ref['dev'], FALSE, $media);
						
						endforeach;
						
					endforeach;
				
				} elseif($this->combine) { // we're combining and minifying
					
					foreach($this->css as $media => $refs):
					
						// lets try to cache it, shall we?
						$lastmodified = 0;
						$files = array();
						$filenames = '';
						$not_combined = '';
						
						foreach ($refs as $ref):
						
							$lastmodified = max($lastmodified, filemtime( realpath( $this->style_path . $ref['dev'] ) ) );
							$filenames .= $ref['dev'];
							
							if($ref['combine'] == false):
								$not_combined .= (isset($ref['prod'])) ? $this->_tag('css', $ref['prod'], $media) : $this->_tag('css', $ref['dev'], $media);
							else:
								$files[] = (isset($ref['prod'])) ? array('prod'=>$ref['prod'], 'dev'=>$ref['dev'] ) : array('dev'=>$ref['dev']);
							endif;
							
						endforeach;
	
						$filename = $lastmodified . md5($filenames).'.css';
						
						if( !file_exists($this->cache_path.$filename) ) $this->_combine('css', $files, $filename);
	
						echo $not_combined;
						echo $this->_tag('css',  $filename, TRUE, $media);
						
					endforeach;
				
				} elseif(!$this->combine && $this->minify_css) { // we want to minify, but not combine
					
					foreach($this->css as $media => $refs):
					
						foreach($refs as $ref):
							
							if( isset($ref['prod']) ){
							
								$f = $this->style_uri . $ref['prod'];
							
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
				
				}else{ // we're in a production environment, but not minifying or combining
					
					foreach($this->css as $media => $refs):
					
						foreach($refs as $ref):
							
							$f = (isset($ref['prod'])) ? $ref['prod'] : $ref['dev'];
							echo $this->_tag('css', $f, FALSE, $media);
						
						endforeach;	
						
					endforeach;	
				
				}
				
			break;

		}
	}
	
	
	/** 
	* Internal function for compressing/combining scripts
	* @param	Flag the asset type: css|js
	* @param	array of file references to be combined. Should contain arrays, as included in primary asset arrays: ('dev'=>$dev, 'prod'=>$prod)
	* @param	Filename of the file-to-be
	*/
	private function _combine($flag, $files, $filename)
	{

		$file_data = '';
		
		$path = ($flag == 'css') ? $this->style_path : $this->script_path;
		$minify = ($flag == 'css') ? $this->minify_css : $this->minify_js;
		
	
		foreach($files as $file):

			if($minify):
			
				$file_data .=  $this->_minify( $flag, $file['dev'] ) . "\n";
				
			else:
			
				$file_data .=  file_get_contents( realpath($path.$file['dev']) ) ."\n";
				
			endif;
		
		endforeach;
		
		$this->_cache( $filename, $file_data );

	}


	/** 
	* Internal function for minifying assets
	* @param	Flag the asset type: css|js
	* @param	Contents to be minified
	*/
	private function _minify($flag, $file_ref)
	{
	
		switch($flag){
			
			case 'js':
			
				$this->CI->load->library('jsmin');

				$contents = file_get_contents( realpath($this->script_path.$file_ref) );
				return $this->CI->jsmin->minify($contents);
			
			break;
			
			
			case 'css':
			
				$this->CI->load->library('cssmin');
				$this->CI->cssmin->config(array('relativePath'=>$this->style_uri));
				
				$contents = file_get_contents( realpath($this->style_path.$file_ref) );
				return $this->CI->cssmin->minify($contents);
			
			break;
		}
	
	}
	
	
	/** 
	* Internal function for writing cache files
	* @param	filename of the new file
	* @param	Contents of the new file
	*/
	private function _cache($filename, $file_data)
	{
		$filepath = $this->cache_path . $filename; 
		//change ernscht: $filepath = realpath($this->cache_path . $filename);
		file_put_contents( $filepath, $file_data );			
	
	}
	
	
	/** 
	* Internal function for making tag strings
	* @param	flag for type: css|js
	* @param	Reference of file. 
	* @param	Flag for cache dir.  Defaults to FALSE.
	* @param	Media type for the tag.  Only applies to CSS links. defaults to 'screen'
	*/
	private function _tag($flag, $ref, $cache = FALSE, $media = 'screen')
	{
	

		switch($flag){
		
			case 'css':
				
				$dir = ($cache) ? $this->cache_uri : $this->style_uri;
				
				echo '<link type="text/css" rel="stylesheet" href="'.$dir.$ref.'" media="'.$media.'" />'."\r\n";
			
			break;

			case 'js':
				
				$dir = ($cache) ? $this->cache_uri : $this->script_uri;
				
				echo '<script type="text/javascript" src="'.$dir.$ref.'"></script>'."\r\n";
			
			break;
		
		}
	
	}	
	
	
	/** 
	* Function used to clear the asset cache. If no flag is set, both CSS and JS will be emptied.
	* @param	Flag the asset type: css|js|both
	*/		
	public function empty_cache($flag)
	{
		
		$this->CI->load->helper('file');
		
		$files = get_filenames($this->cache_path);

		switch($flag){

			case 'js':
			case 'css':
			
				foreach( $files as $file ){
					
					$ext = substr( strrchr( $file, '.' ), 1 );
					
					if ( $ext == $flag ) {

						unlink( $this->cache_path . $file );

					}
					
				}
			
			break;
			
			
			default:
			
				foreach( $files as $file ){
					
					$ext = substr( strrchr( $file, '.' ), 1 );
					
					if ( $ext == 'js' || $ext == 'css') {

						unlink( $this->cache_path . $file );

					}
					
				}	
				
			break;
		
		}			
	
	}
}