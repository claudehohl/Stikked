<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Philip Sturgeon
 * @created 9 Dec 2008
 */

class Curl {
	
    private $CI;                // CodeIgniter instance
    
    private $responce;          // Contains the cURL responce for debug
   
    private $session;           // Contains the cURL handler for a session
    private $url;               // URL of the session
    private $options = array(); // Populates curl_setopt_array
    private $headers = array(); // Populates extra HTTP headers
    
    public $error_code;         // Error code returned as an int
    public $error_string;       // Error message returned as a string
    public $info;               // Returned after request (elapsed time, etc)
    
    function __construct($url = '')
    {
        $this->CI =& get_instance();
        log_message('debug', 'cURL Class Initialized');
        
        if (!function_exists('curl_init')) {
            log_message('error', 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.') ;
        }
        
        if($url) $this->create($url);
    }
 
    /* =================================================================================
     * SIMPLE METHODS 
     * Using these methods you can make a quick and easy cURL call with one line.
     * ================================================================================= */
 
    // Return a get request results
    public function simple_get($url, $options = array())
    {
        // If a URL is provided, create new session
        $this->create($url);

        // Add in the specific options provided
        $this->options($options);

        return $this->execute();
    }
 
    // Send a post request on its way with optional parameters (and get output)
    // $url = '', $params = array(), $options = array()
    public function simple_post($url, $params = array(), $options = array())
    { 
		$this->create($url);
        
		$this->post($params, $options);
        
		return $this->execute();
    }
 
    // Send a post request on its way with optional parameters (and get output)
    // $url = '', $params = array(), $options = array()
    public function simple_put($url, $params = array(), $options = array())
    { 
		$this->create($url);
        
		$this->put($params, $options);
        
		return $this->execute();
    }
 
    // Send a post request on its way with optional parameters (and get output)
    // $url = '', $params = array(), $options = array()
    public function simple_delete($url)
    { 
		$this->create($url);
    	
		$this->http_method('delete');
			        
		return $this->execute();
    }
    
    public function simple_ftp_get($url, $file_path, $username = '', $password = '')
    {
        // If there is no ftp:// or any protocol entered, add ftp://
        if(!preg_match('!^(ftp|sftp)://! i', $url)) {
            $url = 'ftp://'.$url;
        }
        
        // Use an FTP login
        if($username != '')
        {
            $auth_string = $username;
            
            if($password != '')
            {
            	$auth_string .= ':'.$password;
            }
            
            // Add the user auth string after the protocol
            $url = str_replace('://', '://'.$auth_string.'@', $url);
        }
        
        // Add the filepath
        $url .= $file_path;

        $this->options(CURLOPT_BINARYTRANSFER, TRUE);
        $this->options(CURLOPT_VERBOSE, TRUE);
        
        return $this->execute();
    }
    
    /* =================================================================================
     * ADVANCED METHODS 
     * Use these methods to build up more complex queries
     * ================================================================================= */
     
    public function post($params = array(), $options = array()) { 
        
        // If its an array (instead of a query string) then format it correctly
        if(is_array($params)) {
            $params = http_build_query($params);
        }
        
        // Add in the specific options provided
        $this->options($options);
        
        $this->http_method('post');
        
        $this->option(CURLOPT_POST, TRUE);
        $this->option(CURLOPT_POSTFIELDS, $params);
    }
    
    public function put($params = array(), $options = array()) { 
        
        // If its an array (instead of a query string) then format it correctly
        if(is_array($params)) {
            $params = http_build_query($params);
        }
        
        // Add in the specific options provided
        $this->options($options);
        
        $this->option(CURLOPT_PUT, TRUE);
        $this->option(CURLOPT_POSTFIELDS, $params);
    }
    
    public function set_cookies($params = array()) {
        
        if(is_array($params)) {
            $params = http_build_query($params);
        }
        
        $this->option(CURLOPT_COOKIE, $params);
        return $this;
    }
    
    public function http_header($header_string)
    {
		$this->headers[] = $header_string;
    }
    
    public function http_method($method)
    {
    	$this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        return $this;
    }
    
    public function http_login($username = '', $password = '', $type = 'any')
    {
		$this->option(CURLOPT_HTTPAUTH, constant('CURLAUTH_'.strtoupper($type) ));
        $this->option(CURLOPT_USERPWD, $username.':'.$password);
        return $this;
    }
    
    public function proxy($url = '', $port = 80) {
        
        $this->option(CURLOPT_HTTPPROXYTUNNEL. TRUE);
        $this->option(CURLOPT_PROXY, $url.':'. 80);
        return $this;
    }
    
    public function proxy_login($username = '', $password = '') {
        $this->option(CURLOPT_PROXYUSERPWD, $username.':'.$password);
        return $this;
    }
    
    public function options($options = array())
    {
        // Merge options in with the rest - done as array_merge() does not overwrite numeric keys
        foreach($options as $option_code => $option_value)
        {
            $this->option($option_code, $option_value);
        }
        unset($option_code, $option_value);

        // Set all options provided
        curl_setopt_array($this->session, $this->options);
                
        return $this;
    }
    
    public function option($code, $value) {
    	$this->options[$code] = $value;
        return $this;
    }
    
    // Start a session from a URL
    public function create($url) {
        
        // Reset the class
        $this->set_defaults();

        // If no a protocol in URL, assume its a CI link
        if(!preg_match('!^\w+://! i', $url)) {
            $this->CI->load->helper('url');
            $url = site_url($url);
        }
        
        $this->url = $url;
        $this->session = curl_init($this->url);
        
        return $this;
    }
    
    // End a session and return the results
    public function execute()
    {
        // Set two default options, and merge any extra ones in
        if(!isset($this->options[CURLOPT_TIMEOUT]))           $this->options[CURLOPT_TIMEOUT] = 30;
        if(!isset($this->options[CURLOPT_RETURNTRANSFER]))    $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        if(!isset($this->options[CURLOPT_FOLLOWLOCATION]))    $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
        if(!isset($this->options[CURLOPT_FAILONERROR]))       $this->options[CURLOPT_FAILONERROR] = TRUE;

		if(!empty($this->headers))
		{
			$this->option(CURLOPT_HTTPHEADER, $this->headers); 
		}

        $this->options();

        // Execute the request & and hide all output
        $this->responce = curl_exec($this->session);

        // Request failed
        if($this->responce === FALSE)
        {
            $this->error_code = curl_errno($this->session);
            $this->error_string = curl_error($this->session);
            
            curl_close($this->session);
            $this->session = NULL;
            return FALSE;
        } 
        
        // Request successful
        else
        {
            $this->info = curl_getinfo($this->session);
            
            curl_close($this->session);
            $this->session = NULL;
            return $this->responce;
        }
    }
    
    
    public function debug()
    {
        echo "=============================================<br/>\n";
        echo "<h2>CURL Test</h2>\n";
        echo "=============================================<br/>\n";
        echo "<h3>Responce</h3>\n";
        echo "<code>".nl2br(htmlentities($this->responce))."</code><br/>\n\n";
    
        if($this->error_string)
        {
    	    echo "=============================================<br/>\n";
    	    echo "<h3>Errors</h3>";
    	    echo "<strong>Code:</strong> ".$this->error_code."<br/>\n";
    	    echo "<strong>Message:</strong> ".$this->error_string."<br/>\n";
        }
    
        echo "=============================================<br/>\n";
        echo "<h3>Info</h3>";
        echo "<pre>";
        print_r($this->info);
        echo "</pre>";
	}
    
    private function set_defaults()
    {
        $this->responce = '';
        $this->info = array();
        $this->options = array();
        $this->error_code = 0;
        $this->error_string = '';
    }
}
// END cURL Class

/* End of file cURL.php */
/* Location: ./application/libraries/curl.php */