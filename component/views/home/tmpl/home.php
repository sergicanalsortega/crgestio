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

?>

<div class="row" id="auth">
    <div class="col-lg-5 col-12">
        <div id="auth-left">

            <?php if(!$user->getAuth()) : ?>
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
            <?php else : ?>
                <h1 class="auth-title mb-5">Logout.</h1>
            <?php endif; ?>

            <?php if(!$user->getAuth()) : ?>
            <form action="<?= $config->site; ?>/index.php?task=register.login" method="post" class="text-left needs-validation" novalidate>
              <input type="hidden" name="token" value="<?= $_GET['token']; ?>">
              <input type="hidden" name="return" value="<?= $_GET['return']; ?>">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" name="email" class="form-control form-control-xl" placeholder="Username">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
            <?php else : ?>
                <a href="index.php?task=register.logout" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Logout</a>
            <?php endif; ?>

        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>