<nav>
    <ul>
    <?php 
    if (logged_in()) { 
    ?>
        <li><a href="index.php">My Configurations</a></li>
    	<?php if ((int)$user_data['admin']) { ?>
        <li><a href="add_device.php">Add Device</a></li>
    <?php 
        }
    } else { 
    ?>
        <li><a href="register.php">Register</a></li>
    <?php 
    } 
    ?>
    </ul>
</nav>