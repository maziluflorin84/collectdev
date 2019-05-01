<?php
include 'main_functions/init.php';
protect_page();
protect_admin_page((int)$user_data['admin']);
include 'includes/overall/header.php';

$ext = "";
if (empty($_POST) === false) {
    $required_fields = array('devName', 'devtype');
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
        'url' => $_POST['url'],
        'image' => $image_name
    );
    $inserted_id = insert_device($device_data);
    if ($inserted_id != 0) {
        $template_paths = "device_templates/device_code/";
        create_device_code("libraryCode", $template_paths, $inserted_id);
        create_device_code("variableCode", $template_paths, $inserted_id);
        create_device_code("setupCode", $template_paths, $inserted_id);
        create_device_code("loopCode", $template_paths, $inserted_id);

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
        <ul id="formListId">
            <li>Device type*:<br> <select id="devType" onchange="selectTypeFunction()" name="devType">
                    <option value="Empty"></option>
                    <option value="Arduino">Arduino</option>
                    <option value="Wifi">Wifi Module</option>
                    <option value="Sensor">Sensor</option>
                    <option value="Actuator">Actuator</option>
                </select>
            </li>
            <li>Device name*:<br> <input type="text" name="devName">
            </li>
            <li>Device URL:<br> <input type="text" name="url">
            </li>
            <!-- <li>Pins needed: <input type="number" name="numOfPins" id="numOfPins" min="0" max="10" value="0" style="width: 1.5em;" readonly="true">
                <input type="button" value="-" onclick="incDecValue('numOfPins', '-')"><input type="button" value="+" onclick="incDecValue('numOfPins', '+')">
                <input type="button" value="Ok" onclick="drawPinFields('numOfPins', 'formListId')">
            </li> -->
            <li>Device image:<br> <input type="file" name="image">
            </li>
        </ul>
        <button type="submit" id="devSubmit" name="submit" disabled="disabled">Submit</button>
    </form>
    * required
</section>

<?php include 'includes/overall/footer.php'; ?>