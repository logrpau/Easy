$( document ).ready(function() {
    $('#calendar').fullCalendar({
        header:{ 
            left: 'today,prev,next,Miboton',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        height: 450,
        events: {
            url: '/home/turnos',
            type: 'GET',
            error: function() {
              alert('there was an error while fetching events!');
            }
          }
        
        });
});