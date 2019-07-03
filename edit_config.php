<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    if (empty($_POST) === true) {
        header('Location: my_configs.php?failed');
    }

    $configuration = get_configuration($_POST['config-id']);
    $wifiData = get_device($configuration['wifi_id']);
    $sensorData = get_device($configuration['sensor_id']);
    $actuatorData = get_device($configuration['actuator_id']);
    
    $updated = false;
    $generate = false;

    if (isset($_REQUEST['config-edit']) === true && empty($_REQUEST['config-edit']) === false) {
        if($_REQUEST['config-edit']=="Delete") {
            if (delete_config($_POST['config-id'])) {
                header('Location: my_configs.php?delete-success');
                exit();
            }
        } else if ($_REQUEST['config-edit']=="Update") {
            $configurationData = array(
                'ssid' => $_POST['wifi-ssid'],
                'pass' => $_POST['wifi-pass'],
                'sensor_condition' => $_POST['condition-device'],
                'sensor_value' => $_POST['input-value'],
                'actuator_value_if' => $_POST['if-output-value'],
                'actuator_value_else' => $_POST['else-output-value']
            );
            if ($configuration['ssid'] != $configurationData['ssid'] || $configuration['pass'] != $configurationData['pass']) {
                $generate = true;
            }
            if (update_config($_POST['config-id'], $configurationData)) {
                $configuration['ssid'] = $_POST['wifi-ssid'];
                $configuration['pass'] = $_POST['wifi-pass'];
                $configuration['sensor_condition'] = $_POST['condition-device'];
                $configuration['sensor_value'] = $_POST['input-value'];
                $configuration['actuator_value_if'] = $_POST['if-output-value'];
                $configuration['actuator_value_else'] = $_POST['else-output-value'];
                $updated = true;
            }
        } else if($_REQUEST['config-edit']=="Cancel") {
            header('Location: my_configs.php');
            exit();
        }
    }
    ?>

<h1>Edit Configuration</h1>
<?php
if ($updated) {
    echo '<p class="successful-action">The configuration was updated successfully!</p>';
}
?>

<?php
if ($updated && $generate) {
    echo '<p class="successful-action">You must upload this code to Arduino IDE!</p>';
?>
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
    if ($updated && !$generate) {
        echo '<p class="successful-action">The changes should be available from now!</p>';
    }
?>
<section>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <p class="failed-action">
                <input type="submit" name="config-edit" value="Delete"> * Do not push if you don't want to delete this configuration
            </p>
            <fieldset class="config-fieldset">
                <legend>Configuration Info</legend>
                <ul id="info" class="config-info-form">
                    <li>
                        Configuration name:<br/>
                        <input type="hidden" name="config-id" id="config-id" value="<?=$configuration['ID'];?>">
                        <input type="text" name="config-name" id="config-name" value="<?=$configuration['title'];?>" disabled>
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
            <input type="submit" name="config-edit" value="Update">
            <input type="submit" name="config-edit" value="Cancel">
        </div>
    </form>
</section>
<?php
}
}

include 'includes/overall/footer.php';
?>