<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Languages extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->config('geshi_languages');
        $this->geshi_languages = $this->config->item('geshi_languages');
        $this->favorite_languages = $this->config->item('favorite_languages');

        if ($this->favorite_languages === null) {
            $this->load->config('config');
            $this->favorite_languages = $this->config->item('favorite_languages');
        }
    }

    public function valid_language($lang)
    {
        return array_key_exists($lang, $this->geshi_languages);
    }

    public function get_languages()
    {
        $data = array();

        if (is_array($this->favorite_languages)) {
            foreach ($this->favorite_languages as $key) {
                $data[$key] = $this->geshi_languages[$key];
            }
            $data["0"] = "-----------------";
        }
        foreach ($this->geshi_languages as $key => $value) {

            if (!in_array($key, $data)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function code_to_description($code)
    {
        return $this->geshi_languages[$code];
    }
}
