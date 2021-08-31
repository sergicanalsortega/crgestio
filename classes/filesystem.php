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

class Filesystem
{    
    
    /**
     * Method to upload user picture
     * @param $path string the destination path
    **/
    public function upload($path)
    {
    	$app  = factory::getApplication();
        $db   = factory::getDatabase();
        $lang = factory::getLanguage();
		$user = factory::getUser();

		$type = 'success';

		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name'];
    		$targetPath = CWPATH_BASE . DS. $path;
    		$targetFile =  $targetPath. $_FILES['file']['name'];

    		move_uploaded_file($tempFile, $targetFile);

			$msg = 'Imatge pujada amb èxit';

        } else {
            $msg = $lang->get('CW_SETTINGS_UPLOAD_ERROR_NOIMAGE');
			$type = 'error';
        }
			
        $app->setMessage($msg, $type);
    }

}