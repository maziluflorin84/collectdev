function copyToClipboard(element) {
    var text = $(element).clone().find('br').prepend('\r\n').end().text()
    element = $('<textarea>').appendTo('body').val(text).select()
    document.execCommand('copy')
    element.remove()
}

function newConfiguration() {
    window.location = 'new_config.php';
}

function whatToInsertIfDeviceType(obj) {
    var liNumDPins = document.getElementById("liNumDPins");
    var numDigitalPins = document.getElementById("numDigitalPins");
    if (obj.value != "Arduino") {
        numDigitalPins.disabled = true;
        liNumDPins.disabled = true;
        numDigitalPins.style.visibility = "hidden";
        liNumDPins.style.visibility = "hidden";
    } else {
        numDigitalPins.disabled = false;
        liNumDPins.disabled = false;
        numDigitalPins.style.visibility = "visible";
        liNumDPins.style.visibility = "visible";
    }
}