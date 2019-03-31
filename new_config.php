<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    ?>

<h1>New Configurations</h1>
<section>
    <p>Data to be added</p>
</section>
<section>
    <button>Generate code</button>
</section>

<?php
}

include 'includes/overall/footer.php';
?>