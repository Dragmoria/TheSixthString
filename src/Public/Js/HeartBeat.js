let timer = 600000;
let userinputCheck = "";
$(document).on('mousemove click', handleUserActivity);

function handleUserActivity() {
    if (userinputCheck === ''){
        userinputCheck = "Movement Detected"
    }
}

setInterval(function() {

    timer -= 60000;

    if (timer <= 0) {
        if (userinputCheck === ''){
        $.ajax({
            url: '/LogOutPulse',
            method: 'POST',
            data: { action: 'heartbeat' },
            success: function(response) {
                window.location.href = "/Login";
            }
        });
        userinputCheck = "";
        timer = 600000;
    } else{
        userinputCheck = "";
        timer = 600000;
    }
    }
}, 60000); 



window.addEventListener('unload', function () {
    $.ajax({
        url: '/LogOutPulse',
        method: 'POST',
        data: { action: 'heartbeat' },
        success: function(response) {
            window.location.href = "/Login";
        }
    });
});