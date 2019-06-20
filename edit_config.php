<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    // if (empty($_POST) === false) {
    //     if (delete_config($_POST['config'])) {
    //         header('Location: index.php?success');
    //     }
    //     exit();
    // }
    // if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
    //     echo '<p class="successful-action">Configurations has been deleted!</p>';
    // }
    if (empty($_POST) === true) {
        header('Location: index.php?failed');
    }

    $configuration = get_configuration($_POST['config']);
    $sensorData = get_device($configuration['sensor_id']);
    $actuatorData = get_device($configuration['actuator_id']);

    // if (empty($_POST) === false) {
    //     $configurationData = array(
    //         'title' => $_POST['config-name'],
    //         'ssid' => $_POST['wifi-ssid'],
    //         'pass' => $_POST['wifi-pass'],
    //         'user_id' => $user_data['ID'],
    //         'sensor_id' => $_POST['sensor-device'],
    //         'sensor_condition' => $_POST['condition-device'],
    //         'sensor_value' => $_POST['input-value'],
    //         'actuator_id' => $_POST['actuator-device'],
    //         'actuator_value_if' => $_POST['if-output-value'],
    //         'actuator_value_else' => $_POST['else-output-value']
    //     );
    //     $table = '`configurations`';
    //     $inserted_id = insert_data($configurationData, $table);
    //     if ($inserted_id != 0) {
    //         header('Location: new_config.php?success');
    //     }
    //     exit();
    // }
    // if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
    //     echo '<p class="successful-action">Configurations has been added!</p>';
    // }
    ?>

<h1>Edit Configuration</h1>
<section>
    <form action="" method="post" enctype="multipart/form-data">
        <div style="width: 600px;">
            <fieldset class="config-fieldset">
                <legend>Configuration Info</legend>
                <ul id="info" class="config-info-form">
                    <li>
                        Configuration name:<br/>
                        <input type="text" name="config-name" id="config-name" value="<?php echo $configuration['title']; ?>" disabled>
                    </li>
                </ul>
            </fieldset>
            <fieldset class="config-fieldset">
                <legend>WiFi connection</legend>
                <ul id="wifi" class="config-info-form">
                    <li>
                        SSID:<br/>
                        <input type="text" name="wifi-ssid" id="wifi-ssid" value="<?php echo $configuration['ssid']; ?>">
                    </li>
                    <li>
                        Pass:<br/>
                        <input type="text" name="wifi-pass" id="wifi-pass" value="<?php echo $configuration['pass']; ?>">
                    </li>
                </ul>
            </fieldset>
            <!-- <fieldset class="config-fieldset">
                <legend>Select devices</legend>
                <ul>
                    <li>
                        Arduino:<br/>
                        <select name="arduinoDevice" id="arduinoDevice" onchange="selectArduinoDevice()">
                            <option value="empty"></option>
                            <?php
                            // foreach ($arduinoData as &$value) {
                            //     echo "<option value=\"" . $value["name"] . "\" id=\"Arduino_" . $value["ID"] . "\">" . $value["name"] . "</option>";
                            // }
                            ?>
                        </select>
                    </li>
                    <li>
                        Wifi:<br/>
                        <select name="wifiDevice" id="wifiDevice" onchange="selectWifiDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            // foreach ($wifiData as &$value) {
                            //     echo "<option value=\"" . $value["name"] . "\" id=\"Wifi_" . $value["ID"] . "\">" . $value["name"] . "</option>";
                            // }
                            ?>
                        </select>
                    </li>
                    <li>
                        Sensor:<br/>
                        <select name="sensor-device" id="sensor-device" onchange="selectsensorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            // foreach ($sensorData as &$value) {
                            //     echo "<option value=\"".$value["ID"]."\" ";
                            //             echo "id=\"Sensor_".$value["ID"]."\" ";
                            //             echo "value-name=\"".$value["name"]."\"";
                            //             echo "value-one=\"".$value["value_one"]."\" ";
                            //             echo "value-or-to=\"".$value["value_or_to"]."\" ";
                            //             echo "value-two=\"".$value["value_two"]."\"> ";
                            //         echo $value["name"];
                            //     echo "</option>";
                            // }
                            ?>
                        </select>
                    </li>
                    <li>
                        Actuator:<br/>
                        <select name="actuator-device" id="actuator-device" onchange="selectactuatorDevice()" disabled>
                            <option value="empty"></option>
                            <?php
                            // foreach ($actuatorData as &$value) {
                            //     echo "<option value=\"".$value["ID"]."\" ";
                            //             echo "id=\"Sensor_".$value["ID"]."\" ";
                            //             echo "value-name=\"".$value["name"]."\"";
                            //             echo "value-one=\"".$value["value_one"]."\" ";
                            //             echo "value-or-to=\"".$value["value_or_to"]."\" ";
                            //             echo "value-two=\"".$value["value_two"]."\"> ";
                            //         echo $value["name"];
                            //     echo "</option>";
                            // }
                            ?>
                        </select>
                    </li>
                </ul>
            </fieldset> -->
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
                        <div class="rTableCell" id="if-sensor-id">
                            <?=$sensorData['name'];?>
                        </div>
                        <div class="rTableCell" id="if-condition">
                            <select name="condition-device" id="condition-device" style="width: max-content;">
                                <option value="empty"<?=$configuration['sensor_condition'] == 'empty' ? ' selected="selected"' : '';?>> </option>
                                <option value="equal"<?=$configuration['sensor_condition'] == 'equal' ? ' selected="selected"' : '';?>>==</option>
                                <option value="different"<?=$configuration['sensor_condition'] == 'different' ? ' selected="selected"' : '';?>>!=</option>
                                <option value="greater"<?=$configuration['sensor_condition'] == 'greater' ? ' selected="selected"' : '';?>>></option>
                                <option value="greaterOrEqual"<?=$configuration['sensor_condition'] == 'greaterOrEqual' ? ' selected="selected"' : '';?>>>=</option>
                                <option value="less"<?=$configuration['sensor_condition'] == 'less' ? ' selected="selected"' : '';?>><</option>
                                <option value="lessOrEqual"<?=$configuration['sensor_condition'] == 'lessOrEqual' ? ' selected="selected"' : '';?>><=</option>
                            </select>
                        </div>
                        <div class="rTableCell" id="if-input-field">
                            <?php
                            if ($sensorData['value_or_to'] == 'or') {
                                echo '<select name="input-value" id="input-value" style="width: max-content;">';
                                    echo '<option value="';
                                        echo $sensorData['value_one'].'"';
                                        echo $configuration['sensor_value'] == $sensorData['value_one'] ? ' selected="selected"' : '';
                                        echo '>'.$sensorData['value_one'];
                                    echo '</option>';
                                    echo '<option value="';
                                        echo $sensorData['value_two'].'"';
                                        echo $configuration['sensor_value'] == $sensorData['value_two'] ? ' selected="selected"' : '';
                                        echo '>'.$sensorData['value_two'];
                                    echo '</option>';
                                echo '</select>';
                            } else if ($sensorData['value_or_to'] == 'or') {
                                echo '<input type="number" name="input-value" id="input-value" size="3" value="'.$configuration['sensor_value'].'" min="'.$sensorData['value_one'].'" max="'.$sensorData['value_two'].'">';
                            } else {
                                echo '<input type="text" name="input-value" id="input-value" size="3" value="'.$configuration['sensor_value'].'">';
                            }
                            ?>
                        </div>
                        <div class="rTableCell">then </div>
                        <div class="rTableCell" id="if-actuator-id">
                            <?=$actuatorData['name'];?>
                        </div>
                        <div class="rTableCell" id="if-output-field">
                            <?php
                            if ($actuatorData['value_or_to'] == 'or') {
                                echo '<select name="if-output-value" id="if-output-value" style="width: max-content;">';
                                    echo '<option value="';
                                        echo $actuatorData['value_one'].'"';
                                        echo $configuration['actuator_value_if'] == $actuatorData['value_one'] ? ' selected="selected"' : '';
                                        echo '>'.$actuatorData['value_one'];
                                    echo '</option>';
                                    echo '<option value="';
                                        echo $actuatorData['value_two'].'"';
                                        echo $configuration['actuator_value_if'] == $actuatorData['value_two'] ? ' selected="selected"' : '';
                                        echo '>'.$actuatorData['value_two'];
                                    echo '</option>';
                                echo '</select>';
                            } else if ($actuatorData['value_or_to'] == 'or') {
                                echo '<input type="number" name="if-output-value" id="if-output-value" size="3" value="'.$configuration['actuator_value_if'].'" min="'.$actuatorData['value_one'].'" max="'.$actuatorData['value_two'].'">';
                            } else {
                                echo '<input type="text" name="if-output-value" id="if-output-value" size="3" value="'.$configuration['actuator_value_if'].'">';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="rTableRow" align="center">
                        <div class="rTableCell" align="left">else</div>
                        <div class="rTableCell" id="else-sensor-id"></div>
                        <div class="rTableCell"></div>
                        <div class="rTableCell" id="else-input-field"></div>
                        <div class="rTableCell"></div>
                        <div class="rTableCell" id="else-actuator-id">
                            <?=$actuatorData['name'];?>
                        </div>
                        <div class="rTableCell" id="else-output-field">
                            <?php
                            if ($actuatorData['value_or_to'] == 'or') {
                                echo '<select name="else-output-value" id="else-output-value" style="width: max-content;">';
                                    echo '<option value="';
                                        echo $actuatorData['value_one'].'"';
                                        echo $configuration['actuator_value_else'] == $actuatorData['value_one'] ? ' selected="selected"' : '';
                                        echo '>'.$actuatorData['value_one'];
                                    echo '</option>';
                                    echo '<option value="';
                                        echo $actuatorData['value_two'].'"';
                                        echo $configuration['actuator_value_else'] == $actuatorData['value_two'] ? ' selected="selected"' : '';
                                        echo '>'.$actuatorData['value_two'];
                                    echo '</option>';
                                echo '</select>';
                            } else if ($actuatorData['value_or_to'] == 'or') {
                                echo '<input type="number" name="else-output-value" id="else-output-value" size="3" value="'.$configuration['actuator_value_else'].'" min="'.$actuatorData['value_one'].'" max="'.$actuatorData['value_two'].'">';
                            } else {
                                echo '<input type="text" name="else-output-value" id="else-output-value" size="3" value="'.$configuration['actuator_value_else'].'">';
                            }
                            ?>
                        </div>
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
            <button type="submit" id="configSubmit" name="configSubmit">Update and Generate code</button>
        </div>
    </form>
</section>

<?php
}

include 'includes/overall/footer.php';
?>