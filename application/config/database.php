<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

/*
$db['default']['hostname'] = 'ec2-54-225-197-143.compute-1.amazonaws.com';
$db['default']['username'] = 'kmtbhqognorbgl';
$db['default']['password'] = 'DNCt4ejfUfiYcn6bWSq6DVuNny';
$db['default']['database'] = 'df3bo201dhdmuk';
$db['default']['dbdriver'] = 'postgre';
$db['default']['port']     = 5432;
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
$db['default']['bin_dump'] = "/usr/bin/pg_dump";
*/
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'postgres';
$db['default']['password'] = 'postgres0';
$db['default']['database'] = 'crossfit_milagro_demo';
$db['default']['dbdriver'] = 'postgre';
$db['default']['port']     = 5432;
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
$db['default']['bin_dump'] = "C:\Bitnami\wappstack-5.4.37-0\postgresql\bin\pg_dump.exe";

/*
$db['digifort']['hostname'] = "localhost";
$db['digifort']['username'] = "sysdba";
$db['digifort']['password'] = "masterkey";
$db['digifort']['database'] = "C:\FireBird\FTT\DIGIFORTDB.FDB";
$db['digifort']['dbdriver'] = "firebird";
$db['digifort']['port']     = 3050;
$db['digifort']['dbprefix'] = "";
$db['digifort']['pconnect'] = FALSE;
$db['digifort']['db_debug'] = TRUE;
$db['digifort']['cache_on'] = FALSE;
$db['digifort']['cachedir'] = "";
$db['digifort']['char_set'] = "NONE";
$db['digifort']['dbcollat'] = "NONE";
$db['digifort']['dialect'] = 3;
*/
 //phpinfo();
 





/*****************/
/***** BROWSE ****/
/*****************/
/*
$db['browse']['hostname'] = 'Driver={SQL Server Native Client 10.0};Server=192.168.0.103;Database=BdAleGye;';   // 
$db['browse']['username'] = 'sa';
$db['browse']['password'] = 'sqlserver0';
$db['browse']['database'] = '';
$db['browse']['dbdriver'] = 'odbc';
//$db['browse']['port']     = 5432;
$db['browse']['dbprefix'] = '';
$db['browse']['pconnect'] = FALSE;
$db['browse']['db_debug'] = TRUE;
$db['browse']['cache_on'] = FALSE;
$db['browse']['cachedir'] = '';
$db['browse']['char_set'] = 'utf8';
$db['browse']['dbcollat'] = 'utf8_general_ci';
$db['browse']['swap_pre'] = '';
$db['browse']['autoinit'] = TRUE;
$db['browse']['stricton'] = FALSE;
*/
/* End of file database.php */
/* Location: ./application/config/database.php */
