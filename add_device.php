<?php
include 'main_functions/init.php';
protect_page();
protect_admin_page((int)$user_data['admin']);
include 'includes/overall/header.php';
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
                var titles = ['library', 'variable', 'setup', 'loop'];
                var titleEnding = " code for this device";


                for (var i = 0; i < itemsList.length; i++) {
                    var li = document.createElement("li");
                    var textarea = document.createElement("textarea");
                    var br = document.createElement("br");

                    textarea.setAttribute('id', textareasList[i]);
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
	<section>
		<form action="" method="post">
			<ul id="formListId">
				<li>
					Device type<br>
					<select id="devType" onchange="selectTypeFunction()"> <!-- whatToInsertIfDeviceType(this, this.id) -->
            			<option value="Empty"></option>
            			<option value="Arduino">Arduino</option>
                        <option value="Wifi">Wifi Module</option>
            			<option value="Sensor">Sensor</option>
            			<option value="Actuator">Actuator</option>
            		</select>
				</li>
                <li>
                    Device name<br>
                    <input type="text" name="devName">
                </li>
			</ul>
            <button type="submit" id="devSubmit" name="submit" disabled="disabled">Submit</button>
		</form>
	</section>
    
<?php include 'includes/overall/footer.php'; ?>