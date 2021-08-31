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

class topmenuHelper
{
	public static function getMessages()
	{
		$db   = factory::getDatabase();

	  	$db->query('SELECT u.username, u.email, m.* FROM `#_messages` AS m INNER JOIN `#_users` AS u ON u.id = m.userid WHERE m.estat = 0');

		return $db->fetchObjectList();
	}

	public static function countMessages()
	{
		$db   = factory::getDatabase();

	  	$db->query('SELECT count(id) FROM `#_messages` WHERE estat = 0');

		return $db->loadResult();
	}

	public static function getComments()
	{
		$db   = factory::getDatabase();
		$user = factory::getUser();

	  	$db->query('SELECT u.username, u.email, cn.* FROM `#_comments_notices` AS cn INNER JOIN `#_comments` AS c ON c.comment_id = cn.comment_id INNER JOIN `#_users` AS u ON u.id = c.comment_user WHERE cn.status = 1 AND cn.userid = '.$user->id.' AND c.comment_user != '.$user->id);

		return $db->fetchObjectList();
	}

	public static function countComments()
	{
		$db   = factory::getDatabase();
		$user = factory::getUser();

	  	$db->query('SELECT count(cn.id) FROM `#_comments_notices` AS cn INNER JOIN `#_comments` AS c ON c.comment_id = cn.comment_id WHERE status = 1 AND cn.userid = '.$user->id.' AND c.comment_user != '.$user->id);

		return $db->loadResult();
	}

	public static function isAdmin()
	{
		$user = factory::getUser();

		if($user->level == 1) { return true; } 

		return false;
	}

	public static function isEntry()
	{
		$db   = factory::getDatabase();
		$user = factory::getUser();

	  	$db->query('SELECT type FROM `#_hores` WHERE userid = '.$user->id.' AND DAY(registre) = '.date('d').' AND MONTH(registre) = '.date('m').' AND YEAR(registre) = '.date('Y').' ORDER BY registre DESC LIMIT 1');

		return $db->loadResult();
	}

}
