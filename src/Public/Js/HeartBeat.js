let timer = 600000;
let HeartbeatCheck = 1;
$(document).on('mousemove click', handleUserActivity);

function handleUserActivity() {
    if (HeartbeatCheck <= 1) {
        HeartbeatCheck = 2
    }
}

setInterval(function () {

    timer -= 60000;

    if (timer <= 0) {
        if (HeartbeatCheck > 1) {
            $.ajax({
                url: '/LogOutPulse',
                method: 'POST',
                data: { action: 'heartbeat' },
                success: function (response) {
                    window.location.href = "/Login";
                }
            });
            HeartbeatCheck = 1;
            timer = 600000;
        } else {
            HeartbeatCheck = 1;
            timer = 600000;
        }
    }
}, 60000);
