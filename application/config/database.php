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

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			// $db['ph']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['ph']['hostname'] = 'ULTRABOOK-PC\SQLEXPRESS';
            $db['ph']['username'] = 'sa';
            $db['ph']['password'] = '1';
            $db['ph']['database'] = 'SUSPHUT';

            // $db['dq']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['dq']['hostname'] = 'ULTRABOOK-PC\SQLEXPRESS';
            $db['dq']['username'] = 'sa';
            $db['dq']['password'] = '1';
            $db['dq']['database'] = 'SUSDQ';

            // $db['tb']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['tb']['hostname'] = 'ULTRABOOK-PC\SQLEXPRESS';
            $db['tb']['username'] = 'sa';
            $db['tb']['password'] = '1';
            $db['tb']['database'] = 'SUSTB';

            // $db['tb']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['b']['hostname'] = 'ULTRABOOK-PC\SQLEXPRESS';
            $db['b']['username'] = 'sa';
            $db['b']['password'] = '1';
            $db['b']['database'] = 'SUSPHB';

		break;

		case 'testing':

		// $db['default']['hostname'] = '190.168.50.45\SUSSERVER';
  //           $db['default']['username'] = 'usr_webforecast';
  //           $db['default']['password'] = 'w3bf0r3c@st';
  //           $db['default']['database'] = 'SUSDQ';
            // $db['ph']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['ph']['hostname'] = 'PPI-HRIS\SUSSERVER';
            $db['ph']['username'] = 'sa';
            $db['ph']['password'] = 'mis1234567';
            $db['ph']['database'] = 'SUSPHUT';

            // $db['dq']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['dq']['hostname'] = 'PPI-HRIS\SUSSERVER';
            $db['dq']['username'] = 'sa';
            $db['dq']['password'] = 'mis1234567';
            $db['dq']['database'] = 'SUSDQ';

            // $db['tb']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['tb']['hostname'] = 'PPI-HRIS\SUSSERVER';
            $db['tb']['username'] = 'sa';
            $db['tb']['password'] = 'mis1234567';
            $db['tb']['database'] = 'SUSTB';

            // $db['tb']['hostname'] = 'JOSEPHINE-PC\SQLEXPRESS2008';
            $db['b']['hostname'] = 'PPI-HRIS\SUSSERVER';
            $db['b']['username'] = 'sa';
            $db['b']['password'] = 'mis1234567';
            $db['b']['database'] = 'SUSPHB';

	      break;

		case 'production':
			$db['default']['hostname'] = 'localhost';
			$db['default']['username'] = 'ravenm6_siteuser';
			$db['default']['password'] = '42sd@asd2';
			$db['default']['database'] = 'ravenm6_raven';
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

// $db['default']['dbdriver'] = 'sqlsrv'; //Drivers
// $db['default']['dbprefix'] = '';
// $db['default']['pconnect'] = FALSE;
// $db['default']['db_debug'] = TRUE;
// $db['default']['cache_on'] = FALSE;
// $db['default']['cachedir'] = '';
// $db['default']['char_set'] = 'utf8';
// $db['default']['dbcollat'] = 'utf8_general_ci';
// $db['default']['swap_pre'] = '';
// $db['default']['autoinit'] = TRUE;
// $db['default']['stricton'] = FALSE;

// $db['default']['hostname'] = 'localhost';
// $db['default']['username'] = '';
// $db['default']['password'] = '';
// $db['default']['database'] = '';
$db['ph']['dbdriver'] = 'sqlsrv'; //Drivers
$db['ph']['dbprefix'] = '';
$db['ph']['pconnect'] = FALSE;
$db['ph']['db_debug'] = TRUE;
$db['ph']['cache_on'] = FALSE;
$db['ph']['cachedir'] = '';
$db['ph']['char_set'] = 'utf8';
$db['ph']['dbcollat'] = 'utf8_general_ci';
$db['ph']['swap_pre'] = '';
$db['ph']['autoinit'] = TRUE;
$db['ph']['stricton'] = FALSE;

$db['dq']['dbdriver'] = 'sqlsrv'; //Drivers
$db['dq']['dbprefix'] = '';
$db['dq']['pconnect'] = FALSE;
$db['dq']['db_debug'] = TRUE;
$db['dq']['cache_on'] = FALSE;
$db['dq']['cachedir'] = '';
$db['dq']['char_set'] = 'utf8';
$db['dq']['dbcollat'] = 'utf8_general_ci';
$db['dq']['swap_pre'] = '';
$db['dq']['autoinit'] = TRUE;
$db['dq']['stricton'] = FALSE;

$db['tb']['dbdriver'] = 'sqlsrv'; //Drivers
$db['tb']['dbprefix'] = '';
$db['tb']['pconnect'] = FALSE;
$db['tb']['db_debug'] = TRUE;
$db['tb']['cache_on'] = FALSE;
$db['tb']['cachedir'] = '';
$db['tb']['char_set'] = 'utf8';
$db['tb']['dbcollat'] = 'utf8_general_ci';
$db['tb']['swap_pre'] = '';
$db['tb']['autoinit'] = TRUE;
$db['tb']['stricton'] = FALSE;

$db['b']['dbdriver'] = 'sqlsrv'; //Drivers
$db['b']['dbprefix'] = '';
$db['b']['pconnect'] = FALSE;
$db['b']['db_debug'] = TRUE;
$db['b']['cache_on'] = FALSE;
$db['b']['cachedir'] = '';
$db['b']['char_set'] = 'utf8';
$db['b']['dbcollat'] = 'utf8_general_ci';
$db['b']['swap_pre'] = '';
$db['b']['autoinit'] = TRUE;
$db['b']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */