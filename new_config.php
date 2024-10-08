<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    $arduinosData = get_devices("Arduino");
    $wifisData = get_devices("Wifi");
    $sensorsData = get_devices("Sensor");
    $actuatorsData = get_devices("Actuator");

    $inserted_id = 0;

    if (isset($_REQUEST['configSubmit']) === true && empty($_REQUEST['configSubmit']) === false) {
        if ($_REQUEST['configSubmit']=="Save") {
            $configurationData = array(
                'title' => $_POST['config-name'],
                'ssid' => $_POST['wifi-ssid'],
                'pass' => $_POST['wifi-pass'],
                'user_id' => $user_data['ID'],
                'arduino_id' => $_POST['arduino-device'],
                'wifi_id' => $_POST['wifi-device'],
                'sensor_id' => $_POST['sensor-device'],
                'sensor_condition' => $_POST['condition-device'],
                'sensor_value' => $_POST['input-value'],
                'actuator_id' => $_POST['actuator-device'],
                'actuator_value_if' => $_POST['if-output-value'],
                'actuator_value_else' => $_POST['else-output-value']
            );
            $table = '`configurations`';
            $inserted_id = insert_data($configurationData, $table);
            // if ($inserted_id != 0) {
            //     header('Location: new_config.php?success');
            //     exit();
            // }
        } else if($_REQUEST['configSubmit']=="Cancel") {
            header('Location: my_configs.php');
            exit();
        }
    }
    ?>

<h1>New Configuration</h1>

<?php
if ($inserted_id != 0) {
    $configuration = get_configuration($inserted_id);
    $wifiData = get_device($configuration['wifi_id']);
    $sensorData = get_device($configuration['sensor_id']);
    $actuatorData = get_device($configuration['actuator_id']);
?>
<p class="successful-action">Configuration has been added!</p>
<p class="successful-action">You must upload this code to Arduino IDE!</p>
<section>
    <div>
        <pre>
            <code id="configuration" class="arduino">
<?php
print_code($wifiData['library_code'], "");
print_code($sensorData['library_code'], "");
print_code($actuatorData['library_code'], "");
echo "<br>";

echo "int configurationID = ".$configuration['ID'].";<br>";
echo "String ssid = \"".$configuration['ssid']."\";<br>";
echo "String pass = \"".$configuration['pass']."\";<br>";
echo "String server = \"".getHostByName(getHostName())."\";<br>";
print_code($wifiData['variable_code'], "");
print_code($sensorData['variable_code'], "");
print_code($actuatorData['variable_code'], "");
echo "<br>";

echo "void setup() {<br>";
print_code($wifiData['setup_code'], "    ");
print_code($sensorData['setup_code'], "    ");
print_code($actuatorData['setup_code'], "    ");
echo "}<br>";

echo "void loop() {<br>";
print_code($actuatorData['loop_code'], "    ");    
print_code($wifiData['loop_code'], "    ");
print_code($sensorData['loop_code'], "    ");
echo "}<br>";
?>
            </code>
        </pre>
        <a href="#copy-text" onclick="copyToClipboard('#configuration')" id="copy-text">Copy code</a><br><br>
    </div>
    <form action="my_configs.php">
        <input type="submit" name="config-back" value="Back">
    </form>
</section>
<?php
} else {
?>
<section>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <fieldset class="config-fieldset">
                <legend>Configuration Info</legend>
                <ul id="info" class="config-info-form">
                    <li>
                        Configuration name:<br/>
                        <input type="text" name="config-name" id="config-name">
                    </li>
                </ul>
            </fieldset>
            <fieldset class="config-fieldset">
                <legend>WiFi connection</legend>
                <ul id="wifi" class="config-info-form">
                    <li>
                        SSID:<br/>
                        <input type="text" name="wifi-ssid" id="wifi-ssid">
                    </li>
                    <li>
                        Pass:<br/>
                        <input type="text" name="wifi-pass" id="wifi-pass">
                    </li>
                </ul>
            </fieldset>
            <fieldset class="config-fieldset">
                <legend>Select devices</legend>
                <ul>
                    <li>
                        Arduino:<br>
                        <div class="rTable">
                            <div class="rTableRow" align="center">
                                <div class="rTableCellDevice" align="left">
                                    <select name="arduino-device" id="arduino-device" onchange="selectArduinoDevice()">
                                        <option value="empty"></option>
                                        <?php
                                        foreach ($arduinosData as &$value) {
                                            echo "<option value=\"".$value["ID"]."\" ";
                                                    echo "id=\"Arduino_".$value["ID"]."\" ";
                                                    echo "value-name=\"".$value["name"]."\">";
                                                echo $value["name"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="rTableCellDevice" align="left">
                                    <img src="images/arduino.png" height="50px">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        Wifi:<br>
                        <div class="rTable">
                            <div class="rTableRow" align="center">
                                <div class="rTableCellDevice" align="left">
                                    <select name="wifi-device" id="wifi-device" onchange="selectWifiDevice()" disabled>
                                        <option value="empty"></option>
                                        <?php
                                        foreach ($wifisData as &$value) {
                                            echo "<option value=\"".$value["ID"]."\" ";
                                                    echo "id=\"Wifi_".$value["ID"]."\" ";
                                                    echo "value-name=\"".$value["name"]."\">";
                                                echo $value["name"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="rTableCellDevice" align="left">
                                    <img src="images/wifi.png" height="50px">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        Sensor:<br>
                        <div class="rTable">
                            <div class="rTableRow" align="center">
                                <div class="rTableCellDevice" align="left">
                                    <select name="sensor-device" id="sensor-device" onchange="selectSensorDevice()" disabled>
                                        <option value="empty"></option>
                                        <?php
                                        foreach ($sensorsData as &$value) {
                                            echo "<option value=\"".$value["ID"]."\" ";
                                                    echo "id=\"Sensor_".$value["ID"]."\" ";
                                                    echo "value-name=\"".$value["name"]."\"";
                                                    echo "value-one=\"".$value["value_one"]."\" ";
                                                    echo "value-or-to=\"".$value["value_or_to"]."\" ";
                                                    echo "value-two=\"".$value["value_two"]."\"> ";
                                                echo $value["name"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="rTableCellDevice" align="left">
                                    <img src="images/sensor.png" height="50px">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        Actuator:<br>
                        <div class="rTable">
                            <div class="rTableRow" align="center">
                                <div class="rTableCellDevice" align="left">
                                    <select name="actuator-device" id="actuator-device" onchange="selectactuatorDevice()" disabled>
                                        <option value="empty"></option>
                                        <?php
                                        foreach ($actuatorsData as &$value) {
                                            echo "<option value=\"".$value["ID"]."\" ";
                                                    echo "id=\"Sensor_".$value["ID"]."\" ";
                                                    echo "value-name=\"".$value["name"]."\"";
                                                    echo "value-one=\"".$value["value_one"]."\" ";
                                                    echo "value-or-to=\"".$value["value_or_to"]."\" ";
                                                    echo "value-two=\"".$value["value_two"]."\"> ";
                                                echo $value["name"];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="rTableCellDevice" align="left">
                                    <img src="images/actuator.png" height="50px">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </fieldset>
            <fieldset class="config-fieldset">
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
            <input type="submit" name="configSubmit" value="Save">
            <input type="submit" name="configSubmit" value="Cancel">
        </div>
    </form>
</section>
<?php
}
}

include 'includes/overall/footer.php';
?>