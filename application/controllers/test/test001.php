<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test001 extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        //echo BASEPATH;
        echo "TEST 001";
    }
    
	public function jasperstarter()
	{
        $this->load->library('library_jasperstarter');
        //$this->library_jasperstarter->dbConnection('localhost', 'test', 'root', 'mysql0');
        //$this->library_jasperstarter->setPathJavaBin('/opt/java/jdk1.7.0_51/bin/java');
        //$this->library_jasperstarter->setPathJavaBin('/opt/java/jdk1.6.0_45/bin/java');
        $this->library_jasperstarter->setPathFolderOutput( BASEPATH . '../temp' );
        $this->library_jasperstarter->setPathJavaBin('C:\Program Files (x86)\Java\jdk1.7.0_65\jre\bin\java.exe');
        //$this->library_jasperstarter->dbGeneric('org.postgresql.Driver', 'jdbc:postgresql://localhost:5433', 'base_system3', 'postgres', 'postgres');
        //$this->library_jasperstarter->dbGeneric('org.postgresql.Driver', 'jdbc:postgresql://localhost:5433/base_system3', 'postgres', 'postgres');
        $this->library_jasperstarter->dbConnection('localhost', 'base_system3', 'postgres', 'postgres', '5433', 'postgres');
        
        $path_file_jasper = BASEPATH . "../application/reports/report1.jasper";
        $file_name_output = 'report1_' . ( uniqid() );
        $arrParameter = array('parameter1'=>'Amelia Piedad');
        
        $res = $this->library_jasperstarter->downloadReport( $path_file_jasper, $file_name_output, $arrParameter, 'pdf');
        
        var_dump($res);
	}
    
    public function jasperstarter_xml( $option=0 )
	{
        $this->load->library('library_jasperstarter');
        $this->library_jasperstarter->setPathJavaBin('/opt/java/jdk1.7.0_72/bin/java');
        $this->library_jasperstarter->setPathFolderOutput( BASEPATH . '../application/temp' );
        
        $seq = uniqid('',TRUE);
        
        if( empty($option) )
        {
            $this->library_jasperstarter->dbXML( BASEPATH . "../application/temp/report_data_xml.xml", "/store/media" );
        }
        else
        {
            require_once BASEPATH. '../application/third_party/array2xml/Array2XML.php';
        
            $store = array(
                'media' => array(
                    array(
                        'name' => 'Lollywood2',
                        'description' => 'Pakistani film media'
                    ),
                    array(
                        'name' => 'Bollywood3',
                        'description' => 'Indian film media'
                    ),
                    array(
                        'name' => 'Hollywood4',
                        'description' => 'English film media'
                    )
                )
            );

            $xml = Array2XML::createXML('store', $store);

            $path_xml = BASEPATH . "../application/temp/report_data_xml2-$seq.xml";
            
            write_file($path_xml, $xml->saveXML());
            chmod($path_xml, 0777);
            
            $this->library_jasperstarter->dbXML($path_xml, "/store/media" );
        }
        
        $path_file_jasper = BASEPATH . "../application/reports/report_xml.jasper";
        $file_name_output = 'report1_' . ( $seq );
        
        $arrParameter = array();
        
        $res = $this->library_jasperstarter->downloadReport( $path_file_jasper, $file_name_output, $arrParameter, 'pdf');
        
        var_dump($res);
	}
    
    public function array2xml()
    {
        require_once BASEPATH. '../application/third_party/array2xml/Array2XML.php';
        
        /*
        <?xml version="1.0" encoding="UTF-8"?>
        <head/>
        <books type="fiction">
            <book author="George Orwell">
                <title>1984</title>
            </book>
            <book author="Isaac Asimov">
                <title><![CDATA[Foundation]]></title>
                <price>$15.61</price>
            </book>
            <book author="Robert A Heinlein">
                <title><![CDATA[Stranger in a Strange Land]]></title>
                <price discount="10%">$18.00</price>
            </book>
        </books>
        */
        
        $books = array(
            '@attributes' => array(
                'type' => 'fiction'
            ),
            'book' => array(
                array(
                    '@attributes' => array(
                        'author' => 'George Orwell'
                    ),
                    'title' => '1984'
                ),
                array(
                    '@attributes' => array(
                        'author' => 'Isaac Asimov'
                    ),
                    'title' => array('@cdata'=>'Foundation'),
                    'price' => '$15.61'
                ),
                array(
                    '@attributes' => array(
                        'author' => 'Robert A Heinlein'
                    ),
                    'title' =>  array('@cdata'=>'Stranger in a Strange Land'),
                    'price' => array(
                        '@attributes' => array(
                            'discount' => '10%'
                        ),
                        '@value' => '$18.00'
                    )
                )
            )
        );
        
        $xml = Array2XML::createXML('books', $books);
        
        echo $xml->saveXML();
    }
    
    public function zend()
    {
        $this->load->library('library_zend');
        
        $test = Zend_Barcode::draw('ean8', 'image', array('text' => 'abc123'), array());
        //var_dump($test);
        imagejpeg($test, 'temp/'.( uniqid() ).'.jpg', 100);
    }
    
    public function zend2()
    {
        /*$this->load->library('library_zend2');
        
        $obj = new Zend\Captcha\Image( array(
            'imgDir'=> BASEPATH . '../temp',
            'font' => BASEPATH .'../application/third_party/fonts/LesJoursHeureux.otf' ,
            'width' => 250,
            'height' => 100,
            'dotNoiseLevel' => 40,
            'lineNoiseLevel' => 3)
        );
        
        $string_captcha_ID = $obj->generate();
        
        echo $string_captcha_ID."<br/>";
        //echo $obj->get()."<br/>";
        echo $obj->getWord();*/
    }
    
    public function js()
    {
        
    }
    
    public function jsr( $name_key )
    {
        
    }
}

