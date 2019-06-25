<?php
function email($to, $subject, $body) {
    mail($to, $subject, $body, 'From: florin.mazilu@info.uaic.ro');
}

function logged_in_redirect() {
    if (logged_in() === true) {
        header('Location: index.php');
    }
}

function protect_page() {
    if (logged_in() === false) {
        header('Location: protected.php');
        exit();
    }
}

function protect_admin_page($admin) {
    if (!$admin) {
        header('Location: protected_admin.php');
        exit();
    }
}


function array_sanitize(&$item) {
    global $db;
    $item = $db->real_escape_string(htmlentities(strip_tags(trim($item)), ENT_QUOTES, 'UTF-8'));
}

function sanitize($data) {
    global $db;
    return $db->real_escape_string(htmlentities(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8'));
}


function output_errors($errors) {
    return '<ul style="color: #ff0000"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}

function insert_data($insertion_data, $table) {
    global $db;
    array_walk($insertion_data, 'array_sanitize');
    $fields = '`' . implode('`, `', array_keys($insertion_data)) . '`';
    $data = '\'' . implode('\', \'', $insertion_data) . '\'';
    
    $stmt = $db->prepare("INSERT INTO $table ($fields) VALUES ($data)");
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return 0;
    }
}

function delete_config($config_id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM `configurations` WHERE `ID` = ? ");
    $stmt->bind_param("i", $config_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function update_config($config_id, $configurationData) {
    global $db;
    array_walk($configurationData, 'array_sanitize');
    $out = "UPDATE `configurations` SET ";
    $out1 = "";
    foreach ($configurationData as $key => $value) {
        $out1 .= "`".$key."` = '$value', ";
    }
    $out2 = " WHERE `ID` = ?";
    $query = $out.rtrim($out1, ", ")." ".$out2."";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $config_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function create_device_code($type, $path, $index) {
    if (isset($_POST[$type]) === true && empty($_POST[$type]) === false) {
        global $db;
        $filename = $path . $index . "_" . $type . ".txt";
        $file = tmpfile();
        $file = fopen($filename, "a+");
        file_put_contents($filename, $_POST[$type]);
        fclose($file);
        
        $field = "";
        switch ($type) {
            case "libraryCode":
                $field = "library_code";
                break;
            case "variableCode":
                $field = "variable_code";
                break;
            case "setupCode":
                $field = "setup_code";
                break;
            case "loopCode":
                $field = "loop_code";
                break;
            case "descriptionText":
                $field = "description_text";
                break;
        }
        $updating = '`' . $field . '` = \'' . $index . "_" . $type . ".txt" . '\'';
        $stmt = $db->prepare("UPDATE `devices` SET $updating WHERE `ID` = ?");
        $stmt->bind_param('i', $index);
        $stmt->execute();
    }
}

function get_devices($type) {
    global $db;
    $data = array();
    $stmt = $db->prepare("SELECT * FROM `devices` WHERE `type` = ? ");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $stmt->bind_result($ID, $name, $devType, $valueTitle, $valueOne, $valueOrTo, $valueTwo, $libraryCode, $variableCode, $setupCode, $loopCode, $url, $image, $descriptionText);
    while ($row = $stmt->fetch()) {
        $dataRow = array();
        $dataRow = array_merge($dataRow, array("ID" => $ID, "name" => $name, "type" => $devType, "value_title" => $valueTitle));
        $dataRow = array_merge($dataRow, array("value_one" => $valueOne, "value_or_to" => $valueOrTo, "value_two" => $valueTwo));
        $dataRow = array_merge($dataRow, array("library_code" => $libraryCode, "variable_code" => $variableCode, "setup_code" => $setupCode));
        $dataRow = array_merge($dataRow, array("loop_code" => $loopCode, "url" => $url, "image" => $image, "description_text" => $descriptionText));
        $data[] = $dataRow;
    }
    return $data;
}

function get_configurations($userID) {
    global $db;
    $data = array();
    $stmt = $db->prepare("SELECT * FROM `configurations` WHERE `user_id` = ? ORDER BY `ID` ASC");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $stmt->bind_result($ID, $title, $ssid, $pass, $userID, $arduinoID, $wifiID, $sensorID, $sensorCondition, $sensorValue, $actuatorID, $actuatorValueIf, $actuatorValueElse);
    while ($row = $stmt->fetch()) {
        $dataRow = array();
        $dataRow = array_merge($dataRow, array("ID" => $ID, "title" => $title, "ssid" => $ssid, "pass" => $pass, "user_id" => $userID));
        $dataRow = array_merge($dataRow, array("arduino_id" => $arduinoID, "wifi_id" => $wifiID, "sensor_id" => $sensorID));
        $dataRow = array_merge($dataRow, array("sensor_condition" => $sensorCondition, "sensor_value" => $sensorValue));
        $dataRow = array_merge($dataRow, array("actuator_id" => $actuatorID, "actuator_value_if" => $actuatorValueIf));
        $dataRow = array_merge($dataRow, array("actuator_value_else" => $actuatorValueElse));
        $data[] = $dataRow;
    }
    return $data;
}

function get_device($device_id) {
    global $db;
    $dataRow = array();
    $stmt = $db->prepare("SELECT * FROM `devices` WHERE `ID` = ? ");
    $stmt->bind_param("s", $device_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($ID, $name, $devType, $valueTitle, $valueOne, $valueOrTo, $valueTwo, $libraryCode, $variableCode, $setupCode, $loopCode, $url, $image, $descriptionText);
        $stmt->fetch();
        $dataRow = array_merge($dataRow, array("ID" => $ID, "name" => $name, "type" => $devType, "value_title" => $valueTitle));
        $dataRow = array_merge($dataRow, array("value_one" => $valueOne, "value_or_to" => $valueOrTo, "value_two" => $valueTwo));
        $dataRow = array_merge($dataRow, array("library_code" => $libraryCode, "variable_code" => $variableCode));
        $dataRow = array_merge($dataRow, array("setup_code" => $setupCode, "loop_code" => $loopCode, "url" => $url, "image" => $image));
        $dataRow = array_merge($dataRow, array("description_text" => $descriptionText));
    }
    return $dataRow;
}

function get_configuration($config_id) {
    global $db;
    $dataRow = array();
    $stmt = $db->prepare("SELECT * FROM `configurations` WHERE `ID` = ? ORDER BY `ID` ASC");
    $stmt->bind_param("s", $config_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($ID, $title, $ssid, $pass, $userID, $arduinoID, $wifiID, $sensorID, $sensorCondition, $sensorValue, $actuatorID, $actuatorValueIf, $actuatorValueElse);
        $stmt->fetch();
        $dataRow = array_merge($dataRow, array("ID" => $ID, "title" => $title, "ssid" => $ssid, "pass" => $pass, "user_id" => $userID));
        $dataRow = array_merge($dataRow, array("arduino_id" => $arduinoID, "wifi_id" => $wifiID, "sensor_id" => $sensorID));
        $dataRow = array_merge($dataRow, array("sensor_condition" => $sensorCondition, "sensor_value" => $sensorValue));
        $dataRow = array_merge($dataRow, array("actuator_id" => $actuatorID, "actuator_value_if" => $actuatorValueIf));
        $dataRow = array_merge($dataRow, array("actuator_value_else" => $actuatorValueElse));
    }
    return $dataRow;
}