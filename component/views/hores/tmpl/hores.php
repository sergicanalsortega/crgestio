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

$model 	= $app->getModel('hores');
$page  	= $app->getVar('page', 1, 'get');
$view  	= $app->getVar('view', '', 'get');
$tab  	= $app->getVar('tab', 'diari', 'get');
$date  	= $app->getVar('date', date('Y-m-d'), 'get');
?>

<style>
    .bg-day { cursor: pointer; }
    .bg-saturday { background-color: yellow; }
    .bg-sunday { background-color: red; }
    .bg-festiu {background-color: red;}
    .bg-baixa {background-color: black;}
    .bg-vacança {background-color: black;}

    .bg-actual {background-color: #ccc;}

    #tableau thead, #tableau tbody, #tableau tfoot, #tableau tr, #tableau td, #tableau th{
        border-style: inherit;
        border-width: 1px;
    }

</style>
    
    
<script langage="JavaScript">
    document.addEventListener("DOMContentLoaded", function(event) {
        Mode();

        $('.Projecte').change(function()
        {
            var id = $(this).val();
            $.get(domain+"?view=hores&task=getDataProjecte&id="+id+"&mode=raw")
            .done(function( data ) {
                data = JSON.parse(data);
                $('.cell0 .Descripcio').val(data.razonsocial);
                $('.cell0 .HoresReals').val(data.totalhoresrecompte);
                $('.cell0 .HoresPrev').val(data.horesprevistes);
            });
        });

        $('#hores-form .remove').click(function()
        {
            var cell = $(this).data('cell');
            var id   = $('#hores-form .row'+cell+' > #Id').val();
            $.get(domain+"?view=hores&task=deleteHour&id="+id+"&mode=raw");
        });

        $('#itemsList .remove').click(function()
        {
            var cell = $(this).data('cell');
            var id   = $('#itemsList .row'+cell+' > #Id').val();
            $.get(domain+"?view=hores&task=deleteRegistre&id="+id+"&mode=raw");
        });
    });

    //obtenim la data del localstoratge, si no hi ha data obtenim la actual
    date = getDateLocalStorage();

    let classe = '';
    let events = [];
    annee=date.getFullYear();
    mois=date.getMonth();

    los_meses=["Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre"];
    los_meses2=["J","F","M","A","M","J","J","A","S","O","N","D"];
    los_dias=["D","DIL","DIM","DIM","DIJ","DIV","DIS","DIU"];

    function getEvents(firstDay, lastDay){

        let events = []

        //get Festius
        $.get(domain+"?view=hores&task=getFestius&mode=raw", {firstDay, lastDay})
            .done(function( data ) {
                data = JSON.parse(data);

                for (const i in data) {
                    events.push({
                        date: data[i],
                        class: 'bg-festiu',
                    });
                }
            }
        );

        //get Vacançes
        $.get(domain+"?view=hores&task=getVacances&mode=raw", {firstDay, lastDay})
            .done(function( data ) {
                data = JSON.parse(data);

                for (const i in data) {
                    events.push({
                        date: data[i],
                        class: 'bg-vacança',
                    });
                }
        });

        //get Baixes
        $.get(domain+"?view=hores&task=getBaixes&mode=raw", {firstDay, lastDay})
            .done(function( data ) {
                data = JSON.parse(data);

                for (const i in data) {
                    events.push({
                        date: data[i],
                        class: 'bg-baixa',
                    });
                }
        });

        //get Hores Treballades
        // $.get(domain+"?view=hores&task=getHoresTreballades&mode=raw", {firstDay, lastDay})
        //     .done(function( data ) {
        //         data = JSON.parse(data);

        //         for (const i in data) {
        //             events.push({
        //                 date: data[i],
        //                 class: 'blue',
        //             });
        //         }
        // });

        return events;
    }

    //format output date
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function getDateLocalStorage(){

        return (localStorage.getItem('date')) ? new Date(localStorage.getItem('date')) : new Date();;
    }

    function getDateSelected(){
        let dateSelected = new Date();
        dateSelected.setYear(document.Calendrier.Annee.value);
        dateSelected.setMonth(document.Calendrier.Mois.value);
        dateSelected.setDate(1);

        return dateSelected;
    }

    function onDayClick(el) {
        rawDate = el.getAttribute('data-date')
        localStorage.setItem('date', rawDate);
        window.location.href = domain+'?view=hores&date='+rawDate; 
    }

    function Mois()
    {
        //obtenim el primer i ultim dia respecte el mes i any seleccionat
        const firstDay = formatDate(new Date(getDateSelected().getFullYear(), getDateSelected().getMonth(), 1));
        const lastDay = formatDate(new Date(getDateSelected().getFullYear(), getDateSelected().getMonth() + 1, 0));

        //fem les crides ajax a la base de dades
        events = getEvents(firstDay, lastDay);

        for(i=0;i<7;i++){
            calendrier+="<td width='"+100/7+"%'>"+los_dias[i+1]+"</td>";
        }

        calendrier+="</tr>";
        afficher.setYear(document.Calendrier.Annee.value);
        afficher.setMonth(document.Calendrier.Mois.value);
        afficher.setDate(31);

        if(afficher.getDate()!=31)afficher.setDate(31-afficher.getDate());

        afficher.setMonth(document.Calendrier.Mois.value);
        nbjours=afficher.getDate();
        nbsem=Sem(document.Calendrier.Annee.value,document.Calendrier.Mois.value,nbjours);
        nbsem=Sem(document.Calendrier.Annee.value,document.Calendrier.Mois.value,nbjours);
        nbsem-=Sem(document.Calendrier.Annee.value,document.Calendrier.Mois.value,1)-1;
        boutmois=new Date(document.Calendrier.Annee.value,document.Calendrier.Mois.value,nbjours);

        if(boutmois.getDay()==0){
            nbsem--;
        }

        boutmois=new Date(document.Calendrier.Annee.value,document.Calendrier.Mois.value,1);

        if(boutmois.getDay()==0){
            nbsem++;
        }

        h=1;
        for(i=0;i<nbsem;i++)
    {
        calendrier+="<tr align='center'>";
            for(a=1;a<=7;a++,h++)
        {
            afficher.setDate(h);
            if((afficher.getDay()==a||(afficher.getDay()==0&&a==7))&&afficher.getMonth()==document.Calendrier.Mois.value)
            {
                    Sem(document.Calendrier.Annee.value,document.Calendrier.Mois.value,h-1)
                    Sem(document.Calendrier.Annee.value,document.Calendrier.Mois.value,h-1)

                    if(afficher.getDay()==6) { //dissabte
                        classe = 'bg-saturday'; 
                    }

                    if(afficher.getDay()==0) { //diumenge
                        classe = 'bg-sunday'; 
                    }
                    
                    //pintem els events
                    for (let item of events) {
                        if(formatDate(afficher) == formatDate(item.date.fecha)){
                            classe = item.class;
                        }
                    }

                    //pintem el dia actual
                    if(formatDate(afficher) == formatDate(getDateLocalStorage())){
                        classe = 'bg-actual';
                    }

                    calendrier+="<td class='bg-day "+classe+"' data-date='"+afficher.toISOString().split("T")[0]+"' onclick='onDayClick(this);'>";
                    classe = '';
                    calendrier+=afficher.getDate();
                }
                else
                {
                    calendrier+="<td>&nbsp";
                    h--;
                }
                calendrier+="</td>";
            }
            calendrier+="</tr>";
        }
        calendrier+="</table>";
        document.getElementById("Cal").innerHTML=calendrier;
        document.getElementById("SelMois").style.visibility="visible";
        
    }

    function Mode(r=false){
        //recuperem la data del select i la guardem al localsoratge, despres redirigim
        if(r) { 
            const rawDate = formatDate(getDateSelected());
            localStorage.setItem('date', rawDate);
            window.location.href = domain+'?view=hores&date='+rawDate; 
        }
        
        mode=1;
        calendrier="<table style='font-size:9' width='100%' border='1'>";
        calendrier+="<tr align='center' bgcolor='#00FFFF'>";
        afficher=new Date();
        Mois(); 
    }

    function Sem(A,M,K){

        date.setYear(A);
        date.setMonth(M);
        date.setDate(K);
        date2=new Date(A,0,1);
        x=1;

        do
        {
            date2.setDate(x);
            x++;
        }
        while(date2.getDay()!=1);

        temps=date.getTime()-date2.getTime()+24*60*60*1000;
        sem=temps/(1000*60*60*24*7);

        return Math.ceil(sem);
    }
</script>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Hores <?= $date != '' ? $date : ''; ?></h3>
                <p class="text-subtitle text-muted">Registre horari</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hores</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

	<!-- Basic Horizontal form layout section start -->
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Calendari</h4>
                            <?= $html->renderButtons('hores', 'hores'); ?>
                        </div>
                        <span class="square green"></span> Vacançes
                        <span class="square black"></span> Baixes
                        <span class="square red"></span> Festius 
                        <span class="square yellow"></span> Dissabtes 
                        <span class="square blue1"></span><!----><span class="square blue2"><!----></span><!----><span class="square blue3"></span> Treball
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- <div id="calendari" data-IdCalendari="<?= $user->IdCalendari; ?>"></div> -->
                            <div class="text-right" ID=tableau>
                                <form name="Calendrier">
                                <table style='font-size:9' class="table">
                                <tr class="text-center">
                                    <td>
                                    <div id=SelMois>
                                    <select name="Mois" id="mes" tabindex="1" onchange="Mode(1)" class="form-select" >
                                    <script langage="JavaScript">
                                        for(i=0;i<12;i++)
                                        {
                                            document.write("<option ");
                                            if(i==mois)document.write("selected ");
                                            document.write("value='"+i+"'>"+los_meses[i]+"</option>");
                                        }
                                    </script>
                                    </select>
                                    </div>
                                    </td>
                                    <td>
                                    <select name="Annee" id="any" tabindex="2" onchange="Mode(1)" class="form-select">
                                    <script langage="JavaScript">
                                        for(i=(annee-50);i<(annee+51);i++)
                                        {
                                            document.write("<option ");
                                            if(i==annee)document.write("selected ");
                                            document.write("value='"+i+"'>"+i+"</option>");
                                        }
                                    </script>
                                    </select>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="2">
                                    <div class="text-center" ID=Cal>
                                    </div>
                                    </td>
                                </tr>
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Registre horari</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-signin needs-validation" id="hores-form" action='<?= $config->site; ?>/index.php?view=hores&amp;task=saveHorari' method="post" novalidate>
                                <input type="hidden" name="IdTreballador" value="<?= $user->Id; ?>">
                                <input type="hidden" name="Data1" value="<?= $date; ?>">
                                <?= $html->getRepeatable('hores', array('Id', 'Hora', 'TipusMoviment', 'Comentari'), $model->getEntradesTreballador($date), null, null, null); ?>  
                                <button type="submit" class="btn btn-primary"><?= $lang->get('CW_SAVE'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<section class="section">
        <div class="card">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button onclick="document.getElementById('tab').value='diari';" class="nav-link <?php if($tab == 'diari') : ?>active<?php endif; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#diari" type="button" role="tab" aria-controls="diari" aria-selected="true">Diari treball</button>
                    </li>
                    <!--
                    <li class="nav-item" role="presentation">
                        <button onclick="document.getElementById('tab').value='resum';"  class="nav-link <?php if($tab == 'resum') : ?>active<?php endif; ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#resum" type="button" role="tab" aria-controls="resum" aria-selected="false">Resum dies anteriors</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button onclick="document.getElementById('tab').value='vacances';"  class="nav-link <?php if($tab == 'vacances') : ?>active<?php endif; ?>" id="contact-tab" data-bs-toggle="tab" data-bs-target="#vacances" type="button" role="tab" aria-controls="vacances" aria-selected="false">Vacances 2021</button>
                    </li>
                        -->
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="diari" role="tabpanel" aria-labelledby="diari-tab">
                        <form action="<?= $config->site; ?>/index.php?view=hores&task=saveRegistre" method="post" id="itemsList" name="itemsList" class="mt-3 w-100 needs-validation" novalidate>
                            <input type="hidden" name="IdTreballador" value="<?= $user->Id; ?>">
                            <input type="hidden" name="Data" value="<?= $date; ?>">
                            <input type="hidden" name="view" value="hores">
                            <input type="hidden" name="tab" id="tab" value="diari">
                            <?= $html->getRepeatable('horesPersonal', array('Id', 'IdProjecte', 'Descripcio', 'Hores', 'HoresReals', 'HoresPrev', 'KM', 'Dietes', 'Observacions'), $model->getRegistresTreballador($date), null, null, null); ?> 
                            <button type="submit" class="btn btn-primary"><?= $lang->get('CW_SAVE'); ?></button>
                        </form>
                    </div>
                    <!--
                    <div class="tab-pane fade" id="resum" role="tabpanel" aria-labelledby="resum-tab">..</div>
                    <div class="tab-pane fade" id="vacances" role="tabpanel" aria-labelledby="vacances-tab">...</div>
                    -->

                </div>

            </div>
        </div>

    </section>
</div>