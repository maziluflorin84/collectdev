<?php
include 'main_functions/init.php';
protect_page();
protect_admin_page((int)$user_data['admin']);
include 'includes/overall/header.php';

$ext = "";
if (empty($_POST) === false) {
    $required_fields = array('devName', 'devtype', 'url', 'image');
    foreach ($_POST as $key => $value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Fields marked with an asterisk are required';
        }
    }
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_file_type = array('jpg', 'jpeg', 'png');
    $image_size = $_FILES['image']['size'];
    $allowed_image_size = 1.5 * pow(1024, 2);
    $image_error = $_FILES['image']['error'];

    if (!in_array($ext, $allowed_file_type)) {
        $errors[] = "You cannot upload images of other types than jpg, jpeg or png";
    } else if ($image_error !== 0) {
        $errors[] = "There was an error uploading the file";
    } else if ($image_size > $allowed_image_size) {
        $errors[] = "The image size exceeds the limit";
    }
}
?>

<h1>Add device</h1>

<?php
if (empty($_POST) === false && empty($errors) === true) {
    $image_name = md5(time()) . "." . $ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_destination = 'images/' . $image_name;
    move_uploaded_file($image_tmp_name, $image_destination);

    $device_data = array(
        'name' => $_POST['devName'],
        'type' => $_POST['devType'],
        'value_title' => (isset($_POST['valueTitle']) === true && empty($_POST['valueTitle']) === false) ? $_POST['valueTitle'] : null,
        'value_one' => (isset($_POST['valueOne']) === true && empty($_POST['valueOne']) === false) ? $_POST['valueOne'] : null,
        'value_or_to' => (isset($_POST['selectOrTo']) === true && empty($_POST['selectOrTo']) === false) ? $_POST['selectOrTo'] : null,
        'value_two' => (isset($_POST['valueTwo']) === true && empty($_POST['valueTwo']) === false) ? $_POST['valueTwo'] : null,
        'url' => $_POST['url'],
        'image' => $image_name
    );
    $table = '`devices`';
    $inserted_id = insert_data($device_data, $table);
    if ($inserted_id != 0) {
        $template_paths = "device_templates/device_code/";
        create_device_code("libraryCode", $template_paths, $inserted_id);
        create_device_code("variableCode", $template_paths, $inserted_id);
        create_device_code("setupCode", $template_paths, $inserted_id);
        create_device_code("loopCode", $template_paths, $inserted_id);
        create_device_code("descriptionText", $template_paths, $inserted_id);

        header('Location: add_device.php?success');
    }
    exit();
}

if (empty($errors) === false) {
    echo output_errors($errors);
} else  if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
    echo '<p class="successful-action">Device has been added!</p>';
}
?>

<section>
    <form action="" method="post" enctype="multipart/form-data">
        <div style="width: 70%">
            <ul id="formListId">
                <li>Device type*:<br>
                    <div class="rTable">
                        <div class="rTableRow" align="center">
                            <div class="rTableCellDevice" align="left">
                                <input type="radio" name="devType" id="dev-arduino" value="Arduino" onclick="selectTypeFunction(this);">
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-arduino">Arduino</label>
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-arduino"><img src="images/arduino.png" height="75px"></label>
                            </div>
                        </div>
                        <div class="rTableRow" align="center">
                            <div class="rTableCellDevice" align="left">
                                <input type="radio" name="devType" id="dev-wifi" value="Wifi" onclick="selectTypeFunction(this);">
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-wifi">Wifi Module</label>
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-wifi"><img src="images/wifi.png" height="75px"></label>
                            </div>
                        </div>
                        <div class="rTableRow" align="center">
                            <div class="rTableCellDevice" align="left">
                                <input type="radio" name="devType" id="dev-sensor" value="Sensor" onclick="selectTypeFunction(this);">
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-sensor">Sensor</label>
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-sensor"><img src="images/sensor.png" height="75px"></label>
                            </div>
                        </div>
                        <div class="rTableRow" align="center">
                            <div class="rTableCellDevice" align="left">
                                <input type="radio" name="devType" id="dev-actuator" value="Actuator" onclick="selectTypeFunction(this);">
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-actuator">Actuator</label>
                            </div>
                            <div class="rTableCellDevice" align="left">
                                <label for="dev-actuator"><img src="images/actuator.png" height="75px"></label>
                            </div>
                        </div>
                    </div>
                </li>
                <li>Device name*:<br> <input type="text" name="devName">
                </li>
                <li>Device URL*:<br> <input type="text" name="url">
                </li>
                <li>Device image*:<br> <input type="file" name="image">
                </li>
            </ul>
            <button type="submit" id="devSubmit" name="submit" disabled="disabled">Submit</button><br>
            * required
        </div>
    </form>
</section>

<?php include 'includes/overall/footer.php'; ?>