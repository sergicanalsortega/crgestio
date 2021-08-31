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

include('includes/model.php');

class register extends model
{

    /**
     * Method to check if email exists
    */
    function checkEmail()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'checkEmail' || $_GET['task'] == 'register.checkEmail')) {
            $db         = factory::getDatabase();
            $email      = $_GET['email'];

            $db->query('SELECT Id FROM `#_Treballadors` WHERE eMail = '.$db->quote($email));
            if($id = $db->loadResult()) {
                echo false;
            } else {
                echo true;
            }
        }
    }

    /**
     * Method to register a new user
    */
    function register()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'register' || $_GET['task'] == 'register.register')) {
            $config = factory::getConfig();
            $app    = factory::getApplication();
            $db     = factory::getDatabase();
            $user   = factory::getUser();
            $lang   = factory::getLanguage();

            //si un campo esta vacio abortamos...
            if($_POST['email'] == "" || $_POST['password'] == "" || $_POST['password2'] == "") {
                $app->setMessage($lang->get('Rellena todos los campos por favor'), 'danger');
                $app->redirect($config->site.'/index.php?view=register');
                return false;
            }

            //check if email exists...
            $db->query('SELECT Id FROM `#_Treballadors` WHERE eMail = '.$db->quote($_POST['email']));
            if($id = $db->loadResult()) {
                $app->setMessage($lang->get('El email ya existe, por favor elige otro'), 'danger');
                $app->redirect($config->site.'/index.php?view=register');
                return false;
            }

            if($_POST['password'] === $_POST['password2']) {

                unset($_POST['password2']);
                unset($_POST['auth_token']);

                //create user
                $_POST['eMail']         = $_POST['email'];
                $_POST['_password']      = $app->encryptPassword($_POST['password']);
                $_POST['level']         = 2;
                $_POST['language']      = 'ca-es';
                $result = $db->insertRow('#_Treballadors', $_POST);

                $lastid = $db->lastId();

                if($result && $result2) {
                    //send a confirmation to the user...
                    $subject    = $lang->replace('CW_REGISTER_WELCOME_SUBJECT', $config->sitename);
                    $link       = $config->site.'/index.php?view=register&task=validate&token='.$token;
                    $body       = $lang->replace('CW_REGISTER_WELCOME_BODY', $_POST['username'],  $config->sitename, $link);
                    $send       = $this->sendMail($_POST['email'], $_POST['email'], $subject, $body);

                    if($send) {
                        $app->setMessage($lang->replace('CW_REGISTER_SUCCESS_MSG', $config->sitename), 'success');
                        $app->redirect($config->site.'/index.php?view=home');
                        exit(0);
                    } else {
                        //mostrar el link de activacion en el mensaje ya que fallo el email...
                        $app->setMessage($lang->replace('CW_REGISTER_EMAIL_ERROR_MSG', $link), 'danger');
                        $app->redirect($config->site.'/index.php?view=register');
                        return true;
                    }
                } else {
                    $app->setMessage($lang->get('CW_REGISTER_ERROR_MSG'), 'danger');
                    $app->redirect($config->site.'/index.php?view=register');
                    return false;
                }
            } else {
                $app->setMessage($lang->get('CW_REGISTER_PASSWORDS_NOT_MATCH_MSG'), 'danger');
                $app->redirect($config->site.'/index.php?view=register');
                return false;
            }
        }
    }

    /**
     * Method to reset the user password
    */
    function resendActivation()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'resendActivation' || $_GET['task'] == 'register.resendActivation')) {
            $config = factory::getConfig();
            $app    = factory::getApplication();
            $user   = factory::getUser();
            $lang   = factory::getLanguage();

            //send a confirmation to the user...
            $subject    = $lang->replace('CW_REGISTER_WELCOME_SUBJECT', $config->sitename);
            $link       = $config->site.'/index.php?view=register&task=validate&token='.$user->token;
            $body       = $lang->replace('CW_REGISTER_WELCOME_BODY', $user->Treballadors,  $config->sitename, $link);
            $send       = $this->sendMail($user->email, $user->email, $subject, $body);

            if($send) {
                $app->setMessage($lang->get('CW_REGISTER_RESET_SUCCESS_MSG'), 'success');
                $app->redirect($config->site.'/index.php?view=home');
            } else {
                $app->setMessage($lang->get('CW_REGISTER_RESET_ERROR_MSG'), 'danger');
            }
        }
    }

    /**
     * Method to reset the user password
    */
    function reset()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'reset' || $_GET['task'] == 'register.reset')) {
            $config = factory::getConfig();
            $app    = factory::getApplication();
            $db     = factory::getDatabase();
            $user   = factory::getUser();
            $lang   = factory::getLanguage();

            //si un campo esta vacio abortamos...
            if($_POST['email'] == "") {
                $app->setMessage($lang->get('Rellena todos los campos por favor'), 'danger');
                $app->redirect($config->site.'/index.php?view=register&layout=reset');
                return false;
            }

            $email  = $db->quote($_POST['email']);

            $db->query("SELECT Id FROM `#_Treballadors` WHERE eMail = $email");
            $id = $db->loadResult();
            $newpassword = uniqid();
            $password = $app->encryptPassword($newpassword);
            $result = $db->updateField('#_Treballadors', '_password', $password, 'id', $id);
            //send email to user...
            if($result) {
                //send a confirmation to the user...
                $subject  = $lang->replace('CW_REGISTER_RESET_SUBJECT', $config->sitename);
                $body     = $lang->replace('CW_REGISTER_RESET_BODY', $_POST['email'], $config->sitename, $newpassword);
                $send     = $this->sendMail($_POST['email'], $_POST['email'], $subject, $body);

                if($send) {
                    $app->setMessage($lang->get('CW_REGISTER_RESET_SUCCESS_MSG'), 'success');
                    $app->redirect($config->site.'/index.php?view=home');
                } else {
                    $app->setMessage($lang->get('CW_REGISTER_RESET_ERROR_MSG'), 'danger');
                }
            } else {
                $app->setMessage($lang->get('CW_REGISTER_RESET_ERROR_MSG'), 'danger');
            }
        }
    }

    /**
     * Method to login into the application
    */
    public function login()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'login' || $_GET['task'] == 'register.login')) 
        {
            $config  = factory::getConfig();
            $app     = factory::getApplication();
            $db      = factory::getDatabase();
            $user    = factory::getUser();
            $lang    = factory::getLanguage();
            $session = factory::getSession();

            $email    = $app->getVar('email', '', 'post', 'string');
            $password = $app->getVar('password', '', 'post', 'string');
            $return   = $app->getVar('return', '', 'post', 'string');

            //si un campo esta vacio abortamos...
            if($email == "" || $password == "") {
                $app->setMessage($lang->get('Rellena todos los campos por favor'), 'danger');
                $app->redirect($config->site.'/index.php?view=home');
            }

            $db->query("SELECT _password FROM #_Treballadors WHERE eMail = ".$db->quote($email));
            $dbpass = $db->loadResult();
            
            if($app->decryptPassword($password, $dbpass)) {

                $db->query("SELECT Id FROM #_Treballadors WHERE eMail = ".$db->quote($email));
                if($id = $db->loadResult()) {
                    
                    $user->setAuth($id);

                    //register session
                    //$session->createSession();

                    $app->setMessage($lang->replace('CW_LOGIN_SUCCESS_MSG',  $user->Treballadors), 'success');

                    $return == '' ? $authUrl = $config->site.$config->login_redirect : $authUrl = base64_decode($return);
                    $app->redirect($authUrl);

                } else {
                    $app->setMessage($lang->get('CW_LOGIN_ERROR_MSG'), 'danger');
                    $app->redirect($config->site.'/index.php?view=home');
                }
            } else {
                $app->setMessage($lang->get('Password not match '.$db->last_query.' '.$password.' '.$dbpass), 'danger');
                $app->redirect($config->site.'/index.php?view=home');
            }
        }
    }

    /**
     * Method to logout the application
    */
    public function logout()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'logout' || $_GET['task'] == 'register.logout')) {
            $config     = factory::getConfig();
            $app        = factory::getApplication();
            $session    = factory::getSession();
            $user       = factory::getUser();

            //esborrem sessió de la DB...
            //$db->query('DELETE FROM `#_sessions` WHERE userid = '.$user->id);

            //register session
            $session->destroySession();

            //Unset token and user data from session
            unset($_SESSION['cw_userid']);
            unset($_SESSION['token']);
            unset($_SESSION['userData']);

            $app->redirect($config->site.'/index.php?view=home');
        }
    }

    /**
     * Method to validate user for the first time into the application after a successful registration
    */
    function validate()
    {
        if(isset($_GET['task']) && ($_GET['task'] == 'validate' || $_GET['task'] == 'register.validate')) {
            $config = factory::getConfig();
            $app    = factory::getApplication();
            $db     = factory::getDatabase();
            $user   = factory::getUser();
            $lang   = factory::getLanguage();

            $sitename = $config->sitename;

            //if token...
            if(isset($_GET['token'])) {
                $result = $db->updateField('#_Treballadors', 'block', 0, 'token', $_GET['token']);
                if($result) {
                    if($config->admin_mails == 1) {
                        $this->sendAdminMail('Nuevo registro en '.$sitename, "Un nuevo usuario se ha registrado en ".$sitename.".");
                    }
                    $app->setMessage($lang->replace('CW_REGISTER_WELCOME_MSG_SUCCESS',  $sitename), 'success');
                } else {
                    $app->setMessage($lang->get('CW_REGISTER_WELCOME_MSG_ERROR'), 'danger');
                }
                $app->redirect($config->site.'/index.php');
            }
        }
    
    }
}
