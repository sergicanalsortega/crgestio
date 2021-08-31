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

defined('_Afi') or die('restricted access');

class Configuration {

	public $site        	= 'http://172.17.0.12';
	public $offline     	= 0;
	public $log         	= '/opt/bitnami/apache/htdocs/logs/afigest.log';
	public $sitename    	= 'Colomer-Rifà';
	public $description 	= 'Gestió de tasques';
	public $email       	= 'kim@afi.cat';
	public $debug       	= 0;
	public $driver      	= 'sqlsrv';
	public $host        	= '172.17.0.10';
	public $user        	= 'web';
	public $pass        	= 'nK4maMSYHTgukoy9n3GJ';
	public $database    	= 'ColomerRifa_6_test';
	public $dbprefix    	= '';
	public $token_time  	= 300;
	public $template    	= 'mazer';
	public $cookie      	= 30;
	public $admin_mails 	= 1;
	public $inactive    	= 1000;
	public $login_redirect 	= '/index.php?view=hores';
	public $show_register 	= 0;
	public $pagination  	= 20;
}
