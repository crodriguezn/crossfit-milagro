<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Encrypt
{
    static protected $Encryption_Key = '7A1lTldCU7Nfga7DrCbjq7g1UJ1coT3i';
    
    static public function encode( $value )
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('encrypt');
        
        return $MY->encrypt->encode( $value );
    }
    
    static public function decode( $value_encoded )
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('encrypt');
        
        return $MY->encrypt->decode( $value_encoded );
    }
    
    static public function encrypt( $value, $encryption_key='' )
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('library_zend2');
        
        $filter = new \Zend\Filter\Encrypt();
        $filter->setKey( empty($encryption_key) ? self::$Encryption_Key : $encryption_key );
        
        return $filter->filter( $value );
    }
    
    static public function decrypt( $value_encoded, $encryption_key='' )
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('library_zend2');
        
        $filter = new \Zend\Filter\Decrypt();
        $filter->setKey( empty($encryption_key) ? self::$Encryption_Key : $encryption_key );
        
        return $filter->filter($value_encoded);
    }
    
    static public function encriptBlockCipher($value, $encryption_key='')
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('library_zend2');
        
        $cipher = \Zend\Crypt\BlockCipher::factory('mcrypt', array('algorithm' => 'aes'));
        $cipher->setKey( empty($encryption_key) ? self::$Encryption_Key : $encryption_key );
        
        return $cipher->encrypt($value);
    }
    
    static public function decryptBlockCipher($value_encoded, $encryption_key='')
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('library_zend2');
        
        $cipher = \Zend\Crypt\BlockCipher::factory('mcrypt', array('algorithm' => 'aes'));
        $cipher->setKey( empty($encryption_key) ? self::$Encryption_Key : $encryption_key );
        
        return $cipher->decrypt($value_encoded);
    }
    
    static function encrypt_decrypt($action, $string, $encryption_key='')
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = empty($encryption_key) ? 'This is my secret key' : $encryption_key;
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' )
        {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
    
    // *****************
    // Util for database
    // *****************
    
    static public function encryptId($value, $encryption_key)
    {
        /*$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($value), MCRYPT_MODE_ECB, $iv);

        return base64_encode($encrypted_string);*/
        
        return self::encrypt_decrypt('encrypt', $value, $encryption_key);
    }

    static public function decryptId($value_encrypted, $encryption_key )
    {
        /*$value_encrypted = base64_decode($value_encrypted);

        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv      = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $value   = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $value_encrypted, MCRYPT_MODE_ECB, $iv);

        $value = trim($value);
        
        if( !is_numeric($value) )
        {
            exit('Violacion de seguridad');
        }

        return $value;*/
        
        $result = self::encrypt_decrypt('encrypt', $value, $encryption_key);
        
        return $result;
    }
}