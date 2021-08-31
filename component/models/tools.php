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

class tools extends model
{

  public function legal()
  {
      $app  = factory::getApplication();
      $config = factory::getConfig();

      $nom     = $_POST['nom'];
    	$empresa = $_POST['empresa'];
    	$nif	   = $_POST['nif'];
    	$adreca	 = $_POST['adreca'];
    	$email	 = $_POST['email'];
    	$jutjats = $_POST['jutjats'];
    	$format	 = $_POST['format'];

      if($format == '') { $format = 'html'; }

    	//Avis legal català
    	$cat_avis_legal = file_get_contents(CWPATH_ASSETS.'/legal/cat_avis_legal.html');
		$cat_avis_legal = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $cat_avis_legal);
		$cat_avis_legal = str_replace('<NIF>', '<b>'.$nif.'</b>', $cat_avis_legal);
    	$cat_avis_legal = str_replace('<POBLACIO_JUJATS>', '<b>'.$jutjats.'</b>', $cat_avis_legal);

    	//Aviso legal español
    	$esp_aviso_legal = file_get_contents(CWPATH_ASSETS.'/legal/esp_aviso_legal.html');
		$esp_aviso_legal = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $esp_aviso_legal);
		$esp_aviso_legal = str_replace('<NIF>', '<b>'.$nif.'</b>', $esp_aviso_legal);
    	$esp_aviso_legal = str_replace('<POBLACIO_JUJATS>', '<b>'.$jutjats.'</b>', $esp_aviso_legal);

    	//Avís legal francès
    	$fra_aviso_legal = file_get_contents(CWPATH_ASSETS.'/legal/fra_aviso_legal.html');
		$fra_aviso_legal = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $fra_aviso_legal);
		$fra_aviso_legal = str_replace('<NIF>', '<b>'.$nif.'</b>', $fra_aviso_legal);
    	$fra_aviso_legal = str_replace('<POBLACIO_JUJATS>', '<b>'.$jutjats.'</b>', $fra_aviso_legal);

    	//Avís legal anglès
    	$eng_aviso_legal = file_get_contents(CWPATH_ASSETS.'/legal/eng_aviso_legal.html');
		$eng_aviso_legal = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $eng_aviso_legal);
		$eng_aviso_legal = str_replace('<NIF>', '<b>'.$nif.'</b>', $eng_aviso_legal);
    	$eng_aviso_legal = str_replace('<POBLACIO_JUJATS>', '<b>'.$jutjats.'</b>', $eng_aviso_legal);
		
    	//Cookies català
    	$cat_cookies = file_get_contents(CWPATH_ASSETS.'/legal/cat_cookies.html');

    	//Cookies español
    	$esp_cookies = file_get_contents(CWPATH_ASSETS.'/legal/esp_cookies.html');

    	//Cookies francès
    	$fra_cookies = file_get_contents(CWPATH_ASSETS.'/legal/fra_cookies.html');

    	//Cookies anglès
    	$eng_cookies = file_get_contents(CWPATH_ASSETS.'/legal/eng_cookies.html');
		
    	//Política de privacitat català
    	$cat_politica_privacitat = file_get_contents(CWPATH_ASSETS.'/legal/cat_politica_privacitat.html');
    	$cat_politica_privacitat = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $cat_politica_privacitat);
    	$cat_politica_privacitat = str_replace('<ADRECA>', '<b>'.$adreca.'</b>', $cat_politica_privacitat);
    	$cat_politica_privacitat = str_replace('<NIF>', '<b>'.$nif.'</b>', $cat_politica_privacitat);
    	$cat_politica_privacitat = str_replace('<EMAIL_EMPRESA>', '<b>'.$email.'</b>', $cat_politica_privacitat);

    	//Política de privacitat español
    	$esp_politica_privacitat = file_get_contents(CWPATH_ASSETS.'/legal/esp_politica_privacidad.html');
    	$esp_politica_privacitat = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $esp_politica_privacitat);
    	$esp_politica_privacitat = str_replace('<ADRECA>', '<b>'.$adreca.'</b>', $esp_politica_privacitat);
    	$esp_politica_privacitat = str_replace('<NIF>', '<b>'.$nif.'</b>', $esp_politica_privacitat);
    	$esp_politica_privacitat = str_replace('<EMAIL_EMPRESA>', '<b>'.$email.'</b>', $esp_politica_privacitat);

    	//Política de privacitat francès
    	$fra_politica_privacitat = file_get_contents(CWPATH_ASSETS.'/legal/fra_politica_privacidad.html');
    	$fra_politica_privacitat = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $fra_politica_privacitat);
    	$fra_politica_privacitat = str_replace('<ADRECA>', '<b>'.$adreca.'</b>', $fra_politica_privacitat);
    	$fra_politica_privacitat = str_replace('<NIF>', '<b>'.$nif.'</b>', $fra_politica_privacitat);
    	$fra_politica_privacitat = str_replace('<EMAIL_EMPRESA>', '<b>'.$email.'</b>', $fra_politica_privacitat);

    	//Política de privacitat francès
    	$eng_politica_privacitat = file_get_contents(CWPATH_ASSETS.'/legal/eng_politica_privacidad.html');
    	$eng_politica_privacitat = str_replace('<EMPRESA>', '<b>'.$empresa.'</b>', $eng_politica_privacitat);
    	$eng_politica_privacitat = str_replace('<ADRECA>', '<b>'.$adreca.'</b>', $eng_politica_privacitat);
    	$eng_politica_privacitat = str_replace('<NIF>', '<b>'.$nif.'</b>', $eng_politica_privacitat);
    	$eng_politica_privacitat = str_replace('<EMAIL_EMPRESA>', '<b>'.$email.'</b>', $eng_politica_privacitat);
		
    	//Zip file
    	$zip = new ZipArchive;
    	if ($zip->open(CWPATH_ASSETS.'/legal/files/'.$nom.'.zip', ZipArchive::CREATE) === TRUE) {

    		$zip->addFromString('cat_avis_legal.'.$format, $cat_avis_legal);
    		$zip->addFromString('esp_aviso_legal.'.$format, $esp_aviso_legal);
			$zip->addFromString('fra_aviso_legal.'.$format, $esp_aviso_legal);
			$zip->addFromString('eng_aviso_legal.'.$format, $esp_aviso_legal);
    		$zip->addFromString('cat_cookies.'.$format, $cat_cookies);
    		$zip->addFromString('esp_cookies.'.$format, $esp_cookies);
			$zip->addFromString('fra_cookies.'.$format, $esp_cookies);
			$zip->addFromString('eng_cookies.'.$format, $esp_cookies);
    		$zip->addFromString('cat_politica_privacitat.'.$format, $cat_politica_privacitat);
    		$zip->addFromString('esp_politica_privacidad.'.$format, $esp_politica_privacitat);
			$zip->addFromString('fra_politica_privacidad.'.$format, $esp_politica_privacitat);
			$zip->addFromString('eng_politica_privacidad.'.$format, $esp_politica_privacitat);

    		$zip->close();
    	}

      $app->redirect($config->site.'/index.php?view=tools');
  }

  public function getFiles()
  {
    if ($handle = opendir(CWPATH_ASSETS.'/legal/files')) {
      while (false !== ($entry = readdir($handle))) {

          if ($entry != "." && $entry != "..") {

              $files[] = $entry;
          }
      }

      closedir($handle);
    }
    return $files;
  }

  public function deleteFile()
  {
    $app  = factory::getApplication();

    $file = $app->getVar('file');

    unlink(CWPATH_ASSETS.'/legal/files/'.$file);

    $app->setMessage('Arxiu esborrat amb èxit', 'success');
    $app->redirect($config->site.'/index.php?view=tools');
  }

  	public function backup_tables() 
  	{
	  	$db 		= factory::getDatabase();
	  	$app 		= factory::getApplication();
	  	$config 	= factory::getConfig();

    	$link = mysqli_connect($config->host, $config->user, $config->pass, $config->database);

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit;
		}

    	mysqli_query($link, "SET NAMES 'utf8'");

		//get all of the tables
		$tables 	= array();
		$result 	= mysqli_query($link, 'SHOW TABLES');
		while($row 	= mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}

		$return = '';
		//cycle through
		foreach($tables as $table)
		{
			$result 	= mysqli_query($link, 'SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($result);
			$num_rows 	= mysqli_num_rows($result);

			$return	   .= 'DROP TABLE IF EXISTS '.$table.';';
			$row2 		= mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
			$return	   .= "\n\n".$row2[1].";\n\n";
			$counter 	= 1;

			//Over tables
			for ($i = 0; $i < $num_fields; $i++) 
			{   //Over rows
				while($row = mysqli_fetch_row($result))
				{   
					if($counter == 1){
						$return.= 'INSERT INTO '.$table.' VALUES(';
					} else{
						$return.= '(';
					}

					//Over fields
					for($j=0; $j<$num_fields; $j++) 
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = str_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}

					if($num_rows == $counter){
						$return.= ");\n";
					} else{
						$return.= "),\n";
					}
					++$counter;
				}
			}
			$return.="\n\n\n";
		}

		//save file
		$fileName = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
		$handle = fopen(CWPATH_ASSETS.DS.'backups'.DS.$fileName, 'w+');
		fwrite($handle, $return);
		if(fclose($handle)){
			$app->setMessage("Done, the file name is: ".$fileName, 'success');
			$app->redirect($config->site.'/index.php?view=tools'); 
		}
	}
}
