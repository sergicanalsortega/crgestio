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

abstract class onSendNotifications {
	
	public static function execute($args) {

        $db     = factory::getDatabase();
        $config = factory::getConfig();
        $user   = factory::getUser();
        $app    = factory::getApplication();

        $model  = $app->getModel('issues');

        $created = $user->getUserObject($args['created_by']);
        $usuari  = $user->getUserObject($args['usuari']);
		
        //si resolta
        if($args['estat'] == 3) {
            $subject = "AfiGest - La incidència nº ".$args['incidencia_id']." es resolta";
            $link    = $config->site."/index.php?view=issues&layout=edit&id=".$args['incidencia_id'];
            $body    = "Hola {{USERNAME}}<p>Un usuari ha donat per resolta la incidencia nº ".$args['incidencia_id'].",<p>Segueix l'enllaç per llegir-lo:</p><p>".$link."&return=".base64_encode($link)."</p>";
            if($args['altres_usuaris'] != '') { $altres_usuaris = explode(',', $args['altres_usuaris']); }
            $model->sendMail($created->email, $created->username, $subject, str_replace('{{USERNAME}}', $created->username, $body));
            if(count($altres_usuaris)) {
                foreach($altres_usuaris as $altres) {
                    $row = $user->getUserObject($altres);
                    $model->sendMail($row->email, $row->username, $subject, str_replace('{{USERNAME}}', $row->username, $body));
                }
            }
        }
        if($args['result1']) {
            $subject = "AfiGest - Actualitzada la incidència nº ".$args['incidencia_id'];
            $link    = $config->site."/index.php?view=issues&layout=edit&id=".$args['incidencia_id'];
            $body    = "Hola {{USERNAME}}<p>La incidència nº ".$args['incidencia_id'].", ha estat actualitzada.</p><p>Segueix l'enllaç per llegir el contingut:</p><p>".$link."&return=".base64_encode($link)."</p>";
            if($args['altres_usuaris'] != '') { $altres_usuaris = explode(',', $args['altres_usuaris']); }
            $model->sendMail($usuari->email, $usuari->username, $subject, str_replace('{{USERNAME}}', $usuari->username, $body));
            if(count($altres_usuaris)) {
                foreach($altres_usuaris as $altres) {
                    $row = $user->getUserObject($altres);
                    $model->sendMail($row->email, $row->username, $subject, str_replace('{{USERNAME}}', $row->username, $body));
                }
            }
        }
        if($args['result2']) {
            $subject = "AfiGest - Nova incidència nº ".$id;
            $link    = $config->site."/index.php?view=issues&layout=edit&id=".$args['incidencia_id'];
            $body    = "Hola {{USERNAME}}<p>Una nova incidència amb nº ".$args['incidencia_id'].", ha estat creada.</p><p>Segueix l'enllaç per llegir el contingut:</p><p>".$link."&return=".base64_encode($link)."</p>";
            if($args['altres_usuaris'] != '') { $altres_usuaris = explode(',', $args['altres_usuaris']); }
            $model->sendMail($usuari->email, $usuari->username, $subject, str_replace('{{USERNAME}}', $usuari->username, $body));
            if(count($altres_usuaris)) {
                foreach($altres_usuaris as $altres) {
                    $row = $user->getUserObject($altres);
                    $model->sendMail($row->email, $row->username, $subject, str_replace('{{USERNAME}}', $row->username, $body));
                }
            }
        }	
	}
}
