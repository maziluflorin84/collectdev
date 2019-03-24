<?php
include 'main_functions/init.php';
protect_page();
protect_admin_page((int)$user_data['admin']);
include 'includes/overall/header.php';
?>
	<h1>Add device</h1>
	<section>
		<form action="" method="post">
			<ul>
				<li>
					Device name<br>
					<input type="text" name="devName">
				</li>
				<li>
					Device type<br>
					<select name="devType">
            			<option></option>
            			<option>Single-board microcontroller</option>
            			<option>Sensor</option>
            			<option>Actuator</option>
            		</select>
				</li>
				<li>
					Number of pins <input type="text" name="numPins" style="width: 20px;">
				</li>
				<li>
					<button name="submit">Submit</button>
				</li>
			</ul>
		</form>
	</section>
<?php include 'includes/overall/footer.php'; ?>