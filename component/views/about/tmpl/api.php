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

<div class="breadcrumb-holder">
 <div class="container-fluid">
   <ul class="breadcrumb">
     <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
     <li class="breadcrumb-item active">Api</li>
   </ul>
 </div>
</div>

<section class="forms">
 <div class="container-fluid">

 <div class="my-4 w-100 text-right"><?= $html->renderButtons('about', 'about'); ?></div>
 
   <div class="row">

     <div class="col-lg-12 my-3">

       <div class="card">
         <div class="card-header d-flex align-items-center">
           <h4>API</h4>
         </div>
         <div class="card-body">
           <h3>API Rest</h3>
           <p>afiFramework té una API Rest que et permet obtenir llistes de resultats conjunts o individuals, més abaix tens algun exemple preparat. Per fer servir l'api necessites una apikey que pots generar en el teu <a href="index.php?view=profile">perfil</a>.</p>
           <hr>
           <h3>Exemples</h3>
           <p>Recuperar la llista d'incidències.</p>
           <pre>http://afigest.aficat.com/index.php?task=api.getIssues&apikey={YOUR_APIKEY}&mode=raw</pre>
           <p>Recuperar la llista d'incidències relacionada amb un userid.</p>
           <pre>http://afigest.aficat.com/index.php?task=api.getIssuesByUserid&apikey={YOUR_APIKEY}&userid={USERID}&mode=raw</pre>
           <p>Recuperar una incidència per la seva ID.</p>
           <pre>http://afigest.aficat.com/index.php?task=api.getIssues&apikey={YOUR_APIKEY}&id=ID&mode=raw</pre>
           <p>Recuperar una llista d'incidències per el seu estat (1-pendent 2-progres 3-resolt 4-descartat).</p>
           <pre>http://afigest.aficat.com/index.php?task=api.getIssuesByStatus&apikey={YOUR_APIKEY}&estat={STATUS}&mode=raw</pre>
		   <p>Recuperar una llista d'incidències no facturades.</p>
           <pre>http://afigest.aficat.com/index.php?task=api.getIssuesNotBilled&apikey={YOUR_APIKEY}&[projecteid={PROJECTID}]&mode=raw</pre>
		   <p>Recuperar una llista de projectes.</p>
           <pre>http://afigest.aficat.com/index.php?task=api.getProjectsList&apikey={YOUR_APIKEY}&mode=raw</pre>
         </div>
       </div>

    </div>
   </div>
 </div>
</section>
