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

class Settings
{
    public $show_messages          = 1;

    public $dark_mode              = 0;

    /**
     * Constructor
    */
    function __construct() {
        $this->get();
    }

    /**
     * Method to get the user object
     * @param id int the user id
     * @return object
    */
    function get()
    {
        $db  = factory::getDatabase();
        $db->query('SELECT * FROM #_settings WHERE Id = 1');
        $row = $db->fetchArray();

        foreach($row as $k => $v) {
            $this->$k = $v;
        }
    }
}
?>
