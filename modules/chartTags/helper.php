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

class chartTagsHelper
{
	public static function getTags($tag) {

		$db = factory::getDatabase();

		$sql = 'SELECT COUNT(incidencia_id) FROM `#_incidencies` WHERE tags = '.$db->quote($tag);
		$db->query($sql);

		return $db->loadResult();
	}

}