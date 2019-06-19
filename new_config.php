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
                <legend>Configuration Info</legend>
                <ul id="info" class="config-info-form">
                    <li>
                        Configuration name:<br/>
                        <input type="text" name="config-name" id="config-name">
                    </li>
                </ul>
            </fieldset>
            <fieldset class="newConfigFieldset">
                <legend>WiFi connection</legend>
                <ul id="wifi" class="config-info-form">
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
                                echo "<option value=\"".$value["name"]."\" ";
                                        echo "id=\"Sensor_".$value["ID"]."\" ";
                                        echo "value-one=\"".$value["value_one"]."\" ";
                                        echo "value-or-to=\"".$value["value_or_to"]."\" ";
                                        echo "value-two=\"".$value["value_two"]."\"> ";
                                    echo $value["name"];
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        Actuator:<br/>
                        <select name="actuator-device" id="actuator-device" onchange="selectactuatorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            foreach ($actuatorData as &$value) {
                                echo "<option value=\"".$value["name"]."\" ";
                                        echo "id=\"Sensor_".$value["ID"]."\" ";
                                        echo "value-one=\"".$value["value_one"]."\" ";
                                        echo "value-or-to=\"".$value["value_or_to"]."\" ";
                                        echo "value-two=\"".$value["value_two"]."\"> ";
                                    echo $value["name"];
                                echo "</option>";
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
                        <div class="rTableCell" align="left">if</div>
                        <div class="rTableCell" id="if-sensor-id"></div>
                        <div class="rTableCell" id="if-condition"></div>
                        <div class="rTableCell" id="if-input-field"></div>
                        <div class="rTableCell">then </div>
                        <div class="rTableCell" id="if-actuator-id"></div>
                        <div class="rTableCell" id="if-output-field"></div>
                    </div>
                    <div class="rTableRow" align="center">
                        <div class="rTableCell" align="left">else</div>
                        <div class="rTableCell" id="else-sensor-id"></div>
                        <div class="rTableCell"></div>
                        <div class="rTableCell" id="else-input-field"></div>
                        <div class="rTableCell"></div>
                        <div class="rTableCell" id="else-actuator-id"></div>
                        <div class="rTableCell" id="else-output-field"></div>
                    </div>
                    <div class="rTableRow" align="center">
                        <div class="rTableCell" align="left">endif</div>
                        <div class="rTableCell" id="endif-sensor-id"></div>
                        <div class="rTableCell"></div>
                        <div class="rTableCell" id="endif-input-field"></div>
                        <div class="rTableCell"></div>
                        <div class="rTableCell" id="endif-actuator-id"></div>
                        <div class="rTableCell" id="endif-output-field"></div>
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