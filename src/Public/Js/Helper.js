
function blockKeys(event, forbiddenKeys, splitOn = ';') {
    var keys = forbiddenKeys.split(splitOn);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (keys.includes(key)) {
        event.preventDefault();
        return false;
    }
}