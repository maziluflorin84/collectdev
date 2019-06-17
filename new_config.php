<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    $arduinoData = get_device("Arduino");
    $wifiData = get_device("Wifi");
    $sensorData = get_device("Sensor");
    $actuatorData = get_device("Actuator");
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
            <fieldset class="newConfigFieldset">
                <legend>Select devices</legend>
                <ul>
                    <li>
                        Arduino:<br/>
                        <select name="arduinoDevice" id="arduinoDevice" onchange="selectArduinoDevice()">
                            <option value="empty"></option>
                            <?php
                            foreach ($arduinoData as &$value) {
                                echo "<option value=\"" . $value["name"] . "\" id=\"Arduino_" . $value["ID"] . "\">" . $value["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        Wifi:<br/>
                        <select name="wifiDevice" id="wifiDevice" onchange="selectWifiDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            foreach ($wifiData as &$value) {
                                echo "<option value=\"" . $value["name"] . "\" id=\"Wifi_" . $value["ID"] . "\">" . $value["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        Sensor:<br/>
                        <select name="sensorDevice" id="sensorDevice" onchange="selectsensorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            foreach ($sensorData as &$value) {
                                echo "<option value=\"" . $value["name"] . "\" id=\"Sensor_" . $value["ID"] . "\">" . $value["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        Actuator:<br/>
                        <select name="actuatorDevice" id="actuatorDevice" onchange="selectactuatorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            foreach ($actuatorData as &$value) {
                                echo "<option value=\"" . $value["name"] . "\" id=\"Actuator_" . $value["ID"] . "\">" . $value["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </li>
                </ul>
            </fieldset>
            <fieldset class="newConfigFieldset">
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