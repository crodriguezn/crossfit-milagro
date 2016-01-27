<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zend2 extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        echo "ZEND";
    }
    
    public function captcha()
    {
        $captcha = new Zend\Captcha\Figlet(array(
            'name' => 'foo',
            'wordLen' => 6,
            'timeout' => 300,
        ));
        
        $id = $captcha->generate();

        //this will output a Figlet string
        echo $captcha->getFiglet()->render($captcha->getWord());
    }
    
    public function captcha2()
    {
        $path = BASEPATH . '../resources/captcha/'.( date('Y').'/'.date('m').'/'.date('d') );
        if( !file_exists($path) )
        {
            mkdir($path, 0777, TRUE);
        }
        
        $session = new Zend\Session\Container('ZEND_PARANGARI');
        $session->offsetSet('text1', 'value1');
        //$session->set
        
        $obj = new Zend\Captcha\Image();
        
        $obj->setImgDir($path);
        $obj->setFont(BASEPATH .'../application/third_party/fonts/LesJoursHeureux.otf');
        $obj->setFontSize(40);
        $obj->setWidth(250);
        $obj->setHeight(100);
        $obj->setDotNoiseLevel(40);
        $obj->setLineNoiseLevel(3);
        $obj->setWordlen(6);
        $obj->setSession($session);
        
        $string_captcha_ID = $obj->generate();
        
        echo $string_captcha_ID."<br/>";
        echo $obj->getWord();
        
        $obj->isValid($string_captcha_ID);
        
        Helper_Log::write($_SESSION);
    }
    
    public function captcha2_check()
    {
        $path = BASEPATH . '../resources/captcha/'.( date('Y').'/'.date('m').'/'.date('d') );
        if( !file_exists($path) )
        {
            mkdir($path, 0777, TRUE);
        }
        
        $session = new Zend\Session\Container('ZEND_PARANGARI');
        
        $obj = new Zend\Captcha\Image();
        $obj->setSession($session);
        
        echo $obj->getWord() == 'h4c984' ? 'VALID' : 'INVALID';echo "<br/>";
        
        $v = $session->offsetGet('text1');
        var_dump($v);
    }
}

