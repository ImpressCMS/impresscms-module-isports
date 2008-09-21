<?php
/**
* Classes responsible for managing isports statistics objects
*
* @copyright	http://www.impresscms.org The ImpressCMS Project
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Vaughan Montgomery aka M0nty <vaughan@impresscms.org>
* @version	$Id$
*/

if(!defined('ICMS_ROOT_PATH')) {die('ICMS root path not defined');}

// including the IcmsPersistabelSeoObject
include_once ICMS_ROOT_PATH.'/kernel/icmspersistableseoobject.php';

/**
* Statistics status definitions
*/
define('ISPORTS_STAT_STATUS_PUBLISHED', 1);
define('ISPORTS_STAT_STATUS_PRIVATE', 2);

/**
* Review status definitions
*/
define('ISPORTS_REVIEW_STATUS_PUBLISHED', 1);
define('ISPORTS_REVIEW_STATUS_PENDING', 2);
define('ISPORTS_REVIEW_STATUS_DRAFT', 3);
define('ISPORTS_REVIEW_STATUS_PRIVATE', 4);

class IsportsStat extends IcmsPersistableSeoObject
{
	/**
     * Constructor
     *
     * @param object $handler IsportsStatisticsHandler object
     */
	public function __construct(&$handler)
	{
		global $xoopsConfig;

		$this->IcmsPersistableObject($handler);

		$this->quickInitVar('stat_id', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('stat_title', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('stat_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('stat_published_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('stat_review_published_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('stat_review_uid', XOBJ_DTYPE_INT);
		$this->quickInitVar('stat_status', XOBJ_DTYPE_INT, false, false, false, ISPORTS_STAT_STATUS_PUBLISHED);
		$this->quickInitVar('stat_review_status', XOBJ_DTYPE_INT, false, false, false, ISPORTS_STAT_REVIEW_STATUS_PUBLISHED);
		$this->quickInitVar('stat_canreview', XOBJ_DTYPE_INT, false, false, false, true);
		$this->quickInitVar('stat_reviews', XOBJ_DTYPE_INT);
		$this->hideFieldFromForm('stat_reviews');

		$this->quickInitVar('stat_notification_sent', XOBJ_DTYPE_INT);
		$this->hideFieldFromForm('stat_notification_sent');
		$this->quickInitVar('review_notification_sent', XOBJ_DTYPE_INT);
		$this->hideFieldFromForm('review_notification_sent');

		$this->initCommonVar('counter', false);
		$this->initCommonVar('dohtml', false, true);
		$this->initCommonVar('dobr', false);
		$this->initCommonVar('doimage', false, true);
		$this->initCommonVar('dosmiley', false, true);
		$this->initCommonVar('doxcode', false, true);

		$this->setControl('stat_review', 'dhtmltextarea');
		$this->setControl('stat_review_uid', 'user');
		$this->setControl('stat_status', array(
										'itemHandler' => 'stat',
										'method' => 'getStat_statusArray',
										'module' => 'isports'));
		$this->setControl('stat_review_status', array(
										'itemHandler' => 'stat_review',
										'method' => 'getStat_Review_statusArray',
										'module' => 'isports'));

		$this->setControl('stat_canreview', 'yesno');

		$this->IcmsPersistableSeoObject();
    }

	/**
	* Overriding the IcmsPersistableObject::getVar method to assign a custom method on some
	* specific fields to handle the value before returning it
	*
	* @param str $key key of the field
	* @param str $format format that is requested
	* @return mixed value of the field that is requested
	*/
	function getVar($key, $format = 's')
	{
		if($format == 's' && in_array($key, array('stat_review_uid', 'stat_review_status'))) {return call_user_func(array($this,$key));}
		return parent::getVar($key, $format);
	}

	/**
	* Retrieving the name of the poster, linked to his profile
	*
	* @return str name of the poster
	*/
	function stat_review_uid() {return icms_getLinkedUnameFromId($this->getVar('stat_review_uid', 'e'));}

	/**
	* Retrieving the status of the statistic
	*
	* @param str status of the statistic
	* @return mixed $stat_statusArray[$ret] status of the statistic
	*/
	function stat_status()
	{
		$ret = $this->getVar('stat_status', 'e');
		$stat_statusArray = $this->handler->getStat_statusArray();
		return $stat_statusArray[$ret];
	}

	/**
	* Retrieving the status of the statistic Review
	*
	* @param str status of the statistic review
	* @return mixed $stat_review_statusArray[$ret] status of the statistic review
	*/
	function stat_review_status()
	{
		$ret = $this->getVar('stat_review_status', 'e');
		$stat_review_statusArray = $this->handler->getStat_Review_statusArray();
		return $stat_review_statusArray[$ret];
	}

	/**
	* Returns the need to br
	*
	* @return bool true | false
	*/
	function need_do_br()
	{
		global $xoopsConfig, $xoopsUser;

		$isports_module = icms_getModuleInfo('isports');
		$groups = $xoopsUser->getGroups();

		$editor_default = $xoopsConfig['editor_default'];
		$gperm_handler = xoops_getHandler('groupperm');
		if(file_exists(ICMS_EDITOR_PATH.'/'.$editor_default.'/xoops_version.php' ) && $gperm_handler->checkRight('use_wysiwygeditor', $isports_module->mid(), $groups))
		{return false;}
		else {return true;}
	}

	/**
	* Check if user has access to view this statistic
	*
	* User will be able to view the statistic if
	*    - the status of the statistic is Published OR
	*    - he is an admin
	*
	* @return bool true if user can view this statistic, false if not
	*/
	function accessGranted()
	{
		global $isports_isAdmin, $xoopsUser;
		return $this->getVar('stat_status', 'e') == ISPORTS_STAT_STATUS_PUBLISHED || $isports_isAdmin;
	}

	/**
	* Retrieve statistics review info (number of reviews)
	*
	* @return str statistic review info
	*/
	function getReviewsInfo()
	{
		$stat_reviews = $this->getVar('stat_reviews');
		if($stat_reviews) {return '<a href="'.$this->getItemLink(true).'#reviews_container">'.sprintf(_CO_ISPORTS_STAT_REVIEWS_INFO, $stat_reviews).'</a>';}
		else {return _CO_ISPORTS_STAT_NO_REVIEW;}
	}

	/**
	* Retrieve the statistics
	*
	* @return str statistics content
	*/
	function getStatTable() {
		$ret = $this->getVar('stat_table');
		return $ret;
	}

	/**
	* Retrieve the reviews
	*
	* @return str reviews content
	*/
	function getStatReviewContent() {
		$ret = $this->getVar('stat_review');
		return $ret;
	}

	/**
	* Check to see wether the current user can edit or delete this review
	*
	* @return bool true if he can, false if not
	*/
	function userCanEditAndDelete()
	{
		global $xoopsUser, $isports_isAdmin;
		if(!is_object($xoopsUser)) {return false;}
		if($isports_isAdmin) {return true;}
		return $this->getVar('stat_review_uid', 'e') == $xoopsUser->uid();
	}

	/**
	* Sending the notification related to a statistic being published
	*
	* @return VOID
	*/
	function sendNotifStatPublished() {
		global $isportsModule;
		$module_id = $isportsModule->getVar('mid');
		$notification_handler = xoops_getHandler('notification');
	
		$tags['STAT_TITLE'] = $this->getVar('stat_title');
		$tags['STAT_URL'] = $this->getItemLink(true);
	
		$notification_handler->triggerEvent('global', 0, 'stat_published', $tags, array(), $module_id);
	}

	/**
	* Sending the notification related to a review being published
	*
	* @return VOID
	*/
	function sendNotifStatReviewPublished() {
		global $isportsModule;
		$module_id = $isportsModule->getVar('mid');
		$notification_handler = xoops_getHandler('notification');
	
		$tags['STAT_REVIEW'] = $this->getVar('stat_review');
		$tags['STAT_URL'] = $this->getItemLink(true);
	
		$notification_handler->triggerEvent('global', 0, 'stat_review_published', $tags, array(), $module_id);
	}
	/**
	* Overridding IcmsPersistable::toArray() method to add a few info
	*
	* @return array of post info
	*/
	function toArray()
	{
		$ret = parent::toArray();
		$ret['stat_info'] = $this->getStatInfo();
		$ret['stat_review_info'] = $this->getReviewsInfo();
		$ret['stat_table'] = $this->getStatTable();
		$ret['editItemLink'] = $this->getEditItemLink(false, true, true);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(false, true, true);
		return $ret;
	}
}

class IsportsStatHandler extends IcmsPersistableObjectHandler
{
	/**
	* @var array of status
	*/
	var $_stat_statusArray = array();
	
	/**
	* Constructor
	*/
	public function __construct(&$db) {$this->IcmsPersistableObjectHandler($db, 'stat', 'stat_id', 'stat_title', 'stat_content', 'isports');}
	
	/**
	* Retreive the possible status of a statistic object
	*
	* @return array of status
	*/
	function getStat_statusArray()
	{
		if(!$this->_stat_statusArray)
		{
			$this->_stat_statusArray[ISPORTS_STAT_STATUS_PUBLISHED] = _CO_ISPORTS_STAT_STATUS_PUBLISHED;
			$this->_stat_statusArray[ISPORTS_STAT_STATUS_PRIVATE] = _CO_ISPORTS_STAT_STATUS_PRIVATE;
		}
		return $this->_stat_statusArray;
	}

	/**
	* Retreive the possible status of a statistic object
	*
	* @return array of status
	*/
	function getStat_Review_statusArray()
	{
		if(!$this->_stat_review_statusArray)
		{
			$this->_stat_review_statusArray[ISPORTS_STAT_REVIEW_STATUS_PUBLISHED] = _CO_ISPORTS_STAT_REVIEW_STATUS_PUBLISHED;
			$this->_stat_review_statusArray[ISPORTS_STAT_REVIEW_STATUS_PENDING] = _CO_ISPORTS_STAT_REVIEW_STATUS_PENDING;
			$this->_stat_review_statusArray[ISPORTS_STAT_REVIEW_STATUS_DRAFT] = _CO_ISPORTS_STAT_REVIEW_STATUS_DRAFT;
			$this->_stat_review_statusArray[ISPORTS_STAT_REVIEW_STATUS_PRIVATE] = _CO_ISPORTS_STAT_REVIEW_STATUS_PRIVATE;
		}
		return $this->_stat_review_statusArray;
	}

	/**
	* Create the criteria that will be used by getStats and getStatsCount
	*
	* @param int $start to which record to start
	* @param int $limit limit of stats to return
	* @param int $stat_id if specified, only the statistics of this id will be returned
	* @return CriteriaCompo $criteria
	*/
	function getStatsCriteria($start=0, $limit=0, $stat_id=false)
	{
		$criteria = new CriteriaCompo();
		if($start) {$criteria->setStart($start);}
		if($limit) {$criteria->setLimit(intval($limit));}
		$criteria->setSort('stat_published_date');
		$criteria->setOrder('DESC');
		$criteria->add(new Criteria('stat_status', ISPORTS_STAT_STATUS_PUBLISHED));
		if($stat_id) {$criteria->add(new Criteria('stat_id', $stat_id));}
		return $criteria;
	}

	/**
	* Create the criteria that will be used by getStatsReview and getStatsReviewCount
	*
	* @param int $start to which record to start
	* @param int $limit limit of stats to return
	* @param int $stat_id if specified, only the reviews of this id will be returned
	* @return CriteriaCompo $criteria
	*/
	function getStatsReviewCriteria($start=0, $limit=0, $stat_id=false)
	{
		$criteria = new CriteriaCompo();
		if($start) {$criteria->setStart($start);}
		if($limit) {$criteria->setLimit(intval($limit));}
		$criteria->setSort('stat_review_published_date');
		$criteria->setOrder('DESC');
		$criteria->add(new Criteria('stat_review_status', ISPORTS_STAT_REVIEW_STATUS_PUBLISHED));
		if($stat_id) {$criteria->add(new Criteria('stat_id', $stat_id));}
		return $criteria;
	}

	/**
	* Get stats as array, ordered by stat_published_date DESC
	*
	* @param int $start to which record to start
	* @param int $stat_id if specified, only the stat of this id will be returned
	* @return array of posts
	*/
	function getStats($start=0, $stat_id=false)
	{
		$isportsModuleConfig = icms_getModuleConfig('isports');
	
		$criteria = $this->getStatsCriteria($start, $isportsModuleConfig['stats_limit'], $stat_id);
		$ret = $this->getObjects($criteria, true, false);
		return $ret;
	}

	/**
	* Get stats reviews as array, ordered by stat_review_published_date DESC
	*
	* @param int $start to which record to start
	* @param int $stat_id if specified, only the review of this id will be returned
	* @return array of posts
	*/
	function getStatsReview($start=0, $stat_id=false)
	{
		$isportsModuleConfig = icms_getModuleConfig('isports');
	
		$criteria = $this->getStatsReviewCriteria($start, $isportsModuleConfig['stats_limit'], $stat_id);
		$ret = $this->getObjects($criteria, true, false);
		return $ret;
	}

    /**
     * Get a list of users
     *
     * @return array list of users
     */
    function getPostersArray() {
    	$member_handler = xoops_getHandler('member');
    	return $member_handler->getUserList();
    }

	/**
	* Get stats count
	*
	* @param int $stat_id if specified, only the stats of this id will be returned
	* @return array of stats
	*/
	function getStatsCount($stat_id)
	{
		$criteria = $this->getStatsCriteria(false, false, $stat_id);
		return $this->getCount($criteria);
	}

	/**
	* Get stats review count
	*
	* @param int $stat_id if specified, only the reviews of this id will be returned
	* @return array of stats
	*/
	function getStatsReviewCount($stat_id)
	{
		$criteria = $this->getStatsReviewCriteria(false, false, $stat_id);
		return $this->getCount($criteria);
	}

	/**
	* Get Stats requested by the global search feature
	*
	* @param array $queryarray array containing the searched keywords
	* @param bool $andor wether the keywords should be searched with AND or OR
	* @param int $limit maximum results returned
	* @param int $offset where to start in the resulting dataset
	* @param int $userid should we return posts by specific poster ?
	* @return array array of posts
	*/
	function getStatsForSearch($queryarray, $andor, $limit, $offset, $userid)
	{
		$criteria = new CriteriaCompo();
	
		if($queryarray)
		{
			$criteriaKeywords = new CriteriaCompo();
			for($i = 0; $i < count($queryarray); $i++)
			{
				$criteriaKeyword = new CriteriaCompo();
				$criteriaKeyword->add(new Criteria('stat_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new Criteria('stat_table', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new Criteria('stat_status', ISPORTS_STAT_STATUS_PUBLISHED));
		return $this->getObjects($criteria, true, false);
	}

	/**
	* Update number of reviews on a stat
	*
	* This method is triggered by isports_rev_update in include/functions.php which is
	* called by ImpressCMS when updating reviews
	*
	* @param int $stat_id id of the stat to update
	* @param int $total_num total number of reviews so far in this stat
	* @return VOID
	*/
	function updateReviews($stat_id, $total_num)
	{
		$statObj = $this->get($stat_id);
		if($statObj && !$statObj->isNew())
		{
			$statObj->setVar('stat_reviews', $total_num);
			$this->insert($statObj, true);
		}
	}

	/**
	* Check wether the current user can submit a new review or not
	*
	* @return bool true if he can false if not
	*/
	function userCanSubmit()
	{
		global $xoopsUser, $isports_isAdmin;
		$isportsModuleConfig = icms_getModuleConfig('isports');
	
		if(!is_object($xoopsUser)) {return false;}
		if($isports_isAdmin) {return true;}
		$user_groups = $xoopsUser->getGroups();
		return count(array_intersect($isportsModuleConfig['review_groups'], $user_groups)) > 0;
	}

	/**
	* BeforeSaveReview event
	*
	* Event automatically triggered by IcmsPersistable Framework before the object is inserted or updated.
	*
	* @param object $obj IsportsStat object
	* @return true
	*/
	function beforeSaveReview(&$obj) {
		$obj->setVar('dobr', $obj->need_do_br());
		return true;
	}

	/**
	* AfterSave event
	*
	* Event automatically triggered by IcmsPersistable Framework after the object is inserted or updated
	*
	* @param object $obj IsportsStat object
	* @return true
	*/
	function afterSave(&$obj)
	{
		if(!$obj->getVar('stat_notification_sent') && $obj->getVar('stat_status', 'e') == ISPORTS_STAT_STATUS_PUBLISHED)
		{
			$obj->sendNotifStatPublished();
			$obj->setVar('stat_notification_sent', true);
			$this->insert($obj);
		}
		return true;
	}

	/**
	* AfterSaveReview event
	*
	* Event automatically triggered by IcmsPersistable Framework after the object is inserted or updated
	*
	* @param object $obj IsportsReview object
	* @return true
	*/
	function afterSaveReview(&$obj)
	{
		if(!$obj->getVar('review_notification_sent') && $obj->getVar('reviews_status', 'e') == ISPORTS_REVIEW_STATUS_PUBLISHED) {
			$obj->sendNotifReviewPublished();
			$obj->setVar('review_notification_sent', true);
			$this->insert($obj);
		}
		return true;
	}
}
?>