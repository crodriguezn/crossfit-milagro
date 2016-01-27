<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH.'../application/third_party/browscap/php-local-browscap.php');

class libBrowscap
{
    protected $db;
    protected $user_agent;
    protected $return_array;
    protected $cache;
    
    public function __construct()
    {
        $this->db = BASEPATH.'../application/third_party/browscap/browscap.ini';
        $this->user_agent = NULL;
        $this->return_array = FALSE;
        $this->cache = TRUE;
        
    }
    
    function get_browser_local()
    {
        return get_browser_local($this->user_agent, $this->return_array, $this->db, $this->cache);
    }
            
}
