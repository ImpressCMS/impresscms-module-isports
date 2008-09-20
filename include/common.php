<?php
/**
* Common file of the module included on all pages of the module
*
* @copyright	http://www.impresscms.org The ImpressCMS Project
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Vaughan Montgomery aka M0nty <vaughan@impresscms.org>
* @version	$Id$
*/

if(!defined('ICMS_ROOT_PATH')) die('ICMS root path not defined');

if(!defined('ISPORTS_DIRNAME')) {define('ISPORTS_DIRNAME', $modversion['dirname'] = basename(dirname(dirname(__FILE__))));}
if(!defined('ISPORTS_URL')) {define('ISPORTS_URL', ICMS_URL.'/modules/'.ISPORTS_DIRNAME.'/');}
if(!defined('ISPORTS_ROOT_PATH'))	{define('ISPORTS_ROOT_PATH', ICMS_ROOT_PATH.'/modules/'.ISPORTS_DIRNAME.'/');}
if(!defined('ISPORTS_IMAGES_URL'))	{define('ISPORTS_IMAGES_URL', ISPORTS_URL.'images/');}
if(!defined('ISPORTS_ADMIN_URL'))	{define('ISPORTS_ADMIN_URL', ISPORTS_URL.'admin/');}

// Include the common language file of the module
icms_loadLanguageFile('isports', 'common');

include_once(ISPORTS_ROOT_PATH.'include/functions.php');

// Creating the module object to make it available throughout the module
$isportsModule = icms_getModuleInfo(ISPORTS_DIRNAME);
if(is_object($isportsModule)) {$isports_moduleName = $isportsModule->getVar('name');}

// Find if the user is admin of the module and make this info available throughout the module
$isports_isAdmin = icms_userIsAdmin(ISPORTS_DIRNAME);

// Creating the module config array to make it available throughout the module
$isportsConfig = icms_getModuleConfig(ISPORTS_DIRNAME);

// creating the icmsPersistableRegistry to make it available throughout the module
global $icmsPersistableRegistry;
$icmsPersistableRegistry = IcmsPersistableRegistry::getInstance();

?>