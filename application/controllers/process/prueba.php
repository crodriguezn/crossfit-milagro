<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prueba extends MY_Controller
{
   
    function __construct()
    {
        parent::__construct( self::SYSTEM_PUBLIC );
    }

    public function index()
    {
        print_r(Helper_Fecha::getArrayMonth());
        
        print_r(Helper_Fecha::getArrayYear());
        print_r(Helper_Fecha::getMonth_Translate());
        print_r(Helper_Fecha::getLastDay_By_YearMonth());
        print_r(Helper_Fecha::getArrayDay(null, null));
        /*$test = Helper_Fecha::getArrayYear(2); //los años a adelantar lo cambias logicamente.
        foreach($test as $k => $v){
            echo "[$k] = ($v[0], $v[1])<br />";
        }*/
    }
}