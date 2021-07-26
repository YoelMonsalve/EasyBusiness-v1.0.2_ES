<?php

// -----------------------------------------------------------------------
// DEFINE SEPARATOR ALIASES
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');
define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE PATHS
// -----------------------------------------------------------------------
/* Defining the SITE_ROOT properly
   This is very important, by security */
if ( !defined('SITE_ROOT') ) {
	/* === By Yoel.- 2020.05.26 ===
	 * My understanding:
	 *
	 * SITE_ROOT is one level above of the folder "include", 
	 * this way if INC_PATH = /localhost/include, then
	 * the SITE_ROOT is deducted as /localhost ... as it 
	 * should be. 
	 * Also, this script is SUPPOSED to be always into the 
	 * folder localhost/includes */

	// my own path (/include)
	$INC_PATH = dirname(__FILE__);
	// then, SITE_ROOT is based in $INC_PATH
	define( "SITE_ROOT", realpath($INC_PATH.'/..') );
}

//define("SITE_PATH", "EasyBusiness/v1.0.2/");
define("SITE_PATH", "");

defined("INC_ROOT")? null: define("INC_ROOT", realpath(dirname(__FILE__)));
define("LIB_PATH_INC", INC_ROOT.DS);

require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'functions.php');
require_once(LIB_PATH_INC.'session.php');
require_once(LIB_PATH_INC.'upload.php');
require_once(LIB_PATH_INC.'database.php');
require_once(LIB_PATH_INC.'sql.php');

?>
