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

//if user is logged or register isn't allowed in config...
if($user->getAuth()) {
  $app->redirect($config->site.'/index.php?view=home&layout=dashboard');
}
if($config->show_register == 0) {
  $app->redirect($config->site.'/index.php?view=home');
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
         <?php if(!$user->getAuth()) : ?>
         <form action="index.php?view=register&amp;task=register" method="post" data-toggle="validator" class="text-left form-validate">
           <?= $html->getEmailField('register', 'email', ''); ?>
           <!-- Password-->
           <?= $html->getPasswordField('register', 'password', ''); ?>
           <!-- Password2 -->
           <?= $html->getPasswordField('register', 'password2', ''); ?>
           <!-- Security token -->
           <?= $html->getTextField('register', 'auth_token', $app->setToken()); ?>
           <!-- Submit button -->
           <?= $html->getButton('register', 'submit'); ?>

           <p style="margin-top:5px;">
           <a href="index.php?view=home" class="btn btn-success btn-block btn-lg">Login</a>
           </p>
           <?php else : ?>
           <a href="<?= $config->site; ?>/index.php?view=register&task=logout" class="btn btn-success btn-block"><?= $lang->get('CW_MENU_LOGOUT'); ?></a>
           <?php endif; ?>

         </form>
         <small>Imatge diaria gràcies a Bing</small>
       </div>
     </div>
   </div>
 </div>
