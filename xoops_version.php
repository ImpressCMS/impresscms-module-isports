<?php
/**
* iSports Module
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package	module
* @since		1.0
* @author		vaughan <vaughan@impresscms.org>
* @version	$Id: xoops_version.php 1 2008-08-10 14:00:45Z m0nty_ $
*/

$modversion['name'] = 'iSports';
$modversion['version'] = '1.0 Alpha';
$modversion['description'] = 'A multiple sports statistics & fantasy league module';
$modversion['author'] = 'Vaughan <vaughan@impresscms.org>';
$modversion['credits'] = '';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'images/isports_slogo.png';
$modversion['dirname'] = 'isports';

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = '';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Blocks

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = '';
$modversion['sub'][1]['url'] = '';

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

// Notification
$modversion['hasNotification'] = 0;

// Templates
$i=1;

$modversion['templates'][$i]['file'] = 'isports_header.html';
$modversion['templates'][$i]['description'] = 'Header info';
$i++;

$modversion['templates'][$i]['file'] = 'isports_footer.html';
$modversion['templates'][$i]['description'] = 'Footer info';
$i++;

$i++;
$modversion['templates'][$i]['file'] = 'isports_admin_menu.html';
$modversion['templates'][$i]['description'] = '(Admin) Tabs bar for administration pages';

?>