<?php
/**
* iSports Module
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package	module
* @since		1.0
* @author		vaughan <vaughan@impresscms.org>
* @version	$Id: admin_header.php 1 2008-08-10 14:00:45Z m0nty_ $
*/
include '../../../include/cp_header.php';
include_once ICMS_ROOT_PATH.'/modules/isports/include/functions.php');
include_once ICMS_ROOT_PATH.'/modules/isports/include/common.php');
include_once ICMS_ROOT_PATH.'/class/xoopsformloader.php';

$myts = & MyTextSanitizer::getInstance();

$imagearray = array
(
	'editimg'		=> "<img src='../images/icon/edit.gif' alt='"._AM_ISP_ICO_EDIT."' title='"._AM_ISP_ICO_EDIT."' align='middle'>",
	'deleteimg'	=> "<img src='../images/icon/delete.gif' alt='"._AM_ISP_ICO_DELETE."' title='"._AM_ISP_ICO_DELETE."' align='middle'>",
	'online'		=> "<img src='../images/icon/on.gif' alt='"._AM_ISP_ICO_ONLINE."' title='"._AM_ISP_ICO_ONLINE."' align='middle'>",
	'offline'		=> "<img src='../images/icon/off.gif' alt='"._AM_ISP_ICO_OFFLINE."' title='"._AM_ISP_ICO_OFFLINE."' align='middle'>",
	'approved'	=> "<img src='../images/icon/on.gif' alt=''"._AM_ISP_ICO_APPROVED."' title=''"._AM_ISP_ICO_APPROVED."' align='middle'>",
	'notapproved'	=> "<img src='../images/icon/off.gif' alt='"._AM_ISP_ICO_NOTAPPROVED."' title='"._AM_ISP_ICO_NOTAPPROVED."' align='middle'>",
	'relatedfaq'	=> "<img src='../images/icon/link.gif' alt='"._AM_ISP_ICO_LINK."' title='"._AM_ISP_ICO_LINK."' align='middle'>",
	'relatedurl'	=> "<img src='../images/icon/urllink.gif' alt='"._AM_ISP_ICO_URL."' title='"._AM_ISP_ICO_URL."' align='middle'>",
	'addfaq'		=> "<img src='../images/icon/add.gif' alt='"._AM_ISP_ICO_ADD."' title='"._AM_ISP_ICO_ADD."' align='middle'>",
	'approve'		=> "<img src='../images/icon/approve.gif' alt='"._AM_ISP_ICO_APPROVE."' title='"._AM_ISP_ICO_APPROVE."' align='middle'>",
	'statsimg'	=> "<img src='../images/icon/stats.gif' alt='"._AM_ISP_ICO_STATS."' title='"._AM_ISP_ICO_STATS."' align='middle'>",
	'ignore'		=> "<img src='../images/icon/ignore.gif' alt='"._AM_ISP_ICO_IGNORE."' title='"._AM_ISP_ICO_IGNORE."' align='middle'>",
	'ack_yes'		=> "<img src='../images/icon/on.gif' alt='"._AM_ISP_ICO_ACK."' title='"._AM_ISP_ICO_ACK."' align='middle'>",
	'ack_no'		=> "<img src='../images/icon/off.gif' alt='"._AM_ISP_ICO_REPORT."' title='"._AM_ISP_ICO_REPORT."' align='middle'>",
	'con_yes'		=> "<img src='../images/icon/on.gif' alt='"._AM_ISP_ICO_CONFIRM."' title='"._AM_ISP_ICO_CONFIRM."' align='middle'>",
	'con_no'		=> "<img src='../images/icon/off.gif' alt='"._AM_ISP_ICO_CONBROKEN."' title='"._AM_ISP_ICO_CONBROKEN."' align='middle'>"
);
?>