<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    
    $listOfConfigurations = array(1, 2, 3);
    ?>
    
<script type="text/javascript">
    var currentValue = 0;
    function handleClick(myRadio) {
//         alert('Old value: ' + currentValue);
//         alert('New value: ' + myRadio.value);
//         currentValue = myRadio.value;
        if (document.getElementById('editConfig').disabled == true) {
            document.getElementById('editConfig').disabled = false;
        }
        if (document.getElementById('delConfig').disabled == true) {
            document.getElementById('delConfig').disabled = false;
        }
    }
</script>
<h1>My Configurations</h1>
<section>
    <p>Create a new configuration by clicking on thing button <button onclick="newConfiguration()">New</button></p>
</section>
<section>
    <form name="configurationForm">
        <fieldset>
            <legend>Configurations</legend>
            <?php
            if ($listOfConfigurations) {
                foreach ($listOfConfigurations as $configuration) {
                    echo "<input type=\"radio\" id=\"configId". $configuration ."\" name=\"config\" value=\"". $configuration ."\" onclick=\"handleClick(this);\"> ";
                    echo "<label for=\"configId". $configuration ."\">Configuration ". $configuration ."</label><br>";
                }
            } else {
                echo "There are no configurations at the moment!";
            }
            ?>
        </fieldset>
        <button id="editConfig" onclick="editConfiguration()" disabled="disabled">Edit</button>
        <button id="delConfig" onclick="deleteConfiguration()" disabled="disabled">Delete</button>
    </form>
</section>

<?php
}

include 'includes/overall/footer.php';
?>