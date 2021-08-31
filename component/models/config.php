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

include('includes/model.php');

class config extends model
{

  public function saveConfig()
  {
      $app  = factory::getApplication();
      $db   = factory::getDatabase();
      $lang = factory::getLanguage();

      $obj = new stdClass();
      $obj->show_messages   = $app->getVar('show_messages', 0);
      $obj->dark_mode       = $app->getVar('dark_mode', 0);

      $result = $db->updateRow("#_settings", $obj, 'Id', 1);

      if($result) {
        $app->setMessage($lang->get('CW_SETTINGS_SAVE_SUCCESS'), 'success');
      } else {
        $app->setMessage($lang->get('CW_SETTINGS_SAVE_ERROR'), 'danger');
      }
      $app->redirect($config->site.'/index.php?view=config');
    }
}
