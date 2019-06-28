<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    if (isset($_GET['failed']) === true && empty($_GET['failed']) === true) {
        echo '<p class="failed-action">Something went wrong!</p>';
    } else if (isset($_GET['delete-success']) === true && empty($_GET['delete-success']) === true) {
        echo '<p class="successful-action">The configuration was successfully deleted!</p>';
    } else if (isset($_GET['update-success']) === true && empty($_GET['update-success']) === true) {
        echo '<p class="successful-action">The configuration was updated successfully!</p>';
    }
    $listOfConfigurations = get_configurations($user_data['ID']);
    ?>
    
<script type="text/javascript">
    var currentValue = 0;
    function handleClick(myRadio) {
        if (document.getElementById('config-edit').disabled == true) {
            document.getElementById('config-edit').disabled = false;
        }
    }
</script>
<h1>My Configurations</h1>
<section>
    <p>Create a new configuration by clicking on thing button <button onclick="newConfiguration()">New</button></p>
</section>
<section>
    <form action="edit_config.php" method="post" enctype="multipart/form-data">
        <div>
            <fieldset class="config-fieldset" id="id-confgi-fieldset">
                <legend>Configurations</legend>
                <?php
                if ($listOfConfigurations) {
                    foreach ($listOfConfigurations as $configuration) {
                        $sensorData = get_device($configuration['sensor_id']);
                        $actuatorData = get_device($configuration['actuator_id']);
                        $operator = '';
                        switch ($configuration['sensor_condition']) {
                            case 'equal': $operator = '==';
                                break;
                            case 'different': $operator = '!=';
                                break;
                            case 'greater': $operator = '>';
                                break;
                            case 'greaterOrEqual': $operator = '>=';
                                break;
                            case 'less': $operator = '<';
                                break;
                            case 'lessOrEqual': $operator = '<=';
                                break;
                        }
                        echo '<label id="label-'.$configuration['ID'].'" style="font-size: 0.9em;">';
                            echo '<input type="radio" id="'.$configuration['ID'].'" name="config-id" value="'.$configuration['ID'].'" onclick="handleClick(this);">';
                            echo '<div style="display: inline-block; Courier New; white-space: nowrap; overflow: hidden;" id="div-title-'.$configuration['ID'].'">';
                            echo $configuration['title'];
                            echo '</div> ';
                            echo '<script>setConfigurationWidth("'.$configuration['ID'].'", "div-title-'.$configuration['ID'].'", "'.$sensorData['name'].'", "'.$operator.'", "'.$configuration['sensor_value'].'", "'.$actuatorData['name'].'", "'.$configuration['actuator_value_if'].'", "'.$configuration['actuator_value_else'].'")</script>';
                        echo '</label><br>';
                        echo (next($listOfConfigurations)==true) ? '<br>' : '';
                    }
                } else {
                    echo "There are no configurations at the moment!";
                }
                ?>
            </fieldset>
            <input type="submit" id="config-edit" name="config-edit" disabled="disabled" value="Edit">
        </div>
    </form>
</section>

<?php
}

include 'includes/overall/footer.php';
?>