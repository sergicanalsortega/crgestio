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

class hores extends model
{
	private $table  = '#_HoresPersonal_Observacions';
	private $view   = 'hores';
	private $key    = 'Id';
	private $order  = 'Id';
	private $dir    = 'DESC';
	private $rows   = 'SELECT COUNT(h.Id) FROM #_HoresPersonal_Observacions AS h';
	private $sql    = 'SELECT h.*, u.username FROM #_HoresPersonal_Observacions AS h INNER JOIN `#_users` AS u ON h.userid = u.IdTreballador';
	
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

		unset($_GET['page'], $_GET['view']);

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
		    $this->sql .= ' ORDER BY h.'.$this->order.' '.$this->dir.' LIMIT '.$offset.', '.$no_of_records_per_page;
			if($config->debug == 1) { echo 'getList: '.$this->sql.'\n'; }
		    $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		//echo $this->sql;
		return $db->fetchObjectList();
	}

	public function saveHorari()
	{
		$db 	= factory::getDatabase();
		$app 	= factory::getApplication();
		$lang   = factory::getLanguage();
		$config = factory::getConfig();

		$data1 			= $app->getVar('Data1', '');
		$data2 			= $app->getVar('Hora', '');
		$IdTreballador 	= $app->getVar('IdTreballador');
		$observa 		= $app->getVar('Comentari', '');
		$tipusMov 		= $app->getVar('TipusMoviment', '');
		$entradaId 		= $app->getVar('Id', '');

		$db->connectDB($config->host, $config->user, $config->pass, 'ColomerRifa_ControlHorari_test');

		$i = 0;
		foreach($data2 as $key => $value) {

			$hora   = new stdClass();

			$hora->IdTreballador 	= $IdTreballador;
			$hora->Data 			= $data1."T00:00:00.000Z";
			$hora->Hora 			= $data1."T".$data2[$i].":00.000Z";
			$hora->TipusMoviment    = $tipusMov[$i];
			$hora->Comentari 		= $observa[$i];

			if($entradaId[$i] != '') { 
				$hora->Id 	= $entradaId[$i];
				$result = $db->updateRow('#_TreballadorsMovimentsHoraris', $hora, 'Id', $entradaId[$i]);
			} else {
				$result = $db->insertRow('#_TreballadorsMovimentsHoraris', $hora);
			}

			$i++;
		}

		$db->close();

		if($result) {
			$app->setMessage($lang->get('CW_HORES_SUCCESS_SAVE'), 'success');
		} else {
			$app->setMessage($lang->get('CW_HORES_ERROR_SAVE'), 'danger');
		}

		$app->redirect('index.php?view=hores&date='.$data1);
	}

	public function saveRegistre()
	{
		$db 	= factory::getDatabase();
		$app 	= factory::getApplication();
		$lang   = factory::getLanguage();
		$user   = factory::getUser();

		$data 			= $app->getVar('Data', '');
		$IdTreballador 	= $app->getVar('IdTreballador');
		$observa 		= $app->getVar('Observacions', '');
		$IdProjecte 	= $app->getVar('IdProjecte', '');
		$km 			= $app->getVar('KM', '');
		$hores 			= $app->getVar('Hores', '');
		$dietes 		= $app->getVar('Dietes', '');
		$entradaId 		= $app->getVar('Id', '');
		$CatProf        = $user->CategoriaProfessional;

		//recollim preuKM
		$db->query('SELECT PreuKM FROM #_Parametres WHERE Exercici = '.substr($data, 2, 2));
		$PreuKM = $db->loadResult();

		//recollim preuHora
		switch($CatProf) {
			case 'Director':
				$col = 'PreuHoresDirector';
				break;
			case 'Ajudant':
				$col = 'PreuHoresAjudant';
				break;
			case 'Tècnic 3':
				$col = 'PreuHoresAjudant';
				break;
			case 'Delineant':
				$col = 'PreuHoresDelineant';
				break;
			case 'Tècnic 2':
				$col = 'PreuHoresDelineant';
				break;
			case 'Administratiu':
				$col = 'PreuHoresAdministratiu';
				break;
			case 'Tècnic':
				$col = 'PreuHoresTecnic';
				break;
			case 'Tècnic 1':
				$col = 'PreuHoresTecnic';
				break;
		}
		$db->query('SELECT '.$col.' FROM #_Parametres WHERE Exercici = '.substr($data, 2, 2));
		$PreuHora = $db->loadResult();

		$i = 0;
		foreach($IdProjecte as $key => $value) {

			$hora   = new stdClass();

			$hora->IdTreballador 	= $IdTreballador;
			$hora->Data 			= $data."T00:00:00.000Z";
			$hora->IdProjecte 		= $IdProjecte[$i];
			$hora->Hores 			= $hores[$i];
			$hora->HoresExtres    	= 0;
			$hora->KM 				= $km[$i];
			$hora->Observacions 	= $observa[$i];
			$hora->CatProf			= $CatProf;
			$hora->Dietes			= $dietes[$i];
			$hora->PreuHora			= $PreuHora;
			$hora->PreuKM			= $PreuKM;

			if($entradaId[$i] != '') { 
				$hora->Id 	= $entradaId[$i];
				$result = $db->updateRow('#_HoresPersonal', $hora, 'Id', $entradaId[$i]);
			} else {
				$result = $db->insertRow('#_HoresPersonal', $hora);
			}

			$i++;
		}

		if($result) {
			$app->setMessage($lang->get('CW_HORES_PERSONAL_SUCCESS_SAVE'), 'success');
		} else {
			$app->setMessage($lang->get('CW_HORES_PERSONAL_ERROR_SAVE'), 'danger');
		}

		$app->redirect('index.php?view=hores&date='.$data);
	}

	public function deleteHour()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$config = factory::getConfig();

		$id  = $app->getVar('id');

		$db->connectDB($config->host, $config->user, $config->pass, 'ColomerRifa_ControlHorari_test');

		$db->deleteRow('#_TreballadorsMovimentsHoraris', 'Id', $id);

		$db->close();
	}

	public function deleteRegistre()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();

		$id  = $app->getVar('id');

		$db->deleteRow('#_HoresPersonal', 'Id', $id);
	}

	public function getFestius()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$user	= factory::getUser();

		$firstDay  	= $app->getVar('firstDay', 1, 'get');
		$lastDay  	= $app->getVar('lastDay', 1, 'get');
		$firstDay 	.= 'T00:00:00.000Z';
		$lastDay 	.= 'T00:00:00.000Z';


		$db->query("SELECT DISTINCT dbo.fNomesData(Data) AS fecha
		FROM #_HoresPersonal_DiesFestius H
		WHERE H.IdTreballador = ".$user->Id." AND H.Data BETWEEN '".$firstDay."' AND '".$lastDay."'
		GROUP BY H.Data
		ORDER BY fecha");

		$rows = $db->fetchObjectList();

		echo json_encode($rows);

		exit();
	}

	public function getVacances()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$user	= factory::getUser();

		$firstDay  = $app->getVar('firstDay', 1, 'get');
		$lastDay  = $app->getVar('lastDay', 1, 'get');
		$firstDay 	.= 'T00:00:00.000Z';
		$lastDay 	.= 'T00:00:00.000Z';

		$db->query("SELECT dbo.fNomesData(Data) AS fecha, SUM(Hores) AS SumVacancesDia
		FROM #_HoresPersonal_Vacances H
		WHERE H.IdTreballador = ".$user->Id." AND H.Data BETWEEN '".$firstDay."' AND '".$lastDay."'
		GROUP BY H.Data
		ORDER BY H.Data");

		$rows = $db->fetchObjectList();

		echo json_encode($rows);

		exit();
	}

	public function getBaixes()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$user	= factory::getUser();

		$firstDay  = $app->getVar('firstDay', 1, 'get');
		$lastDay  = $app->getVar('lastDay', 1, 'get');
		$firstDay 	.= 'T00:00:00.000Z';
		$lastDay 	.= 'T00:00:00.000Z';

		$db->query("SELECT dbo.fNomesData(Data) AS fecha, SUM(Hores) AS SumBaixesDia
		FROM #_HoresPersonal_Baixes H
		WHERE H.IdTreballador = ".$user->Id." AND H.Data BETWEEN '".$firstDay."' AND '".$lastDay."'
		GROUP BY H.Data
		ORDER BY H.Data");

		$rows = $db->fetchObjectList();

		echo json_encode($rows);

		exit();
	}

	public function getHoresTreballades()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$user	= factory::getUser();

		$firstDay  = $app->getVar('firstDay', 1, 'get');
		$lastDay  = $app->getVar('lastDay', 1, 'get');

		$db->query('SELECT H.Data AS fecha, H.IdTreballador
		SUM(H.Hores+H.HoresExtres) AS SumHoresDia,
		CASE
		   WHEN SUM(H.Hores+H.HoresExtres)> dbo.fGetHoresJornada(H.IdTreballador, H.Data) THEN 1
		   WHEN SUM(H.Hores+H.HoresExtres)> dbo.fGetHoresJornada(H.IdTreballador, H.Data) THEN 0 
		   ELSE -1 
		END AS Color
		FROM #_HoresPersonal H
		WHERE H.IdTreballador = '.$user->Id.' AND H.Data BETWEEN '.$firstDay.' AND '.$lastDay.'
		GROUP BY H.Data, , H.IdTreballador
		ORDER BY H.Data');

		$rows = $db->fetchObjectList();

		echo json_encode($rows);

		exit();
	}

	public function getEntradesTreballador($date)
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();
		$user	= factory::getUser();
		$config = factory::getConfig();

		$data = $date.'T00:00:00.000Z';

		$db->connectDB($config->host, $config->user, $config->pass, 'ColomerRifa_ControlHorari_test');

		$db->query('SELECT Id, TipusMoviment, Comentari, dbo.fNomesHora(Hora) AS Hora FROM #_TreballadorsMovimentsHoraris WHERE IdTreballador = '.$user->Id.' AND Data = '.$db->quote($data));

		$rows = $db->fetchObjectList();

		$db->close();

		return $rows;
	}

	public function getRegistresTreballador($date)
	{
		$db  	= factory::getDatabase();
		$user	= factory::getUser();

		$data = $date.'T00:00:00.000Z';

		$db->query('SELECT h.*, v.reftreballfrm, v.razonsocial, v.horesprevistes, v.totalhoresrecompte FROM #_HoresPersonal AS h LEFT JOIN #_vtreballs AS v ON v.IdProjecte = h.IdProjecte WHERE h.IdTreballador = '.$user->Id.' AND h.Data = '.$db->quote($data));

		$rows = $db->fetchObjectList();

		return $rows;
	}	

	public function getDataProjecte()
	{
		$db  	= factory::getDatabase();
		$app 	= factory::getApplication();

		$id     = $app->getVar('id');

		$db->query('SELECT id, reftreballfrm, razonsocial, horesprevistes, totalhoresrecompte FROM #_vtreballs WHERE IdProjecte = '.$id.' ORDER BY id DESC');

		$rows = $db->fetchObject();

		echo json_encode($rows);

		exit();
	}
}
 