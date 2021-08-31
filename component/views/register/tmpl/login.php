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

if($user->getAuth()) {
    $app->redirect($config->site.$config->login_redirect);
}

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
        <p>Gestor de tasques d'Afi Informàtica.</p>
        <form action="<?= $config->site; ?>/index.php?task=register.login" method="post" class="text-left form-validate">
          <input type="hidden" name="token" value="<?= $_GET['token']; ?>">
          <input type="hidden" name="return" value="<?= $_GET['return']; ?>">
          <!-- Username-->
          <?= $html->getEmailField('login', 'email'); ?>
          <!-- Password -->
          <?= $html->getPasswordField('login', 'password'); ?>
          <!-- Last visit -->
          <?= $html->getTextField('login', 'lastvisitDate', date('Y-m-d H:i:s')); ?>
          <!-- Language -->
          <?= $html->getTextField('login', 'language', 'en-gb'); ?>
          <!-- Token -->
          <?= $html->getTextField('login', 'auth_token', $app->setToken()); ?>
          <div class="form-group text-center">
            <?= $html->getButton('login', 'submit'); ?>
          </div>
        </form>
        <small>Imatge diaria gràcies a Bing</small>
      </div>
    </div>
  </div>
</div>
