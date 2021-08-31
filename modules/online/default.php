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
$user = factory::getUser();
?>

<div class="row-fluid">
    <div class="card mb-3">
        <h2 class="display h4 d-flex text-success"><i class="fa fa-users"></i>&nbsp;&nbsp;Usuaris en línia</h2>
        <?php foreach(onlineHelper::getOnlineUsers() as $online) : ?>
        <p><b><?= $online->username; ?></b> <?php if($online->userid == $user->id) : ?><a href="<?= $config->site; ?>/index.php?view=register&amp;task=logout" class="logout"> <i class="fa fa-sign-out"></i></a><?php endif; ?></p>
        <?php endforeach; ?>
    </div>
</div>