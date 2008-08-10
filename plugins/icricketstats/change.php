<?php
/*
******************************************************************************
TPLLeagueStats is a league stats software designed for football (soccer) team.

Copyright (C) 2003  Timo Lepp�nen / TPL Design
email:     info@tpl-design.com
www:       www.tpl-design.com/tplleaguestats

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 2of the License,
or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the;
Free Software Foundation,Inc.,
59 Temple Place - Suite 330,
Boston,
MA  02111-1307,
USA.

******************************************************************************
Ported to xoops by 
Mythrandir http://www.web-udvikling.dk
and 
ralf57 http://www.madeinbanzi.it

Cricket League Version & Modifications

* iCricket League Statistics Module
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package	module
* @since		1.0
* @author		vaughan <vaughan@impresscms.org>
* @version	$Id: change.php 1 2008-08-10 14:00:45Z m0nty_ $
******************************************************************************
*/

include ('../../mainfile.php');

$HTTP_REFERER = $_SERVER['HTTP_REFERER'];

$submit = $_POST['submit'];
$submit1 = $_POST['submit1'];
$submit2 = $_POST['submit2'];
$submit3 = $_POST['submit3'];
$submit4 = $_POST['submit4'];
$submit5 = $_POST['submit5'];
$submit6 = $_POST['submit6'];

if($submit)
{
	$cricket_season = intval($_POST['season']);

	//New value for session variable
	$_SESSION['defaultseasonid'] = $cricket_season;

	header("Location: $HTTP_REFERER");
}
elseif($submit1)
{
	$cricket_league = intval($_POST['league']);

	//New value for session variable
	$_SESSION['defaultleagueid'] = $cricket_league;

	header("Location: $HTTP_REFERER");
}
elseif($submit2)
{
	$cricket_change = intval($_POST['change_show']);

	//New value for session variable
	$_SESSION['defaultshow'] = $cricket_change;

	header("Location: index.php?sort=pts");
}
elseif($submit3)
{
	$cricket_change = intval($_POST['change_table']);

	//New value for session variable
	$_SESSION['defaulttable'] = $cricket_change;

	header("Location: $HTTP_REFERER");
}
elseif($submit4)
{
	$cricket_change = intval($_POST['home_id']);

	//New value for session variable
	$_SESSION['defaulthomeid'] = $cricket_change;

	header("Location: $HTTP_REFERER");
}
elseif($submit5)
{
	$cricket_change = intval($_POST['away_id']);

	//New value for session variable
	$_SESSION['defaultawayid'] = $cricket_change;

	header("Location: $HTTP_REFERER");
}
elseif($submit6)
{
	$cricket_moveto = $_POST['moveto'];

	header("Location: $cricket_moveto");
}
else
{
header("Location: index.php?sort=pts");
}
exit();
?>