<?php
include 'main_functions/init.php';
protect_page();
protect_admin_page((int) $user_data['admin']);
include 'includes/overall/header.php';

if (empty($_POST) === false) {
    $required_fields = array('devName', 'devtype');
    foreach ($_POST as $key=>$value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }
    }
}
?>

    <script type="text/javascript">
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
    </script>

<h1>Add device</h1>

<?php
    if (empty($_POST) === false && empty($errors) === true) {
        $device_data = array(
            'name' => $_POST['devName'],
            'type' => $_POST['devType'],
//             'image' => $_POST['image']
        );
        $inserted_id = insert_device($device_data);
        if ($inserted_id != 0) {
            $template_paths = "device_templates/";
            create_device_code("libraryCode", $template_paths, $inserted_id);
            create_device_code("variableCode", $template_paths, $inserted_id);
            create_device_code("setupCode", $template_paths, $inserted_id);
            create_device_code("loopCode", $template_paths, $inserted_id);

            header('Location: add_device.php?success');
        }
        exit();
    }
    
    if (empty($errors) === false) {
        echo output_errors($errors);
    } else  if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
        echo '<p style="color: #008800; margin-top: 1em;">Device has been added!</p>';
    }
?>

<section>
    <form action="" method="post">
        <ul id="formListId">
            <li>Device type*:<br> <select id="devType"
                onchange="selectTypeFunction()" name="devType">
                    <!-- whatToInsertIfDeviceType(this, this.id) -->
                    <option value="Empty"></option>
                    <option value="Arduino">Arduino</option>
                    <option value="Wifi">Wifi Module</option>
                    <option value="Sensor">Sensor</option>
                    <option value="Actuator">Actuator</option>
            </select>
            </li>
            <li>Device name*:<br> <input type="text" name="devName">
            </li>
        </ul>
        <button type="submit" id="devSubmit" name="submit"
            disabled="disabled">Submit</button>
    </form>
    * required
</section>

<?php include 'includes/overall/footer.php'; ?>