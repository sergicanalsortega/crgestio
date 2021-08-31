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


$model 		= $app->getModel();
$pid 		= $app->getVar('id', 0, 'get');
$projecte 	= $model->getItem();
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item active">Projectes</li>
		</ul>
	</div>
</div>

<section class="forms">
  	<div class="container-fluid">
    	<div class="row">

			<div class="col-lg-12 my-3"><a title="Tornar a projectes" class="hasTip" href="javascript:history.go(-1);"><i class="fa fa-angle-left fa-2x"></i></a></div>

      		<div class="col-12">

				<div class="card">
          			<div class="card-header d-flex align-items-center">
            			<h4>Projecte</h4>
          			</div>
          			<div class="card-body">
						<form action="index.php?view=projects&task=saveItem" method="post">
							<input type="hidden" name="projecte_id" value="<?= $pid; ?>" />
							<input type="hidden" name="return" value="<?= $app->getVar('return', '', 'get'); ?>" />
							<?= $html->getTextField('projects', 'nom', $projecte->nom); ?>
							<?= $html->getTextField('projects', 'abreujatura', $projecte->abreujatura); ?>
							<?= $html->getTextField('projects', 'ref_externa', $projecte->ref_externa); ?>
							<?= $html->getTextField('projects', 'slack_channel', $projecte->slack_channel); ?>
							<?= $html->getTextareaField('projects', 'observacions', $projecte->observacions); ?>
							<div class="form-group">
								<?php if($user->nou == 1 || $user->editar == 1) : ?>
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
								<?php endif; ?>
							</div>
						</form>
					</div>
				</div>

			</div>

    	</div>
	</div>
</section>
