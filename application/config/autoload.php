<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Helper files
| 4. Custom config files
| 5. Language files
| 6. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packges
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/

$autoload['packages'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in the system/libraries folder
| or in your application/libraries folder.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'session', 'xmlrpc');
*/

$autoload['libraries'] = array(
    // SYSTEM
    'upload',
    // APPLICATION
    'libsession'
);


/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/

$autoload['helper'] = array(
    // SYSTEM
    'url', 
    // APPLICATION
    'encrypt', 'log', 'fecha', 'array', 'email', 'file', 'captcha', 'request', 'browser', 'directory'
);


/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/

$autoload['config'] = array(
    'binary','company','jasperstarter','system'
);


/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/

$autoload['language'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('model1', 'model2');
|
*/

$autoload['model'] = array(
    // default
    'mAppVersion'                   => 'default/app_version_model',
    'mCatalog'                      => 'default/catalog_model',
    'mCatalogType'                  => 'default/catalog_type_model',
    'mCiudad'                       => 'default/ciudad_model',
    'mCompanyBranch'                => 'default/company_branch_model',
    'mCompany'                      => 'default/company_model',
    'mConfigurationSystem'          => 'default/configuration_system_model',
    'mModule'                       => 'default/module_model',
    'mPais'                         => 'default/pais_model',
    'mPermission'                   => 'default/permission_model',
    'mPerson'                       => 'default/person_model',
    'mProfile'                      => 'default/profile_model',
    'mProfilePermission'            => 'default/profile_permission_model',
    'mProvincia'                    => 'default/provincia_model',
    'mRol'                          => 'default/rol_model',
    'mRolModule'                    => 'default/rol_module_model',
    'mSessionsActivity'             => 'default/session_activity_model',
    'mUserLog'                      => 'default/user_log_model',
    'mUser'                         => 'default/user_model',
    'mUserProfileCompanyBranch'     => 'default/user_profile_company_branch_model',
    'mUserProfile'                  => 'default/user_profile_model',
    
);


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */