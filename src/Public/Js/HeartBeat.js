const pageInitiatingTime = Date.now();
console.log(pageInitiatingTime);
let timer = 75000;

$(document).on('mousemove click', handleUserActivity);

function handleUserActivity() {
    timer = 300000;
}

setInterval(function() {

    timer -= 1000;

    if (timer <= 0) {
        $.ajax({
            url: '/HeartBeat',
            method: 'POST',
            data: { action: 'heartbeat' },
            success: function(response) {
                window.location.href = "/Login";
            }
        });

        timer = 300000;
    }
}, 1000); 