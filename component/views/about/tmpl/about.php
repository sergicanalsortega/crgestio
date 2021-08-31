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
     <li class="breadcrumb-item active">About</li>
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
           <h4>Sobre AfiGest</h4>
         </div>
         <div class="card-body">
           <h3>Llicència</h3>
           <p>AfiGest es software lliure desenvolupat sota la llicència <a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GNU GPL v.3</a>.</p>
           <hr>
           <h3>Descripció</h3>
           <p>AfiGest permet gestionar incidències per projectes de software.</p>
           <hr>
           <h3>Descarregues</h3>
           <img src="assets/img/android.png" class="img-fluid" alt="Disponible per Android">
         </div>
       </div>

    </div>
   </div>
 </div>
</section>
