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

class groups extends model
{
    private $table  = '#_usergroups';
	private $view   = 'groups';
	private $key    = 'id';
	private $order  = 'id';
	private $dir    = 'ASC';
	private $rows   = 'SELECT COUNT(g.id) FROM #_usergroups_map AS g';
	private $sql    = 'SELECT g.* FROM #_usergroups_map AS g';
	
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
					$filters .= 'g.'.$k[2].' LIKE "%'.$v.'%"';
				}
				if(strtolower($k[1]) == 'equal') {
					$options = explode(':', $v);
					$j = 0;
					$filters .= '(';
					foreach($options as $option) {
						if($j != 0) $filters .= ' OR ';
						$filters .= 'g.'.$k[2].' = '.$options[$j];
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
		    $this->sql .= ' ORDER BY g.'.$this->order.' '.$this->dir;
			$this->sql .= $db->limit($offset, $no_of_records_per_page);
			if($config->debug == 1) { echo 'getList: '.$this->sql; }
		    $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		//echo $this->sql;
		return $db->fetchObjectList();
	}

	public function getItem($table, $key)
	{
		return parent::getItem($this->table, $this->key);
	}

    public function saveGroup()
    {
        $app  	= factory::getApplication();
        $db   	= factory::getDatabase();

		$id     = $app->getVar('id');
		$key    = $app->getVar('key');
        
		$db->query("SELECT permisos FROM #_usergroups_map WHERE id = ".$id);
		$permisos = json_decode($db->loadResult(), true);
		
		$permisos[$key] == 1 ? $permisos[$key] = 0 : $permisos[$key] = 1; 

		$permisos = json_encode($permisos);

		$result = $db->updateField('#_usergroups_map', 'permisos', $permisos, 'id', $id);

		if($result) { echo 1; } else { echo 0; }
    }
}
