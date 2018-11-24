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
          },
          eventClick: function(event) {
            if (event.id) {
                window.location = 'turno/'+ event.id;
              return false;
            }
          }
        
        });
});