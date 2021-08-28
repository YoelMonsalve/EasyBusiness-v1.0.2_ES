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
	// the include path (e.g. ../include)
	$INC_PATH = dirname(__FILE__);
	// SITE_ROOT is based in $INC_PATH
	// The SITE_ROOT is the fullpath of the site in the host machine. 
	// It is useful, for example, to require_once(), or include_once() 
	// sentences.
	define( "SITE_ROOT", realpath($INC_PATH.'/..') );
}

/* The SITE_URL, instead, is the URL to this site in the host.
 * Change this to your needs, although we recommend to use the path: 
 * 
 *     /EasyBusiness/v1.0.2_ES/
 *     
 */
define("SITE_URL", "");
//define("SITE_URL", "/EasyBusiness/v1.0.2_ES/");

defined("INC_ROOT")? null: define("INC_ROOT", realpath(dirname(__FILE__)));
define("LIB_PATH_INC", INC_ROOT.DS);

require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'functions.php');
require_once(LIB_PATH_INC.'session.php');
require_once(LIB_PATH_INC.'upload.php');
require_once(LIB_PATH_INC.'database.php');
require_once(LIB_PATH_INC.'sql.php');

?>
