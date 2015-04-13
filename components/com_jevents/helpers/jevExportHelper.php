<?php
/**
 * JEvents Component for Joomla
 *
 * @version     $Id: jevExportHelper.php
 * @package     JEvents
 * @copyright   Copyright (C) 2008-2015 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */

// no direct access
defined('_JEXEC') or die;

/**
 * JEvents component helper.
 *
 * @package		Jevents
 * @since		1.6
 */
class JevExportHelper {

	static function getAddToGCal($row)
	{
		$eventData = JevExportHelper::getEventStringArray($row);

		$urlString['title'] = "text=".$eventData['title'];
		$urlString['dates'] = "dates=".$eventData['dates'];
		$urlString['location'] = "location=".$eventData['location'];
		$urlString['trp'] = "trp=false";
		$urlString['websiteName'] = "sprop=".$eventData['sitename'];
		$urlString['websiteURL'] = "sprop=name:".$eventData['siteurl'];
		$urlString['details'] = "details=".$eventData['details'];
		$link = "http://www.google.com/calendar/event?action=TEMPLATE&".implode("&", $urlString);

		return $link;
	}

	static function getAddToYahooCal($row)
	{
		$eventData = JevExportHelper::getEventStringArray($row);

		$urlString['title'] = "title=".$eventData['title'];
		$urlString['st'] = "st=".$eventData['st'];
		$urlString['et'] = "et=".$eventData['et'];
		$urlString['rawdetails'] = "desc=".$eventData['details'];
		$urlString['location'] = "in_loc=".$eventData['location'];
		$link = "http://calendar.yahoo.com/?v=60&view=d&type=20&".implode("&", $urlString);

		return $link;
	}

	static function getEventStringArray($row)
	{
		$urlString['title'] = urlencode($row->title());
		$urlString['dates'] = JevDate::strftime("%Y%m%dT%H%M%SZ",$row->getUnixStartTime())."/".JevDate::strftime("%Y%m%dT%H%M%SZ",$row->getUnixEndTime());
		$urlString['st'] = JevDate::strftime("%Y%m%dT%H%M%SZ",$row->getUnixStartTime());
		$urlString['et'] = JevDate::strftime("%Y%m%dT%H%M%SZ",$row->getUnixEndTime());
		$urlString['duration'] = (int)$row->getUnixEndTime() - (int)$row->getUnixStartTime();
		$urlString['location'] = urlencode("myaddress");
		$urlString['sitename'] = urlencode("sitename");
		$urlString['siteurl'] = urlencode("siteurl");
		$urlString['rawdetails'] = urlencode($row->get('description'));
		$urlString['details'] = urlencode(strip_tags($row->get('description')));

		return $urlString;
	}
}