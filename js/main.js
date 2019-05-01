function copyToClipboard(element) {
    var text = $(element).clone().find('br').prepend('\r\n').end().text()
    element = $('<textarea>').appendTo('body').val(text).select()
    document.execCommand('copy')
    element.remove()
}

function newConfiguration() {
    window.location = 'new_config.php';
}

function selectTypeFunction() {
    var checkLibraries = document.getElementById("libraryItem");
    var checkVariables = document.getElementById("variableItem");
    var checkSetup = document.getElementById("setupItem");
    var checkLoop = document.getElementById("loopItem");
    var checkSelectValue = document.getElementById("devType").value;            
    if (checkSelectValue != "Empty" && checkSelectValue != "Arduino" && checkLibraries == null) {
        var ul = document.getElementById("formListId");
        var itemsList = ['libraryItem', 'variableItem', 'setupItem', 'loopItem'];
        var textareasList = ['libraryCode', 'variableCode', 'setupCode', 'loopCode'];
        var titles = ['Library', 'Variable', 'Setup', 'Loop'];
        var titleEnding = " code for this device";

        for (var i = 0; i < itemsList.length; i++) {
            var li = document.createElement("li");
            var textarea = document.createElement("textarea");
            var br = document.createElement("br");

            textarea.setAttribute('id', textareasList[i]);
            textarea.setAttribute('name', textareasList[i]);
            textarea.setAttribute('rows', "5");
            textarea.setAttribute('cols', "50");

            li.setAttribute('id', itemsList[i]);
            li.appendChild(document.createTextNode(titles[i].concat(titleEnding)));
            li.appendChild(br);
            li.appendChild(textarea);
            ul.appendChild(li);
        }
    } else if ((checkSelectValue == "Empty" || checkSelectValue == "Arduino") && checkLibraries != null) {
        checkLibraries.parentNode.removeChild(checkLibraries);
        checkVariables.parentNode.removeChild(checkVariables);
        checkSetup.parentNode.removeChild(checkSetup);
        checkLoop.parentNode.removeChild(checkLoop);
    }

    var submitButton = document.getElementById("devSubmit");
    if (checkSelectValue == "Empty") {
        submitButton.setAttribute("disabled", "");
    } else {
        submitButton.removeAttribute("disabled");
    }
}