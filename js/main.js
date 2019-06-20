function copyToClipboard(element) {
    var text = $(element).clone().find('br').prepend('\r\n').end().text()
    element = $('<textarea>').appendTo('body').val(text).select()
    document.execCommand('copy')
    element.remove()
}

function newConfiguration() {
    window.location = 'new_config.php';
}

function editConfiguration() {
    window.location = 'edit_config.php';
}

function selectArduinoDevice() {
    var arduinoDeviceSelector = document.getElementById('arduinoDevice');
    var wifiDeviceSelector = document.getElementById('wifiDevice');
    var sensorDeviceSelector = document.getElementById('sensor-device');
    var actuatorDeviceSelector = document.getElementById('actuator-device');

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
    var sensorDeviceSelector = document.getElementById('sensor-device');
    var actuatorDeviceSelector = document.getElementById('actuator-device');

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
    var sensorDeviceSelector = document.getElementById('sensor-device');
    var sensorId = document.getElementById('if-sensor-id');
    var inputField = document.getElementById('if-input-field');
    var ifCondition = document.getElementById('if-condition');

    while (sensorId.firstChild) {
        sensorId.removeChild(sensorId.firstChild);
    }

    while (inputField.firstChild) {
        inputField.removeChild(inputField.firstChild);
    }

    while (ifCondition.firstChild) {
        ifCondition.removeChild(ifCondition.firstChild);
    }

    if (sensorDeviceSelector.value != 'empty') {
        var sensorSpan = document.createElement('span');
        sensorSpan.setAttribute('id', 'sensor-name');
        sensorSpan.appendChild(document.createTextNode(sensorDeviceSelector.options[sensorDeviceSelector.selectedIndex].getAttribute('value-name')));
        sensorId.appendChild(sensorSpan);

        var optionEmpty = document.createElement('option');
        optionEmpty.setAttribute('value', 'empty');
        optionEmpty.appendChild(document.createTextNode(''));
        var optionEqual = document.createElement('option');
        optionEqual.setAttribute('value', 'equal');
        optionEqual.appendChild(document.createTextNode('=='));
        var optionDifferent = document.createElement('option');
        optionDifferent.setAttribute('value', 'different');
        optionDifferent.appendChild(document.createTextNode('!='));
        var optionGreater = document.createElement('option');
        optionGreater.setAttribute('value', 'greater');
        optionGreater.appendChild(document.createTextNode('>'));
        var optionGreaterOrEqual = document.createElement('option');
        optionGreaterOrEqual.setAttribute('value', 'greaterOrEqual');
        optionGreaterOrEqual.appendChild(document.createTextNode('>='));
        var optionLess = document.createElement('option');
        optionLess.setAttribute('value', 'less');
        optionLess.appendChild(document.createTextNode('<'));
        var optionLessOrEqual = document.createElement('option');
        optionLessOrEqual.setAttribute('value', 'lessOrEqual');
        optionLessOrEqual.appendChild(document.createTextNode('<='));
        var selectCondition = document.createElement('select');
        selectCondition.setAttribute('id', 'condition-device');
        selectCondition.setAttribute('name', 'condition-device');
        selectCondition.setAttribute('style', 'width: max-content;');
        selectCondition.appendChild(optionEmpty);
        selectCondition.appendChild(optionEqual);
        selectCondition.appendChild(optionDifferent);
        selectCondition.appendChild(optionGreater);
        selectCondition.appendChild(optionGreaterOrEqual);
        selectCondition.appendChild(optionLess);
        selectCondition.appendChild(optionLessOrEqual);
        ifCondition.appendChild(selectCondition);

        var valueOne = sensorDeviceSelector.options[sensorDeviceSelector.selectedIndex].getAttribute('value-one');
        var valueOrTo = sensorDeviceSelector.options[sensorDeviceSelector.selectedIndex].getAttribute('value-or-to');
        var valueTwo = sensorDeviceSelector.options[sensorDeviceSelector.selectedIndex].getAttribute('value-two');
        var inputSpan = document.createElement('span');
        inputSpan.setAttribute('id', 'span-input-value');
        if (valueOrTo == 'or') {
            var optionOne = document.createElement('option');
            optionOne.setAttribute('value', valueOne)
            optionOne.appendChild(document.createTextNode(valueOne));

            var optionTwo = document.createElement('option');
            optionTwo.setAttribute('value', valueTwo)
            optionTwo.appendChild(document.createTextNode(valueTwo));

            var inputValue = document.createElement('select');
            inputValue.setAttribute('id', 'input-value');
            inputValue.setAttribute('name', 'input-value');
            inputValue.setAttribute('style', 'width: max-content;');
            inputValue.appendChild(optionOne);
            inputValue.appendChild(optionTwo);

            inputSpan.appendChild(inputValue);
        } else if (valueOrTo == 'to') {
            var inputValue = document.createElement('input');
            inputValue.setAttribute('type', 'number');
            inputValue.setAttribute('id', 'input-value');
            inputValue.setAttribute('name', 'input-value');
            inputValue.setAttribute('size', 3);
            inputValue.setAttribute('value', parseInt(valueOne, 10));
            inputValue.setAttribute('min', parseInt(valueOne, 10));
            inputValue.setAttribute('max', parseInt(valueTwo, 10));
            inputSpan.appendChild(inputValue);
        } else {
            var inputValue = document.createElement('input');
            inputValue.setAttribute('type', 'text');
            inputValue.setAttribute('id', 'input-value');
            inputValue.setAttribute('name', 'input-value');
            inputValue.setAttribute('size', 3);
            inputSpan.appendChild(inputValue);
        }
        inputField.appendChild(inputSpan);
    }
}

function selectactuatorDevice() {
    var actuatorDeviceSelector = document.getElementById('actuator-device');
    var ifActuatorId = document.getElementById('if-actuator-id');
    var elseActuatorId = document.getElementById('else-actuator-id');
    var ifOutputField = document.getElementById('if-output-field');
    var elseOutputField = document.getElementById('else-output-field');

    while (ifActuatorId.firstChild) {
        ifActuatorId.removeChild(ifActuatorId.firstChild);
    }

    while (elseActuatorId.firstChild) {
        elseActuatorId.removeChild(elseActuatorId.firstChild);
    }

    while (ifOutputField.firstChild) {
        ifOutputField.removeChild(ifOutputField.firstChild);
    }

    while (elseOutputField.firstChild) {
        elseOutputField.removeChild(elseOutputField.firstChild);
    }

    if (actuatorDeviceSelector.value != 'empty') {
        var ifActuatorSpan = document.createElement('span');
        ifActuatorSpan.setAttribute('id', 'if-actuator-name');
        ifActuatorSpan.appendChild(document.createTextNode(actuatorDeviceSelector.options[actuatorDeviceSelector.selectedIndex].getAttribute('value-name')));
        ifActuatorId.appendChild(ifActuatorSpan);

        var elseActuatorSpan = document.createElement('span');
        elseActuatorSpan.setAttribute('id', 'else-actuator-name');
        elseActuatorSpan.appendChild(document.createTextNode(actuatorDeviceSelector.options[actuatorDeviceSelector.selectedIndex].getAttribute('value-name')));
        elseActuatorId.appendChild(elseActuatorSpan);

        var valueOne = actuatorDeviceSelector.options[actuatorDeviceSelector.selectedIndex].getAttribute('value-one');
        var valueOrTo = actuatorDeviceSelector.options[actuatorDeviceSelector.selectedIndex].getAttribute('value-or-to');
        var valueTwo = actuatorDeviceSelector.options[actuatorDeviceSelector.selectedIndex].getAttribute('value-two');
        var ifOutputSpan = document.createElement('span');
        ifOutputSpan.setAttribute('id', 'if-span-output-value');
        var elseOutputSpan = document.createElement('span');
        elseOutputSpan.setAttribute('id', 'else-span-output-value');
        if (valueOrTo == 'or') {
            var ifOptionOne = document.createElement('option');
            ifOptionOne.setAttribute('value', valueOne)
            ifOptionOne.appendChild(document.createTextNode(valueOne));

            var elseOptionOne = document.createElement('option');
            elseOptionOne.setAttribute('value', valueOne)
            elseOptionOne.appendChild(document.createTextNode(valueOne));

            var ifOptionTwo = document.createElement('option');
            ifOptionTwo.setAttribute('value', valueTwo)
            ifOptionTwo.appendChild(document.createTextNode(valueTwo));

            var elseOptionTwo = document.createElement('option');
            elseOptionTwo.setAttribute('value', valueTwo)
            elseOptionTwo.appendChild(document.createTextNode(valueTwo));

            var ifOutputValue = document.createElement('select');
            ifOutputValue.setAttribute('id', 'if-output-value');
            ifOutputValue.setAttribute('name', 'if-output-value');
            ifOutputValue.setAttribute('style', 'width: max-content;');
            ifOutputValue.appendChild(ifOptionOne);
            ifOutputValue.appendChild(ifOptionTwo);

            var elseOutputValue = document.createElement('select');
            elseOutputValue.setAttribute('id', 'else-output-value');
            elseOutputValue.setAttribute('name', 'else-output-value');
            elseOutputValue.setAttribute('style', 'width: max-content;');
            elseOutputValue.appendChild(elseOptionOne);
            elseOutputValue.appendChild(elseOptionTwo);

            ifOutputSpan.appendChild(ifOutputValue);

            elseOutputSpan.appendChild(elseOutputValue);
        } else if (valueOrTo == 'to') {
            var ifOutputValue = document.createElement('input');
            ifOutputValue.setAttribute('type', 'number');
            ifOutputValue.setAttribute('id', 'if-output-value');
            ifOutputValue.setAttribute('name', 'if-output-value');
            ifOutputValue.setAttribute('size', 3);
            ifOutputValue.setAttribute('value', parseInt(valueOne, 10));
            ifOutputValue.setAttribute('min', parseInt(valueOne, 10));
            ifOutputValue.setAttribute('max', parseInt(valueTwo, 10));
            ifOutputSpan.appendChild(ifOutputValue);

            var elseOutputValue = document.createElement('input');
            elseOutputValue.setAttribute('type', 'number');
            elseOutputValue.setAttribute('id', 'else-output-value');
            elseOutputValue.setAttribute('name', 'else-output-value');
            elseOutputValue.setAttribute('size', 3);
            elseOutputValue.setAttribute('value', parseInt(valueOne, 10));
            elseOutputValue.setAttribute('min', parseInt(valueOne, 10));
            elseOutputValue.setAttribute('max', parseInt(valueTwo, 10));
            elseOutputSpan.appendChild(elseOutputValue);
        } else {
            var ifOutputValue = document.createElement('input');
            ifOutputValue.setAttribute('type', 'text');
            ifOutputValue.setAttribute('id', 'if-output-value');
            ifOutputValue.setAttribute('name', 'if-output-value');
            ifOutputValue.setAttribute('size', 3);
            ifOutputSpan.appendChild(ifOutputValue);

            var elseOutputValue = document.createElement('input');
            elseOutputValue.setAttribute('type', 'text');
            elseOutputValue.setAttribute('id', 'else-output-value');
            elseOutputValue.setAttribute('name', 'else-output-value');
            elseOutputValue.setAttribute('size', 3);
            elseOutputSpan.appendChild(elseOutputValue);
        }
        ifOutputField.appendChild(ifOutputSpan);

        elseOutputField.appendChild(elseOutputSpan);
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