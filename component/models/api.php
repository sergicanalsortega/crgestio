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

class Api
{
    /**
     * Apikey used to retrieve data
     *
     * @var  string
     * @access   private
    */
    private $apikey = '';

    /**
     * Id
     *
     * @var  int
     * @access   private
    */
    private $id = 0;

    /**
     * Userid
     *
     * @var  int
     * @access   private
    */
    private $userid = 0;

    /**
     * Estat
     *
     * @var  int
     * @access   private
    */
    private $estat = 0;
 
	/**
     * projecteId
     *
     * @var  int
     * @access   private
    */
    private $projecteId = 0;

    /**
     * retrieve all
     * @access   public
     */
    public function getIssues()
    {
        $db  = factory::getDatabase();
        $app = factory::getApplication();

        header('Content-Type: application/json');

        $this->apikey = $app->getVar('apikey', '');

        try {
            if($this->checkApikey($this->apikey)) {
                $db->query('SELECT * FROM `#_incidencies`');
                echo json_encode($db->fetchObjectList());
            } else {
                echo json_encode(array(
                    'error' => array(
                        'msg' => 'Not valid apikey',
                        'code' => '500',
                    )
                )); 
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                )
            ));
        }
        exit();
    }

    /**
     * retrieve all data from a specific id
     * @access   public
     */
    public function getIssuesById()
    {
        $db  = factory::getDatabase();
        $app = factory::getApplication();

        header('Content-Type: application/json');

        $this->apikey  = $app->getVar('apikey', '');
        $this->id      = $app->getVar('id', '');

        try {
            if($this->checkApikey($apikey)) {
                $db->query('SELECT * FROM `#_incidencies` WHERE incidencia_id = '.$this->id);
                echo json_encode($db->fetchObject());
            } else {
                echo json_encode(array(
                    'error' => array(
                        'msg' => 'Not valid apikey',
                        'code' => '500',
                    )
                )); 
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                )
            ));
        }
        exit();
    }

    /**
     * retrieve all data from a specific userid
     * @access   public
     */
    public function getIssuesByUserid()
    {
        $db  = factory::getDatabase();
        $app = factory::getApplication();

        header('Content-Type: application/json');

        $this->apikey  = $app->getVar('apikey', '');
        $this->userid  = $app->getVar('userid', '');

        try {
            if($this->checkApikey($this->apikey)) {
                $db->query('SELECT * FROM `#_incidencies` WHERE usuari = '.$this->userid);
                echo json_encode($db->fetchObject());
            } else {
                echo json_encode(array(
                    'error' => array(
                        'msg' => 'Not valid apikey',
                        'code' => '500',
                    )
                )); 
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                )
            ));
        }
        exit();
    }

    /**
     * retrieve all data from a specific status
     * @access   public
     */
    public function getIssuesByStatus()
    {
        $db  = factory::getDatabase();
        $app = factory::getApplication();

        header('Content-Type: application/json');

        $this->apikey  = $app->getVar('apikey', '');
        $this->estat   = $app->getVar('estat', '');

        try {
            if($this->checkApikey($this->apikey)) {
                $db->query('SELECT * FROM `#_incidencies` WHERE estat = '.$this->estat);
                echo json_encode($db->fetchObjectList());
            } else {
                echo json_encode(array(
                    'error' => array(
                        'msg' => 'Not valid apikey',
                        'code' => '500',
                    )
                )); 
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                )
            ));
        }
        exit();
    }
	
	/**
     * 27/06/2020: Recuperar les incidències no facturades, amb l'opció de demanar només les d'un projecte en particular
     * @access   public
     */
	public function getIssuesNotBilled()
    {
		$db  = factory::getDatabase();
        $app = factory::getApplication();
		
        $this->apikey     = $app->getVar('apikey', '');
        $this->projecteId = $app->getVar('projecteid', 0);
		
		try {
            if($this->checkApikey($this->apikey)) {
				$query = 'SELECT i.*, p.ref_externa, p.abreujatura ' .
					' FROM `#_incidencies` i INNER JOIN `#_projectes` p ON i.projecteId=p.projecte_id ' .
					' WHERE facturat = 0';
				if ($this->projecteId != 0) {
					$query .= ' AND projecteId= ' . $this->projecteId;
				}
				$query .= ' ORDER BY p.abreujatura, i.incidencia_id';
				$db->query($query);
                echo json_encode($db->fetchObjectList());
            } else {
                echo json_encode(array(
                    'error' => array(
                        'msg' => 'Not valid apikey',
                        'code' => '500',
                    )
                )); 
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                )
            ));
        }
		
        header('Content-Type: application/json');
		exit();
	}

	/**
     * 27/06/2020: Recuperar la llista de projectes
     * @access   public
     */
	public function getProjectsList()
    {
		$db  = factory::getDatabase();
        $app = factory::getApplication();
		
        $this->apikey     = $app->getVar('apikey', '');
		
		try {
            if($this->checkApikey($this->apikey)) {
				$db->query(
					'SELECT p.projecte_id, p.nom, p.abreujatura, p.observacions, p.slack_channel, p.ref_externa, p.ordering, count(*) AS no_facturat ' .
					'FROM `#_projectes` p INNER JOIN `#_incidencies` i ON p.projecte_id=i.projecteId ' .
					'WHERE i.facturat=0 ' .
					'GROUP BY p.projecte_id, p.nom, p.abreujatura, p.observacions, p.slack_channel, p.ref_externa, p.ordering ' .
					'ORDER BY p.projecte_id');
                echo json_encode($db->fetchObjectList());
            } else {
                echo json_encode(array(
                    'error' => array(
                        'msg' => 'Not valid apikey',
                        'code' => '500',
                    )
                )); 
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                )
            ));
        }
		
        header('Content-Type: application/json');
		exit();
	}
	
    
	
    /**
     * check if apikey is valid
     * @param    string  $apikey      User apikey
     * @access   public
     */
    private function checkApikey($apikey)
    {
        $db = factory::getDatabase();
        $db->query('SELECT id FROM `#_users` WHERE apikey = '.$db->quote($apikey).' AND level = 1 AND block = 0');
        if($id = $db->loadResult()) {
            return true;
        }
        return false;
    }

}
?>
