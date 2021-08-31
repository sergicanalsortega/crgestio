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
     <li class="breadcrumb-item active">Log</li>
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
           <h4>AfiGest 1.4.1</h4>
         </div>
         <div class="card-body">
           <h3>Canvis en la versió</h3>
           <hr>
           <p>Estils per mostrar actiu la secció del menú lateral.</p>
           <p>Nou sistema per escollir des de la funció si es volen o no els filtres colapsables.</p>
           <p>Nou mòdul del temps local basat en OpenWeatherMap.</p>
           <p>Els usuaris ja es poden editar.</p>
           <p>Els grups d'usuaris ja es poden editar.</p>
           <p>Afegit CP i Població com a camps del perfil.</p>
           <p>Multiples projectes poden associar-se a un usuari/a i aquest només veu a la llista d'incidències les relacionades.</p>
           <p>Els filtres de projectes només mostren els projectes associats.</p>
           <p>A la vista usuaris es pot configurar els permissos Crear, Editar i Esborrar. Els botons tenen en compte aquests valors per apareixer.</p>
           <p>Botó Backup a la vista Tools per respatllar la base de dades en qualsevol moment.</p>
           <p>Eliminat Datetimepicker de jquery a favor del input date de html5.</p>
           <p>Eliminat jQuery Datatables per sistema propi totalment amb PHP.</p>
         </div>
       </div>

       <div class="card">
         <div class="card-header d-flex align-items-center">
           <h4>AfiGest 1.4.0</h4>
         </div>
         <div class="card-body">
           <h3>Canvis en la versió</h3>
           <hr>
           <p>Nova secció per gestionar els grups d'usuaris per part dels administradors.</p>
           <p>Camp de grup d'usuari al formulari d'incidència.</p>
           <p>Tipus d'incidència es pot gestionar des de la base de dades segons necessitat del programa.</p>
           <p>Estat d'incidència es pot gestionar des de la base de dades segons necessitat del programa.</p>
           <p>Habilitat de registrar les hores de treball del personal.</p>
           <p>Sistema de tasques i subtasques.</p>
           <p>Apartat de configuració per administradors.</p>
           <p>Incipient sistema de recompenses de l'ùs de la aplicació.</p>
           <p>Nova secció changelog.</p>
           <p>Canvis en el dashboard.</p>
           <p>Nova icona de comentaris nous a la barra superior.</p>
         </div>
       </div>

    </div>
   </div>
 </div>
</section>
