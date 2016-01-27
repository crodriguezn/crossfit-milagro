<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Data
{
    const RESET_DEFAULT = 0;
    const RESET_STRING  = 1;
    
    public function __construct()
    {
    }
    
    public function toArray()
    {
        return (array) $this;
    }
}
