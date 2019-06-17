function copyToClipboard(element) {
    var text = $(element).clone().find('br').prepend('\r\n').end().text()
    element = $('<textarea>').appendTo('body').val(text).select()
    document.execCommand('copy')
    element.remove()
}

function newConfiguration() {
    window.location = 'new_config.php';
}

function selectArduinoDevice() {
    var arduinoDeviceSelector = document.getElementById('arduinoDevice');
    var wifiDeviceSelector = document.getElementById('wifiDevice');
    var sensorDeviceSelector = document.getElementById('sensorDevice');
    var actuatorDeviceSelector = document.getElementById('actuatorDevice');

    if (arduinoDeviceSelector.value != 'empty') {
        wifiDeviceSelector.disabled = false;
    } else {
        deselectDevice(wifiDeviceSelector);
        deselectDevice(sensorDeviceSelector);
        deselectDevice(actuatorDeviceSelector);
    }
}

function selectWifiDevice() {
    var wifiDeviceSelector = document.getElementById('wifiDevice');
    var sensorDeviceSelector = document.getElementById('sensorDevice');
    var actuatorDeviceSelector = document.getElementById('actuatorDevice');

    if (wifiDeviceSelector.value != 'empty') {
        sensorDeviceSelector.disabled = false;
        actuatorDeviceSelector.disabled = false;
    } else {
        deselectDevice(sensorDeviceSelector);
        deselectDevice(actuatorDeviceSelector);
    }
}

function deselectDevice(deviceSelector) {
    var options = deviceSelector.options;
    for (var opt, j = 0; opt = options[j]; j++) {
        if (opt.value == 'empty') {
            deviceSelector.selectedIndex = j;
            break;
        }
    }
    deviceSelector.disabled = true;
}

function selectsensorDevice() {
    var sensorDeviceSelector = document.getElementById('sensorDevice');
    var sensorId = document.getElementById('sensorId');
    var sensorSpan = document.createElement('span');

    while (sensorId.firstChild) {
        sensorId.removeChild(sensorId.firstChild);
    }

    if (sensorDeviceSelector.value != 'empty') {
        sensorSpan.setAttribute('id', 'sensorName');
        sensorSpan.appendChild(document.createTextNode(sensorDeviceSelector.value));
        sensorId.appendChild(sensorSpan);
    }
}

function selectactuatorDevice() {
    var actuatorDeviceSelector = document.getElementById('actuatorDevice');
    var actuatorId = document.getElementById('actuatorId');
    var actuatorSpan = document.createElement('span');

    while (actuatorId.firstChild) {
        actuatorId.removeChild(actuatorId.firstChild);
    }

    if (actuatorDeviceSelector.value != 'empty') {
        actuatorSpan.setAttribute('id', 'actuatorName');
        actuatorSpan.appendChild(document.createTextNode(actuatorDeviceSelector.value));
        actuatorId.appendChild(actuatorSpan);
    }
}

function selectTypeFunction() {
    // var checkInsertPins = document.getElementById('insertButton');
    var checkLibraries = document.getElementById('libraryItem');
    var checkVariables = document.getElementById('variableItem');
    var checkSetup = document.getElementById('setupItem');
    var checkLoop = document.getElementById('loopItem');
    var checkDescription = document.getElementById('descriptionItem');
    var checkSelectValue = document.getElementById('devType').value;
    if (checkSelectValue != 'Empty' && checkSelectValue != 'Arduino' && checkLibraries == null) {
        var ul = document.getElementById('formListId');
        var itemsList = ['libraryItem', 'variableItem', 'setupItem', 'loopItem', 'descriptionItem'];
        var textareasList = ['libraryCode', 'variableCode', 'setupCode', 'loopCode', 'descriptionText'];
        var titles = ['Library', 'Variable', 'Setup', 'Loop', 'Description'];
        var titleEnding = ' code for this device';

        // var listItem = document.createElement('li');
        // var inputNumber = document.createElement('input');
        // var inputButtonMinus = document.createElement('input');
        // var inputButtonPlus = document.createElement('input');
        // var inputButtonOk = document.createElement('input');

        // inputNumber.setAttribute('type', 'number');
        // inputNumber.setAttribute('name', 'numOfPins');
        // inputNumber.setAttribute('id', 'numOfPins');
        // inputNumber.setAttribute('min', '0');
        // inputNumber.setAttribute('max', '10');
        // inputNumber.setAttribute('value', '0');
        // inputNumber.setAttribute('style', 'width: 1.5em;');
        // inputNumber.setAttribute('readonly', 'true');
        // inputNumber.setAttribute('onclick', 'insertField(\'formListId\')');

        // inputButtonMinus.setAttribute('type', 'button');
        // inputButtonMinus.setAttribute('id', 'button-minus');
        // inputButtonMinus.setAttribute('value', '-');
        // inputButtonMinus.setAttribute('onclick', 'incDecValue(\'numOfPins\', \'-\')');

        // inputButtonPlus.setAttribute('type', 'button');
        // inputButtonPlus.setAttribute('id', 'button-plus');
        // inputButtonPlus.setAttribute('value', '+');
        // inputButtonPlus.setAttribute('onclick', 'incDecValue(\'numOfPins\', \'+\')');

        // inputButtonOk.setAttribute('type', 'button');
        // inputButtonOk.setAttribute('id', 'button-ok');
        // inputButtonOk.setAttribute('value', 'Ok');
        // inputButtonOk.setAttribute('onclick', 'drawPinFields(\'numOfPins\', \'insertButton\')');

        // listItem.setAttribute('id', 'insertButton');
        // listItem.appendChild(document.createTextNode('Pins needed: '));
        // listItem.appendChild(inputNumber);
        // listItem.appendChild(document.createTextNode(' '));
        // listItem.appendChild(inputButtonMinus);
        // listItem.appendChild(inputButtonPlus);
        // listItem.appendChild(document.createTextNode(' '));
        // listItem.appendChild(inputButtonOk);
        // ul.appendChild(listItem);

        for (var i = 0; i < itemsList.length; i++) {
            var li = document.createElement('li');
            var textarea = document.createElement('textarea');
            var br = document.createElement('br');

            textarea.setAttribute('id', textareasList[i]);
            textarea.setAttribute('name', textareasList[i]);
            textarea.setAttribute('rows', '5');
            textarea.setAttribute('cols', '50');

            li.setAttribute('id', itemsList[i]);
            if (titles[i] == 'Description') {
                li.appendChild(document.createTextNode(titles[i]));
            } else {
                li.appendChild(document.createTextNode(titles[i].concat(titleEnding)));
            }
            li.appendChild(br);
            li.appendChild(textarea);
            ul.appendChild(li);
        }
    } else if ((checkSelectValue == 'Empty' || checkSelectValue == 'Arduino') && checkLibraries != null) {
        // checkInsertPins.parentNode.removeChild(checkInsertPins);
        checkLibraries.parentNode.removeChild(checkLibraries);
        checkVariables.parentNode.removeChild(checkVariables);
        checkSetup.parentNode.removeChild(checkSetup);
        checkLoop.parentNode.removeChild(checkLoop);
        checkDescription.parentNode.removeChild(checkDescription);
    }

    var submitButton = document.getElementById('devSubmit');
    if (checkSelectValue == 'Empty') {
        submitButton.setAttribute('disabled', '');
    } else {
        submitButton.removeAttribute('disabled');
    }
}

// function incDecValue(id, operation) {
//     var numOfPins = document.getElementById(id);
//     if (operation == '-' && numOfPins.value > 0) {
//         numOfPins.setAttribute('value', numOfPins.value--);
//     } else if (operation == '+' && numOfPins.value < 10) {
//         numOfPins.setAttribute('value', numOfPins.value++)
//     }
// }

// function drawPinFields(id, parentNodeId) {
//     var numOfPins = document.getElementById(id).value;
//     var li = document.getElementById(parentNodeId);
//     var inputButtonMinus = document.getElementById('button-minus');
//     var inputButtonPlus = document.getElementById('button-plus');
//     var inputButtonOk = document.getElementById('button-ok');
//     for (let i = 1; i <= numOfPins; i++) {
//         var inputText = document.createElement('input');
//         var brLine1 = document.createElement('br');
//         var brLine2 = document.createElement('br');

//         inputText.setAttribute('type', 'text');
//         inputText.setAttribute('name', 'pin-field-' + i);
//         inputText.setAttribute('id', 'pin-field-' + i);

//         li.appendChild(brLine1);
//         li.appendChild(document.createTextNode('Add pin title:'));
//         li.appendChild(brLine2);
//         li.appendChild(inputText);
//     }
//     inputButtonMinus.setAttribute('disabled', 'true');
//     inputButtonPlus.setAttribute('disabled', 'true');
//     inputButtonOk.setAttribute('disabled', 'true');
// }