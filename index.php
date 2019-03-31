<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    ?>

<h1>My Configurations</h1>
<section>
    <p>Here will be all of the user's configurations</p>
</section>
<section>
    <button onclick="newConfiguration()">New configuration</button>
</section>

<?php
}

include 'includes/overall/footer.php';
?>