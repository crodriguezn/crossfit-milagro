<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_OS
{
    const OS_UNKNOWN = 1;
    const OS_WIN = 2;
    const OS_LINUX = 3;
    const OS_OSX = 4;

    static public function isWindows()
    {
        return self::getOS() == self::OS_WIN;
    }
    
    static public function isLinux()
    {
        return self::getOS() == self::OS_LINUX;
    }
    
    static public function isMacOS()
    {
        return self::getOS() == self::OS_OSX;
    }
    
    static public function isX32()
    {
        return PHP_INT_SIZE < 8;
    }
    
    static public function isX64()
    {
        return PHP_INT_SIZE == 8;
    }
    
    static public function getOS()
    {
        switch( TRUE )
        {
            case stristr(PHP_OS, 'DAR'):
                return self::OS_OSX;
            case stristr(PHP_OS, 'WIN'):
                return self::OS_WIN;
            case stristr(PHP_OS, 'LINUX'):
                return self::OS_LINUX;
            default:
                return self::OS_UNKNOWN;
        }
    }
}