<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    $arduinoData = get_devices("Arduino");
    $wifiData = get_devices("Wifi");
    $sensorData = get_devices("Sensor");
    $actuatorData = get_devices("Actuator");

    if (isset($_REQUEST['configSubmit']) === true && empty($_REQUEST['configSubmit']) === false) {
        if ($_REQUEST['configSubmit']=="Save and Generate") {
            $configurationData = array(
                'title' => $_POST['config-name'],
                'ssid' => $_POST['wifi-ssid'],
                'pass' => $_POST['wifi-pass'],
                'user_id' => $user_data['ID'],
                'sensor_id' => $_POST['sensor-device'],
                'sensor_condition' => $_POST['condition-device'],
                'sensor_value' => $_POST['input-value'],
                'actuator_id' => $_POST['actuator-device'],
                'actuator_value_if' => $_POST['if-output-value'],
                'actuator_value_else' => $_POST['else-output-value']
            );
            $table = '`configurations`';
            $inserted_id = insert_data($configurationData, $table);
            if ($inserted_id != 0) {
                header('Location: new_config.php?success');
            }
            exit();
        } else if($_REQUEST['configSubmit']=="Cancel") {
            header('Location: index.php');
            exit();
        }
    }

    if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
        echo '<p class="successful-action">Configurations has been added!</p>';
    }
    ?>

<h1>New Configuration</h1>
<section>
    <form action="" method="post" enctype="multipart/form-data">
        <div style="width: 600px;">
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
                        <select name="sensor-device" id="sensor-device" onchange="selectsensorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            foreach ($sensorData as &$value) {
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
                    </li>
                    <li>
                        Actuator:<br/>
                        <select name="actuator-device" id="actuator-device" onchange="selectactuatorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            foreach ($actuatorData as &$value) {
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
            <input type="submit" name="configSubmit" value="Save and Generate">
            <input type="submit" name="configSubmit" value="Cancel">
        </div>
    </form>
</section>

<?php
}

include 'includes/overall/footer.php';
?>