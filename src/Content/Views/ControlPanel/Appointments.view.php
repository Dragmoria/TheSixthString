<style>
    .sizedAndSuch {
        height: calc(100vh - 71px);
    }
</style>

<div class="container p-5 sizedAndSuch">
    <div id="calendar"></div>
</div>

<div class="modal" tabindex="-1" id="showAppoinm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Afspraak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Start: <span id="start"></span><br>
                Eind: <span id="end"></span><br>
                Product: <span id="product"></span><br>
            </div>
            <div class="modal-footer">
                <a id="toProductButton">
                    <button type="button" class="btn btn-primary">Naar product</button>
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            height: '100%',
            locale: 'nl',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/controlPanel/Appointments/GetAppointments',
            eventClick: function(info) {
                $('#start').text(info.event.start.toLocaleString());
                $('#end').text(info.event.end.toLocaleString());
                $('#product').text(info.event.extendedProps.productNaam);
                $('#toProductButton').attr('href', '/Product/' + info.event.extendedProps.productId);
                $('#showAppoinm').modal('show');
            }
        });
        calendar.render();
    });
</script>