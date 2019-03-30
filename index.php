<?php
include 'main_functions/init.php';
include 'includes/overall/header.php';

if (logged_in()) {
    ?>

<h1>My Configurations</h1>
<section>
    <p>Just a template</p>
</section>
<section>
    <pre>
        <code id="configuration" class="arduino"
            style="overflow: auto; height: 400px;"><?php
    $handle = fopen("device_templates/client_server_communication/client_server_communication.ino", "r");
    if ($handle) {
        $first_lines = true;
        while (($line = fgets($handle)) !== false) {
            if (!empty(trim($line)) || !$first_lines) {
                echo str_replace("<", "&lt;", $line);
                $first_lines = false;
            } else {
                
            }
        }
        fclose($handle);
    } else {
        echo "File not found";
    }
      ?></code>
	</pre>
    <button onclick="copyToClipboard('#configuration')">Copy text</button>
</section>

<?php
}

include 'includes/overall/footer.php';
?>