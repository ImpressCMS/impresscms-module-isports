<?php
/**
* Configuring the admin side menu for the module
*
* @copyright	http://www.impresscms.org The ImpressCMS Project
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Vaughan Montgomery aka M0nty <vaughan@impresscms.org>
* @version	$Id$
*/

$i = -1;
$i++;
$adminmenu[$i]['title'] = _MI_ISPORTS_STATISTICS;
$adminmenu[$i]['link'] = 'admin/statistics.php';
$i++;
$adminmenu[$i]['title'] = _MI_ISPORTS_FANTASY;
$adminmenu[$i]['link'] = 'admin/fantasy.php';

global $xoopsModule;
if(isset($xoopsModule))
{
	$i = -1;
	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$xoopsModule->getVar('mid');
	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL.'/modules/isports/';
	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL.'/modules/system/admin.php?fct=modulesadmin&op=update&module='.$xoopsModule->getVar('dirname');
	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL.'/modules/isports/admin/about.php';
}
?>