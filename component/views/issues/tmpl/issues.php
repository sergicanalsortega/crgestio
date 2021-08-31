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

$model 	= $app->getModel('issues');
$pid 	= $app->getVar('projecteId', '');
$search = $app->getVar('search', '');
$page  	= $app->getVar('page', 1, 'get');
$view  	= $app->getVar('view', '', 'get');
$orderDir    = $app->getVar('orderDir', 'asc');
$colDir      = $app->getVar('colDir', 'incidencia_id');
$list   = $model->getList();
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item active">Incidències</li>
		</ul>
	</div>
</div>

<section class="statistics">
  <div class="container-fluid">
    <div class="row d-flex">

      <div class="col-12">

			<div class="my-4 w-100 text-right"><?= $html->renderButtons('issues', 'issues'); ?></div>

			<?php if(count($list)) : ?>

			<form action="" method="get" id="itemsList" name="itemsList" class="w-100">

				<div class="w-100"><?= $html->renderFilters('issues', 'issues'); ?></div>

				<input type="hidden" name="view" value="issues">
				<?php $get = $_GET; ?>

				<?php $fields = array(array('name' => 'nom', 'editable' => true), array('name' => 'project'), array('name' => 'tipusText'), array('name' => 'estatText'), array('name' => 'fecha'), array('name' => 'username'), array('name' => 'tags'), array('name' => 'num'), array('name' => 'usergroup')); ?>
				<?php $columns = array(array('name' => 'Nom', 'width' => '30%'), array('name' => 'Projecte'), array('name' => 'Tipus'), array('name' => 'Estat'), array('name' => 'Data'), array('name' => 'Usuari'), array('name' => 'Tag'), array('name' => 'Número'), array('name' => 'Grup')); ?>
				<!-- <?//= $html->renderTable('issues', 'incidencia_id', 'nom', $model->getList(), $fields, $columns); ?> -->

				<div class="table-responsive">
        			<table id="issues" class="table table-striped table-bordered">
        				<thead class="thead-dark">
        					<tr>
        						<th width="1%" data-orderable="false"><input type="checkbox" id="selectAll"></th>
								<?php
								$i = 0;
								foreach($columns as $column) : 
								$orderDir == 'asc' ? $dir = 'desc' : $dir = 'asc';
								?>
									<th width="<?= $column['width']; ?>">
										<a href="index.php?view=<?= $view; ?>&page=<?= $page; ?>&orderDir=<?= $dir; ?>&colDir=<?= $fields[$i]; ?>"><?= $column['name']; ?>
										<?= $fields[$i] == $colDir ? '<i class="fa fa-sort-'.$dir.'"></i>' : '<i class="fa fa-sort-asc"></i>'; ?>
									</th>
								<?php 
								$i++;
								endforeach; ?>
        					</tr>
        				</thead>
        				<tbody>
						<?php
						foreach($list as $d) : ?>
							<?php 
							if($d->estat == 1) { $badge = 'danger text-light'; }
							if($d->estat == 2) { $badge = 'warning text-dark'; }
							if($d->estat == 3) { $badge = 'dark text-light'; }
							if($d->estat == 4) { $badge = 'light text-dark'; }
							?>
							<tr class="item" data-id="<?= $d->incidencia_id; ?>">
								<td>
									<input type="checkbox" name="cd" data-id="<?= $d->incidencia_id; ?>">
								</td>
								<td>
									<a href="index.php?view=<?= $view; ?>&layout=edit&id=<?= $d->incidencia_id; ?>"><?= $d->nom; ?></a>
									<?php if($model->isCommentNew($d->incidencia_id)) : ?>
										&nbsp;<span class="badge bg-danger text-light">New</span>
									<?php endif; ?>
								</td>
								<td>
									<a href="/index.php?view=projects&layout=edit&id=<?= $d->projecteId; ?>"><?= $d->project; ?></a>
								</td>
								<td>
									<?= $model->getTipus($d->tipus); ?>
								</td>
								<td>
									<span class="badge bg-<?= $badge; ?>"><?= $d->estatText; ?></span>
								</td>
								<td>
									<?= $d->fecha; ?>
								</td>
								<td>
									<?= $d->username; ?>
								</td>
								<td>
									<?= $d->tags; ?>
								</td>
								<td>
									<?= $d->num; ?>
								</td>
								<td>
									<?= $d->usergroup; ?>
								</td>
							</tr>
						<?php endforeach; ?>
        				</tbody>
        			</table>
        		</div>

        		<?= $model->pagination($get); ?>

			</form>

			<?php else : ?>

			<div class="col-12 mx-auto text-center">
				<div><img src="assets/img/ufo.png" class="img-fluid" alt="..."></div>
				<div class="mt-5"><h3><b>Eureka! no tens cap incidència per resoldre en aquest projecte.</b></h3></div>
			</div>

			<?php endif; ?>

      </div>
		</div>
	</div>
</section>
