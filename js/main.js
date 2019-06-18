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
    var ul = document.getElementById('formListId');
    var checkValues = document.getElementById('valuesItem');
    var checkLibraries = document.getElementById('libraryItem');
    var checkVariables = document.getElementById('variableItem');
    var checkSetup = document.getElementById('setupItem');
    var checkLoop = document.getElementById('loopItem');
    var checkDescription = document.getElementById('descriptionItem');
    var checkSelectValue = document.getElementById('devType').value;

    if (checkValues != null) {
        checkValues.parentNode.removeChild(checkValues);
    }
    if (checkLibraries != null) {
        checkLibraries.parentNode.removeChild(checkLibraries);
        checkVariables.parentNode.removeChild(checkVariables);
        checkSetup.parentNode.removeChild(checkSetup);
        checkLoop.parentNode.removeChild(checkLoop);
        checkDescription.parentNode.removeChild(checkDescription);
    }

    if (checkSelectValue == 'Sensor' || checkSelectValue == 'Actuator') {
        setSensorOrActuator(ul);
        setOtherThanArduino(ul);
    } else if (checkSelectValue == 'Wifi') {
        setOtherThanArduino(ul);
    }

    // if (checkSelectValue != 'Empty' && checkSelectValue != 'Arduino' && checkLibraries == null) {
    //     setOtherThanArduino(ul);
    // } else if ((checkSelectValue == 'Empty' || checkSelectValue == 'Arduino') && checkLibraries != null) {
    //     checkLibraries.parentNode.removeChild(checkLibraries);
    //     checkVariables.parentNode.removeChild(checkVariables);
    //     checkSetup.parentNode.removeChild(checkSetup);
    //     checkLoop.parentNode.removeChild(checkLoop);
    //     checkDescription.parentNode.removeChild(checkDescription);
    // }

    var submitButton = document.getElementById('devSubmit');
    if (checkSelectValue == 'Empty') {
        submitButton.setAttribute('disabled', '');
    } else {
        submitButton.removeAttribute('disabled');
    }
}

function setSensorOrActuator(ul) {
    var listItem = document.createElement('li');
    var br = document.createElement('br');
    var valueTitle = document.createElement('input');
    var valueOne = document.createElement('input');
    var selectOrTo = document.createElement('select');
    var optionOr = document.createElement('option');
    var optionTo = document.createElement('option');
    var valueTwo = document.createElement('input');

    listItem.setAttribute('id', 'valuesItem');

    valueTitle.setAttribute('type', 'text');
    valueTitle.setAttribute('name', 'valueTitle');
    valueTitle.setAttribute('id', 'valueTitle');
    valueTitle.setAttribute('placeholder', 'Value title');
    valueTitle.setAttribute('maxlength', '20');
    valueTitle.setAttribute('style', 'width: 12em; font-family: "Courier New";')

    valueOne.setAttribute('type', 'text');
    valueOne.setAttribute('name', 'valueOne');
    valueOne.setAttribute('id', 'valueOne');
    valueOne.setAttribute('placeholder', 'value 1');
    valueOne.setAttribute('maxlength', '10');
    valueOne.setAttribute('style', 'width: 6em; font-family: "Courier New";')

    selectOrTo.setAttribute('name', 'selectOrTo');
    selectOrTo.setAttribute('id', 'selectOrTo');
    selectOrTo.setAttribute('style', 'width: max-content; font-family: "Courier New";')
    optionOr.setAttribute('value', 'or');
    optionOr.setAttribute('id', 'optionOr');
    optionOr.text = 'or';
    optionTo.setAttribute('value', 'to');
    optionTo.setAttribute('id', 'optionTo');
    optionTo.text = 'to';

    valueTwo.setAttribute('type', 'text');
    valueTwo.setAttribute('name', 'valueTwo');
    valueTwo.setAttribute('id', 'valueTwo');
    valueTwo.setAttribute('placeholder', 'value 2');
    valueTwo.setAttribute('maxlength', '10');
    valueTwo.setAttribute('style', 'width: 6em; font-family: "Courier New";')

    selectOrTo.appendChild(optionOr);
    selectOrTo.appendChild(optionTo);
    listItem.appendChild(document.createTextNode('Values to work with*:'));
    listItem.appendChild(br);
    listItem.appendChild(valueTitle);
    listItem.appendChild(document.createTextNode(' = { '));
    listItem.appendChild(valueOne);
    listItem.appendChild(document.createTextNode(' '));
    listItem.appendChild(selectOrTo);
    listItem.appendChild(document.createTextNode(' '));
    listItem.appendChild(valueTwo);
    listItem.appendChild(document.createTextNode(' }'));
    ul.appendChild(listItem);
}

function setOtherThanArduino(ul) {
    var itemsList = ['libraryItem', 'variableItem', 'setupItem', 'loopItem', 'descriptionItem'];
    var textareasList = ['libraryCode', 'variableCode', 'setupCode', 'loopCode', 'descriptionText'];
    var titles = ['Library', 'Variable', 'Setup', 'Loop', 'Description'];
    var titleEnding = ' code for this device';

    for (var i = 0; i < itemsList.length; i++) {
        var li = document.createElement('li');
        var textarea = document.createElement('textarea');
        var br = document.createElement('br');

        textarea.setAttribute('id', textareasList[i]);
        textarea.setAttribute('name', textareasList[i]);
        textarea.setAttribute('rows', '3');
        textarea.setAttribute('cols', '55');

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
}