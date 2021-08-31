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

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $lang->get('CW_SETTINGS_TITLE'); ?></h3>
                <p class="text-subtitle text-muted">Configuració global</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $lang->get('CW_SETTINGS_TITLE'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

	<!-- Basic Horizontal form layout section start -->
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title"><?= $lang->get('CW_SETTINGS_TITLE'); ?></h4>  
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <form class="form-signin needs-validation" id="settings-form" action='<?= $config->site; ?>/index.php?view=config&amp;task=saveConfig' method="post" novalidate>

                        <!-- Messages -->
                        <?= $html->getListField('config', 'show_messages', $settings->show_messages); ?>

                        <!-- Dark mode -->
                        <?= $html->getListField('config', 'dark_mode', $settings->dark_mode); ?>

                        <?= $html->getButton('config', 'submit'); ?>

                      </form>
                  </div>
              </div>
            </div>
        </div>
    </section>

</div>
