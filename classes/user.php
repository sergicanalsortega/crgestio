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

class User
{
    public $Id                      = 0;
    public $DNI                     = "";
    public $Treballadors            = "";
    public $CategoriaProfessional   = "";
    public $eMail                   = "";
    public $NotificarCanvisEstat    = "";
    public $Alta                    = 0;
    public $Baixa                   = "";
    public $idCalendari             = 1;
    public $admin                   = 0;
    public $HoresJornada            = '';
    public $DiesVacances            = '';
    public $HorariMatiEntrada       = '';
    public $HorariMatiSortida       = '';
    public $HorariTardaEntrada      = '';
    public $HorariTardaSortida      = '';
    public $Autonom                 = '';
    public $IdCapArea               = '';
    public $EsCapArea               = '';
    public $ExcloureEnInformeHores  = 0;
    public $Fitxar                  = '';
    public $_language               = "";
    public $_level                  = 2;
    public $_password               = "";
    public $_apikey                 = "";

    /**
     * Constructor
    */
    function __construct() {
        if( isset($_SESSION['cw_userid']) ) {

            if(isset($_SESSION['cw_userid'])) { $this->Id = $_SESSION['cw_userid']; }
            $this->setAuth($this->Id);
        }
    }

    /**
     * Method to generate auth token
     * @param str $str
     * @return str
    */
    function genToken($str)
    {
        return bin2hex($str);
    }

    /**
     * Method to know if user exist
     * @param int $id
     * @return boolean true if owner false if not
    */
    function isUser($id)
    {
        $db  = factory::getDatabase();
        $db->query('SELECT * FROM #_Treballadors WHERE Id = '.(int)$id);
        if($db->num_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Method to get the user authentication
     * @return boolean true if authenticate false if not
    */
    function getAuth()
    {
        if( !isset($_SESSION['cw_userid']) ) {
            return false;
        }
        return true;
    }

    /**
     * Method to set authentication values
     * @param id int the user id
     * @return void
    */
    function setAuth($id)
    {
        $_SESSION['cw_userid'] = $id;

        $db  = factory::getDatabase();
        $db->query('SELECT u.* FROM #_Treballadors AS u WHERE u.Id = '.(int)$id);
        $row = $db->fetchArray();

        foreach($row as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * Method to get the user object
     * @param id int the user id
     * @return object
    */
    function getUserObject($id)
    {
        $db  = factory::getDatabase();
        $db->query('SELECT u.* FROM #_Treballadors AS u WHERE u.Id = '.(int)$id);
        $row = $db->fetchObject();

        return $row;
    }

    /**
     * Method to get the usergroup tree
     * @param lvl int the user level
     * @return object
    */
    public function getGroups($lvl)
    {
        $db  = factory::getDatabase();
        $log = factory::getLog();
        //$log->lwrite('getGroups'.$lvl.'...');
        $groups[] = $lvl;

        $db->query('SELECT id FROM #_usergroups WHERE parent_id = '.(int)$lvl);
        $rows = $db->fetchObjectList();

        if(count($rows)) {
            foreach($rows as $row) {
                $result = $this->getGroups($row->id); 
                foreach($result as $group) {
                    //$log->lwrite('getGroups'.$lvl.' '.$group);
                    $groups[]=$group;
                }
            }
            //$log->lwrite('base 1 getGroups'.$lvl.implode(',',$groups));
            return array_unique($groups, SORT_NUMERIC);
        } else {
            //$log->lwrite('base 2 getGroups'.$lvl.implode(',',$groups));
            return array_unique($groups, SORT_NUMERIC);
        }
    }
}
?>
