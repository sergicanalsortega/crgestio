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
require CWPATH_LIBRARIES.DS.'fpdf'.DS.'vendor'.DS.'autoload.php';
require CWPATH_LIBRARIES.DS.'fpdf'.DS.'vendor'.DS.'setasign'.DS.'fpdf'.DS.'html_table.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class report extends model
{	
	private $table  = '#_incidencies';
	private $view   = 'report';
	private $key    = 'projecteId';
	private $order  = 'projecteId';
	private $dir    = 'DESC';
	private $sql    = "SELECT i.*, p.nom as pnom, u.username FROM `#_incidencies` i INNER JOIN `#_projectes` p ON p.projecte_id = i.projecteId INNER JOIN `#_users` AS u ON u.id = i.usuari WHERE i.estat = 3 AND i.data_factura = '0000-00-00 00:00:00'";

	public function getList($limit=true)
	{
		$db  	= factory::getDatabase();
		$user 	= factory::getUser();
		$app    = factory::getApplication();
		$config = factory::getConfig();
		$session = factory::getSession();

		$page  = $app->getVar('page', 1, 'get');
		$order = $app->getVar('list_column', $this->order, 'get');
		$dir   = $app->getVar('list_dir', $this->dir, 'get');

		if($limit) { 
			
			$session->setVar('list_dir', $dir);

			$no_of_records_per_page = $app->getVar('list', $config->pagination, 'get');
			if($no_of_records_per_page == '*') $no_of_records_per_page = 100000;
		}

		unset($_GET['page'], $_GET['view'], $_GET['list'], $_GET['list_column'], $_GET['list_dir'],$_GET['task'], $_GET['mode']);

		if($limit) {  $offset = ($page-1) * $no_of_records_per_page; }

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
		$db->query($this->sql.$filters);
		$count_rows = $db->loadResult();

        if($count_rows > 0) {

			$this->sql .= $filters;
		    $this->sql .= ' ORDER BY i.'.$this->order.' '.$this->dir.' LIMIT '.$offset.', '.$no_of_records_per_page;
			if($config->debug == 1) { echo 'getList: '.$this->sql.'\n'; }
		    $db->query($this->sql);
		}

		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		//echo $this->sql;
		return $db->fetchObjectList();
	}
	
	public function facturar() 
	{
		$db    = factory::getDatabase();
		$items  = json_decode($_POST['items'], true);

		foreach($items as $item) 
			$db->query('UPDATE #_incidencies SET data_factura = '.$db->quote(date('Y-m-d H:i:s')).', facturat = 1 WHERE incidencia_id = '.$item);	
	}

	public function getProjectesPendentsDeFacturar()
	{
		$db = factory::getDatabase();
		$db->query(
			'SELECT projecte_id, P.nom, count(*) AS numIncidPF ' .
			'FROM #_projectes P INNER JOIN #_incidencies I ON P.projecte_id=I.projecteId ' .
			'WHERE I.estat = 3 AND (I.tipus = 3 OR I.tipus = 1) AND I.data_factura = "0000-00-00 00:00:00" ' .
			'GROUP BY projecte_id, P.nom ' .
			'ORDER BY P.nom');
			//$db->query('select projecte_id, nom from #_projectes P inner join #_incidencies I ON P.projecte_id=I.projecteId;');
		return $db->fetchObjectList();
	}

	public function pdf()
	{
		// instantiate and use the dompdf class
		$pdf = new PDF();

		//$columns = array('Id', 'Descripció', 'Tipus', 'Usuari', 'Data resolució', 'Temps previst', 'Temps invertit');
		$columns = array('Id', 'Descripció', 'Tipus', 'Usuari');

		$html  = '';
		$html .= '<table width="100%" border="1">';
		$html .= '<thead>';
		$html .= '<tr>';
		
		foreach($columns as $column) {
			$html .= '<th>'.$column.'</th>';
		}
		
		$html .= '</tr>';
		$html .= '</thead>';
		
		$pnom  = null;
		$limit = false;
		$items = $this->getList($limit);
		$html .= '<tbody>';

		foreach($items as $item) {

			if($item->pnom != $pnom) {
				$html .= '<tr style="background-color:#28a745;padding:5px;"><td colspan="8"><span style="color:#fff">'.$item->pnom.'</span></td></tr>';
			}
			$html .= '<tr>';
			$html .= '<td>'.$item->incidencia_id.'</td>';
			$html .= '<td>'.$item->nom.'</td>';
			$html .= '<td>'.$item->tipus.'</td>';
			$html .= '<td>'.$item->usuari.'</td>';
			// $html .= '<td>'.$item->data_resolucio.'</td>';
			// $html .= '<td>'.$item->temps_previst.'</td>';
			// $html .= '<td>'.$item->temps_invertit.'</td>';
			$html .= '</tr>';

			$pnom = $item->pnom;
		} 

		$html .= '</tbody>';
		$html .= '</table>';

		$pdf->AddPage('L');

		$pdf->SetFont('Arial', 'B', 14);
		$pdf->WriteHTML($html);

		$pdf->Output();
		exit();
	}

	public function xls()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$writer->save('hello world.xlsx');
	}
}
