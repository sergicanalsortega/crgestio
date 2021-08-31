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

$model 	    = $app->getModel();
$issue 	    = $model->getItem();
$id 	      = $app->getVar('id', $issue->incidencia_id);
$idProjecte = $app->getVar('projecteId', $issue->projecteId);
$parentId   = $app->getVar('parentId', 0);

if($id != 0) { 
  $model->readMessages($id); 
  $subtasques = $model->getSubtasques($id);
}
?>

<div class="breadcrumb-holder">
  <div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
      <?php if($id > 0) : ?>
			<li class="breadcrumb-item active"><a href="index.php?view=issues">Incidències</a></li>
      <li class="breadcrumb-item active">Incidència #<?= $issue->num_incidencia; ?></li>
      <?php else : ?>
      <li class="breadcrumb-item active">Incidències</li>
      <?php endif; ?>
		</ul>
	</div>
</div>

<section class="forms">
  <div class="container-fluid">
    <div class="row">

			<div class="col-12 my-3"><a title="Tornar al projecte" class="hasTip" href="javascript:history.go(-1);"><i class="fa fa-angle-left fa-2x"></i></a></div>

      <div class="col-12 col-md-6">

        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h4>Incidència <small>&nbsp;Id: <?= $issue->incidencia_id; ?> // Creació: <?= date('d-m-Y H:i', strtotime($issue->data_incidencia)); ?></small></h4>
          </div>
          <div class="card-body">
            <p>Edita o crea una nova incidència.</p>
            <form action="index.php?view=issues&task=saveItem" method="post">

    					<input type="hidden" name="incidencia_id" value="<?= $id; ?>" />
    					<input type="hidden" name="num_incidencia" value="<?= $issue->num_incidencia; ?>" />
              <input type="hidden" name="created_by" value="<?= $issue->created_by; ?>" />
              <input type="hidden" name="sortir" id="sortir" value="0" />


    					<?= $html->getTextField('issue', 'nom', $issue->nom); ?>
              <?php if($issue->parentId != 0 || $parentId != 0) : ?>
              <?= $html->getTextField('issue', 'parentId', $parentId != 0 ? $parentId : $issue->parentId); ?>
              <?php endif; ?>
              <?= $html->getListField('issue', 'prioritat', $issue->projecteId == '' ? 1 :$issue->prioritat); ?>
              <?= $html->getListField('issue', 'tipus', $issue->tipus); ?>
              <?= $html->getListField('issue', 'temps_previst', $issue->temps_previst); ?>
              <?= $html->getListField('issue', 'temps_invertit', $issue->temps_invertit); ?>
              <?= $html->getListField('issue', 'projecteId', $idProjecte, $model->getProjectes(), 'nom', 'projecte_id'); ?>
              <?= $html->getListField('issue', 'estat',  $issue->projecteId == '' ? 1 : $issue->estat); ?>
              <?= $html->getDateField('issue', 'data_limit', $issue->data_limit); ?>
              <?= $html->getUsersField('issue', 'usuari', $issue->usuari); ?>
              <?= $html->getUsersField('issue', 'altres_usuaris', $issue->altres_usuaris); ?>
              <?= $html->getUsergroupsField('issue', 'usergroup', $issue->usergroup, 2); ?>
              <?= $html->getTagsField('issue', 'tags', $issue->tags); ?>

    					<div class="form-group">
    						<textarea name="descripcio" class="form-control" placeholder="Descripció de la incidència" style="height: 150px;"><?= trim($issue->descripcio); ?></textarea>
    					</div>
              <div class="form-group text-right">
                  <a href="index.php?view=issues" class="btn btn-danger"><i class="fa fa-chrevon-left"></i> Sortir</a>
                  <?php if($user->nou == 1 || $user->editar == 1) : ?>
                  &nbsp;<a href="#" class="btn btn-success saveandclose"><i class="fa fa-save"></i> Guardar i Sortir</a>
                  &nbsp;<button type="submit" class="btn btn-success submit"><i class="fa fa-save"></i> Guardar</button>
                  <?php if($id != '') : ?>
                  &nbsp;<a href="index.php?view=issues&layout=edit&parentId=<?= $id; ?>&projecteId=<?= $issue->projecteId; ?>" class="btn btn-info"><i class="fa fa-plus"></i> Crear Subtasca</a>
                  <?php endif; ?>
                  <?php endif; ?>
              </div>

    				</form>
          </div>
        </div>
      </div>
  		<div class="col-12 col-md-6">

        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h4>Comentaris</h4>
          </div>
          <div class="card-body">
            <p>Comenta sobre la incidència.</p>

            <div class="media-list">
              <?php
              if($_GET['id'] != 0) :
              $i = 0;
              foreach($model->getActivityComments() as $comment) :
              $imageWidth = '200'; //The image size
              $imgUrl = 'https://secure.gravatar.com/avatar/'.md5($comment->email).'?size='.$imageWidth;
              ?>

              <div class="media mt-4">
                <div style="background-image: url(<?= $imgUrl; ?>)" class="media-object avatar mr-3"></div>
                <div class="media-body text-muted text-small"><strong class="text-dark"><?= $comment->username; ?>: </strong><?= $model->formatComment($comment->comment_txt); ?><br><small><?= $model->timeElapsed($comment->comment_data); ?></small></div>
              </div>

              <?php
              $i++;
              endforeach; ?>
              </div>
              <?php endif; ?>
              <form action="index.php?view=issues&task=saveComment" method="post" class="mt-5">
                <input type="hidden" name="incidencia_id" value="<?= $id; ?>" />
                <input type="hidden" name="return" value="<?= $app->getVar('return', '', 'get'); ?>" />
                <div class="form-group">
                  <textarea name="comment_txt" class="form-control" placeholder="Afegeix un comentari" style="height: 150px;"></textarea>
                  <div><small>Fes servir #num on [num] es la id d'una incidència per crear un link cap a la incidència relacionada.</small></div>
                  <div><small>Fes servir @p on [p] es la id d'un projecte per crear un link cap al projecte relacionat.</small></div>
                </div>
                <div class="form-group text-right">
                  <button type="submit" class="btn btn-success"><i class="fa fa-comment"></i> Enviar</button>
                </div>
              </form>
				    </div>
          </div>
  		  </div>
      </div>
        
    <div class="row">
          
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h4>Subtasques</h4>
          </div>
          <div class="card-body">
            <p>Subtasques d'aquesta incidència.</p>
            <?php if(count($subtasques)) : ?>
            <?php foreach($subtasques as $subtasca) : ?>
              <div><a href="index.php?view=issues&layout=edit&id=<?= $subtasca->incidencia_id; ?>"><?= $subtasca->nom; ?></a></div>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-12">

        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h4>Adjunts</h4>
          </div>
          <div class="card-body">
            <p>Adjunta arxius sobre la incidència.</p>

            <div class="card-body">
              <p>DropzoneJS is an open source library that provides drag’n’drop file uploads with image previews.</p>
              <div class="row">
                <div class="col-xl-12">
                  <form id="upload" action="index.php?view=issues&task=upload" class="dropzone" enctype="multipart/form-data">
                    <input type="hidden" name="incidencia_id" value="<?= $id; ?>" />
                    <div class="dz-message">
                      <p>Drop files here or click to upload.</p>
                    </div>
                  </form>
                </div>
                <div class="row mt-3">
                  <?php foreach($model->getAttachments() as $attach) : ?>
                  <div class="col-lg-3">
                    <div class="card">
                      <a href="<?= $config->site; ?>/assets/img/uploads/<?= $attach->image; ?>" data-lightbox="gallery" data-title="<?= $attach->image; ?>">
                        <?php $ext = pathinfo(CWPATH_BASE.'/assets/img/uploads/'.$attach->image);
                        if($ext['extension'] == 'jpg' || $ext['extension'] == 'png' || $ext['extension'] == 'jpeg' || $ext['extension'] == 'gif') { $link = $config->site.'/assets/img/uploads/'.$attach->image; }
                        if($ext['extension'] == 'odt' || $ext['extension'] == 'doc' || $ext['extension'] == 'docx' ) { $link = $config->site.'/assets/img/word.png'; }
                        if($ext['extension'] == 'xls' || $ext['extension'] == 'xlsx') { $link = $config->site.'/assets/img/excel.png'; }
                        if($ext['extension'] == 'pdf') { $link = $config->site.'/assets/img/pdf.jpg'; }
                        if($ext['extension'] == 'zip' || $ext['extension'] == 'rar' || $ext['extension'] == '7zip' || $ext['extension'] == 'tar.bz') { $link = $config->site.'/assets/img/zip.jpg'; }
                        ?>
                        <img src="<?= $link; ?>" height="170" alt="..." class="img-fluid">
                      </a>
                      <div class="card-body">
                        <h5 class="card-title mb-1"><?= $attach->image; ?></h5>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
				    </div>
          </div>
  		  </div>
      </div>
	  </div>
  </div>
</section>
