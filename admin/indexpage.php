<?php
/**
* iSports Module
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package	module
* @since		1.0
* @author		vaughan <vaughan@impresscms.org>
* @version	$Id: indexpage.php 1 2008-08-10 14:00:45Z m0nty_ $
*/

include 'admin_header.php';

$op = isset($_REQUEST['op']) ? trim(StopXSS($_REQUEST['op'])) : 'default';

switch ($op)
{
	case 'save':
		global $xoopsDB;
	
		$indexheading = $myts->addslashes($_POST['indexheading']);
		$indexheader = $myts->addslashes($_POST['indexheader']);
		$indexfooter = $myts->addslashes($_POST['indexfooter']);
		$indeximage = $myts->addslashes($_POST['indeximage']);
		$dohtml = isset($_POST['dohtml']);
		$dosmiley = isset($_POST['dosmiley']);
		$doxcodes = isset($_POST['doxcodes']);
		$doimages = isset($_POST['doimages']);
		$dobreak = isset($_POST['dobreak']);
		$indexheaderalign = $_POST['indexheaderalign'];
		$indexfooteralign = $_POST['indexfooteralign'];
	
		$sql = sprintf("UPDATE %s SET indexheading = %s, indexheader = %s, indexfooter = %s, indeximage = %s, indexheaderalign = %s, indexfooteralign = %s, dohtml = '%u', dosmiley = '%u', doxcodes = '%u', doimages = '%u', dobreak = '%u'", $xoopsDB->prefix('isports_indexpage'), $xoopsDB->quoteString($indexheading), $xoopsDB->quoteString($indexheader), $xoopsDB->quoteString($indexfooter), $xoopsDB->quoteString($indeximage), $xoopsDB->quoteString($indexheaderalign), $xoopsDB->quoteString($indexfooteralign), intval($dohtml), intval($dosmiley), intval($doxcodes), intval($doimages), intval($dobreak));

		$result = $xoopsDB->query($sql);
		if(!$result) {redirect_header(ISPORTS_URL.'admin/indexpage.php', 1, _AM_ISP_IPAGE_NOTUPDATED);}
		else {redirect_header(ISPORTS_URL.'admin/indexpage.php', 1, _AM_ISP_IPAGE_UPDATED);}
	break;

	default:
		include_once ISPORTS_ROOT_PATH.'class/isp_lists.php';
		include ISPORTS_ROOT_PATH.'/class/xoopsformloader.php';
	
		global $xoopsModuleConfig, $xoopsDB;

		$result = $xoopsDB->query("SELECT indexheading, indexheader, indexfooter, indeximage, indexheaderalign, indexfooteralign, dohtml, dosmiley, doxcodes, doimages, dobreak FROM ".$xoopsDB->prefix('isports_indexpage')."");
		list($indexheading, $indexheader, $indexfooter, $indeximage, $indexheaderalign, $indexfooteralign, $dohtml, $dosmiley, $doxcodes, $doimages, $dobreak) = $xoopsDB->fetchrow($result);
	
		isports_icms_cp_header();
		isports_adminMenu(1, _AM_ISP_INDEXPAGE);
	
		echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_ISP_IPAGE_INFORMATION."</legend>\n
			<div style='padding: 8px;'>"._AM_ISP_MINDEX_PAGEINFOTXT."</div>\n
			</fieldset>\n";
	
		$sform = new XoopsThemeForm(_AM_ISP_IPAGE_MODIFY, 'op', xoops_getenv('PHP_SELF'));
		$sform->addElement(new XoopsFormText(_AM_ISP_IPAGE_CTITLE, 'indexheading', 60, 60, $indexheading), false);
		$graph_array = &ispLists::getListTypeAsArray(ICMS_ROOT_PATH.'/'.$xoopsModuleConfig['mainimagedir'], $type = 'images');
		$indeximage_select = new XoopsFormSelect('', 'indeximage', $indeximage);
		$indeximage_select->addOptionArray($graph_array);
		$indeximage_select->setExtra("onchange='showImgSelected(\"image\", \"indeximage\", \"".$xoopsModuleConfig['mainimagedir']."\", \"\", \"".ICMS_URL."\")'");
		$indeximage_tray = new XoopsFormElementTray(_AM_ISP_IPAGE_CIMAGE, '&nbsp;');
		$indeximage_tray->addElement($indeximage_select);
		if(!empty($indeximage))
		{
			$indeximage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='".ICMS_URL."/".$xoopsModuleConfig['mainimagedir']."/".$indeximage."' name='image' id='image' alt='' title='image' />"));
		}
		else
		{
			$indeximage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='".ICMS_URL."/uploads/blank.gif' name='image' id='image' alt='' title='image' />"));
		}
		$sform->addElement($indeximage_tray);
	
		$sform->addElement(new XoopsFormDhtmlTextArea(_AM_ISP_IPAGE_CHEADING, 'indexheader', $indexheader, 15, 60));
		$headeralign_select = new XoopsFormSelect(_AM_ISP_IPAGE_CHEADINGA, 'indexheaderalign', $indexheaderalign);
		$headeralign_select->addOptionArray(array('left' => _AM_ISP_IPAGE_CLEFT, 'right' => _AM_ISP_IPAGE_CRIGHT, 'center' => _AM_ISP_IPAGE_CCENTER));
		$sform->addElement($headeralign_select);
		$sform->addElement(new XoopsFormTextArea(_AM_ISP_IPAGE_CFOOTER, 'indexfooter', $indexfooter, 10, 60));
		$footeralign_select = new XoopsFormSelect(_AM_ISP_IPAGE_CFOOTERA, 'indexfooteralign', $indexfooteralign);
		$footeralign_select->addOptionArray(array('left' => _AM_ISP_IPAGE_CLEFT, 'right' => _AM_ISP_IPAGE_CRIGHT, 'center' => _AM_ISP_IPAGE_CCENTER));
		$sform->addElement($footeralign_select);
	
		$options_tray = new XoopsFormElementTray(_AM_ISP_TEXTOPTIONS, '<br />');
	
		$html_checkbox = new XoopsFormCheckBox('', 'dohtml', $dohtml);
		$html_checkbox->addOption(1, _AM_ISP_ALLOWHTML);
		$options_tray->addElement($html_checkbox);
	
		$smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $dosmiley);
		$smiley_checkbox->addOption(1, _AM_ISP_ALLOWSMILEY);
		$options_tray->addElement($smiley_checkbox);
	
		$xcodes_checkbox = new XoopsFormCheckBox('', 'doxcodes', $doxcodes);
		$xcodes_checkbox->addOption(1, _AM_ISP_ALLOWXCODE);
		$options_tray->addElement($xcodes_checkbox);
	
		$noimages_checkbox = new XoopsFormCheckBox('', 'doimages', $doimages);
		$noimages_checkbox->addOption(1, _AM_ISP_ALLOWIMAGES);
		$options_tray->addElement($noimages_checkbox);
	
		$breaks_checkbox = new XoopsFormCheckBox('', 'dobreak', $dobreak);
		$breaks_checkbox->addOption(1, _AM_ISP_ALLOWBREAK);
		$options_tray->addElement($breaks_checkbox);
		$sform->addElement($options_tray);
	
		$button_tray = new XoopsFormElementTray('', '');
		$hidden = new XoopsFormHidden('op', 'save');
		$button_tray->addElement($hidden);
		$button_tray->addElement(new XoopsFormButton('', 'post', _AM_ISP_BSAVE, 'submit'));
		$sform->addElement($button_tray);
		$sform->display();
	break;
}
xoops_cp_footer();
?>