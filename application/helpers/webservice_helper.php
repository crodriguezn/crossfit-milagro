<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once BASEPATH . '../application/third_party/nusoap/lib/nusoap.php';

class Helper_Webservice
{
    
    static public function crearWebServiceUntis()
    {
        
        $nusoap_server = new soap_server();
        $nusoap_server->configureWSDL('Transferir archivo Untis', 'urn:transferir_archivo_untis');
        // Parametros de entrada
        $nusoap_server->wsdl->addComplexType('datos_entrada', 'complexType', 'struct', 'all', '', array(
            'archivo' => array('name' => 'Archivo', 'type' => 'xsd:base64Binary'))
        );

        // Parametros de Salida
        $nusoap_server->wsdl->addComplexType('datos_salida', 'complexType', 'struct', 'all', '', array('mensaje' => array('name' => 'mensaje', 'type' => 'xsd:string'))
        );
        
        $nusoap_server->wsdl->addComplexType('anio_lectivo_salida', 'complexType', 'struct', 'all', '', array('mensaje' => array('name' => 'mensaje', 'type' => 'xsd:string'))
        );

        $nusoap_server->register('enviar_xml', // nombre del metodo o funcion
                array('datos_entrada' => 'tns:datos_entrada'), // parametros de entrada
                array('return' => 'tns:datos_salida'), // parametros de salida
                'urn:transferir_archivo_untis', // namespace
                'urn:hellowsdl2#enviar_xml', // soapaction debe ir asociado al nombre del metodo
                'rpc', // style
                'encoded', // use
                'La siguiente funcion recibe un archivo y transfiere los datos al servidor' // documentation
        );
        
        $nusoap_server->register('consultar_anio_lectivo_activo', // nombre del metodo o funcion
                array('datos_entrada' => ''), // parametros de entrada
                array('return' => 'tns:anio_lectivo_salida'), // parametros de salida
                'urn:transferir_archivo_untis', // namespace
                'urn:hellowsdl3#consultar_anio_lectivo_activo', // soapaction debe ir asociado al nombre del metodo
                'rpc', // style
                'encoded', // use
                'La siguiente funcion envia el año lectivo activo' // documentation
        );
        
        return  $nusoap_server;
    }
    
    static public function recibir_archivo($archivo_zip)
    {
        //define('READ_LEN', 4096);
        
        file_put_contents(BASEPATH."../application/temp/temp_archivos_xml/recibido.zip", $archivo_zip);
        $mensaje_error = array('mensaje' => 'Error al transferir el archivo');

        $zip2 = new ZipArchive();
        
        if( !file_exists(BASEPATH.'../application/temp/temp_archivos_xml/recibido.zip') )
        {
            return $mensaje_error;
        }

        if( $zip2->open(BASEPATH.'../application/temp/temp_archivos_xml/recibido.zip') === TRUE )
        {
            $zip2->extractTo(BASEPATH.'../application/temp/temp_archivos_xml/');
            $zip2->close();
            
            if( file_exists(BASEPATH.'../application/temp/archivos_xml/export_horario.xml') )
            {
                if( !Helper_File::files_identical(BASEPATH.'../application/temp/temp_archivos_xml/export_horario.xml', BASEPATH.'../application/temp/archivos_xml/export_horario.xml', array(2)) )
                {
                    $mensaje =  Business_Web_Service_Xml::procesar_archivo(BASEPATH.'../application/temp/archivos_xml/export_horario.xml');
                    return array('mensaje' => $mensaje);
                }
                else
                {
                    return array('mensaje' => 'El archivo tiene el mismo contenido');
                }
            }
            else
            {
                $contents = file_get_contents(BASEPATH."../application/temp/temp_archivos_xml/export_horario.xml");
                
                file_put_contents(BASEPATH."../application/temp/archivos_xml/export_horario.xml", $contents);
                
                $mensaje=  Business_Web_Service_Xml::procesar_archivo(BASEPATH.'../application/temp/archivos_xml/export_horario.xml');
                
                return array('mensaje' => $mensaje);
            }
        }
        else
        {
            return $mensaje_error;
        }
            
    }
}