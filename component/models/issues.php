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

class issues extends model
{
	private $table  = '#_incidencies';
	private $view   = 'issues';
	private $key    = 'incidencia_id';
	private $order  = 'incidencia_id';
	private $dir    = 'DESC';
	private $rows   = 'SELECT COUNT(i.incidencia_id) FROM `#_incidencies` AS i ';
	private $sql    = 'SELECT i.incidencia_id, i.nom, i.tipus, i.estat, i.tags, i.projecteId, i.usergroup, DATE_FORMAT(i.data_incidencia,"%d/%m/%Y") AS fecha, ' .
						' p.nom AS project, CONCAT(p.abreujatura, "-", i.num_incidencia) AS num, u.username, ' .
						' CASE estat ' .
						' when 1 then "Pendent" ' .
						' when 2 then "Progrés" ' .
						' when 3 then "Resolt" ' .
						' when 4 then "Descartat" ' .
						' else concat("¿",estat,"?") ' .
						' END AS estatText ' .
						' FROM `#_incidencies` AS i ' .
							' LEFT JOIN `#_projectes` AS p ON p.projecte_id = i.projecteId ' .
							' LEFT JOIN `#_users` AS u ON u.id = i.usuari';

	public function getList()
	{
		$db  	= factory::getDatabase();
		$user 	= factory::getUser();
		$app    = factory::getApplication();
		$config = factory::getConfig();
		$session = factory::getSession();

		$page  = $app->getVar('page', 1, 'get');
		$orderDir    = $app->getVar('orderDir', $this->dir);
		$colDir      = $app->getVar('colDir', $this->order);

		$groups = $user->getGroups($user->level);
		//print_r($groups);

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
		//si te projectes assignats només ha de veure aquests
		if($user->projects != '' && $user->projects != '*') {
			strpos($filters, 'WHERE') !== false ? $project .= ' AND ' : $project .= ' WHERE ';
			$project .= ' (i.projecteId IN ('.$db->quote($user->projects).'))';
		}

		//comprovem usergroup and no admin
		if($user->level != 1) {
			strpos($project, 'WHERE') !== false ? $project .= ' AND ' : $project .= ' WHERE ';
			$project .= ' (i.usergroup IN ('.implode(',',$groups).'))';
		}

		$db->query($this->rows.$filters.$project);
		$count_rows = $db->loadResult();

        if($count_rows > 0) {

			$this->sql .= $filters;
			//si te projectes assignats només ha de veure aquests
			if($user->projects != '' && $user->projects != '*') {
				strpos($this->sql, 'WHERE') !== false ? $this->sql .= ' AND ' : $this->sql .= ' WHERE ';
				$this->sql .= ' (i.projecteId IN ('.$db->quote($user->projects).'))';
			}
			//comprovem usergroup and no admin
			if($user->level != 1) {
				strpos($this->sql, 'WHERE') !== false ? $this->sql .= ' AND ' : $this->sql .= ' WHERE ';
				$this->sql .= ' (i.usergroup IN ('.implode(',',$groups).'))';
			}

		    $this->sql .= ' ORDER BY '.$colDir.' '.$orderDir.' LIMIT '.$offset.', '.$no_of_records_per_page;
			if($config->debug == 1 || $app->getVar('debug', 0) == 1) { echo 'getList: '.$this->sql.'\n'; }
		    $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		return $db->fetchObjectList();
	}

	public function getItem()
	{
		return parent::getItem($this->table, $this->key);
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

	public static function getProjectName($id)
	{
		$db = factory::getDatabase();

		$sql = 'select nom from #_projectes where projecte_id = '.$id;
		if($config->debug == 1) { echo 'getProjectsName: '.$sql.'\n'; }
		$db->query($sql);

		return $db->loadResult();
	}

	public static function getProjectLogo($id)
	{
		$db = factory::getDatabase();

		$sql = 'select logo from #_projectes where projecte_id = '.$id;
		$db->query($sql);
		if($config->debug == 1) { echo 'getProjectsLogo: '.$sql.'\n'; }

		return $db->loadResult();
	}

	/**
     * Method to upload user picture
    **/
    function upload()
    {
    	$app  = factory::getApplication();
      $db   = factory::getDatabase();
      $lang = factory::getLanguage();
			$user = factory::getUser();

      $path = 'assets/img/uploads/';
			$type = 'success';

			if (!empty($_FILES)) {

      	$issue  = $app->getVar('incidencia_id', 0);

				$tempFile = $_FILES['file']['tmp_name'];
    		$targetPath = CWPATH_BASE . DS. $path;
    		$targetFile =  $targetPath. $_FILES['file']['name'];

    		move_uploaded_file($tempFile, $targetFile);

				$attach = new stdClass();
				$attach->image = $_FILES['file']['name'];
				$attach->path = $path;
				$attach->incidencia_id = $issue;
				$attach->userid = $user->id;
				$db->insertRow('#_attachments', $attach);

				$msg = 'Imatge pujada amb èxit';

				$app->trigger('onRewardUser', $attach);

      } else {
        $msg = $lang->get('CW_SETTINGS_UPLOAD_ERROR_NOIMAGE');
				$type = 'error';
      }
			$app->setMessage($msg, $type);
      $app->redirect('index.php?view=issues&layout=edit&id='.$issue);
    }

		public function getAttachments() {
			$db 	= factory::getDatabase();
			$app 	= factory::getApplication();

			$id  = $app->getVar('id', 0);

			if($id != 0) {
				$db->query('SELECT * FROM #_attachments WHERE incidencia_id = '.$id);
				$rows = $db->fetchObjectList();
				return $rows;
			}
		}

    	public function saveItem()
	  	{
			$db 	= factory::getDatabase();
			$config = factory::getConfig();
			$app 	= factory::getApplication();
			$user   = factory::getUser();

			$sortir = $_POST['sortir'];

			unset($_POST['sortir']);

			$id = $app->getVar('incidencia_id', 0, 'post');

			if(!$user->getAuth() || ($id == 0 && $user->nou == 0) || ($id != 0 && $user->editar == 0) ) {
				$app->setMessage('No tens suficients permisos per accedir a aquest àrea', 'error');
				$app->redirect($config->site.'/index.php?view=home&layout=dashboard');
			}

			//valors per defecte
			if($_POST['incidencia_id'] == '') { $_POST['incidencia_id'] = 0; }
			if($_POST['data_incidencia'] == '') { $_POST['data_incidencia'] = date('Y-m-d H:i:s'); }
			if($_POST['data_actualitzacio'] == '') { $_POST['data_actualitzacio'] = date('Y-m-d H:i:s'); }
			if($_POST['data_limit'] == '') { $_POST['data_limit'] = date('Y-m-d H:i:s'); }
			if($_POST['data_factura'] == '') { $_POST['data_factura'] = '0000-00-00 00:00:00'; }
			if($_POST['data_resolucio'] == '') { $_POST['data_resolucio'] = '0000-00-00 00:00:00'; }
			if($_POST['temps_invertit'] == '') { $_POST['temps_invertit'] = 0; }
			if($_POST['temps_previst'] == '') { $_POST['temps_previst'] = 0; }
			if($_POST['tipus'] == '') { $_POST['tipus'] = 0; }
			if($_POST['created_by'] == '') { $_POST['created_by'] = $user->id; }
			//si l'estat es resolt guardem data si no l'esborrem
			if($_POST['estat'] == 3) { $_POST['data_resolucio'] = date('Y-m-d H:i:s'); } else { $_POST['data_resolucio'] = '0000-00-00 00:00:00'; }
			//abans de res si es resolt no pot estar buit
			if($_POST['estat'] == 3 && $_POST['temps_previst'] == '') { $_POST['temps_previst'] = 10; }
			if($_POST['estat'] == '') { $_POST['estat'] = 1; }
			if($_POST['prioritat'] == '') { $_POST['prioritat'] = 1; }
			if($_POST['ordering'] == '') { $_POST['ordering'] = 1; }
			if($_POST['num_incidencia'] == '') {
				$db->query('SELECT MAX(num_incidencia) + 1 FROM `#_incidencies` WHERE projecteId = '.$_POST['projecteId']);
				$num = $db->loadResult();
				if($num == null) { $num = 1; }
				$_POST['num_incidencia'] = $num;
			}
			  
			if($_POST['altres_usuaris'] != '') {
				foreach($_POST['altres_usuaris'] as $altres) {
					$attendants .= $altres . ",";
				}
				$attendants = substr($attendants,0,-1);
				$_POST['altres_usuaris'] = $attendants;
			}

			if($id > 0) {
				$result = $db->updateRow($this->table, $_POST, $this->key, $id);
				$_POST['result1'] = true;
			} else {
				$result = $db->insertRow($this->table, $_POST);
				$id = $db->lastId();
				$_POST['incidencia_id'] = $id;
				$_POST['result2'] = true;
			}

			//add message
			parent::saveMessage($_POST['usuari'], $id);

			$app->trigger('onSendNotifications', $_POST);

			if($result) {
				$type = 'success';
				$msg  = 'Incidència guardada';
				if($sortir == 0) {
					$link = $config->site.'/index.php?view='.$this->view.'&layout=edit&id='.$id;
				} else {
					$link = $config->site.'/index.php?view='.$this->view.'&filter_equal_projecteId='.$_POST['projecteId'].'&filter_equal_estat=2%3A1&filter_equal_usuari='.$user->id;
				}
			} else {
				$link = $config->site.'/index.php?view='.$this->view.'&layout=edit&id='.$id;
				$type = 'danger';
				$msg  = "Error al guardar la incidència.";
			}

			$app->setMessage($msg, $type);
			$app->redirect($link);

		}

		public function saveComment()
		{
			$db 	= factory::getDatabase();
			$config = factory::getConfig();
			$app 	= factory::getApplication();
			$user   = factory::getUser();

			$comentari = $_POST['comment_txt'];

			if(!empty($_POST['return'])) $return = base64_decode($app->getVar('return', '', 'post'));
			else $return = $config->site.'/index.php?view='.$this->view;

			unset($_POST['return']);

			$id = $app->getVar('incidencia_id', 0, 'post');

			$db->query('SELECT altres_usuaris, created_by, usuari FROM `#_incidencies` WHERE incidencia_id = '.$id);
			$row = $db->fetchObject();

			$created = $user->getUserObject($row->created_by);
			$usuari  = $user->getUserObject($row->usuari);

			if($comentari != '') {

				$comentari = preg_replace('/(\#)([^\s]+)/', '<a href="'.$config->site.'/index.php?view=issues&layout=edit&id=$2">#$2</a>', $_POST['comment_txt']);
				$comentari = preg_replace('/(\@)([^\s]+)/', '<a href="'.$config->site.'/index.php?view=projects&layout=edit&id=$2">#$2</a>', $comentari);

				$comments 					= new stdClass();
				$comments->comment_txt 		= $comentari;
				$comments->comment_data 	= date('Y-m-d H:i:s');
				$comments->comment_user 	= $user->id;
				$comments->comment_issue 	= $id;
				$result = $db->insertRow('#_comments', $comments);
				$lastId = $db->lastId();

				$app->trigger('onRewardUser', $comments);

				//afegim notificació de nou comentari per al creador
				$notice 			= new stdClass();
				$notice->issue_id 	= $id;
				$notice->comment_id = $lastId;
				$notice->userid 	= $row->created_by;
				$result = $db->insertRow('#_comments_notices', $notice);

				//envia email a tots els usuaris
				$subject = "AfiGest - Nou comentari en la incidència nº ".$id;
				$body    = "Hola {{USERNAME}}<p>Un usuari ha fet un nou comentari en la incidencia nº ".$id.", aquest és el comentari:</p><p>".$_POST['nom']."</p>".$comentari.".<p>Segueix l'enllaç per llegir-lo:</p><p>".$config->site."/index.php?view=issues&layout=edit&id=".$id."</p>";
				
				$altres_usuaris = explode(',', $row->altres_usuaris);
				$this->sendMail($created->email, $created->username, $subject, str_replace('{{USERNAME}}', $created->username, $body));
				$this->sendMail($usuari->email, $usuari->username, $subject, str_replace('{{USERNAME}}', $usuari->username, $body));
				if(count($altres_usuaris)) {
					foreach($altres_usuaris as $altres) {
						$row = $user->getUserObject($altres);
						$this->sendMail($row->email, $row->username, $subject, str_replace('{{USERNAME}}', $row->username, $body));
						//afegim notificació de nou comentari per als usuaris associats
						$notice = new stdClass();
						$notice->issue_id = $id;
						$notice->comment_id = $lastId;
						$notice->userid = $row->created_by;
						$result = $db->insertRow('#_comments_notices', $notice);
					}
				}
			}

			if($result) {
				$link = $return;
				$type = 'success';
				$msg  = 'Comentari guardat amb èxit';
			} else {
				$link = $config->site.'/index.php?view='.$this->view.'&layout=edit&id='.$id;
				$type = 'danger';
				$msg  = "Error al guardar el comentari.";
			}

			$app->setMessage($msg, $type);
			$app->redirect($link);

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

	function isCommentNew($issueId)
  	{
		  $db  = factory::getDatabase();
		  $user = factory::getUser();
			$db->query('SELECT id FROM `#_comments_notices` WHERE issue_id = '.$issueId.' AND userid = '.$user->id.' AND status = 1');
			if($id = $db->loadResult()) {
				return true;
			}
			return false;
	}

	public static function readMessages($id)
	{
		$db = factory::getDatabase();

		$db->updateField('#_messages', 'estat', 1, 'incidencia_id', $id);
		$db->updateField('#_comments_notices', 'status', 0, 'issue_id', $id);
	}

	public static function getTotalHores()
	{
		$db = factory::getDatabase();
		$app = factory::getApplication();

		$id = $app->getVar('id', 0);

		$sql = 'select SUM(temps_invertit) AS minutes from #_incidencies where incidencia_id = '.$id;
		if($config->debug == 1) { echo 'getTotalHores: '.$sql.'\n'; }
		$db->query($sql);
		//passem a segons per facilitar el format
		return gmdate('H:i:s', ($db->loadResult() * 60));
	}

	public static function getActivityComments()
	{
		$db = factory::getDatabase();
		$app = factory::getApplication();

		$id = $app->getVar('id', 0);

		$sql = 'SELECT c.*, u.username, u.email FROM `#_comments` AS c INNER JOIN `#_users` AS u ON c.comment_user = u.id WHERE c.comment_issue = '.$id.' ORDER BY c.comment_id ASC';
		if($config->debug == 1) { echo 'getActivityComments: '.$sql.'\n'; }
		$db->query($sql);

		return $db->fetchObjectList();
	}

	public static function formatComment($content)
	{
		$array = array();
		$src = preg_match( '/src="([^"]*)"/i', $content, $array );
    	$content = preg_replace("/<img[^>]+\>/i", "<a href='".$array[1]."' data-lightbox='".$array[1]."'><img class='attach' src='assets/img/attachment.png' /></a>", $content);
    	echo $content;
	}

	public function getSubtasques($id)  
	{
		$db = factory::getDatabase();

		$db->query('SELECT incidencia_id,nom FROM `#_incidencies` WHERE parentId = '.$id);

		return $db->fetchObjectList();
	}

	public function getTipus($id)  
	{
		$db = factory::getDatabase();

		$db->query('SELECT * FROM `#_tipus_incidencia` WHERE id = '.$id);

		$row = $db->fetchObject();

		return '<span class="badge" style="background-color:'.$row->bg_color.';color:'.$row->txt_color.';">'.$row->nom.'</span>';
	}

	public function getProjectes()  
	{
		$db = factory::getDatabase();
		$user = factory::getUser();

		if($user->projects == '*') {
			$db->query('SELECT p.projecte_id,p.nom FROM `#_projectes` AS p ORDER BY p.nom ASC');
		} else {
			$db->query('SELECT p.projecte_id,p.nom FROM `#_projectes` AS p WHERE p.projecte_id IN ('.$user->projects.') ORDER BY p.nom ASC');
		}

		return $db->fetchObjectList();
	}
}
