<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    $devices = get_all_devices();
    ?>
 
<h1>Home</h1>
<section>
    <div>
        Steps to take when creating a Configuration
        <ol>
            <li>First thing you should know is that, a configuration is made up of several devices: a microcontroller, a wifi communication device, a sensor and an actuator</li>
            <li>Make sure you aquire devices that are available on this platform</li>
            <li>Make sure you installed <a href="https://www.arduino.cc/en/Main/Software" id="copy-text" target="_blank">Arduino IDE</a></li>
            <li>Once you have aquired the components, you can select bellow each component to see how to make the connections</li>
            <li>
                Select a device to see how to make the connections
                <select name="devices" id="devices" onchange="showDeviceImage()">
                    <option value="empty"></option>
                    <?php
                    foreach ($devices as &$value) {
                        echo '<option value="'.$value["ID"].'" ';
                                echo 'id="device_"'.$value["ID"].'" ';
                                echo 'value-image="'.$value["image"].'" ';
                                echo 'value-name="'.$value["name"].'">';
                            echo $value["name"];
                        echo '</option>';
                    }
                    ?>
                </select>
                <div id="image">
                    
                </div>
            </li>
            <li>After you finished with making the connections, you can start creating your configuration</li>
            <li>To do that, you must go to the "My Configurations" page and click on the "New" button</li>
            <li>In the newly loaded page, you must enter a configuration name and the wifi connection credentials</li>
            <li>In the frame "Select devices" you must select the exact same devices you used for connections</li>
            <li>In the "Configuration setup" you must set the conditions and values of how the components wiil work</li>
            <li>When clicking the "Save" button, you will be taken to a page which offers you the code that you need to paste in <a href="https://www.arduino.cc/en/Main/Software" id="copy-text" target="_blank">Arduino IDE</a></li>
            <li>Click on "Copy code", open <a href="https://www.arduino.cc/en/Main/Software" id="copy-text" target="_blank">Arduino IDE</a> , paste the code and upload the code with the Arduino components connected to the PC</li>
            <li>In case you need to modify the conditions of the Arduino configuration, you just have to go to "My Configurations", select the configuration that you want to modify, and click on the "Edit" button, modify the values in the "Configuration setup" frame and click on the "Update" button</li>
            <li>When you want to modify the wifi connection credentials, you have to follow the same steps as above, except, this time you modify the values in the "WiFi connection" and click "Update". As opposed to the step above, this time you have to re-upload the code to the Arduino configuration</li>
            <li>To delete a configuration, take the same steps as the previous and click on the "Delete" button</li>
            <li>ENJOY!!!</li>
        </ol>
    </div>
</section>

<?php
}

include 'includes/overall/footer.php';
?>