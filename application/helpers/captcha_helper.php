<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once BASEPATH . '../application/third_party/securimage/securimage.php';

class Helper_Captcha
{
    static public function isValid($captcha_name, $code_captcha)
    {
        $img = new Securimage();
        $img->setNamespace( $captcha_name );
        
        return $img->check( $code_captcha );
    }
    
    static public function show( $captcha_name, $width=300, $height=100 )
    {
        $options = array('send_headers'=>FALSE, 'no_exit'=>TRUE);
        
        $img = new Securimage($options);

        //Change some settings
        $img->namespace = $captcha_name;
        $img->image_width = $width;
        $img->image_height = $height;
        $img->perturbation = 0.85;
        $img->image_bg_color = new Securimage_Color("#f6f6f6");
        $img->use_transparent_text = true;
        $img->text_transparency_percentage = 10; // 100 = completely transparent
        $img->num_lines = 7;
        $img->line_color = new Securimage_Color("#eaeaea");
        $img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
        ob_start();   // start the output buffer
        $img->show( BASEPATH . '../application/third_party/securimage/backgrounds/bg6.jpg'); // alternate use:  $img->show('/path/to/background_image.jpg');
        $imgBinary = ob_get_contents(); // get contents of the buffer
        ob_end_clean(); // turn off buffering and clear the buffer
        header('Content-Type: image/png');
        header('Content-Length: ' . strlen($imgBinary));
        var_dump(gd_info());
        echo $imgBinary;
    }
    
//    static public function create( $captcha_name, $subfolder='' )
//    {
//        $options = array('send_headers'=>FALSE, 'no_exit'=>TRUE);
//        
//        $img = new Securimage($options);
//
//        //Change some settings
//        $img->namespace = $captcha_name;
//        $img->image_width = 300;
//        $img->image_height = 100;
//        $img->perturbation = 0.85;
//        $img->image_bg_color = new Securimage_Color("#f6f6f6");
//        $img->use_transparent_text = true;
//        $img->text_transparency_percentage = 10; // 100 = completely transparent
//        $img->num_lines = 7;
//        $img->line_color = new Securimage_Color("#eaeaea");
//        $img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
//
//        ob_start();
//        
//        $img->show( BASEPATH . '../application/third_party/securimage/backgrounds/bg6.jpg'); // alternate use:  $img->show('/path/to/background_image.jpg');
//
//        $content = ob_get_clean();
//        
//        $folder_captcha_uri  = 'resources/captcha'.( empty($subfolder) ? '' : "/$subfolder" );
//        $folder_captcha_path = BASEPATH . "../" . $folder_captcha_uri;
//        if( !file_exists($folder_captcha_path) )
//        {
//            mkdir($folder_captcha_path, 0777);
//        }
//        
//        $captcha_image_name = ( uniqid() ).'.png';
//        
//        $captcha_uri  = "$folder_captcha_uri/$captcha_image_name";
//        $captcha_path = "$folder_captcha_path/$captcha_image_name";
//        
//        write_file($captcha_path, $content);
//        chmod($captcha_path, 0777);
//        
//        return $captcha_uri;
//    }
}