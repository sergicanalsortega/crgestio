$.ajaxSetup({async: false});

function eventsArray(){
    const IdCalendari = document.getElementById('calendari').getAttribute('data-idcalendari');

    var events = [];

    //get Festius
    $.get(domain+"?view=hores&task=getFestius&mode=raw", { IdCalendari })
        .done(function( data ) {
            data = JSON.parse(data);

            for (const i in data) {
                events.push({
                    start: data[i],
                    className: ['red'],
                    rendering: 'background'
                });
            }
        }
    );

    //get Vacançes
    $.get(domain+"?view=hores&task=getVacances&mode=raw")
        .done(function( data ) {
            data = JSON.parse(data);
            console.log(data);

            for (const i in data) {
                events.push({
                    start: data[i],
                    className: ['green'],
                    rendering: 'background'
                });
            }
    });

    //get Baixes
    $.get(domain+"?view=hores&task=getBaixes&mode=raw")
        .done(function( data ) {
            data = JSON.parse(data);
            console.log(data);

            for (const i in data) {
                events.push({
                    start: data[i],
                    className: ['black'],
                    rendering: 'background'
                });
            }
    });

    return events;
}

function clickEvent(info){
    sessionStorage.setItem('defaultDate', info.dateStr);
    window.location.href = domain+"?view=hores&date="+info.dateStr;
}










