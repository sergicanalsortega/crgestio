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
include_once('helper.php');
?>

<div class="row-fluid">
    <div class="card mb-3">
        <div id="chart_div"></div>
    </div>
</div>

<script>
jQuery(document).ready(function() {
	// Load the Visualization API and the corechart package.
	google.charts.load('current', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(drawChart);

	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawChart() {

	// Create the data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	data.addRows([
		['Programació', <?= chartTagsHelper::getTags('Programació'); ?>],
		['Disseny', <?= chartTagsHelper::getTags('Disseny'); ?>],
		['SEO', <?= chartTagsHelper::getTags('SEO'); ?>],
		['Accesibilitat', <?= chartTagsHelper::getTags('Accesibilitat'); ?>],
		['Usabilitat', <?= chartTagsHelper::getTags('Usabilitat'); ?>]
	]);

	// Set chart options
	var options = {'title':'',
					'width':'100%',
					'height':'auto'};

	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	chart.draw(data, options);
	}
});
</script>