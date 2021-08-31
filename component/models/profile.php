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

class profile extends model
{
    function saveProfile()
    {

      $app  = factory::getApplication();
      $db   = factory::getDatabase();
      $user = factory::getUser();
      $lang = factory::getLanguage();

      $obj = new stdClass();
      $obj->eMail     = $_POST['eMail'];
      if($_POST['password'] != '') {
        $obj->_password  = $app->encryptPassword($_POST['password']);
      }
      //$obj->language  = $_POST['language'];
      $obj->DNI                         = $_POST['DNI'];
      $obj->Treballadors                = $_POST['Treballadors'];
      $obj->poblacio                    = $_POST['poblacio'];
      $obj->CategoriaProfessional       = $_POST['CategoriaProfessional'];
      $obj->_apikey                     = $_POST['apikey'];
      $obj->_language                   = $_POST['language'];

      $result = $db->updateRow("#_users", $obj, 'id', $user->id);

      if($result) {
          $app->setMessage( $lang->get('CW_SETTINGS_SAVE_SUCCESS'), 'success');
      } else {
          $app->setMessage( $lang->get('CW_SETTINGS_SAVE_ERROR'), 'danger');
      }
      $app->redirect($config->site.'/index.php?view=profile');
    }
}
