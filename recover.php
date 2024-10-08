<?php
include 'main_functions/init.php';
logged_in_redirect();
include 'includes/overall/header.php';
?>

<h1>Recover</h1>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
?>

<section>
	<p>We have emailed you</p>
</section>

<?php
} else {
    if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
        if (email_exists($_POST['email']) === true) {
            recover($_POST['email']);
            header('Location: recover.php?success');
            exit();
        } else {
            echo '<p>There is no account with this email address!</p>';
        }
    }
    ?>
<section>
    <form action="" method="post">
        <ul>
            <li>
                Please enter your email address:<br>
                <input type="email" name="email">
            </li>
            <li>
                <input type="submit" value="Recover">
            </li>
        </ul>
    </form>
</section>

    <?php
}
include 'includes/overall/footer.php';
?>