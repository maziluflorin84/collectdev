<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    ?>

<h1>New Configuration</h1>
<section>
    <form name="newConfigurationForm">
        <div style="width: 600px;">
            <fieldset class="newConfigFieldset">
                <legend>WiFi connection</legend>
                <ul id="wifi" class="wifiForm">
                    <li>
                        SSID:<br/>
                        <input type="text" name="wifiSSID" id="wifiSSID">
                    </li>
                    <li>
                        Pass:<br/>
                        <input type="text" name="wifiPass" id="wifiPass">
                    </li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Select devices</legend>
                <ul>
                    <li>
                        Sensor:<br/>
                        <select name="inputDevice" id="inputDevice" onchange="selectInputDevice()">
                            <option value="empty"></option>
                            <option value="sensor1">Sensor 1</option>
                            <option value="sensor22">Sensor 2</option>
                            <option value="sensor333">Sensor 3</option>
                        </select>
                    </li>
                    <li>
                        Actuator:<br/>
                        <select name="outputDevice" id="outputDevice" onchange="selectOutputDevice()">
                            <option value="empty"></option>
                            <option value="actuator1">Actuator 1</option>
                            <option value="actuator22">Actuator 2</option>
                            <option value="actuator333">Actuator 3</option>
                        </select>
                    </li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Configuration setup</legend>
                <div class="rTable">
                    <div class="rTableRow" align="center">
                        <div class="rTableHead"></div>
                        <div class="rTableHead">Input</div>
                        <div class="rTableHead">Condition</div>
                        <div class="rTableHead">Input Value</div>
                        <div class="rTableHead"></div>
                        <div class="rTableHead">Output</div>
                        <div class="rTableHead">Output Value</div>
                    </div>
                    <div class="rTableRow" align="center">
                        <div class="rTableCell">If</div>
                        <div class="rTableCell" id="sensorId"></div>
                        <div class="rTableCell">
                            <select name="conditionDevice" id="conditionDevice">
                                <option value="empty"></option>
                                <option value="equal">==</option>
                                <option value="different">!=</option>
                                <option value="greater">></option>
                                <option value="greaterOrEqual">>=</option>
                                <option value="less"><</option>
                                <option value="lessOrEqual"><=</option>
                            </select>
                        </div>
                        <div class="rTableCell">
                            <input type="text" name="condValue" id="condValue" size="3">
                        </div>
                        <div class="rTableCell">then </div>
                        <div class="rTableCell" id="actuatorId"></div>
                        <div class="rTableCell">
                            <input type="text" name="outputValue" id="outputValue" size="3">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</section>
<section>
    <button>Generate code</button>
</section>

<?php
}

include 'includes/overall/footer.php';
?>