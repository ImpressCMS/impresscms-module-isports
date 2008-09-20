<?php
/**
* Header page included at the begining of each page on user side of the mdoule
*
* @copyright	http://www.impresscms.org The ImpressCMS Project
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Vaughan Montgomery aka M0nty <vaughan@impresscms.org>
* @version	$Id$
*/

if(!defined('ICMS_ROOT_PATH')) die('ICMS root path not defined');

$xoopsTpl->assign('isports_adminpage', isports_getModuleAdminLink());
$xoopsTpl->assign('isports_is_admin', $isports_isAdmin);
$xoopsTpl->assign('isports_url', ISPORTS_URL);
$xoopsTpl->assign('isports_images_url', ISPORTS_IMAGES_URL);

$xoTheme->addStylesheet(ISPORTS_URL.'module.css');

include_once(ICMS_ROOT_PATH.'/footer.php');
?>