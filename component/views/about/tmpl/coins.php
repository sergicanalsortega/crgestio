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
     <li class="breadcrumb-item active">Coins</li>
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
           <h4>AfiGest Coins</h4>
         </div>
         <div class="card-body">
           <h3>Què es el token BTT?</h3>
           <p>El BTT és un token TRC-10, l'estàndard tècnic de la cadena de blocs Tron. Per a què s'entengui, els tokens TRC-10 a Tron són el que els tokens ERC-20 són a Ethereum.</p>
           <script src="https://widgets.coingecko.com/coingecko-coin-ticker-widget.js"></script>
<coingecko-coin-ticker-widget currency="usd" coin-id="bittorrent-2" locale="en"></coingecko-coin-ticker-widget>
           <hr>
           <h3>Com guanyo BTT tokens?</h3>
           <p>Depenent de les accions que l'usuari/a fa a la plataforma es recompensat amb un número de monedes (fake coins), aquí tens una taula amb el valor de cada acció.</p>
           <table class="table my-5">
               <tr>
                <th>Acció</th>
                <th>Recompensa</th>
               </tr>
               <tr>
                   <td>Comentari en una incidència</td>
                   <td>5 monedes</td>
               </tr>
               <tr>
                   <td>Crear una incidència</td>
                   <td>5 monedes</td>
               </tr>
               <tr>
                   <td>Pujar arxiu en una incidència</td>
                   <td>5 monedes</td>
               </tr>
            </table>
            <p>La quantitat total de monedes guanyades es divideix per 1000 i aquesta es la quantitat actual de tokens BTT que l'usuari/a té al seu compte.</p>
           <hr>
           <h3>Retirar BTT</h3>
           <p>Necesites un mínim de 10 BTT per demanar la retirada cap al teu wallet, si no tens un wallet per criptomonedes et recomanem <a href="https://trustwallet.com/" target="_blank">Trust Wallet</a>.</p>
           <p>La teva quantitat de BTT actual és: <?= number_format(($user->coins / 1000), 2); ?> BTT.</p>
           <p>De moment el sistema encara no està preparat per les retirades de criptomonedes, quan sigui a punt t'avisare'm.</p>
         </div>
       </div>

    </div>
   </div>
 </div>
</section>
