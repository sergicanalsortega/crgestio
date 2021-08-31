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

session_start();
define('_Afi', 1);
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Europe/Berlin');
define('CWPATH_BASE', dirname(__FILE__) );
define('DS', DIRECTORY_SEPARATOR );

require_once(CWPATH_BASE.DS.'includes/defines.php');
require_once(CWPATH_CLASSES.DS.'factory.php');

$config = factory::getConfig();
$app    = factory::getApplication();
$user   = factory::getUser();
$lang   = factory::getLanguage();

if($config->offline == 0) {
  $app->redirect($config->site);
}

$reg = file_get_contents('https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=en-IN');
$reg = json_decode($reg);
$bg  = $reg->images[0]->url;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?= $config->sitename; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="<?= $config->description; ?>">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/style.green.premium.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/custom.css">
    <!-- Favicon-->
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" href="<?= $config->site; ?>/assets/img/icons/icon64.jpg">
    <link rel="shortcut icon" href="<?= $config->site; ?>/assets/img/icons/icon16.jpg">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>

  <body>
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
            <p><?= $config->sitename; ?> està offline per tasques de manteniment. Torneu en uns minuts, gràcies!</p>
            <small>Imatge diaria gràcies a Bing</small>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
