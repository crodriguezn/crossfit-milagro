<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['jasperstarter']['firebird']['terminal_terrestre'] = array(
	'db-driver' => 'org.firebirdsql.jdbc.FBDriver',
	'db-url' => 'jdbc:firebirdsql://localhost:3050/C:\FireBird\FTT\DIGIFORTDB.FDB',
	'dbuser' => 'SYSDBA',
	'dbpasswd' => 'masterkey'
);

$config['jasperstarter']['postgres']['terminal_terrestre'] = array(
	'db-driver' => 'org.postgresql.Driver',
	'db-url' => 'jdbc:postgresql://localhost:5432/ftt',
	'dbuser' => 'postgres',
	'dbpasswd' => '123456'
);
