<?php

/**
 * @version     1.0.0 Afi framework $
 * @package     Afi framework
 * @copyright   Copyright © 2016 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@afi.cat
 * @website	    http://www.afi.cat
 *
*/

defined('_Afi') or die ('restricted access');
include_once('helper.php');
$messages         = topmenuHelper::getMessages();
$comments         = topmenuHelper::getComments();
$countMsg         = topmenuHelper::countMessages();
$countComments    = topmenuHelper::countComments();
$config           = factory::getConfig();
?>

<!-- navbar-->
<header class="header">
  <nav class="navbar">
    <div class="container-fluid">
      <div class="navbar-holder d-flex align-items-center justify-content-between">
        <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i id="toggler" class="fa fa-chevron-left"> </i></a><a href="index.php" class="navbar-brand">
            <div class="brand-text d-none d-md-inline-block"><strong class="text-primary"><?= $config->sitename; ?></strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <?php if(topmenuHelper::isAdmin()) : ?>
                <li class="nav-item"><a id="registrar" rel="nofollow" href="index.php?view=home&task=registrar&mode=raw&type=<?= topmenuHelper::isEntry() == 1 ? 0 : 1; ?>" class="btn btn-<?= topmenuHelper::isEntry() == 1 ? 'danger' : 'success'; ?> btn-small"><i class="fa fa-<?= topmenuHelper::isEntry() == 1 ? 'stop' : 'play'; ?>"></i> <?= topmenuHelper::isEntry() == 1 ? 'Sortida' : 'Entrada'; ?></a></li>
                <?php endif; ?>
                <!-- Comments dropdown-->
                <li class="nav-item dropdown"> <a id="comments" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-comment"></i><span class="badge badge-danger"><?= $countComments; ?></span></a>
                <?php if($countComments > 0) : ?>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <?php foreach($comments as $comment) : ?>
                    <li><a rel="nofollow" href="?view=issues&layout=edit&id=<?= $comment->issue_id; ?>" data-id="<?= $comment->issue_id; ?>" class="dropdown-item d-flex">
                        <div class="msg-profile"> <img src="https://secure.gravatar.com/avatar/<?= md5($comment->email); ?>?size=50" alt="<?= $comment->username; ?>" class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <span>Nou comentari de <?= $comment->username; ?> a la incidència: <?= $comment->issue_id; ?></span>
                        </div></a>
                    </li>
                  <?php endforeach; ?>
                  </ul>
                  <?php endif; ?>
                </li>
                <!-- Messages dropdown-->
                <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-danger"><?= $countMsg; ?></span></a>
                  <?php if($countMsg > 0) : ?>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" class="dropdown-item d-flex" href="#" id="readMessages"><h3 class="h5">Marcar com a llegits</h3></a></li>
                    <?php foreach($messages as $message) : ?>
                    <li><a rel="nofollow" href="?view=issues&layout=edit&id=<?= $message->incidencia_id; ?>" data-id="<?= $message->incidencia_id; ?>" class="dropdown-item d-flex readMessage">
                        <div class="msg-profile"> <img src="https://secure.gravatar.com/avatar/<?= md5($message->email); ?>?size=50" alt="<?= $message->username; ?>" class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h6><?= $message->username; ?></h6><span><?= $message->titol; ?></span>
                        </div></a>
                    </li>
                  <?php endforeach; ?>
                  </ul>
                  <?php endif; ?>
                </li>
                <!-- Log out-->
                <li class="nav-item"><a href="<?= $config->site; ?>/index.php?view=register&amp;task=logout" class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a></li>
            </ul>
      </div>
    </div>
  </nav>
</header>
