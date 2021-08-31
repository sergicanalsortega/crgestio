<style>
    body {
  font-family: "Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif;
  background-color: #f5f5f5;
}

.calendar .calendar-header {
  background-color: #f5f5f5;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
  border: 0;
}

.calendar .calendar-header .year-title {
  font-size: 18px;
}

.calendar .calendar-header .year-title:not(.year-neighbor):not(.year-neighbor2) {
  border-bottom: 2px solid #2196f3;
}

.calendar .months-container .month-container {
  height: 260px;
  margin-bottom: 25px;
}

.calendar table.month {
  background-color: white;
  box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.2);
  height: 100%;
}

.calendar table.month th.month-title {
  background-color: #2196F3;
  color: white;
  padding: 12px;
  font-weight: 400;
}

.calendar table.month th.day-header {
  padding-top: 10px;
  color: #CDCDCD;
  font-weight: 400;
  font-size: 12px;
}

.calendar table.month td.day .day-content {
  padding: 8px;
  border-radius: 100%;
}
</style>

<div id="calendari"></div>

<script>
jQuery(document).ready(function() { 
    const currentYear = new Date().getFullYear();
    new Calendar('#calendari', 
    {
        language: 'ca',
        style:'background',
        dataSource: [
        {
            startDate: new Date(currentYear, 1, 4),
            endDate: new Date(currentYear, 1, 15)
        },
        {
            startDate: new Date(currentYear, 3, 5),
            endDate: new Date(currentYear, 5, 15)
        }
        ] 
    }); 
});
</script>