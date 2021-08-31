<?php
/**
 * @version     1.0.0 Afi Framework $
 * @package     Afi Framework
 * @copyright   Copyright © 2014 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@afi.cat
 * @website	    http://www.afi.cat
 *
*/

defined('_Afi') or die ('restricted access');

class onlineHelper
{
	public static function getOnlineUsers() {

		$db = factory::getDatabase();

		$sql = 'SELECT DISTINCT(s.userid), u.username FROM `#_sessions` AS s INNER JOIN `#_users` AS u ON u.id = s.userid WHERE DATE(s.lastvisitDate) = CURDATE()';
		$db->query($sql);

		return $db->fetchObjectList();
	}

}