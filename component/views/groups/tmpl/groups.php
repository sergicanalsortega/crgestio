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

$model 	= $app->getModel('groups');
?>

<script>
function saveGroup(id, key) {
  $.get({url:'index.php?task=groups.saveGroup&id='+id+'&key='+key+'&mode=raw'});
  Messenger().post({message: "Canvi realitzat amb èxit", type: 'success', hideAfter: 10}); 
}
</script>

<!-- Breadcrumb-->
<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
      <li class="breadcrumb-item">Administració</li>
      <li class="breadcrumb-item active">Groups</li>
    </ul>
  </div>
</div>

<section>
  <div class="container-fluid">

    <!-- Page Header-->
    <div class="card">
      <div class="card-header">
        <h4>Grups</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable1" style="width: 100%;" class="table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Usergroup</th>
                <th>Vista</th>
                <th>Accedir</th>
                <th>Crear</th>
                <th>Editar</th>
                <th>Esborrar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($model->getList() as $item) : ?>
              <?php $permisos = json_decode($item->permisos); ?>
              <tr>
                <td><?= $item->id; ?></td>
                <td><?= $item->usergroup_id; ?></td>
                <td><?= $item->vista; ?></td>
                <td>
                  <div class="form-check form-switch">
                    <input onchange="saveGroup(<?= $item->id; ?>, 'access')" class="form-check-input" type="checkbox" id="access" <?= $permisos->access == 1 ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="form-check form-switch">
                    <input onchange="saveGroup(<?= $item->id; ?>, 'new')" class="form-check-input" type="checkbox" id="new" <?= $permisos->new == 1 ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="form-check form-switch">
                    <input onchange="saveGroup(<?= $item->id; ?>, 'edit')" class="form-check-input" type="checkbox" id="edit" <?= $permisos->edit == 1 ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="form-check form-switch">
                    <input onchange="saveGroup(<?= $item->id; ?>, 'delete')" class="form-check-input" type="checkbox" id="delete" <?= $permisos->delete == 1 ? 'checked' : ''; ?>>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
