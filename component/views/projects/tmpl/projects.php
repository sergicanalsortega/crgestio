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

$model 	= $app->getModel();
$pid 	= $app->getVar('projecteId', '');
$search = $app->getVar('search', '');
$page  	= $app->getVar('page', 1, 'get');
$view  	= $app->getVar('view', '', 'get');
$id   	= $app->getVar('id', 0, 'get');
$return = base64_encode($url->selfUrl());
$orderDir    = $app->getVar('orderDir', 'asc');
$colDir      = $app->getVar('colDir', 'projecte_id');
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item active">Projectes</li>
		</ul>
	</div>
</div>

<section class="statistics">
  <div class="container-fluid">
		<div class="row d-flex">

			<div class="col-12">

				<div class="my-4 w-100 text-right"><?= $html->renderButtons('projects', 'projects'); ?></div>

				<form action="" method="get" id="itemsList" name="itemsList">

					<div class="w-100"><?= $html->renderFilters('projects', 'projects'); ?></div>

					<input type="hidden" name="view" value="projects">
					<?php $get = $_GET; ?>

					<?php $fields = array(array('name' => 'projecte_id'), array('name' => 'nom', 'editable' => true), array('name' => 'abreujatura'), array('name' => 'ref_externa')); ?>
					<?php $columns = array(array('name' => 'Id', 'width' => '10%'), array('name' => 'Projecte'), array('name' => 'Abreviació'), array('name' => 'Ref. Externa')); ?>
					<?= $html->renderTable('projects', 'projecte_id', $model->getList(), $fields, $columns); ?>

				</form>

				<?= $model->pagination($get); ?>

			</div>
		</div>
	</div>
</section>