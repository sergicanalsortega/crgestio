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

$model 	= $app->getModel('users');
$list   = $model->getList();
$page   = $app->getVar('page', 1);
?>

<!-- Breadcrumb-->
<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
      <li class="breadcrumb-item">Administració</li>
      <li class="breadcrumb-item active">Usuaris</li>
    </ul>
  </div>
</div>

<section>
  <div class="container-fluid">

    <div class="col-12 my-3"><a class="btn btn-success" href="<?= $config->site; ?>/index.php?view=users&layout=edit"><i class="fa fa-plus"></i> Nou</a></div>

    <!-- Page Header-->
    <div class="card">
      <div class="card-header">
        <h4>Usuaris</h4>
      </div>
      <div class="card-body">

      <?php if(count($list)) : ?>

        <form action="" method="get" id="itemsList" name="itemsList" class="w-100">
        <input type="hidden" name="view" value="users">

        <div class="table-responsive">
          <table id="datatable1" style="width: 100%;" class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Usergroup</th>
                <th>Esborrar</th>
                <th>Editar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($list as $usr) : ?>
              <tr>
                <td><?= $usr->Treballadors; ?></td>
                <td><?= $usr->DNI; ?></td>
                <td><?= $usr->eMail; ?></td>
                <td><?= $usr->_level; ?></td>
                <td><a href="index.php?view=users&task=removeUser&id=<?= $usr->Id; ?>"><i class="bi bi-trash-fill"></i></a></td>
                <td><a href="index.php?view=users&layout=edit&id=<?= $usr->Id; ?>"><i class="bi bi-pencil-square"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <?= $model->pagination($get); ?>

        </form>

        <?php else : ?>

        <div class="col-12 mx-auto text-center">
          <div class="mt-5"><h3><b>No tens cap item a la llista.</b></h3></div>
        </div>

        <?php endif; ?>

      </div>
    </div>
  </div>
</section>
