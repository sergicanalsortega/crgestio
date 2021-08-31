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
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Calendari</li>
    </ul>
  </div>
</div>
<section>
  <div class="container-fluid">

    <div class="card mt-3">
      <div class="card-header">
        <h4>Calendari</h4>
      </div>
      <div class="card-body">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'dayGrid', 'list', 'googleCalendar' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,listYear'
      },
      displayEventTime: false,
      googleCalendarApiKey: 'AIzaSyAAwvIottpNdIRV5Yryu4F3-dgw3X5BkUQ',
      eventSources: [
        {
          googleCalendarId: 'aficat.com_qsgfanmnbul78es689mifgjlno@group.calendar.google.com',
          className: 'nice-event'
        }
      ]
    });

    calendar.render();
});
</script>
