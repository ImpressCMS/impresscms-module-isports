<?php
/**
* iCricket League Statistics Plugin For iSports Module
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package	module
* @since		1.0
* @author		vaughan <vaughan@impresscms.org>
* @version	$Id: icricketstats_version.php 1 2008-08-10 14:00:45Z m0nty_ $
*/

$modversion['name'] = 'iCricket League Stats';
$modversion['version'] = '1.0 Beta1';
$modversion['description'] = 'A nice cricket league stats plugin';
$modversion['author'] = 'Vaughan <vaughan@impresscms.org>';
$modversion['credits'] = 'Mithrandir,ralf57 for the original tplleaguestats module that this is based on';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'images/icricketstats_slogo.png';
$modversion['dirname'] = 'icricketstats';

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/icricketstats.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'isports_icricket_deductedpoints';
$modversion['tables'][1] = 'isports_icricket_leaguematches';
$modversion['tables'][2] = 'isports_icricket_opponents';
$modversion['tables'][3] = 'isports_icricket_seasonnames';
$modversion['tables'][4] = 'isports_icricket_leaguenames';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Templates
// No templates yet

// Blocks
$modversion['blocks'][1]['file'] = 'minitable.php';
$modversion['blocks'][1]['name'] = _MI_CRICK_MINITABLE;
$modversion['blocks'][1]['description'] = _MI_CRICK_MINITABLEDSC;
$modversion['blocks'][1]['show_func'] = 'b_minitable_show';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_CRICK_MENU_HEAD2HEAD;
$modversion['sub'][1]['url'] = 'headtohead.php';
$modversion['sub'][2]['name'] = _MI_CRICK_MENU_SEASSTATS;
$modversion['sub'][2]['url'] = 'season.php';
$modversion['sub'][3]['name'] = _MI_CRICK_MENU_LEAGUESTATS;
$modversion['sub'][3]['url'] = 'league.php';

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

// Notification
$modversion['hasNotification'] = 0;

// Templates
$i=1;

$modversion['templates'][$i]['file'] = 'icricketstats_header.html';
$modversion['templates'][$i]['description'] = 'Header info';
$i++;

$modversion['templates'][$i]['file'] = 'icricketstats_footer.html';
$modversion['templates'][$i]['description'] = 'Footer info';
$i++;

$modversion['templates'][$i]['file'] = 'icricketstats_table.html';
$modversion['templates'][$i]['description'] = '';
$i++;

$modversion['templates'][$i]['file'] = 'icricketstats_topten.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'icricketstats_viewleague.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'icricketstats_viewseason.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'icricketstats_headtohead.html';
$modversion['templates'][$i]['description'] = '';

$i++;
$modversion['templates'][$i]['file'] = 'icricketstats_admin_menu.html';
$modversion['templates'][$i]['description'] = '(Admin) Tabs bar for administration pages';

// Config Settings
global $xoopsDB;
$cricket_get_seasons = $xoopsDB->query("SELECT SeasonID, SeasonName FROM ".$xoopsDB->prefix('isports_icricket_seasonnames')." WHERE SeasonPublish = '1' ORDER BY SeasonName");
while($cricket_thisseason = $xoopsDB->fetchArray($cricket_get_seasons)) {$cricket_allseasons[$cricket_thisseason['SeasonName']] = $cricket_thisseason['SeasonID'];}
$cricket_get_leagues = $xoopsDB->query("SELECT LeagueID, LeagueName FROM ".$xoopsDB->prefix('isports_icricket_leaguenames')." WHERE LeaguePublish = '1' ORDER BY LeagueName");
while($cricket_thisleague = $xoopsDB->fetchArray($cricket_get_leagues)) {$cricket_allleagues[$cricket_thisleague['LeagueName']] = $cricket_thisleague['LeagueID'];}

//Module config setting
$modversion['config'][] = array
(
	'name'		=>	'defaulttable',
	'title'		=>	'_MI_CRICK_PREFDEFLEAGTAB',
	'description'	=>	'',
	'formtype'	=>	'select',
	'valuetype'	=>	'int',
	'options'		=>	array(_MI_CRICK_PREFTABSIM => 4, _MI_CRICK_PREFTABTRA => 1, _MI_CRICK_PREFTABMAT => 2, _MI_CRICK_PREFTABREC => 3),
	'default'		=>	1
);
$modversion['config'][] = array
(
	'name'		=>	'defaultshow',
	'title'		=>	'_MI_CRICK_PREFCAL',
	'description'	=>	'',
	'formtype'	=>	'select',
	'valuetype'	=>	'int',
	'options'		=>	array(_MI_CRICK_PREFCALALL => 1, _MI_CRICK_PREFCALOWN => 2, _MI_CRICK_PREFCALNONE => 3),
	'default'		=>	1
);
$modversion['config'][] = array
(
	'name'		=>	'printdate',
	'title'		=>	'_MI_CRICK_PREFDATE',
	'description'	=>	'',
	'formtype'	=>	'select',
	'valuetype'	=>	'int',
	'options'		=>	array(_MI_CRICK_PREFDATE1 => 1, _MI_CRICK_PREFDATE2 => 2, _MI_CRICK_PREFDATE3 => 3),
	'default'		=>	1
);
$modversion['config'][] = array
(
	'name'		=>	'forwin',
	'title'		=>	'_MI_CRICK_PREFPTSWIN',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'int',
	'default'		=>	3
);
$modversion['config'][] = array
(
	'name'		=>	'fordraw',
	'title'		=>	'_MI_CRICK_PREFPTSDRAW',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'int',
	'default'		=>	1
);
$modversion['config'][] = array
(
	'name'		=>	'forloss',
	'title'		=>	'_MI_CRICK_PREFPTSLOSS',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'int',
	'default'		=>	0
);
$modversion['config'][] = array
(
	'name'		=>	'topoftable',
	'title'		=>	'_MI_CRICK_PREFTOPCOL',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'text',
	'default'		=>	'#CCCCCC'
);
$modversion['config'][] = array
(
	'name'		=>	'bg1',
	'title'		=>	'_MI_CRICK_PREFLISTTMBG',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'text',
	'default'		=>	'#DEDEDE'
);
$modversion['config'][] = array
(
	'name'		=>	'bg2',
	'title'		=>	'_MI_CRICK_PREFMAINCOLSBG',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'text',
	'default'		=>	'#FFFFCC'
);
$modversion['config'][] = array
(
	'name'		=>	'inside',
	'title'		=>	'_MI_CRICK_PREFTTABBGCOL',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'text',
	'default'		=>	'#FFFFFF'
);
$modversion['config'][] = array
(
	'name'		=>	'bordercolour',
	'title'		=>	'_MI_CRICK_PREFTABBDRCOL',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'text',
	'default'		=>	'#CCCCCC'
);
$modversion['config'][] = array
(
	'name'		=>	'tablewidth',
	'title'		=>	'_MI_CRICK_PREFWIDTH',
	'description'	=>	'',
	'formtype'	=>	'textbox',
	'valuetype'	=>	'int',
	'default'		=>	'650'
);

?>