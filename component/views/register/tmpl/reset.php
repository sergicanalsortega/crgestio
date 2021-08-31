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

$reg = file_get_contents('https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=en-IN');
$reg = json_decode($reg);
$bg  = $reg->images[0]->url;
?>

<style>
.side-navbar {
  display: none;
}
.page {
  width: 100%;
}
</style>

<div class="page login-page" style="background-image: url('https://www.bing.com/<?= $bg; ?>');">
  <div class="container">
    <div class="form-outer text-center d-flex align-items-center">
      <div class="form-inner w-100">
        <div class="logo text-uppercase px-5"><img src="assets/img/logo.png" class="img-fluid" alt="<?= $config->sitename; ?>" style="width:65%"></div>
        <p><?= $lang->get('CW_RESET_DESC'); ?></p>
        <form action="<?= $config->site; ?>/index.php?view=register&amp;task=login" method="post" class="text-left form-validate">
          <?= $html->getEmailField('reset', 'email'); ?>
    	    <!-- Security token -->
    	    <input type="hidden" name="auth_token" value="<?= $app->setToken(); ?>" />
          <div class="form-group text-center">
            <button type="submit" id="resetBtn" class="btn btn-success"><?= $lang->get('CW_SEND'); ?></button>
          </div>
        </form>
        <small>Imatge diaria gràcies a Bing</small>
      </div>
    </div>
  </div>
</div>
