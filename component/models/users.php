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

class users extends model
{
  private $table  = '#_Treballadors';
	private $view   = 'users';
	private $key    = 'Id';
	private $order  = 'Id';
	private $dir    = 'DESC';
	private $rows   = 'SELECT COUNT(u.Id) FROM #_Treballadors AS u';
	private $sql    = 'SELECT u.* FROM #_Treballadors AS u';

  public function getList()
	{
		$db  	= factory::getDatabase();
		$user 	= factory::getUser();
		$app    = factory::getApplication();
		$config = factory::getConfig();
		$session = factory::getSession();

		$page  = $app->getVar('page', 1, 'get');

		$no_of_records_per_page = $config->pagination;
		if($no_of_records_per_page == '*') $no_of_records_per_page = 100000;

		unset($_GET['page'], $_GET['view'], $_GET['orderDir'], $_GET['colDir']);

    $offset = ($page-1) * $no_of_records_per_page;

		//get all url vars from filters
		$i = 0;
		$filters = '';
		foreach($_GET as $k => $v) {
			$k = explode('_', $k, 3);
			if($v != '') {

				if (strpos($this->sql, 'WHERE') !== false) $filters.= ' AND ';
				else $filters .= $i == 0  ? ' WHERE ' : ' AND ';

				if(strtolower($k[1]) == 'like') {
					$filters .= 'i.'.$k[2].' LIKE "%'.$v.'%"';
				}
				if(strtolower($k[1]) == 'equal') {
					$options = explode(':', $v);
					$j = 0;
					$filters .= '(';
					foreach($options as $option) {
						if($j != 0) $filters .= ' OR ';
						$filters .= 'i.'.$k[2].' = '.$options[$j];
						$j++;
					}
					$filters .= ')';
				}
				$i++;
			}
		}
		$db->query($this->rows.$filters);
		$count_rows = $db->loadResult();

    if($count_rows > 0) {
			$this->sql .= $filters;
		  $this->sql .= ' ORDER BY u.'.$this->order.' '.$this->dir;
      $this->sql .= $db->limit($offset, $no_of_records_per_page);
			if($config->debug == 1) { echo 'getList: '.$this->sql; }
		  $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		//echo $this->sql;
		return $db->fetchObjectList();
	}

    public function saveUser()
    {
        $app    = factory::getApplication();
        $db     = factory::getDatabase();
        $user   = factory::getUser();
        $lang   = factory::getLanguage();
        $config = factory::getConfig();

        $id = $app->getVar('id', 0);
  
        $obj = new stdClass();
        $obj->Treballadors  = $app->getVar('username');
        $obj->eMail         = $app->getVar('email');
        if($app->getVar('password', '') != '') {
          $obj->_password   = $app->encryptPassword($app->getVar('password'));
        }
        $obj->_level        = $app->getVar('usergroup');
  
        if($id == 0) {
          $obj->_language      = 'ca-es';
          $result = $db->insertRow("#_Treballadors", $obj);
        } else {
          $result = $db->updateRow("#_Treballadors", $obj, 'Id', $id);
        }
  
        if($result) {
          $app->setMessage($lang->get('CW_USERS_SAVE_SUCCESS'), 'success');
        } else {
          $app->setMessage($lang->get('CW_USERS_SAVE_ERROR'), 'danger');
        }
        $app->redirect($config->site.'/index.php?view=users');
    }

    public function getItem($table, $key)
	  {
		  return parent::getItem($this->table, $this->key);
	  }

    public function removeUser()
    {
        $app    = factory::getApplication();
        $db     = factory::getDatabase();
        $lang   = factory::getLanguage();
        $config = factory::getConfig();

        $id   = $app->getVar('id', 0, 'get');
  
        $result = $db->query('DELETE FROM `#_Treballadors` WHERE Id = '.$id);
  
        if($result) {
          $app->setMessage($lang->get('CW_USERS_SAVE_SUCCESS'), 'success');
        } else {
          $app->setMessage($lang->get('CW_USERS_SAVE_ERROR'), 'danger');
        }
        $app->redirect($config->site.'/index.php?view=users');
    }
}
