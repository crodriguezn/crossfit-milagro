<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Formula
{
    static public function evaluar( $formula, $variables )
    {
        // $formula = "( <cal_p1> + <cal_p2> + <cal_p3> ) / 3";
        // $variables = array( 'cal_p1' => 10, ...... );
        
        if( !empty($variables) )
        {
            foreach( $variables as $var => $value )
            {
                $formula = str_replace ("<$var>", $value , $formula);
            }
        }
        
        $resultado = create_function('', "return $formula;");

        return $resultado();
    }
    
    static public function CrearCodigoCustomer( $ultimo, $prefijo = 'WOD' )
    {
        $longitud = strlen($ultimo);
        if($longitud < 5)
        {
            if ($longitud < 4)
            {
                if ($longitud < 3)
                {
                    if ($longitud < 2)
                    {
                        if ($longitud <= 1)
                        {
                            return $prefijo.'0000'. $ultimo;
                        }
                    } 
                    else 
                    {
                        return $prefijo.'000' . $ultimo;
                    }
                } 
                else
                {
                    return $prefijo.'00' . $ultimo;
                }
            }
            else
            {
                return $prefijo.'0' . $ultimo;
            }
        }
        else
        {
            return $prefijo.'' . $ultimo;
        }
    }
}
