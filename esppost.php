<?php
if (empty($_GET)) {
    echo "empty";
} else {
    $data = array();
    foreach ($_GET as $key => $value) {
        $new_data = array($key => $value);
        $data = array_merge($data, $new_data);
    }
    //file_put_contents('sensor.html', "value = " . $Temp);
    echo json_encode($data);
}
?>