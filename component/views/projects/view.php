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

if(!$user->getAuth()) {
    $app->redirect($config->site.'?return='.base64_encode($url->selfUrl()));
}

// $app->addScript('template/clean/js/moment.js');
// $app->addScript('template/clean/js/bootstrap-datetimepicker.min.js');
//$app->addScript('plugins/typeahead/typeahead.js');
// $app->addStylesheet('template/clean/css/bootstrap-datetimepicker.min.css');
$app->addScript($config->site.'/assets/js/jquery.cropit.js');
$app->addScript($config->site.'/assets/js/jquery.base64.min.js');

// $app->addStylesheet('assets/js/datatables.net-bs4/css/dataTables.bootstrap4.css');
// $app->addStylesheet('assets/js/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
// $app->addScript('assets/js/datatables.net/js/jquery.dataTables.js');
// $app->addScript('assets/js/datatables.net-bs4/js/dataTables.bootstrap4.js');
// $app->addScript('assets/js/datatables.net-responsive/js/dataTables.responsive.min.js');
// $app->addScript('assets/js/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
