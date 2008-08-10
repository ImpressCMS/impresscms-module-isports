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
* @version	$Id: index.php 1 2008-08-10 14:00:45Z m0nty_ $
******************************************************************************
*/

include '../../../include/cp_header.php'; //Include file, which checks for permissions and sets navigation

xoops_cp_header();

header("Location:leaguematches.php");

xoops_cp_footer();
?>