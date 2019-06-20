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

function get_device($type) {
    global $db;
    $data = array();
    $stmt = $db->prepare("SELECT * FROM `devices` WHERE `type` = ? ");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $stmt->bind_result($ID, $name, $devType, $valueTitle, $valueOne, $valueOrTo, $valueTwo, $libraryCode, $variableCode, $setupCode, $loopCode, $url, $image, $descriptionText);
    while ($row = $stmt->fetch()) {
        $dataRow = [];
        $dataRow += ["ID" => $ID];
        $dataRow += ["name" => $name];
        $dataRow += ["type" => $devType];
        $dataRow += ["value_title" => $valueTitle];
        $dataRow += ["value_one" => $valueOne];
        $dataRow += ["value_or_to" => $valueOrTo];
        $dataRow += ["value_two" => $valueTwo];
        $dataRow += ["library_code" => $libraryCode];
        $dataRow += ["variable_code" => $variableCode];
        $dataRow += ["setup_code" => $setupCode];
        $dataRow += ["loop_code" => $loopCode];
        $dataRow += ["url" => $url];
        $dataRow += ["image" => $image];
        $dataRow += ["description_text" => $descriptionText];
        $data[] = $dataRow;
    }
    return $data;
}