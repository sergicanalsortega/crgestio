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

if(!$user->getAuth()) {
    $app->redirect($config->site);
}

$model 		= $app->getModel('report');
$page  		= $app->getVar('page', 1, 'get');
$view 		= $app->getVar('view', '', 'get');
$id    		= $app->getVar('id', 0, 'get');
$search  	= $app->getVar('search', '');
?>

<style>
.item-group {
	background-color: #000 !important;
	color: #fff;
}
</style>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item active">Administració</li>
			<li class="breadcrumb-item active">Reports</li>
		</ul>
	</div>
</div>

<section class="statistics">
  <div class="container-fluid">
    <div class="row d-flex">

      	<div class="col-12">

			<div class="my-4 w-100 text-right"><?= $html->renderButtons('report', 'report'); ?>	</div>

        	<form action="" method="get" id="itemsList" name="itemsList">

				<div class="w-100"><?= $html->renderFilters('report', 'report'); ?></div>

				<input type="hidden" name="view" value="report">
				<?php $get = $_GET; ?>

				<?php 
				$columns = array("<input type='checkbox' id='selectAll' ",'Id', 'Projecte', 'Descripció', 'Tipus', 'Usuari', 'Resolució', 'H.Previstes', 'H.Finals');
				?>

				<table class="table">
					<thead>
						<tr>
						<?php foreach($columns as $column) : ?>
						<th><?= $column; ?></th>
						<?php endforeach; ?>
						</tr>
					</thead>
					<?php 
					$pnom = null;
					foreach($model->getList() as $item) : 
					?> 
					<tbody>
						<?php if($item->pnom != $pnom) : ?>
							<tr class="bg-success"><td colspan="9"><span class="text-light"><?= $item->pnom . ' (id ' . $item->projecteId . ')'; ?></span></td></tr> 
						<?php endif; ?>
						<tr>
							<td><input type="checkbox" data-id="<?= $item->incidencia_id; ?>"></td>
							<td><?= $item->incidencia_id; ?></td>
							<td><?= $item->pnom; ?></td>
							<td><?= $item->nom; ?></td>
							<td><?= $item->tipus; ?></td>
							<td><?= $item->username; ?></td>
							<td><?= date('d-m-Y H:i:s', strtotime($item->data_resolucio)); ?></td>
							<td><?= $item->temps_previst; ?></td>
							<td><?= $item->temps_invertit; ?></td>
						</tr>
						<?php 
						$pnom = $item->pnom;
						endforeach; 
						?>
					</tbody>
				</table>

				<?= $model->pagination($get); ?>

			</form>
		</div>

    </div>
  </div>
</section>
