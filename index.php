<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    // if (empty($_POST) === false) {
    //     if (delete_config($_POST['config'])) {
    //         header('Location: index.php?success');
    //     }
    //     exit();
    // }
    // if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
    //     echo '<p class="successful-action">Configurations has been deleted!</p>';
    // }
    if (isset($_GET['failed']) === true && empty($_GET['failed']) === true) {
        echo '<p class="failed-action">Something went wrong!</p>';
    }
    $listOfConfigurations = get_configurations($user_data['ID']);
    ?>
    
<script type="text/javascript">
    var currentValue = 0;
    function handleClick(myRadio) {
        if (document.getElementById('configEdit').disabled == true) {
            document.getElementById('configEdit').disabled = false;
        }

        // if (document.getElementById('configDelete').disabled == true) {
        //     document.getElementById('configDelete').disabled = false;
        // }
    }
</script>
<h1>My Configurations</h1>
<section>
    <p>Create a new configuration by clicking on thing button <button onclick="newConfiguration()">New</button></p>
</section>
<section>
    <form action="edit_config.php" method="post" enctype="multipart/form-data">
        <fieldset class="config-fieldset">
            <legend>Configurations</legend>
            <?php
            if ($listOfConfigurations) {
                foreach ($listOfConfigurations as $configuration) {
                    echo '<label>';
                        echo '<input type="radio" id="'.$configuration['ID'].'" name="config" value="'.$configuration['ID'].'" onclick="handleClick(this);">';
                        echo $configuration['title'];
                    echo '</label><br>';
                }
            } else {
                echo "There are no configurations at the moment!";
            }
            ?>
        </fieldset>
        <button type="submit" id="configEdit" name="configEdit" disabled="disabled">Edit</button>
        <!-- <button type="submit" id="configDelete" name="configDelete" disabled="disabled">Delete</button> -->
    </form>
</section>

<?php
}

include 'includes/overall/footer.php';
?>