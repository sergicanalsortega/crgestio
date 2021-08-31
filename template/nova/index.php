<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $config->sitename; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="<?= $config->description; ?>">
    <meta name="author" content="<?= $config->sitename; ?>">
    <link rel="canonical" href="<?= $url->selfUrl(); ?>">
    <script data-ad-client="ca-pub-2086277945461916" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/style.<?= $user->template; ?>.premium.css" id="theme-stylesheet">
    <!-- Selectize -->
    <link rel="stylesheet" href="<?= $config->site; ?>/assets/css/selectizer.min.css" crossorigin="anonymous" />
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/custom.css">

    <?php
  	if(count($app->stylesheets) > 0) :
  		foreach($app->stylesheets as $stylesheet) : ?>
  		    <link href="<?= $stylesheet; ?>" rel="stylesheet">
  		<?php endforeach;
  	endif;
  	?>
    <!-- Favicon-->
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" href="<?= $config->site; ?>/assets/img/icons/icon64.jpg">
    <link rel="shortcut icon" href="<?= $config->site; ?>/assets/img/icons/icon16.jpg">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/jquery/jquery.min.js"></script>
  </head>
  <body>
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><a href="index.php?view=profile"><img src="https://secure.gravatar.com/avatar/<?= md5($user->email); ?>?size=100" alt="<?= $user->username; ?>" class="img-fluid rounded-circle"></a>
            <h2 class="h5"><?= $user->username; ?></h2><span><?= $user->cargo; ?></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>A</strong><strong class="text-primary">F</strong></a></div>
        </div>
        <?= $app->getModule('sidebarmenu');?>
      </div>
    </nav>
    <div class="page">

      <?= $app->getModule('topmenu');?>

      <?php @include($app->getLayout()); ?>

      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-4">
              <p><?= $config->sitename; ?> &copy; 2020 &middot; Made with <i class="fa fa-heart text-danger"></i> from Barcelona</p>
            </div>
            <div class="col-sm-4 text-center">
              <p>Imatge diària gràcies a Bing</p>
            </div>
            <div class="col-sm-4 text-right">
              <p>Version <a href="index.php?view=about&layout=log"><?= $app->getVersion(); ?></a> &middot; <a href="index.php?view=about&layout=api">API</a> &middot; <?php if($user->getAuth() && $settings->show_coins == 1) : ?><a href="index.php?view=about&layout=coins"><span class="badge bg-warning text-dark" title="<?= $user->coins; ?> coins earned"><?= $user->coins; ?> <img src="assets/img/coin.png" alt="coin" width="10" height="10"></span></a><?php endif; ?></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- JavaScript files-->
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Notifications-->
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/messenger-hubspot/build/js/messenger.min.js">   </script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/messenger-hubspot/build/js/messenger-theme-flat.js">       </script>
    <!-- Selectize -->
    <script src="<?= $config->site; ?>/assets/js/selectizer.js" crossorigin="anonymous"></script>
    <!-- Main File-->
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/js/front.js"></script>
    <?php
    if(count($app->scripts) > 0) :
    foreach($app->scripts as $script) : ?>
    <script src='<?= $script; ?>'></script>
    <?php endforeach;
    endif; ?>
    <script src="<?= $config->site; ?>/assets/js/app.js"></script>
    <?php include('template/'.$config->template.'/message.php'); ?>
  </body>
</html>
