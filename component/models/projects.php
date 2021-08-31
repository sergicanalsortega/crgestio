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

class projects extends model
{
	private $table  = '#_projectes';
	private $view   = 'projects';
	private $key    = 'projecte_id';
	private $order  = 'ordering';
	private $dir    = 'ASC';
	private $sql    = 'SELECT i.* FROM `#_projectes` AS i';
	private $rows   = 'SELECT COUNT(i.projecte_id) FROM `#_projectes` AS i';

	public function getList()
	{
		$db  	= factory::getDatabase();
		$user 	= factory::getUser();
		$app    = factory::getApplication();
		$config = factory::getConfig();
		$session = factory::getSession();

		$page  		 = $app->getVar('page', 1, 'get');
		$orderDir    = $app->getVar('orderDir', $this->dir);
		$colDir      = $app->getVar('colDir', $this->order);

		$no_of_records_per_page = $app->getVar('projects_length', $config->pagination, 'get');
		if($no_of_records_per_page == '*') $no_of_records_per_page = 100000;

		unset($_GET['page'], $_GET['view'], $_GET['projects_length'], $_GET['orderDir'], $_GET['colDir'], $_GET['debug']);

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
		    $this->sql .= ' ORDER BY '.$colDir.' '.$orderDir.' LIMIT '.$offset.', '.$no_of_records_per_page;
			if($config->debug == 1 || $app->getVar('debug', 0) == 1) { echo 'getList: '.$this->sql.'\n'; }
		    $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);

		return $db->fetchObjectList();
	}


	/**
   * Method to reorder item into database
  */
  function reorderItems()
  {
    $db    = factory::getDatabase();
    $items  = json_decode($_POST['items'], true);

    $i = 1;
		foreach($items as $item) {
      $db->query('UPDATE '.$this->table.' SET ordering = '.$i.' WHERE '.$this->key.' = '.$item);
      $i++;
    }
	}

	public function getItem()
	{
		return parent::getItem($this->table, $this->key);
	}

	/**
     * Method to save an item
    */
    function saveItem()
    {
      	$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$config = factory::getConfig();
		$user   = factory::getUser();

		$id  = $app->getVar('projecte_id', 0, 'post');

		if(!$user->getAuth() || ($id == 0 && $user->nou == 0) || ($id != 0 && $user->editar == 0) ) {
			$app->setMessage('No tens suficients permisos per accedir a aquest àrea', 'error');
			$app->redirect($config->site.'/index.php?view=home&layout=dashboard');
		}

		if(!empty($_POST['return'])) $return = base64_decode($app->getVar('return', '', 'post'));
		else $return = $config->site.'/index.php?view='.$this->view;

		unset($_POST['return']);

		if($id == 0) {
			$result = $db->insertRow($this->table, $_POST);
		} else {
			$result = $db->updateRow($this->table, $_POST, $this->key, $id);
		}

		if($result) {
			$app->trigger('onSaveItem');
			$msg  = "El projecte s'ha guardat amb èxit";
			$type = 'success';
		} else {
			$msg  = "El projecte no s'ha pogut guardar";
			$type = 'danger';
		}

		$app->setMessage($msg, $type);
      	$app->redirect($return);
    }

    /**
     * Method to delete an item
    */
    function deleteItems()
    {
      	$db    = factory::getDatabase();
		$user  = factory::getUser();
		$app   = factory::getApplication();
		$config= factory::getConfig();

	  	if(!$user->getAuth() || $user->esborrar == 0) {
			$app->setMessage('No tens suficients permisos per accedir a aquest àrea', 'error');
			$app->redirect($config->site.'/index.php?view=home&layout=dashboard');
		}

      	$items  = json_decode($_POST['items'], true);

      	foreach($items as $item) {
      		$db->deleteRow($this->table, $this->key, $item);
      	}
    }

	public static function getProjectName($id)
	{
		$db = factory::getDatabase();
		$db->query('select nom from #_projectes where projecte_id = '.$id);
		return $db->loadResult();
	}
}
