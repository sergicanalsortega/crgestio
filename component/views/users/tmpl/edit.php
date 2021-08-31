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


$model = $app->getModel();
$item  = $model->getItem();
$id    = $app->getVar('id', 0, 'get');
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item">Administració</li>
            <li class="breadcrumb-item active">Usuaris</li>
		</ul>
	</div>
</div>

<section class="forms">
    <div class="container-fluid">
    <div class="row">

        <div class="col-12">

			<div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Projecte</h4>
                </div>
                <div class="card-body">
                    <p>Com administrador pots crear nous usuaris.</p>
                    <form method="post" action="index.php?view=users&task=saveUser">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <?= $html->getTextField('users', 'username', $item->username); ?>
                        <?= $html->getEmailField('users', 'email', $item->email); ?>
                        <?= $html->getPasswordField('users', 'password'); ?>
                        <?= $html->getUsergroupsField('users', 'usergroup', $item->level); ?>
                        <?= $html->getListField('users', 'projects', $item->projects); ?>
                        <div class="form-group">
                            <input type="submit" value="Guardar" class="btn btn-primary">
                            <a href="/index.php?view=groups" class="btn btn-info"><i class="bi bi-plus-lg"></i> Crear Group</a>
                        </div>
                    </form>
		        </div>
		    </div>

		</div>

    </div>
	</div>
</section>
