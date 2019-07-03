<?php
include 'main_functions/init.php';
if (empty($_GET)) {
    echo "empty";
} else {
    $sensorIsNumeric = false;
    $configuration = get_configuration($_GET['configurationID']);
    if (is_numeric($_GET['sensorValue'])) {
        $sensorValue = floatval($_GET['sensorValue']);
        $sensorIsNumeric = true;
    } else {
        $sensorValue = $_GET['sensorValue'];
    }

    switch ($configuration['sensor_condition']) {
        case 'equal': 
            if (($sensorIsNumeric && $sensorValue == $configuration['sensor_value']) || (!$sensorIsNumeric && strcasecmp($sensorValue, $configuration['sensor_value']) == 0)) {
                $data = array("actuatorValue" => $configuration['actuator_value_if']);
            } else {
                $data = array("actuatorValue" => $configuration['actuator_value_else']);
            }            
            break;
        case 'different': 
            if (($sensorIsNumeric && $sensorValue != $configuration['sensor_value']) || (!$sensorIsNumeric && strcasecmp($sensorValue, $configuration['sensor_value']) != 0)) {
                $data = array("actuatorValue" => $configuration['actuator_value_if']);
            } else {
                $data = array("actuatorValue" => $configuration['actuator_value_else']);
            }
            break;
        case 'greater': 
            if ($sensorIsNumeric && $sensorValue > $configuration['sensor_value']) {
                $data = array("actuatorValue" => $configuration['actuator_value_if']);
            } else {
                $data = array("actuatorValue" => $configuration['actuator_value_else']);
            }
            break;
        case 'greaterOrEqual': 
            if ($sensorIsNumeric && $sensorValue >= $configuration['sensor_value']) {
                $data = array("actuatorValue" => $configuration['actuator_value_if']);
            } else {
                $data = array("actuatorValue" => $configuration['actuator_value_else']);
            }
            break;
        case 'less': 
            if ($sensorIsNumeric && $sensorValue < $configuration['sensor_value']) {
                $data = array("actuatorValue" => $configuration['actuator_value_if']);
            } else {
                $data = array("actuatorValue" => $configuration['actuator_value_else']);
            }
            break;
        case 'lessOrEqual': 
            if ($sensorIsNumeric && $sensorValue <= $configuration['sensor_value']) {
                $data = array("actuatorValue" => $configuration['actuator_value_if']);
            } else {
                $data = array("actuatorValue" => $configuration['actuator_value_else']);
            }
            break;
    }
    echo json_encode($data);
}
?>